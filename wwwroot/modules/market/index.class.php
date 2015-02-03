<?php

/**
 * Contrexx
 *
 * @link      http://www.contrexx.com
 * @copyright Comvation AG 2007-2014
 * @version   Contrexx 4.0
 * 
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Contrexx" is a registered trademark of Comvation AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

/**
 * Market
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @version        1.0.0
 * @package     contrexx
 * @subpackage  module_market
 * @todo        Edit PHP DocBlocks!
 */

//error_reporting (E_ALL);


/**
 * Market
 *
 * Demo market class
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @access        public
 * @version        1.0.0
 * @package     contrexx
 * @subpackage  module_market
 */
class Market extends marketLibrary
{
    /**
    * Template object
    *
    * @access private
    * @var object
    */
    var $_objTpl;
    var $pageContent;
    var $communityModul;
    var $mediaPath;
    var $mediaWebPath;
    var $settings;
    var $categories;
    var $entries;

    /**
     * Constructor
     * @global object $objTemplate
     */
    function __construct($pageContent)
    {
        $this->pageContent = $pageContent;

        $this->_objTpl = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);

        $this->mediaPath = ASCMS_MARKET_MEDIA_PATH . '/';
        $this->mediaWebPath = ASCMS_MARKET_MEDIA_WEB_PATH . '/';

        //get settings
        $this->settings = $this->getSettings();

        //check community modul
        $objModulManager = new modulemanager();
        $arrInstalledModules = $objModulManager->getModules();
        if (in_array(23, $arrInstalledModules)) {
            $this->communityModul = true;
        } else {
            $this->communityModul = false;
        }

        //ipn Check
        if (isset($_GET['act'])) {
            switch($_GET['act']) {
                case "paypalIpnCheck";
                    $objPaypal = new PayPal;
                    $objPaypal->ipnCheck();
                    exit;
                    break;
                default:
                    //nothging
                    break;
            }
        }
    }

    /**
    * Get content page
    *
    * @access public
    */
    function getPage()
    {
        if (!isset($_GET['cmd'])) {
            $_GET['cmd'] = '';
        }

        switch ($_GET['cmd']) {
            case 'detail':
                $this->entryDetails(intval($_GET['id']));
            break;
            case 'send':
                $this->sendMessage(intval($_GET['id']));
            break;
            case 'add':
                $this->addEntry();
            break;
            case 'confirm':
                $this->confirmEntry();
            break;
            case 'edit':
                $this->editEntry();
            break;
            case 'del':
                $this->delEntry();
            break;
            case 'search':
                $this->searchEntry();
            break;
            break;
            default:
                $this->showCategories();
            break;
        }
        return $this->_objTpl->get();
    }



    function showCategories()
    {
        global $objDatabase, $_ARRAYLANG, $_CORELANG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        $catRows                 = 2;
        $categorieRowWidth         = substr(100/$catRows, 0, 2)."%";
        $categorieRows            = array();
        $arrRowsIndex            = array();

        for($x = 1; $x <= $catRows; $x++) {
            $categorieRows[$x] = "";
        }

        //get categories
        $objResult = $objDatabase->Execute("SELECT id, name, description FROM ".DBPREFIX."module_market_categories WHERE status = '1' ORDER BY displayorder");

        if ($objResult !== false) {
            while(!$objResult->EOF) {
                $this->categories['name'][$objResult->fields['id']] = $objResult->fields['name'];
                $this->categories['description'][$objResult->fields['id']] = $objResult->fields['description'];
                $objResult->MoveNext();
            }
        }

        //get search
        $this->getSearch();

        //get navigation
        $this->getNavigation($_GET['id']);

        //show categories
        $i = 1;
        if (!empty($this->categories) && !isset($_GET['id'])) {
            foreach($this->categories['name'] as $catKey => $catName) {
                $count = $this->countEntries($catKey);
                if ($count == "") {
                    $count = "0";
                }

                $categorieRows[$i] .= "<a class='catLink' href='index.php?section=market&amp;id=".$catKey."'>".htmlentities($catName, ENT_QUOTES, CONTREXX_CHARSET)."</a>&nbsp;(".$count.")<br />";
                array_push($arrRowsIndex, substr(htmlentities($catName, ENT_QUOTES, CONTREXX_CHARSET), 0, 1)."<a class='catLink' href='index.php?section=market&amp;id=".$catKey."'>".htmlentities($catName, ENT_QUOTES, CONTREXX_CHARSET)."</a>&nbsp;(".$count.")<br />");

                if ($i%$catRows==0) {
                    $i=1;
                }else{
                    $i++;
                }
            }

            $objResult = $objDatabase->Execute("SELECT id FROM ".DBPREFIX."module_market WHERE status = '1'");
            $allFeeds = $objResult->RecordCount();
            $insertFeeds = $allFeeds." ".$_ARRAYLANG['TXT_MARKET_ADD_ADVERTISEMENT'];

            $this->_objTpl->hideBlock('showCategoriesTitle');
            $this->_objTpl->parse('showInsertEntries');
            $this->_objTpl->hideBlock('showEntriesHeader');

            $this->showLatestEntries();
        }else{
            $title             = $this->categories['name'][$_GET['id']];
            $description     = $this->getDescription($_GET['id']);
            $selectionOffer        = "";
            $selectionSearch    = "";
            $selectionAll        = "";

            if (!isset($_GET['type'])) {
                $_GET['type'] = '';
            }

            switch ($_GET['type']) {
                case 'offer':
                    $selectionOffer        = "checked";
                break;
                case 'search':
                    $selectionSearch    = "checked";
                break;
                default:
                    $selectionAll        = "checked";
                break;
            }
            //typselector
            $selector = '<input type="radio" name="type" onclick="location.replace(\'index.php?section=market&id='.$_GET['id'].'\')" '.$selectionAll.' />'.$_ARRAYLANG['TXT_MARKET_ALL'].'&nbsp;<input type="radio" name="type" onclick="location.replace(\'index.php?section=market&id='.$_GET['id'].'&type=offer\')" '.$selectionOffer.' />'.$_ARRAYLANG['TXT_MARKET_OFFERS'].'&nbsp;<input type="radio" name="type" onclick="location.replace(\'index.php?section=market&id='.$_GET['id'].'&type=search\')" '.$selectionSearch.' />'.$_ARRAYLANG['TXT_MARKET_REQUEST'];
            //get entries
            $this->showEntries($_GET['id']);

            $this->_objTpl->parse('showCategoriesTitle');
            $this->_objTpl->hideBlock('showInsertEntries');
            $this->_objTpl->hideBlock('showCategories');
        }

        //select View
        if  ($this->settings['indexview']['value'] == 1) {
            $categorieRows ='';
            sort($arrRowsIndex);

            $i = 0;
            $firstCol = true;
            $index = '';
            foreach($arrRowsIndex as $rowName) {
                if ($index != substr($rowName, 0, 1)) {
                    $index = substr($rowName, 0, 1);
                    if ($i%$catRows==0) {
                        $i=1;
                    }else{
                        $i++;
                    }

                    $categorieRows[$i] .= (!$firstCol ? "<br />" : "")."<b>".$index."</b><br />".substr($rowName,1);
                    if ($i == $catRows && $firstCol) {
                        $firstCol = false;
                    }
                } else {
                    $categorieRows[$i] .= substr($rowName,1);
                }
            }
        }

        //spez fields
        $objResult = $objDatabase->Execute("SELECT id, value FROM ".DBPREFIX."module_market_spez_fields WHERE lang_id = '1'");
        if ($objResult !== false) {
            while(!$objResult->EOF) {
                $spezFields[$objResult->fields['id']] = $objResult->fields['value'];
                $objResult->MoveNext();
            }
        }

        // set variables
        $this->_objTpl->setVariable(array(
            'MARKET_SEARCH_PAGING'            => $paging,
            'MARKET_CATEGORY_ROW_WIDTH'        => $categorieRowWidth,
            'MARKET_CATEGORY_ROW1'            => $categorieRows[1]."<br />",
            'MARKET_CATEGORY_ROW2'            => $categorieRows[2]."<br />",
            'MARKET_CATEGORY_TITLE'            => $title,
            'MARKET_CATEGORY_DESCRIPTION'    => $description,
            'DIRECTORY_INSERT_ENTRIES'        => $insertFeeds,
            'TXT_MARKET_ENDDATE'            => $_CORELANG['TXT_END_DATE'],
            'TXT_MARKET_TITLE'                => $_ARRAYLANG['TXT_MARKET_TITLE'],
            'TXT_MARKET_PRICE'                => $_ARRAYLANG['TXT_MARKET_PRICE'],
            'TXT_MARKET_CITY'                => $_ARRAYLANG['TXT_MARKET_CITY'],
            'MARKET_TYPE_SECECTION'            => $selector,
            'TXT_MARKET_SPEZ_FIELD_1'        => $spezFields[1],
            'TXT_MARKET_SPEZ_FIELD_2'        => $spezFields[2],
            'TXT_MARKET_SPEZ_FIELD_3'        => $spezFields[3],
            'TXT_MARKET_SPEZ_FIELD_4'        => $spezFields[4],
            'TXT_MARKET_SPEZ_FIELD_5'        => $spezFields[5],
        ));

    }


    function showEntries($catId)
    {
        global $objDatabase, $_ARRAYLANG;

        $today = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $type                 = "";
        $typePaging            = "";

        if ($this->settings['maxdayStatus'] != 0) {
            $this->checkEnddate();
        }

        if (!isset($_GET['type'])) {
            $_GET['type'] = '';
        }

        switch ($_GET['type']) {
            case 'offer':
                $type                = "AND type='offer'";
                $typePaging            = "&type=offer";
            break;
            case 'search':
                $type                 = "AND type ='search'";
                $typePaging            = "&type=search";
            break;
            default:
                $type                 = "";
                $typePaging            = "";
            break;
        }

        switch ($_GET['sort']) {
            case 'title':
                $sort                = "title";
                $sortPaging            = "&sort=title";
            break;
            case 'enddate':
                $sort                = "enddate";
                $sortPaging            = "&sort=enddate";
            break;
            case 'price':
                $sort                = "price";
                $sortPaging            = "&sort=price";
            break;
            case 'residence':
                $sort                = "residence";
                $sortPaging            = "&sort=residence";
            break;
            default:
                $sort                = "sort_id, enddate";
                $sortPaging            = "";
            break;
        }

        if (isset($_GET['way'])) {
            $way         = $_GET['way']=='ASC' ? 'DESC' : 'ASC';
            $wayPaging     = '&way='.$_GET['way'];
        }else{
            $way         = 'ASC';
            $wayPaging     = '';
        }

        $this->_objTpl->setVariable(array(
            'MARKET_ENDDATE_SORT'            => "?section=market&id=".$catId."&type=".$_GET['type']."&sort=enddate&way=".$way,
            'MARKET_TITLE_SORT'                => "?section=market&id=".$catId."&type=".$_GET['type']."&sort=title&way=".$way,
            'MARKET_PRICE_SORT'                => "?section=market&id=".$catId."&type=".$_GET['type']."&sort=price&way=".$way,
            'MARKET_CITY_SORT'                => "?section=market&id=".$catId."&type=".$_GET['type']."&sort=residence&way=".$way,
        ));

        if ($this->settings['maxdayStatus'] == 0) {
            $where = '';
        } else {
            $where = 'AND enddate >= "'.$today.'"';
        }

        /////// START PAGING ///////
        $pos= intval($_GET['pos']);

        if ($sort == 'price') {
            $query='SELECT `id`,`name`,`email`,`type`,`title`,`description`,`premium`,`picture`,`catid`, CAST(`price` AS UNSIGNED) as `price`,`regdate`,`enddate`,`userid`,`userdetails`,`status`,`regkey`,`paypal`,`spez_field_1`,`spez_field_2`,`spez_field_3`,`spez_field_4`,`spez_field_5` FROM '.DBPREFIX.'module_market WHERE catid = "'.contrexx_addslashes($catId).'" AND status="1" '.$where.' '.$type.' ORDER BY '.$sort.' '.$way;
        }else{
            $query='SELECT * FROM '.DBPREFIX.'module_market WHERE catid = "'.contrexx_addslashes($catId).'" AND status="1" '.$where.' '.$type.' ORDER BY '.$sort.' '.$way;
        }

        $objResult = $objDatabase->Execute($query);
        $count = $objResult->RecordCount();
        if ($count > $this->settings['paging']) {
            $paging = getPaging($count, $pos, "&section=market&id=".$catId.$typePaging.$sortPaging.$wayPaging, "<b>Inserate</b>", true, $this->settings['paging']);
        }

        $this->_objTpl->setVariable('SEARCH_PAGING', $paging);
        $objResult = $objDatabase->SelectLimit($query, $this->settings['paging'], $pos);
        /////// END PAGING ///////

        $i=0;
        if ($objResult !== false) {
               while (!$objResult->EOF) {
                   if (empty($objResult->fields['picture'])) {
                    $objResult->fields['picture'] = 'no_picture.gif';
                }

                   $info         = getimagesize($this->mediaPath.'pictures/'.$objResult->fields['picture']);
                   $height     = '';
                   $width         = '';

                   if ($info[0] <= $info[1]) {
                    if ($info[1] > 50) {
                        $faktor = $info[1]/50;
                        $height = 50;
                        $width    = $info[0]/$faktor;
                    } else {
                        $height = $info[1];
                        $width = $info[0];
                    }
                }else{
                    $faktor = $info[0]/80;
                    $result = $info[1]/$faktor;
                    if ($result > 50) {
                        if ($info[1] > 50) {
                            $faktor = $info[1]/50;
                            $height = 50;
                            $width    = $info[0]/$faktor;
                        }else{
                            $height = $info[1];
                            $width = $info[0];
                        }
                    }else{
                        if ($info[0] > 80) {
                            $width = 80;
                            $height = $info[1]/$faktor;
                        }else{
                            $width = $info[0];
                            $height = $info[1];
                        }
                    }
                }
                $width != '' ? $width = 'width="'.round($width,0).'"' : $width = '';
                $height != '' ? $height = 'height="'.round($height,0).'"' : $height = '';
                $image = '<img src="'.$this->mediaWebPath.'pictures/'.$objResult->fields['picture'].'" '.$width.' '.$height.' border="0" alt="'.$objResult->fields['title'].'" />';
                $objFWUser = FWUser::getFWUserObject();
                $objUser = $objFWUser->objUser->getUser($objResult->fields['userid']);
                if ($objUser) {
                    $city = $objUser->getProfileAttribute('city');
                }

                   if ($objResult->fields['premium'] == 1) {
                       $row = "marketRow1";
                   }else{
                       $row = $i % 2 == 0 ? 'marketRow2' : 'marketRow3';
                   }

                   $enddate = date("d.m.Y", $objResult->fields['enddate']);

                   if ($objResult->fields['price'] == 'forfree') {
                       $price = $_ARRAYLANG['TXT_MARKET_FREE'];
                   }elseif ($objResult->fields['price'] == 'agreement') {
                       $price = $_ARRAYLANG['TXT_MARKET_ARRANGEMENT'];
                   }else{
                       $price = $objResult->fields['price'].' '.$this->settings['currency'];
                   }

                   $this->_objTpl->setVariable(array(
                    'MARKET_ENDDATE'            => $enddate,
                    'MARKET_TITLE'                => $objResult->fields['title'],
					'MARKET_COLOR'                => $objResult->fields['color'],
                    'MARKET_DESCRIPTION'        => substr($objResult->fields['description'], 0, 110)."<a href='index.php?section=market&cmd=detail&id=".$objResult->fields['id']."' target='_self'>[...]</a>",
                    'MARKET_PRICE'                => $price,
                    'MARKET_PICTURE'            => $image,
                    'MARKET_ROW'                => $row,
                    'MARKET_DETAIL'                => "index.php?section=market&cmd=detail&id=".$objResult->fields['id'],
                    'MARKET_ID'                    => $objResult->fields['id'],
                    'MARKET_CITY'                => $city,
                    'MARKET_SPEZ_FIELD_1'        => $objResult->fields['spez_field_1'],
                    'MARKET_SPEZ_FIELD_2'        => $objResult->fields['spez_field_2'],
                    'MARKET_SPEZ_FIELD_3'        => $objResult->fields['spez_field_3'],
                    'MARKET_SPEZ_FIELD_4'        => $objResult->fields['spez_field_4'],
                    'MARKET_SPEZ_FIELD_5'        => $objResult->fields['spez_field_5'],
                ));

                $this->_objTpl->parse('showEntries');

                $i++;
                $objResult->MoveNext();
               }

           }



           if ($count <= 0) {
            $this->_objTpl->setVariable(array(
                'MARKET_NO_ENTRIES_FOUND'            => $_ARRAYLANG['TXT_MARKET_NO_ENTRIES_FOUND'],
            ));

            $this->_objTpl->parse('noEntries');
        }


    }

    function showLatestEntries()
    {
        global $objDatabase, $_ARRAYLANG;

        if ($this->_objTpl->blockExists('showLatestEntries')) {
            $objEntries = $objDatabase->SelectLimit('SELECT id, title, picture FROM '.DBPREFIX.'module_market WHERE status !=0 ORDER BY id DESC', 4);
            $colCount = 2;
            $entryNr = 1;
            $rowNr = 1;

            if ($objEntries && $objEntries->RecordCount() > 0) {
                   while (!$objEntries->EOF) {
                       if ($objEntries->fields['picture'] == '') {
                           $pic = 'no_picture.gif';
                       } else {
                           $pic = $objEntries->fields['picture'];
                       }
                       $info         = getimagesize($this->mediaPath.'pictures/'.$pic);
                       $height     = '';
                       $width         = '';

                       if ($info[0] <= $info[1]) {
                           $height = 50;
                       } else {
                           $faktor = $info[0]/80;
                           $result = $info[1]/$faktor;
                           if ($result > 50) {
                               $height = 50;
                           } else {
                               $width = 80;
                           }
                       }

                    $width != '' ? $width = 'width="'.$width.'"' : $width = '';
                    $height != '' ? $height = 'height="'.$height.'"' : $height = '';

                       $image = '<img src="'.$this->mediaWebPath.'pictures/'.$pic.'" '.$width.' '.$height.' border="0" alt="'.$objEntries->fields['title'].'" />';

                       $this->_objTpl->setVariable(array(
                        'MARKET_TITLE'                => htmlentities($objEntries->fields['title'], ENT_QUOTES, CONTREXX_CHARSET),
                        'MARKET_PICTURE'            => $image,
                        'MARKET_ROW'                => ($entryNr % 2 == ($rowNr % 2) ? 'description' : 'description'),
                        'MARKET_DETAIL'                => "index.php?section=market&cmd=detail&id=".$objEntries->fields['id']
                    ));
                    $this->_objTpl->parse('showLatestEntryCols');
                    if ($entryNr % $colCount == 0) {
                        $rowNr++;
                        $this->_objTpl->parse('showLatestEntryRows');
                    }

                    $entryNr++;
                    $objEntries->MoveNext();
                   }

                   $this->_objTpl->parse('showLatestEntries');
               } else {
                   $this->_objTpl->hideBlock('showLatestEntries');
               }
        }
    }


    function getSearch() {

         global $objDatabase, $_ARRAYLANG, $_CORELANG;

         $options = '';

         if  ($this->settings['indexview']['value'] == 1) {
            $order = "name";
        } else {
            $order = "displayorder";
        }

        $objResultSearch = $objDatabase->Execute("SELECT id, name, description FROM ".DBPREFIX."module_market_categories WHERE status = '1' ORDER BY ".$order."");

        if ($objResultSearch !== false) {
            while(!$objResultSearch->EOF) {
                $options .= '<option value="'.$objResultSearch->fields['id'].'">'.$objResultSearch->fields['name'].'</option>';
                $objResultSearch->MoveNext();
            }
        }

        $inputs     .= '<p><label for="catid">'.$_ARRAYLANG['TXT_MARKET_CATEGORY'].'</label><select id="catid" name="catid"><option value="">'.$_ARRAYLANG['TXT_MARKET_ALL_CATEGORIES'].'</option>'.$options.'</select></p>';
        $inputs     .= '<p><label for="type">'.$_ARRAYLANG['TXT_TYPE'].'</label><select id="type" name="type"><option value="">'.$_ARRAYLANG['TXT_MARKET_ALL_TYPES'].'</option><option value="offer">'.$_ARRAYLANG['TXT_MARKET_OFFER'].'</option><option value="search">'.$_ARRAYLANG['TXT_MARKET_SEARCH'].'</option></select></p>';

        $options = '';

        $arrPrices = explode(",", $this->settings['searchPrice']);

        foreach ($arrPrices as $priceValue) {
            $options .= '<option value="'.$priceValue.'">'.$priceValue.' '.$this->settings['currency'].'</option>';
        }

        $inputs     .= '<p><label for="cpricetid">'.$_ARRAYLANG['TXT_MARKET_PRICE_MAX'].'</label><select id="price" name="price"><option value="">'.$_ARRAYLANG['TXT_MARKET_ALL_PRICES'].'</option>'.$options.'</select></p>';


        // set variables
        $this->_objTpl->setVariable(array(
            'TXT_MARKET_SEARCH'                    => $_CORELANG['TXT_SEARCH'],
            'TXT_MARKET_SEARCH_EXP'                => $_CORELANG['TXT_EXP_SEARCH'],
            'MARKET_EXP_SEARCH_FIELD'             => $inputs,
        ));
    }



    function getDescription($id)
    {
        global $objDatabase, $_ARRAYLANG;

        //get categorie
        if ($this->settings['description'] == 1) {
            $objResult = $objDatabase->Execute("SELECT description FROM ".DBPREFIX."module_market_categories WHERE status = '1' AND id = '".contrexx_addslashes($id)."' ORDER BY id DESC");
            if ($objResult !== false) {
                while(!$objResult->EOF) {
                    $description = "<br/>".$objResult->fields['description'];
                    $objResult->MoveNext();
                }
            }
        }else{
            $description = "";
        }

        return $description;
    }



    function getNavigation($catId) {

        global $objDatabase, $_ARRAYLANG;

        //get categorie
         $objResult = $objDatabase->Execute("SELECT  id, name FROM ".DBPREFIX."module_market_categories WHERE status = '1' AND id = '".contrexx_addslashes($catId)."'");
        if ($objResult !== false)    {
            if ($objResult->fields['name'] != '') {
                $verlauf = "&nbsp;&raquo;&nbsp;<a href='index.php?section=market&amp;id=".$catId."'>".$objResult->fields['name']."</a>";
            }else{
                $verlauf = "";
            }
         }

         // set variables
        $this->_objTpl->setVariable(array(
            'TXT_MARKET'                    => $_ARRAYLANG['TXT_ENTRIES'],
            'MARKET_CATEGORY_NAVI'            => $verlauf,
        ));
    }



    function entryDetails($id) {

        global $objDatabase, $_ARRAYLANG, $_CORELANG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        //get erntry
        $this->getEntries('', 'id', $id);

        if (isset($id) && count($this->entries) != 0) {

            //get search
            $this->getSearch();

            //get navigatin
            $this->getNavigation($this->entries[$id]['catid']);

            $enddate = date("d.m.Y", $this->entries[$id]['enddate']);
            $info         = getimagesize($this->mediaPath.'pictures/'.$this->entries[$id]['picture']);
            $height     = '';
            $width         = '';

            if ($info[0] <= $info[1]) {
                if ($info[1] > 200) {
                    $faktor = $info[1]/200;
                    $height = 200;
                    $width    = $info[0]/$faktor;
                } else {
                    $height = $info[1];
                    $width = $info[0];
                }
            }else{
                $faktor = $info[0]/300;
                $result = $info[1]/$faktor;
                if ($result > 200) {
                    if ($info[1] > 200) {
                        $faktor = $info[1]/200;
                        $height = 200;
                        $width    = $info[0]/$faktor;
                    }else{
                        $height = $info[1];
                        $width = $info[0];
                    }
                }else{
                    if ($info[0] > 300) {
                        $width = 300;
                        $height = $info[1]/$faktor;
                    }else{
                        $width = $info[0];
                        $height = $info[1];
                    }
                }
            }

            $width != '' ? $width = 'width="'.round($width,0).'"' : $width = '';
            $height != '' ? $height = 'height="'.round($height,0).'"' : $height = '';

            $image = '<img src="'.$this->mediaWebPath.'pictures/'.$this->entries[$id]['picture'].'" '.$width.' '.$height.' border="0" alt="'.$this->entries[$id]['title'].'" />';

            $user         = $this->entries[$id]['name'].'<br /><br />';
            $userMail    = '<a href="mailto:'.$this->entries[$id]['email'].'">'.$this->entries[$id]['email'].'</a><br />';

            //user details
            $objFWUser = FWUser::getFWUserObject();
            $objUser = $objFWUser->objUser->getUser($this->entries[$id]['userid']);
            if ($objUser) {
                    $objUser->getProfileAttribute('address') != '' ? $street = $objUser->getProfileAttribute('address').'<br />' : $street = '';
                    $objUser->getProfileAttribute('phone_office') != '' ? $phone = $objUser->getProfileAttribute('phone_office').'<br />' : $phone = '';
                    $objUser->getProfileAttribute('phone_mobile') != '' ? $mobile = $objUser->getProfileAttribute('phone_mobile').'<br /><br />' : $mobile = '';
                    if ($objUser->getProfileAttribute('zip') != '' || $objUser->getProfileAttribute('zip') != 0) {
                        $zip = $objUser->getProfileAttribute('zip').' ';
                    } else {
                        $zip = '';
                    }
                    $objUser->getProfileAttribute('city') != '' ? $city = $objUser->getProfileAttribute('city').'<br />' : $city = '';
                    $objUser->getProfileAttribute('website') != '' ? $webpage = '<a href="http://:'.$objUser->getProfileAttribute('website').'" target="_blank">'.$objUser->getProfileAttribute('website').'</a><br />' : $webpage = '';

                $TXTuserDetails = $_ARRAYLANG['TXT_MARKET_CONTACT'];
                $userDetails =     $user.$street.$zip.$city.$phone.$mobile.$userMail.$webpage;

                $residence = $objUser->getProfileAttribute('zip').' '.$objUser->getProfileAttribute('city');
            } else {
            	$TXTuserDetails 	= $_ARRAYLANG['TXT_MARKET_CONTACT'];
                $userDetails 		= $user.$userMail;
            }

            if ($this->entries[$id]['userdetails'] != 1) {
                $userDetails = '';
                $TXTuserDetails = '';
            }

            //type
            if ($this->entries[$id]['type'] == "offer") {
                $type         = $_ARRAYLANG['TXT_MARKET_OFFER'];
                $txtplace     = $_ARRAYLANG['TXT_MARKET_PLACE'];
                $place         = $residence;
            }else{
                $type         = $_ARRAYLANG['TXT_MARKET_SEARCH'];
                $txtplace     = '';
                $place         = '';
            }

            //spez fields
            $objResult = $objDatabase->Execute("SELECT id, value FROM ".DBPREFIX."module_market_spez_fields WHERE lang_id = '1'");
              if ($objResult !== false) {
                while(!$objResult->EOF) {
                    $spezFields[$objResult->fields['id']] = $objResult->fields['value'];
                    $objResult->MoveNext();
                }
              }

            //price
            if ($this->entries[$id]['price'] == 'forfree') {
                   $price = $_ARRAYLANG['TXT_MARKET_FREE'];
               }elseif ($this->entries[$id]['price'] == 'agreement') {
                   $price = $_ARRAYLANG['TXT_MARKET_ARRANGEMENT'];
               }else{
                   $price = $this->entries[$id]['price'].' '.$this->settings['currency'];
               }

               if ($this->settings['maxdayStatus'] == 1) {
                $enddate = $_ARRAYLANG['TXT_MARKET_ADVERTISEMENT_ONLINE'].' '.$enddate;
            } else {
                $enddate = "";
            }

            // set variables
            $this->_objTpl->setVariable(array(
                'MARKET_TITLE'                    => $this->entries[$id]['title'],
                'MARKET_COLOR'                    => $this->entries[$id]['color'],
                'MARKET_ID'                        => $id,
                'MARKET_EDIT'                    => '<a href="index.php?section=market&amp;cmd=edit&amp;id='.$id.'">'.$_ARRAYLANG['TXT_EDIT_ADVERTISEMENT'].'</a>',
                'MARKET_DEL'                    => '<a href="index.php?section=market&amp;cmd=del&amp;id='.$id.'">'.$_ARRAYLANG['TXT_MARKET_DELETE_ADVERTISEMENT'].'</a>',
                'MARKET_TYPE'                    => $type,
                'MARKET_USER_DETAILS'             => $userDetails,
                'TXT_MARKET_USER_DETAILS'         => $TXTuserDetails,
                'MARKET_DESCRIPTION'             => $this->entries[$id]['description'],
                'TXT_MARKET_PLACE'                 => $txtplace,
                'MARKET_PLACE'                     => $place,
                'TXT_MARKET_PRICE'                 => $_ARRAYLANG['TXT_MARKET_PRICE'],
                'MARKET_PRICE'                     => $price,
                'TXT_MARKET_MESSAGE'             => $_ARRAYLANG['TXT_MARKET_SEND_MESSAGE'],
                'TXT_MARKET_TITLE'                 => $_ARRAYLANG['TXT_MARKET_TITLE'],
                'TXT_MARKET_MSG_TITLE'             => $_ARRAYLANG['TXT_MARKTE_MESSAGE_ABOUT'].' ',
                'TXT_MARKET_MSG'                 => $_ARRAYLANG['TXT_MARKET_MESSAGE'],
                'TXT_MARKET_SEND'                 => $_ARRAYLANG['TXT_MARKET_SEND'],
                'MARKET_ENDDATE'                 => $enddate,
                'TXT_FIELDS_REQUIRED'            => $_ARRAYLANG['TXT_MARKET_CATEGORY_ADD_FILL_FIELDS'],
                'TXT_THOSE_FIELDS_ARE_EMPTY'    => $_ARRAYLANG['TXT_MARKET_FIELDS_NOT_CORRECT'],
                'TXT_MARKET_NAME'                 => $_CORELANG['TXT_NAME'],
                'TXT_MARKET_EMAIL'                 => $_CORELANG['TXT_EMAIL'],
                'TXT_MARKET_PRICE_MSG'             => $_ARRAYLANG['TXT_MARKET_PRICE_IS'],
                'TXT_MARKET_NEW_PRICE'             => $_ARRAYLANG['TXT_PRICE_EXPECTATION'],
                'TXT_MARKET_SPEZ_FIELD_1'        => $spezFields[1],
                'TXT_MARKET_SPEZ_FIELD_2'        => $spezFields[2],
                'TXT_MARKET_SPEZ_FIELD_3'        => $spezFields[3],
                'TXT_MARKET_SPEZ_FIELD_4'        => $spezFields[4],
                'TXT_MARKET_SPEZ_FIELD_5'        => $spezFields[5],
                'MARKET_SPEZ_FIELD_1'            => $this->entries[$id]['spez_field_1'],
                'MARKET_SPEZ_FIELD_2'            => $this->entries[$id]['spez_field_2'],
                'MARKET_SPEZ_FIELD_3'            => $this->entries[$id]['spez_field_3'],
                'MARKET_SPEZ_FIELD_4'            => $this->entries[$id]['spez_field_4'],
                'MARKET_SPEZ_FIELD_5'            => $this->entries[$id]['spez_field_5'],
            ));

            if ($this->_objTpl->blockExists('market_picture')) {
                if (!empty($this->entries[$id]['picture'])) {
                    $this->_objTpl->setVariable('MARKET_PICTURE', $image);
                    $this->_objTpl->parse('market_picture');
                } else {
                    $this->_objTpl->hideBlock('market_picture');
                }
            } else {
                $this->_objTpl->setVariable('MARKET_PICTURE', $image);
            }
        }else{
            CSRF::header('Location: ?section=market');
        }
    }



    function sendMessage($id) {

        global $objDatabase, $_ARRAYLANG, $_CORELANG, $_CONFIG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        //get erntry
        $this->getEntries('', 'id', $id);

        if (isset($id) && count($this->entries) != 0) {
            //get search
            $this->getSearch();

            //get navigatin
            $this->getNavigation($this->entries[$id]['catid']);

            if ($_POST['title'] != '' && $_POST['message'] != '') {
                //create mail
                $sendTo        = $this->entries[$id]['email'];
                $fromName    = $_POST['name'];
                $fromMail    = $_POST['email'];
                $subject     = $_POST['title'];
                $newPrice     = $_POST['newprice']!='' ? "\n\n".$_ARRAYLANG['TXT_PRICE_EXPECTATION']."\n".$_POST['newprice'] : '';
                $oldPrice     = $_POST['price']!='' ? "\n\n".$_ARRAYLANG['TXT_MARKET_MESSAGE_PRICE']."\n".$_POST['price'] : '';
                $message     = $_POST['message'].$oldPrice.$newPrice;

                if (@include_once ASCMS_LIBRARY_PATH.'/phpmailer/class.phpmailer.php') {
                    $objMail = new phpmailer();

                    if ($_CONFIG['coreSmtpServer'] > 0 && @include_once ASCMS_CORE_PATH.'/SmtpSettings.class.php') {
                        if (($arrSmtp = SmtpSettings::getSmtpAccount($_CONFIG['coreSmtpServer'])) !== false) {
                            $objMail->IsSMTP();
                            $objMail->Host = $arrSmtp['hostname'];
                            $objMail->Port = $arrSmtp['port'];
                            $objMail->SMTPAuth = true;
                            $objMail->Username = $arrSmtp['username'];
                            $objMail->Password = $arrSmtp['password'];
                        }
                    }

                    $objMail->CharSet = CONTREXX_CHARSET;
                    $objMail->From = $fromMail;
                    $objMail->FromName = $fromName;
                    $objMail->AddReplyTo($fromMail);
                    $objMail->Subject = $subject;
                    $objMail->IsHTML(false);
                    $objMail->Body = $message;
                    $objMail->AddAddress($sendTo);
                    $objMail->Send();
                }

                // set variables
                $this->_objTpl->setVariable(array(
                    'MARKET_TITLE'                    => $_ARRAYLANG['TXT_MARKET_MESSAGE_SUCCESS_TITLE'],
                    'MARKET_MSG_SEND'                => $_ARRAYLANG['TXT_MARKET_MESSAGE_SUCCESS_BODY'],
                    'TXT_MARKET_BACK'                => $_CORELANG['TXT_BACK'],
                ));
            }
        }else{
            CSRF::header('Location: ?section=market');
        }
    }


    function checkEnddate()
    {
        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        $today = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $objDatabase->Execute('UPDATE '.DBPREFIX.'module_market SET status = 0 WHERE enddate < '.$today.'');
    }


    function addEntry()
    {
        global $objDatabase, $_CORELANG, $_ARRAYLANG, $_CONFIG;


        if (!$this->settings['addEntry'] == '1' || (!$this->communityModul && $this->settings['addEntry_only_community'] == '1')) {
            CSRF::header('Location: index.php?section=market');
            exit;
        }elseif ($this->settings['addEntry_only_community'] == '1') {
            $objFWUser = FWUser::getFWUserObject();
            if ($objFWUser->objUser->login()) {
                if (!Permission::checkAccess(99, 'static', true)) {
                    CSRF::header("Location: ".CONTREXX_DIRECTORY_INDEX."?section=login&cmd=noaccess");
                    exit;
                }
            }else {
                $link = base64_encode(CONTREXX_DIRECTORY_INDEX.'?'.$_SERVER['QUERY_STRING']);
                CSRF::header("Location: ".CONTREXX_DIRECTORY_INDEX."?section=login&redirect=".$link);
                exit;
            }
        } else {
            $objFWUser = FWUser::getFWUserObject();
        }

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        //get search
        $this->getSearch();

        //get navigatin
        $this->getNavigation('');

        $this->getCategories();
        $categories = '';
        foreach(array_keys($this->categories) as $catId) {
            $categories .= '<option value="'.$catId.'">'.$this->categories[$catId]['name'].'</option>';
        }

        $daysOnline = '';
        for($x = $this->settings['maxday']; $x >= 1; $x--) {
            $daysOnline .= '<option value="'.$x.'">'.$x.'</option>';
        }

        //get premium
        $objReslut = $objDatabase->Execute("SELECT price_premium FROM ".DBPREFIX."module_market_paypal WHERE id = '1'");
          if ($objReslut !== false) {
            while(!$objReslut->EOF) {
                $premium     = $objReslut->fields['price_premium'];
                $objReslut->MoveNext();
            }
          }

          if ($premium == '' || $premium == '0.00' || $premium == '0') {
              $premium = '';
          }else{
              $premium = $_ARRAYLANG['TXT_MARKET_ADDITIONAL_FEE'].$premium.' '.$_ARRAYLANG['TXT_MARKET_CURRENCY'];
          }

          if ($this->settings['maxdayStatus'] == 1) {
            $daysOnline = '';
            for($x = $this->settings['maxday']; $x >= 1; $x--) {
                $daysOnline .= '<option value="'.$x.'">'.$x.'</option>';
            }

            $daysJS = 'if (days.value == "") {
                            errorMsg = errorMsg + "- '.$_ARRAYLANG['TXT_MARKET_DURATION'].'\n";
                       }
                       ';
        }

        $this->_objTpl->setVariable(array(
            'TXT_MARKET_NAME'                        =>    $_CORELANG['TXT_NAME'],
            'TXT_MARKET_EMAIL'                        =>    $_CORELANG['TXT_EMAIL'],
            'TXT_MARKET_TITLE_ENTRY'                =>    $_ARRAYLANG['TXT_MARKET_TITLE'],
            'TXT_MARKET_DESCRIPTION'                =>    $_CORELANG['TXT_DESCRIPTION'],
            'TXT_MARKET_SAVE'                        =>    $_CORELANG['TXT_ADD'],
            'TXT_MARKET_FIELDS_REQUIRED'            =>    $_ARRAYLANG['TXT_MARKET_CATEGORY_ADD_FILL_FIELDS'],
            'TXT_MARKET_THOSE_FIELDS_ARE_EMPTY'        =>    $_ARRAYLANG['TXT_MARKET_FIELDS_NOT_CORRECT'],
            'TXT_MARKET_PICTURE'                    =>    $_ARRAYLANG['TXT_MARKET_IMAGE'],
            'TXT_MARKET_CATEGORIE'                    =>    $_ARRAYLANG['TXT_MARKET_CATEGORY'],
            'TXT_MARKET_PRICE'                        =>    $_ARRAYLANG['TXT_MARKET_PRICE'].' '.$this->settings['currency'],
            'TXT_MARKET_TYPE'                        =>    $_CORELANG['TXT_TYPE'],
            'TXT_MARKET_OFFER'                        =>    $_ARRAYLANG['TXT_MARKET_OFFER'],
            'TXT_MARKET_SEARCH'                        =>    $_ARRAYLANG['TXT_MARKET_SEARCH'],
            'TXT_MARKET_FOR_FREE'                    =>    $_ARRAYLANG['TXT_MARKET_FREE'],
            'TXT_MARKET_AGREEMENT'                    =>    $_ARRAYLANG['TXT_MARKET_ARRANGEMENT'],
            'TXT_MARKET_END_DATE'                    =>    $_ARRAYLANG['TXT_MARKET_DURATION'],
            'END_DATE_JS'                            =>    $daysJS,
            'TXT_MARKET_ADDED_BY'                    =>    $_ARRAYLANG['TXT_MARKET_ADDEDBY'],
            'TXT_MARKET_USER_DETAIL'                =>    $_ARRAYLANG['TXT_MARKET_USERDETAILS'],
            'TXT_MARKET_DETAIL_SHOW'                =>    $_ARRAYLANG['TXT_MARKET_SHOW_IN_ADVERTISEMENT'],
            'TXT_MARKET_DETAIL_HIDE'                =>    $_ARRAYLANG['TXT_MARKET_NO_SHOW_IN_ADVERTISEMENT'],
            'TXT_MARKET_PREMIUM'                    =>    $_ARRAYLANG['TXT_MARKET_MARK_ADVERTISEMENT'],
            'TXT_MARKET_DAYS'                        =>    $_ARRAYLANG['TXT_MARKET_DAYS']
        ));

        if ($this->settings['maxdayStatus'] != 1) {
            $this->_objTpl->hideBlock('end_date_dropdown');
        }

        $objReslut = $objDatabase->Execute("SELECT id, name, value FROM ".DBPREFIX."module_market_spez_fields WHERE lang_id = '1' AND active='1' ORDER BY id DESC");
        if ($objReslut !== false) {
            $i = 0;
            while(!$objReslut->EOF) {
                $this->_objTpl->setCurrentBlock('spez_fields');

// TODO: Never used
//                ($i % 2)? $class = "row2" : $class = "row1";
                $input = '<input type="text" name="spez_'.$objReslut->fields['id'].'" style="width: 300px;" maxlength="100">';

                // initialize variables
                $this->_objTpl->setVariable(array(
                    'TXT_MARKET_SPEZ_FIELD_NAME'    => $objReslut->fields['value'],
                    'MARKET_SPEZ_FIELD_INPUT'          => $input,
                ));

                $this->_objTpl->parse('spez_fields');
                $i++;
                $objReslut->MoveNext();
            }
          }

        $this->_objTpl->setVariable(array(
            'TXT_MARKET_PREMIUM_CONDITIONS'            =>    $premium,
            'MARKET_CATEGORIES'                        =>    $categories,
            'MARKET_ENTRY_ADDEDBY'                    =>    htmlentities($objFWUser->objUser->getUsername(), ENT_QUOTES, CONTREXX_CHARSET),
            'MARKET_ENTRY_USERDETAILS_ON'            =>    "checked",
            'MARKET_ENTRY_TYPE_OFFER'                =>    "checked",
            'MARKET_DAYS_ONLINE'                    =>    $daysOnline,
        ));
    }



    function confirmEntry() {

        global $objDatabase, $_ARRAYLANG, $_CONFIG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        //get search
        $this->getSearch();

        //get navigatin
        $this->getNavigation($this->entries[$id]['catid']);

        if (isset($_POST['submitEntry']) || isset($_POST['submit'])) {

            if (isset($_POST['submitEntry'])) {
                $this->insertEntry('0');
                $id = $objDatabase->Insert_ID();
            }

            if (isset($_POST['submit'])) {
                $id         = contrexx_addslashes($_POST['id']);
                $regkey     = contrexx_addslashes($_POST['regkey']);

                $objResult = $objDatabase->Execute("SELECT id, regkey, userid FROM ".DBPREFIX."module_market WHERE id = '".$id."' AND regkey='".$regkey."'");
                if ($objResult !== false) {
                    $count = $objResult->RecordCount();
                    while(!$objResult->EOF) {
                        $today = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
                        $objResultUpdate = $objDatabase->Execute("UPDATE ".DBPREFIX."module_market SET status='1', regkey='', regdate='".$today."' WHERE id='".$objResult->fields['id']."'");

                        $this->sendMail($id);

                        if ($objResultUpdate !== false) {
                            CSRF::header('Location: ?section=market&cmd=detail&id='.$objResult->fields['id'].'');
                        }

                        $objResult->MoveNext();
                    }
                 }

                 if ($count == 0) {
                     $error = $_ARRAYLANG['TXT_MARKET_CLEARING_CODE_NOT_EXISTING'];
                 }
            }

            //get paypal
            $objResult = $objDatabase->Execute("SELECT value FROM ".DBPREFIX."module_market_settings WHERE id = '11'");
              if ($objResult !== false) {
                while(!$objResult->EOF) {
                    $codeMode         = $objResult->fields['value'];
                    $objResult->MoveNext();
                }
              }

              if ($codeMode == '0') {
                  $this->_objTpl->touchBlock('infoText');
                  $this->_objTpl->hideBlock('codeForm');
              }else{
                  $confirmForm    = '<form action="index.php?section=market&cmd=confirm" method="post" name="marketSearch" id="marketAGB">
                                   <input type="hidden" name="id" value="'.$id.'" >
                                   <input id="regkey" name="regkey" value="" size="25" maxlength="100" />&nbsp;<input id="submit" type="submit" value="Freischalten" name="submit" />
                                   </form>';

                  $this->_objTpl->parse('codeForm');
                  $this->_objTpl->hideBlock('infoText');
              }

            // set variables
            $this->_objTpl->setVariable(array(
                'TXT_MARKET_TITLE'            => $_ARRAYLANG['TXT_MARKET_REQUIREMENTS'],
                'TXT_MARKET_AGB'            => $_ARRAYLANG['TXT_MARKET_AGB'],
                'TXT_MARKET_CONFIRM'        => $_ARRAYLANG['TXT_MARKET_AGB_ACCEPT'],
                'MARKET_ERROR_CONFIRM'        => $error,
                'MARKET_FORM'                => $confirmForm,
            ));

        }else{
            CSRF::header('Location: ?section=market&cmd=add');
        }
    }



    function searchEntry() {

        global $objDatabase, $_ARRAYLANG, $_CORELANG, $_CONFIG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        //get search
        $this->getSearch();

        //get navigatin
        $this->getNavigation('');

        //spez fields
        $objResult = $objDatabase->Execute("SELECT id, value FROM ".DBPREFIX."module_market_spez_fields WHERE lang_id = '1'");
        if ($objResult !== false) {
            while(!$objResult->EOF) {
                $spezFields[$objResult->fields['id']] = $objResult->fields['value'];
                $objResult->MoveNext();
            }
        }

        // set variables
        $this->_objTpl->setVariable(array(
            'MARKET_SEARCH_PAGING'            => $paging,
            'TXT_MARKET_ENDDATE'            => $_CORELANG['TXT_END_DATE'],
            'TXT_MARKET_TITLE'                => $_ARRAYLANG['TXT_MARKET_TITLE'],
            'TXT_MARKET_PRICE'                => $_ARRAYLANG['TXT_MARKET_PRICE'],
            'TXT_MARKET_CITY'                => $_ARRAYLANG['TXT_MARKET_CITY'],
            'TXT_MARKET_SPEZ_FIELD_1'        => $spezFields[1],
            'TXT_MARKET_SPEZ_FIELD_2'        => $spezFields[2],
            'TXT_MARKET_SPEZ_FIELD_3'        => $spezFields[3],
            'TXT_MARKET_SPEZ_FIELD_4'        => $spezFields[4],
            'TXT_MARKET_SPEZ_FIELD_5'        => $spezFields[5],
        ));

        $today                 = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
        $searchTermOrg         = contrexx_addslashes($_GET['term']);
        $searchTerm         = contrexx_addslashes($_GET['term']);
        $array = explode(' ', $searchTerm);
        for($x = 0; $x < count($array); $x++) {
            $tmpTerm .= $array[$x].'%';
        }

        $searchTerm    = substr($tmpTerm, 0, -1);
        $searchTermExp = "&amp;check=norm&amp;term=".$searchTermOrg;

        if ($_GET['check'] == 'exp') {

            $searchTermExp = "&amp;check=exp&amp;term=".$searchTermOrg;

            if ($_GET['catid'] != '') {
                $query_search         .="AND catid LIKE ('%".$_GET['catid']."%') ";
                $searchTermExp        .= "&amp;catid=".$_GET['catid'];
            }
            if ($_GET['type'] != '') {
                $query_search         .="AND type LIKE ('%".$_GET['type']."%') ";
                $searchTermExp        .= "&amp;type=".$_GET['type'];
            }

            if ($_GET['price'] != '') {
                $query_search         .="AND price <= ".$_GET['price']." ";
                $searchTermExp        .= "&amp;price=".$_GET['price'];
            }
        }

        switch ($_GET['sort']) {
            case 'title':
                $sort                = "title";
                $sortPaging            = "&sort=title";
            break;
            case 'enddate':
                $sort                = "enddate";
                $sortPaging            = "&sort=enddate";
            break;
            case 'price':
                $sort                = "price";
                $sortPaging            = "&sort=price";
            break;
            default:
                $sort                = "sort_id, enddate";
                $sortPaging            = "";
            break;
        }

        if (isset($_GET['way'])) {
            $way         = $_GET['way']=='ASC' ? 'DESC' : 'ASC';
            $wayPaging     = '&way='.$_GET['way'];
        }else{
            $way         = 'ASC';
            $wayPaging     = '';
        }

        $this->_objTpl->setVariable(array(
            'MARKET_ENDDATE_SORT'            => "index.php?section=market&amp;cmd=search&amp;id=".$catId.$searchTermExp."&sort=enddate&way=".$way,
            'MARKET_TITLE_SORT'                => "index.php?section=market&amp;cmd=search&amp;id=".$catId.$searchTermExp."&sort=title&way=".$way,
            'MARKET_PRICE_SORT'                => "index.php?section=market&amp;cmd=search&amp;id=".$catId.$searchTermExp."&sort=price&way=".$way,
        ));

        if ($_GET['term'] != '') {
            $query="SELECT  id,
                            title,
                            description,
                            price,
                            picture,
                            userid,
                            enddate,
                            premium,
                            spez_field_1,
                            spez_field_2,
                            spez_field_3,
                            spez_field_4,
                            spez_field_5,
                      MATCH (title,description) AGAINST ('%$searchTerm%') AS score
                       FROM ".DBPREFIX."module_market
                      WHERE (title LIKE ('%$searchTerm%')
                              OR description LIKE ('%$searchTerm%')
                              OR spez_field_1 LIKE ('%$searchTerm%')
                              OR spez_field_2 LIKE ('%$searchTerm%')
                              OR spez_field_3 LIKE ('%$searchTerm%')
                              OR spez_field_4 LIKE ('%$searchTerm%')
                              OR spez_field_5 LIKE ('%$searchTerm%'))
                         ".$query_search."
                        AND status = '1'
                   ORDER BY score DESC, ".$sort." ".$way."";

            /////// START PAGING ///////
            $pos= intval($_GET['pos']);
            $objResult = $objDatabase->Execute($query);
            $count = $objResult->RecordCount();
            if ($count > $this->settings['paging']) {
                $paging = getPaging($count, $pos, "&section=market&cmd=search".$searchTermExp."&sort=".$sort."&way=".$way, "<b>Inserate</b>", true, $this->settings['paging']);
            }
            $this->_objTpl->setVariable('SEARCH_PAGING', $paging);
            $objResult = $objDatabase->SelectLimit($query, $this->settings['paging'], $pos);
            /////// END PAGING ///////

            if ($objResult !== false) {
                $i = 0;
                while (!$objResult->EOF) {
                    if (empty($objResult->fields['picture'])) {
                        $objResult->fields['picture'] = 'no_picture.gif';
                    }

                    $info         = getimagesize($this->mediaPath.'pictures/'.$objResult->fields['picture']);
                    $height     = '';
                    $width         = '';

                       if ($info[0] <= $info[1]) {
                        if ($info[1] > 50) {
                            $faktor = $info[1]/50;
                            $height = 50;
                            $width    = $info[0]/$faktor;
                        } else {
                            $height = $info[1];
                            $width = $info[0];
                        }
                    }else{
                        $faktor = $info[0]/80;
                        $result = $info[1]/$faktor;
                        if ($result > 50) {
                            if ($info[1] > 50) {
                                $faktor = $info[1]/50;
                                $height = 50;
                                $width    = $info[0]/$faktor;
                            }else{
                                $height = $info[1];
                                $width = $info[0];
                            }
                        }else{
                            if ($info[0] > 80) {
                                $width = 80;
                                $height = $info[1]/$faktor;
                            }else{
                                $width = $info[0];
                                $height = $info[1];
                            }
                        }
                    }

                    $width != '' ? $width = 'width="'.round($width,0).'"' : $width = '';
                    $height != '' ? $height = 'height="'.round($height,0).'"' : $height = '';

                    $image = '<img src="'.$this->mediaWebPath.'pictures/'.$objResult->fields['picture'].'" '.$width.'" '.$height.'" border="0" alt="'.$objResult->fields['title'].'" />';


                    $objFWUser = FWUser::getFWUserObject();
                    $objUser = $objFWUser->objUser->getUser($objResult->fields['userid']);
                    if ($objUser) {
                        $city = $objUser->getProfileAttribute('city');
                    }
                       if ($objResult->fields['premium'] == 1) {
                           $row = "marketRow1";
                       }else{
                           $row = $i%2==0 ? "marketRow2" : "marketRow3";
                       }

                       $enddate = date("d.m.Y", $objResult->fields['enddate']);

                       if ($objResult->fields['price'] == 'forfree') {
                           $price = $_ARRAYLANG['TXT_MARKET_FREE'];
                       }elseif ($objResult->fields['price'] == 'agreement') {
                           $price = $_ARRAYLANG['TXT_MARKET_ARRANGEMENT'];
                       }else{
                           $price = $objResult->fields['price'].' '.$this->settings['currency'];
                       }

                       $this->_objTpl->setVariable(array(
                        'MARKET_ENDDATE'                => $enddate,
                        'MARKET_TITLE'                    => $objResult->fields['title'],
                        'MARKET_DESCRIPTION'            => substr($objResult->fields['description'], 0, 110)."<a href='index.php?section=market&cmd=detail&id=".$objResult->fields['id']."' target='_self'>[...]</a>",
                        'MARKET_PRICE'                    => $price,
                        'MARKET_PICTURE'                => $image,
                        'MARKET_ROW'                    => $row,
                        'MARKET_DETAIL'                    => "index.php?section=market&cmd=detail&id=".$objResult->fields['id'],
                        'MARKET_ID'                        => $objResult->fields['id'],
                        'MARKET_CITY'                    => $city,
                        'MARKET_SPEZ_FIELD_1'            => $objResult->fields['spez_field_1'],
                        'MARKET_SPEZ_FIELD_2'            => $objResult->fields['spez_field_2'],
                        'MARKET_SPEZ_FIELD_3'            => $objResult->fields['spez_field_3'],
                        'MARKET_SPEZ_FIELD_4'            => $objResult->fields['spez_field_4'],
                        'MARKET_SPEZ_FIELD_5'            => $objResult->fields['spez_field_5'],
                    ));

                    $this->_objTpl->parse('showEntries');
                    $objResult->MoveNext();
                    $i++;
                   }

               }

               if ($count <= 0) {
                $this->_objTpl->setVariable(array(
                    'MARKET_NO_ENTRIES_FOUND'            => $_ARRAYLANG['TXT_MARKET_NO_ENTRIES_FOUND'],
                ));

                $this->_objTpl->parse('noEntries');
                $this->_objTpl->hideBlock('showEntries');
            }

        }else{
            $this->_objTpl->setVariable(array(
                'MARKET_NO_ENTRIES_FOUND'            => $_ARRAYLANG['TXT_MARKET_SEARCH_INSERT'],
            ));

            $this->_objTpl->parse('noEntries');
            $this->_objTpl->hideBlock('showEntries');
            $this->_objTpl->hideBlock('showEntriesHeader');
        }

           $this->_objTpl->setVariable(array(
            'TXT_MARKET_SEARCHTERM'            => $searchTermOrg,
        ));

        $this->_objTpl->parse('showEntriesHeader');
    }


    function editEntry() {

        global $objDatabase, $_ARRAYLANG, $_CORELANG, $_CONFIG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        if (!$this->settings['editEntry'] == '1' || (!$this->communityModul && $this->settings['addEntry_only_community'] == '1')) {
            CSRF::header('Location: index.php?section=market&cmd=detail&id='.$_POST['id']);
            exit;
        }elseif ($this->settings['addEntry_only_community'] == '1') {
            $objFWUser = FWUser::getFWUserObject();
            if ($objFWUser->objUser->login()) {
                if (!Permission::checkAccess(100, 'static', true)) {
                    CSRF::header("Location: ".CONTREXX_DIRECTORY_INDEX."?section=login&cmd=noaccess");
                    exit;
                }
            }else {
                $link = base64_encode(CONTREXX_DIRECTORY_INDEX.'?'.$_SERVER['QUERY_STRING']);
                CSRF::header("Location: ".CONTREXX_DIRECTORY_INDEX."?section=login&redirect=".$link);
                exit;
            }
        } else {
            $objFWUser = FWUser::getFWUserObject();
        }

        //get search
        $this->getSearch();

        $this->_objTpl->setVariable(array(
            'TXT_MARKET_TITLE'                        =>    $_ARRAYLANG['TXT_EDIT_ADVERTISEMENT'],
            'TXT_MARKET_TITLE_ENTRY'                =>    $_ARRAYLANG['TXT_MARKET_TITLE'],
            'TXT_MARKET_NAME'                        =>    $_CORELANG['TXT_NAME'],
            'TXT_MARKET_EMAIL'                        =>    $_CORELANG['TXT_EMAIL'],
            'TXT_MARKET_DESCRIPTION'                =>    $_CORELANG['TXT_DESCRIPTION'],
            'TXT_MARKET_SAVE'                        =>    $_CORELANG['TXT_SAVE'],
            'TXT_MARKET_FIELDS_REQUIRED'            =>    $_ARRAYLANG['TXT_MARKET_CATEGORY_ADD_FILL_FIELDS'],
            'TXT_MARKET_THOSE_FIELDS_ARE_EMPTY'        =>    $_ARRAYLANG['TXT_MARKET_FIELDS_NOT_CORRECT'],
            'TXT_MARKET_PICTURE'                    =>    $_CORELANG['TXT_IMAGE'],
            'TXT_MARKET_CATEGORIE'                    =>    $_CORELANG['TXT_CATEGORY'],
            'TXT_MARKET_PRICE'                        =>    $_ARRAYLANG['TXT_MARKET_PRICE'].' '.$this->settings['currency'],
            'TXT_MARKET_TYPE'                        =>    $_CORELANG['TXT_TYPE'],
            'TXT_MARKET_OFFER'                        =>    $_ARRAYLANG['TXT_MARKET_OFFER'],
            'TXT_MARKET_SEARCH'                        =>    $_ARRAYLANG['TXT_MARKET_SEARCH'],
            'TXT_MARKET_FOR_FREE'                    =>    $_ARRAYLANG['TXT_MARKET_FREE'],
            'TXT_MARKET_AGREEMENT'                    =>    $_ARRAYLANG['TXT_MARKET_ARRANGEMENT'],
            'TXT_MARKET_ADDED_BY'                    =>    $_ARRAYLANG['TXT_MARKET_ADDEDBY'],
            'TXT_MARKET_USER_DETAIL'                =>    $_ARRAYLANG['TXT_MARKET_USERDETAILS'],
            'TXT_MARKET_DETAIL_SHOW'                =>    $_ARRAYLANG['TXT_MARKET_SHOW_IN_ADVERTISEMENT'],
            'TXT_MARKET_DETAIL_HIDE'                =>    $_ARRAYLANG['TXT_MARKET_NO_SHOW_IN_ADVERTISEMENT'],
        ));

        if (isset($_GET['id'])) {
            $entryId = contrexx_addslashes($_GET['id']);
            $objResult = $objDatabase->Execute('SELECT type, title, description, premium, picture, catid, price, regdate, enddate, userid, name, email, userdetails, spez_field_1, spez_field_2, spez_field_3, spez_field_4, spez_field_5 FROM '.DBPREFIX.'module_market WHERE id = '.$entryId.' LIMIT 1');
            if ($objResult !== false) {
                while (!$objResult->EOF) {
                    if ($objFWUser->objUser->login() && $objFWUser->objUser->getId()==$objResult->fields['userid'] || Permission::hasAllAccess()) {
                        //entry type
                        if ($objResult->fields['type'] == 'offer') {
                            $offer     = 'checked';
                            $search    = '';
                        }else{
                            $offer     = '';
                            $search    = 'checked';
                        }

                        //entry price
                        if ($objResult->fields['price'] == 'forfree') {
                            $forfree     = 'checked';
                            $price         = '';
                            $agreement     = '';
                        }elseif ($objResult->fields['price'] == 'agreement') {
                            $agreement    = 'checked';
                            $price         = '';
                            $forfree     = '';
                        }else{
                            $price         = $objResult->fields['price'];
                            $forfree     = '';
                            $agreement     = '';
                        }

                        //entry user
                        $objResultUser = $objDatabase->Execute('SELECT username FROM '.DBPREFIX.'access_users WHERE id = '.$objResult->fields['userid'].' LIMIT 1');
                        if ($objResultUser !== false) {
                            $addedby = $objResultUser->fields('username');
                        }

                        //entry userdetails
                        if ($objResult->fields['userdetails'] == '1') {
                            $userdetailsOn         = 'checked';
                            $userdetailsOff     = '';
                        }else{
                            $userdetailsOn         = '';
                            $userdetailsOff     = 'checked';
                        }

                        //entry picture
                        if ($objResult->fields['picture'] != '') {
                            $picture         = '<img width="100" src="'.$this->mediaWebPath.'pictures/'.$objResult->fields['picture'].'" border="0" alt="" /><br /><br />';
                        }else{
                            $picture         = '<img src="'.$this->mediaWebPath.'pictures/no_picture.gif" border="0" alt="" /><br /><br />';
                        }

                        //entry category
                        $this->getCategories();
                        $categories     = '';
                        $checked         = '';
// TODO: Never used
//                        $catID            = $objResult->fields['catid'];
                        foreach(array_keys($this->categories) as $catId) {
                            $catId == $objResult->fields['catid'] ? $checked = 'selected' : $checked = '';
                            $categories .= '<option value="'.$catId.'" '.$checked.'>'.$this->categories[$catId]['name'].'</option>';
                        }

                        //spez fields
                        $objSpezFields = $objDatabase->Execute("SELECT id, name, value FROM ".DBPREFIX."module_market_spez_fields WHERE lang_id = '1' AND active='1' ORDER BY id DESC");
                          if ($objSpezFields !== false) {
                            while(!$objSpezFields->EOF) {

// TODO: Never used
//                                ($i % 2)? $class = "row2" : $class = "row1";
                                $input = '<input type="text" name="spez_'.$objSpezFields->fields['id'].'" value="'.$objResult->fields[$objSpezFields->fields['name']].'" style="width: 300px;" maxlength="100">';

                                // initialize variables
                                $this->_objTpl->setVariable(array(
                                    'TXT_MARKET_SPEZ_FIELD_NAME'        => $objSpezFields->fields['value'],
                                    'MARKET_SPEZ_FIELD_INPUT'              => $input,
                                ));

                                $this->_objTpl->parse('spez_fields');
// TODO: $class is never used
//                                $i++;
                                $objSpezFields->MoveNext();
                            }
                          }


                        $this->_objTpl->setVariable(array(
                            'MARKET_ENTRY_ID'                    =>    $entryId,
                            'MARKET_ENTRY_TYPE_OFFER'            =>    $offer,
                            'MARKET_ENTRY_TYPE_SEARCH'            =>    $search,
                            'MARKET_ENTRY_TITLE'                =>    $objResult->fields['title'],
                            'MARKET_ENTRY_DESCRIPTION'            =>    $objResult->fields['description'],
                            'MARKET_ENTRY_PICTURE'                =>    $picture,
                            'MARKET_ENTRY_PICTURE_OLD'            =>    $objResult->fields['picture'],
                            'MARKET_CATEGORIES'                    =>    $categories,
                            'MARKET_ENTRY_PRICE'                =>    $price,
                            'MARKET_ENTRY_FORFREE'                =>    $forfree,
                            'MARKET_ENTRY_AGREEMENT'            =>    $agreement,
                            'MARKET_ENTRY_ADDEDBY'                =>    $addedby,
                            'MARKET_ENTRY_ADDEDBY_ID'            =>    $objResult->fields['userid'],
                            'MARKET_ENTRY_USERDETAILS_ON'        =>    $userdetailsOn,
                            'MARKET_ENTRY_USERDETAILS_OFF'        =>    $userdetailsOff,
                            'MARKET_ENTRY_NAME'                    =>    $objResult->fields['name'],
                            'MARKET_ENTRY_EMAIL'                =>    $objResult->fields['email'],
                        ));
                           $objResult->MoveNext();
                       }else{
                        CSRF::header('Location: index.php?section=market&cmd=detail&id='.$_GET['id']);
                        exit;
                    }
                }

                //get navigatin
                $this->getNavigation($catID);
            }
        }else{
            if (isset($_POST['submitEntry'])) {
                if ($_FILES['pic']['name'] != "") {
                    $picture = $this->uploadPicture();
                    if ($picture != "error") {
                        $objFile = new File();
                        $objFile->delFile($this->mediaPath, $this->mediaWebPath, "pictures/".$_POST['picOld']);
                    }
                }else{
                    $picture = $_POST['picOld'];
                }

                if ($picture != "error") {
                    if ($_POST['forfree'] == 1) {
                        $price = "forfree";
                    }elseif ($_POST['agreement'] == 1) {
                        $price = "agreement";
                    }else{
                        $price = contrexx_addslashes($_POST['price']);
                    }

                    $objResult = $objDatabase->Execute("UPDATE ".DBPREFIX."module_market SET
                                        type='".contrexx_addslashes($_POST['type'])."',
                                          title='".contrexx_addslashes($_POST['title'])."',
                                          description='".contrexx_addslashes($_POST['description'])."',
                                          picture='".contrexx_addslashes($picture)."',
                                          catid='".contrexx_addslashes($_POST['cat'])."',
                                          price='".$price."',
                                          name='".contrexx_addslashes($_POST['name'])."',
                                          email='".contrexx_addslashes($_POST['email'])."',
                                          spez_field_1='".contrexx_addslashes($_POST['spez_1'])."',
                                          spez_field_2='".contrexx_addslashes($_POST['spez_2'])."',
                                          spez_field_3='".contrexx_addslashes($_POST['spez_3'])."',
                                          spez_field_4='".contrexx_addslashes($_POST['spez_4'])."',
                                          spez_field_5='".contrexx_addslashes($_POST['spez_5'])."',
                                          userdetails='".contrexx_addslashes($_POST['userdetails'])."'
                                          WHERE id='".contrexx_addslashes($_POST['id'])."'");

                    if ($objResult !== false) {
                        CSRF::header('Location: index.php?section=market&cmd=detail&id='.$_POST['id']);
                        exit;
                    }else{
// TODO: Never used
//                        $error = $_CORELANG['TXT_DATABASE_QUERY_ERROR'];
                        CSRF::header('Location: index.php?section=market&cmd=edit&id='.$_POST['id']);
                        exit;
                    }
                }else{
// TODO: Never used
//                    $error = $_CORELANG['TXT_MARKET_IMAGE_UPLOAD_ERROR'];
                    CSRF::header('Location: index.php?section=market&cmd=edit&id='.$_POST['id']);
                    exit;
                }
            }else{
                CSRF::header('Location: index.php?section=market');
                exit;
            }
        }
    }



    function delEntry() {

        global $objDatabase, $_ARRAYLANG, $_CORELANG, $_CONFIG;

        $this->_objTpl->setTemplate($this->pageContent, true, true);

        if (!$this->settings['editEntry'] == '1' || (!$this->communityModul && $this->settings['addEntry_only_community'] == '1')) {
            CSRF::header('Location: index.php?section=market&cmd=detail&id='.$_POST['id']);
            exit;
        }elseif ($this->settings['addEntry_only_community'] == '1') {
            $objFWUser = FWUser::getFWUserObject();
            if ($objFWUser->objUser->login()) {
                if (!Permission::checkAccess(101, 'static', true)) {
                    CSRF::header("Location: ".CONTREXX_DIRECTORY_INDEX."?section=login&cmd=noaccess");
                    exit;
                }
            }else {
                $link = base64_encode(CONTREXX_DIRECTORY_INDEX.'?'.$_SERVER['QUERY_STRING']);
                CSRF::header("Location: ".CONTREXX_DIRECTORY_INDEX."?section=login&redirect=".$link);
                exit;
            }
        } else {
            $objFWUser = FWUser::getFWUserObject();
        }

        //get search
        $this->getSearch();

        if (isset($_GET['id'])) {
            $entryId =contrexx_addslashes($_GET['id']);
            $objResult = $objDatabase->Execute('SELECT id, userid, catid FROM '.DBPREFIX.'module_market WHERE id = '.$entryId.' LIMIT 1');
            if ($objResult !== false) {
                while (!$objResult->EOF) {
                    if ($objFWUser->objUser->login() && $objFWUser->objUser->getId()==$objResult->fields['userid'] || Permission::hasAllAccess()) {
                        $this->_objTpl->setVariable(array(
                            'MARKET_ENTRY_ID'                    =>    $entryId,
                            'TXT_MARKET_DEL'                    =>    $_ARRAYLANG['TXT_MARKET_DELETE_ADVERTISEMENT'],
                            'TXT_MARKET_ABORT'                    =>    $_CORELANG['TXT_CANCEL'],
                            'TXT_MARKET_CONFIRM_DEL'            =>    $_ARRAYLANG['TXT_MARKET_ADVERTISEMENT_DELETE'],
                        ));

                        //get navigatin
                        $this->getNavigation($objResult->fields['catid']);

                        $objResult->MoveNext();
                    }else{
                        CSRF::header('Location: index.php?section=market&cmd=detail&id='.$_GET['id']);
                        exit;
                    }
                }
            }
        }else{
            if (isset($_POST['submitEntry'])) {

                $arrDelete = array();
                $arrDelete[0] = $_POST['id'];
                $this->removeEntry($arrDelete);

                CSRF::header('Location: index.php?section=market');
                exit;
            }else{
                CSRF::header('Location: index.php?section=market');
                exit;
            }
        }
    }


    /**
    * Get Market Latest Entrees
    *
    * getContentLatest
    *
    * @access    public
    * @param    string $pageContent
    * @param     string
    */
    function getBlockLatest()
    {
        global $objDatabase, $objTemplate;

        //get latest
        $query = "SELECT id, title, enddate, catid
                    FROM ".DBPREFIX."module_market
                   WHERE status = '1'
                ORDER BY id DESC
                   LIMIT 5";

        $objResult = $objDatabase->Execute($query);
        if ($objResult !== false) {
            while (!$objResult->EOF) {
                // set variables
                $objTemplate->setVariable('MARKET_DATE', date("d.m.Y", $objResult->fields['enddate']));
                $objTemplate->setVariable('MARKET_TITLE', $objResult->fields['title']);
                $objTemplate->setVariable('MARKET_ID', $objResult->fields['id']);
                $objTemplate->setVariable('MARKET_CATID', $objResult->fields['catid']);

                $objTemplate->parse('marketLatest');


                $objResult->MoveNext();
            }
        }
    }
}
?>
