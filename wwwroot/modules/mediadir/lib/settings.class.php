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
 * Media  Directory Settings
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Media Directory Settings
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectorySettings extends mediaDirectoryLibrary
{

    /**
     * Constructor
     */
    function __construct()
    {
        parent::getSettings();
        parent::getCommunityGroups();
        parent::getFrontendLanguages();
    }
    
    
    function settings_masks($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_masks.html');

        switch ($_GET['tpl']) {
            case 'delete_mask':
                if(!empty($_GET['id'])) {
                    $objDelete = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_masks WHERE `id`='".intval($_GET['id'])."'");
                    if($objDelete !== false){
                        $this->strOkMessage = $_ARRAYLANG['TXT_MEDIADIR_EXPORT_MASK']." ".$_ARRAYLANG['TXT_MEDIADIR_SUCCESSFULLY_DELETED'];
                    } else {
                        $this->strErrMessage = $_ARRAYLANG['TXT_MEDIADIR_EXPORT_MASK']." ".$_ARRAYLANG['TXT_MEDIADIR_CORRUPT_DELETED'];
                    }
                }
                break;
        }  

        $objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_NEW_EXPORT_MASK' => $_ARRAYLANG['TXT_MEDIADIR_NEW_EXPORT_MASK'],
            'TXT_'.$this->moduleLangVar.'_STATUS' => $_CORELANG['TXT_STATUS'],
            'TXT_'.$this->moduleLangVar.'_TITLE' => $_ARRAYLANG['TXT_MEDIADIR_TITLE'],
            'TXT_'.$this->moduleLangVar.'_ACTION' => $_CORELANG['TXT_HISTORY_ACTION'],
            'TXT_'.$this->moduleLangVar.'_FORM_TEMPLATE' => $_ARRAYLANG['TXT_MEDIADIR_FORM_TEMPLATE'],
            'TXT_'.$this->moduleLangVar.'_LANG' => $_CORELANG['TXT_ACCESS_LANGUAGE'],      
            'TXT_'.$this->moduleLangVar.'_CONFIRM_DELETE_DATA' => $_ARRAYLANG['TXT_MEDIADIR_CONFIRM_DELETE_DATA'],
            'TXT_'.$this->moduleLangVar.'_ACTION_IS_IRREVERSIBLE' => $_ARRAYLANG['TXT_MEDIADIR_ACTION_IS_IRREVERSIBLE'],
            'TXT_EDIT' => $_ARRAYLANG['TXT_MEDIADIR_EDIT'],
            'TXT_DELETE' => $_ARRAYLANG['TXT_MEDIADIR_DELETE'],
        ));
                                 
        $objMasks = $objDatabase->Execute("
            SELECT
                `id`,`title`,`active`,form_id 
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_masks
            ORDER BY
                `title` ASC
            ");

        if ($objMasks !== false) {
            while (!$objMasks->EOF) {
                $strMaskTitle = htmlspecialchars($objMasks->fields['title'], ENT_QUOTES, CONTREXX_CHARSET);  
                $intStatus = intval($objMasks->fields['active']);
                $intMaskId = intval($objMasks->fields['id']);
                                                                             
                if($intStatus == 1) {
                    $strStatus = 'images/icons/status_green.gif';
                    $intStatus = 0;
                } else {
                    $strStatus = 'images/icons/status_red.gif';
                    $intStatus = 1;
                }  
                
                $objForm = new mediaDirectoryForm($objMasks->fields['form_id']);  
                       
                //parse data variables
                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_MASK_ROW_CLASS' => $i%2==0 ? 'row1' : 'row2',
                    $this->moduleLangVar.'_MASK_ID' => $intMaskId,
                    $this->moduleLangVar.'_MASK_STATUS' => $strStatus,
                    $this->moduleLangVar.'_MASK_SWITCH_STATUS' => $intStatus,  
                    $this->moduleLangVar.'_MASK_TITLE' => $strMaskTitle,                                 
                    $this->moduleLangVar.'_MASK_FORM' => $objForm->arrForms[$objMasks->fields['form_id']]['formName'][0],                                 
                ));

                $i++;

                $objTpl->parse($this->moduleName.'MaskList');  
                $objMasks->MoveNext();
            }
        }    
                                
        if($objMasks->RecordCount() == 0) {
             $objTpl->setVariable(array(
                'TXT_'.$this->moduleLangVar.'_NO_ENTRIES_FOUND' => $_ARRAYLANG['TXT_MEDIADIR_NO_ENTRIES_FOUND']
            ));

            $objTpl->parse($this->moduleName.'MaskNoEntries');
        } 

        $objTpl->parse('settings_content');
    }



    function settings_modify_mask($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_modify_mask.html');

        //load teplate data
        if(isset($_GET['id']) && $_GET['id'] != 0) {
            $objTpl->hideBlock($this->moduleName.'FormList'); 
            
            $pageTitle = $_ARRAYLANG['TXT_MEDIADIR_EDIT_EXPORT_MASK'];
            $intMaskId = intval($_GET['id']);  
            
            $objMask = $objDatabase->Execute("
                SELECT
                    title,fields,form_id  
                FROM
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_masks
                WHERE
                    id='".$intMaskId."'
                LIMIT 1
            ");
                
            if ($objMask !== false) {
                while (!$objMask->EOF) {
                    $strMaskTitle = htmlspecialchars($objMask->fields['title'], ENT_QUOTES, CONTREXX_CHARSET);
                    $arrMaskInputfields = explode(',', $objMask->fields['fields']); 
                    $intFormId = $objMask->fields['form_id']; 
                    $objMask->MoveNext();
                }
            }

            //parse data variables
            $objTpl->setGlobalVariable(array(
                $this->moduleLangVar.'_MASK_ID' => $intMaskId,     
                $this->moduleLangVar.'_MASK_TITLE' => $strMaskTitle,              
            ));    
            
            //List Inputfields
            $objInputfields = new mediaDirectoryInputfield($intFormId); 
            foreach($objInputfields->arrInputfields as $intFieldId => $arrField) {
                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_INPUTFIELD_ROW_CLASS' => $i%2==0 ? 'row1' : 'row2',   
                    $this->moduleLangVar.'_INPUTFIELD_ID' => $intFieldId,              
                    $this->moduleLangVar.'_INPUTFIELD_NAME' => $arrField['name'][0],              
                    $this->moduleLangVar.'_INPUTFIELD_CHECKED' => in_array($intFieldId, $arrMaskInputfields) ? 'checked="checked"' : '',              
                ));
        
                $i++;   
                $objTpl->parse($this->moduleName.'Inputfield');    
            }    
        } else {
            $pageTitle = $_ARRAYLANG['TXT_MEDIADIR_NEW_EXPORT_MASK']; 
              
            $objForms = new mediaDirectoryForm(null);
            $strForms = $objForms->listForms($objTpl, 4);
            
            $objTpl->setVariable(array(                                                                       
                $this->moduleLangVar.'_MASK_FORMS' => $strForms,         
            ));  
            
            $objTpl->hideBlock($this->moduleName.'InputfieldList');    
        }           

        $objTpl->setVariable(array(
            'TXT_'.$this->moduleLangVar.'_PAGE_TITLE' => $pageTitle,   
            'TXT_'.$this->moduleLangVar.'_TITLE' => $_ARRAYLANG['TXT_MEDIADIR_TITLE'],
            'TXT_'.$this->moduleLangVar.'_INPUTFIELD' => $_ARRAYLANG['TXT_MEDIADIR_INPUTFIELDS'],   
            'TXT_'.$this->moduleLangVar.'_STATUS' => $_CORELANG['TXT_STATUS'],   
            'TXT_'.$this->moduleLangVar.'_FORM_TEMPLATE' => $_ARRAYLANG['TXT_MEDIADIR_FORM_TEMPLATE'],
        ));

        $objTpl->parse('settings_content');
    }



    function settings_save_mask($arrData)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $intMaskId = intval($arrData['maskId']);   
        $intMaskFormId = intval($arrData['maskForm']);
        $strMaskTitle = contrexx_addslashes($arrData['maskTitle']);
        $strMaskInputfields = contrexx_addslashes(join(',', $arrData['maskInputfields']));
        
        if(!empty($intMaskId) && $intMaskId != 0) {
            $objEditMask = $objDatabase->Execute("
                UPDATE
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_masks
                SET
                    title='".$strMaskTitle."',
                    fields='".$strMaskInputfields."'   
                WHERE
                    id='".$intMaskId."'
                ");
            if ($objEditMask === false) {
                return false;
            }            
        } else {
            $objAddMask = $objDatabase->Execute("
                INSERT INTO
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_masks
                SET
                    title='".$strMaskTitle."',
                    form_id='".$intMaskFormId."',
                    active='0'
                ");
            if ($objAddMask === false) {
                return false;
            }
        }        

        return true;
    }



    function settings_classification($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG;

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_classification.html');

        $objTpl->setVariable(array(
            'TXT_'.$this->moduleLangVar.'_CLASSIFICATION' => $_ARRAYLANG['TXT_MEDIADIR_CLASSIFICATION'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CLASSIFICATION_POINTS' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CLASSIFICATION_POINTS'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CLASSIFICATION_POINTS_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CLASSIFICATION_POINTS_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CLASSIFICATION_SEARCH' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CLASSIFICATION_SEARCH'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CLASSIFICATION_SEARCH_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CLASSIFICATION_SEARCH_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CLASSIFICATION_SEARCH_FROM' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CLASSIFICATION_SEARCH_FROM'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CLASSIFICATION_SEARCH_TO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CLASSIFICATION_SEARCH_TO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CLASSIFICATION_SEARCH_EXACT' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CLASSIFICATION_SEARCH_EXACT'],
        ));

        if($this->arrSettings['settingsClassificationSearch'] == 1) {
            $strClassificationSearchFrom = 'selected="selected"';
            $strClassificationSearchTo = '';
            $strClassificationSearchExact = '';
        } else if ($this->arrSettings['settingsClassificationSearch'] == 2) {
            $strClassificationSearchFrom = '';
            $strClassificationSearchTo = 'selected="selected"';
            $strClassificationSearchExact = '';
        } else {
            $strClassificationSearchFrom = '';
            $strClassificationSearchTo = '';
            $strClassificationSearchExact = 'selected="selected"';
        }


        $objTpl->setVariable(array(
            $this->moduleLangVar.'_SETTINGS_CLASSIFICATION_POINTS' => intval($this->arrSettings['settingsClassificationPoints']),
            $this->moduleLangVar.'_SETTINGS_CLASSIFICATION_SEARCH_FROM' => $strClassificationSearchFrom,
            $this->moduleLangVar.'_SETTINGS_CLASSIFICATION_SEARCH_TO' => $strClassificationSearchTo,
            $this->moduleLangVar.'_SETTINGS_CLASSIFICATION_SEARCH_EXACT' => $strClassificationSearchExact,
        ));
    }



    function settings_votes($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_comments_votes.html');

        if(isset($_GET['restore'])){
            if($_GET['restore'] == 'voting') {
                $objDatabase->Execute("TRUNCATE TABLE ".DBPREFIX."module_".$this->moduleTablePrefix."_votes");
            }

            if($_GET['restore'] == 'comments') {
                $objDatabase->Execute("TRUNCATE TABLE ".DBPREFIX."module_".$this->moduleTablePrefix."_comments");
            }
        }

        $objTpl->setVariable(array(
            'TXT_'.$this->moduleLangVar.'_VOTES' => $_ARRAYLANG['TXT_MEDIADIR_VOTES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ALLOW_VOTES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ALLOW_VOTES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_VOTE_ONLY_COMMUNITY' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_VOTE_ONLY_COMMUNITY'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_DELETE_ALL_VOTES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_DELETE_ALL_VOTES'],
            'TXT_'.$this->moduleLangVar.'_COMMENTS' => $_ARRAYLANG['TXT_MEDIADIR_COMMENTS'],
            'TXT_'.$this->moduleLangVar.'_CONFIRM_DELETE_DATA' => $_ARRAYLANG['TXT_MEDIADIR_CONFIRM_DELETE_DATA'],
            'TXT_'.$this->moduleLangVar.'_ACTION_IS_IRREVERSIBLE' => $_ARRAYLANG['TXT_MEDIADIR_ACTION_IS_IRREVERSIBLE'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ALLOW_COMMENTS' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ALLOW_COMMENTS'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_COMMENT_ONLY_COMMUNITY' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_COMMENT_ONLY_COMMUNITY'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_DELETE_ALL_COMMENTS' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_DELETE_ALL_COMMENTS'],
        ));

        if($this->arrSettings['settingsAllowVotes'] == 1) {
            $strAllowVotesOn = 'checked="checked"';
            $strAllowVotesOff = '';
        } else {
            $strAllowVotesOn = '';
            $strAllowVotesOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsVoteOnlyCommunity'] == 1) {
            $strVoteOnlyCommunityOn = 'checked="checked"';
            $strVoteOnlyCommunityOff = '';
        } else {
            $strVoteOnlyCommunityOn = '';
            $strVoteOnlyCommunityOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsAllowComments'] == 1) {
            $strAllowCommentsOn = 'checked="checked"';
            $strAllowCommentsOff = '';
        } else {
            $strAllowCommentsOn = '';
            $strAllowCommentsOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsCommentOnlyCommunity'] == 1) {
            $strCommentOnlyCommunityOn = 'checked="checked"';
            $strCommentOnlyCommunityOff = '';
        } else {
            $strCommentOnlyCommunityOn = '';
            $strCommentOnlyCommunityOff = 'checked="checked"';
        }

        $objTpl->setVariable(array(
            $this->moduleLangVar.'_SETTINGS_ALLOW_VOTES_ON' => $strAllowVotesOn,
            $this->moduleLangVar.'_SETTINGS_ALLOW_VOTES_OFF' => $strAllowVotesOff,
            $this->moduleLangVar.'_SETTINGS_VOTE_ONLY_COMMUNITY_ON' => $strVoteOnlyCommunityOn,
            $this->moduleLangVar.'_SETTINGS_VOTE_ONLY_COMMUNITY_OFF' => $strVoteOnlyCommunityOff,
            $this->moduleLangVar.'_SETTINGS_ALLOW_COMMENTS_ON' => $strAllowCommentsOn,
            $this->moduleLangVar.'_SETTINGS_ALLOW_COMMENTS_OFF' => $strAllowCommentsOff,
            $this->moduleLangVar.'_SETTINGS_COMMENT_ONLY_COMMUNITY_ON' => $strCommentOnlyCommunityOn,
            $this->moduleLangVar.'_SETTINGS_COMMENT_ONLY_COMMUNITY_OFF' => $strCommentOnlyCommunityOff,
        ));
    }


    function settings_map($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $_CONFIG, $objDatabase;

        parent::getSettings();

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_map.html');

        $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_inputfield_types SET `active`='1' WHERE `name`='google_map'");

        $objTpl->setVariable(array(
            'TXT_'.$this->moduleLangVar.'_SETTINGS_GOOGLE_START_POSITION' => $_ARRAYLANG['TXT_MEDIADIR_GOOGLE'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_GOOGLE_START_POSITION' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_GOOGLE_START_POSITION'],
        ));

        $strMapId       = 'settingsGoogleMap_map';
        $strLonId       = 'settingsGoogleMap_lon';
        $strLatId       = 'settingsGoogleMap_lat';
        $strZoomId      = 'settingsGoogleMap_zoom';
        $strStreetId    = 'settingsGoogleMap_street';
        $strZipId       = 'settingsGoogleMap_zip';
        $strCityId      = 'settingsGoogleMap_city';
        $strKey         = $_CONFIG['googleMapsAPIKey'];

        $arrValues = explode(',', $this->arrSettings['settingsGoogleMapStartposition']);

        $strValueLat = $arrValues[0];
        $strValueLon = $arrValues[1];
        $strValueZoom = $arrValues[2];

        $strGoogleMap = '<table cellpadding="0" cellspacing="0" border="0" class="'.$this->moduleName.'TableGoogleMap">';
        $strGoogleMap .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_STREET'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="settingsGoogleMap[street]" id="'.$strStreetId.'" class="'.$this->moduleName.'InputfieldGoogleMapLarge" value="" onfocus="this.select();" /></td></tr>';
        $strGoogleMap .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_CITY'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="settingsGoogleMap[place]" id="'.$strZipId.'" class="'.$this->moduleName.'InputfieldGoogleMapLarge" value="" onfocus="this.select();" /></td></tr>';
        $strGoogleMap .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_ZIP'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="settingsGoogleMap[zip]" id="'.$strCityId.'" class="'.$this->moduleName.'InputfieldGoogleMapSmall" value="" onfocus="this.select();" /></td></tr>';
        $strGoogleMap .= '<tr><td style="border: 0px;"><br /></td><td style="border: 0px;"><input type="button" onclick="searchAddress();" name="settingsGoogleMap[search]" id="'.$this->moduleName.'Inputfield_'.$intId.'_search" value="'.$_CORELANG['TXT_SEARCH'].'" /></td></tr>';
        $strGoogleMap .= '<tr><td style="border: 0px;" coldpan="2"><br /></td></tr>';
        $strGoogleMap .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_LON'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="settingsGoogleMap[lon]" id="'.$strLonId.'" class="'.$this->moduleName.'InputfieldGoogleMapLarge" value="'.$strValueLon.'" onfocus="this.select();" /></td></tr>';
        $strGoogleMap .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_LAT'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="settingsGoogleMap[lat]" id="'.$strLatId.'" class="'.$this->moduleName.'InputfieldGoogleMapLarge" value="'.$strValueLat.'" onfocus="this.select();" /></td></tr>';
        $strGoogleMap .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_ZOOM'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="settingsGoogleMap[zoom]" id="'.$strZoomId.'" class="'.$this->moduleName.'InputfieldGoogleMapSmall" value="'.$strValueZoom.'" onfocus="this.select();" /></td></tr>';
        $strGoogleMap .= '</table><br />';
        $strGoogleMap .= '<div id="'.$strMapId.'" style="border: solid 1px #0A50A1; width: 418px; height: 300px;"></div>';
        
        $strGoogleMap .= <<<EOF
<script src="https://maps.googleapis.com/maps/api/js?key=$strKey&sensor=false&v=3"></script>
<script>
//<![CDATA[
var elZoom, elLon, elLat, elStreet, elZip, elCity;
var map, marker, geocoder, old_marker = null;

function initialize() {
    elZoom = document.getElementById("$strZoomId");
    elLon = document.getElementById("$strLonId");
    elLat = document.getElementById("$strLatId");

    elStreet = document.getElementById("$strStreetId");
    elZip = document.getElementById("$strZipId");
    elCity = document.getElementById("$strCityId");

    map = new google.maps.Map(document.getElementById("$strMapId"));

    map.setCenter(new google.maps.LatLng($strValueLat, $strValueLon));
    map.setZoom($strValueZoom);
    map.setMapTypeId(google.maps.MapTypeId.ROADMAP);

    if($strValueLon != 0 && $strValueLon != 0) {
        marker = new google.maps.Marker({
            map: map
        });
        setPosition(new google.maps.LatLng($strValueLat, $strValueLon));
    }

    geocoder = new google.maps.Geocoder();

    google.maps.event.addListener(map, "click", function(event) {
        setPosition(event.latLng);
    });

    google.maps.event.addListener(map, "idle", function() {
        elZoom.value = map.getZoom();
    });
}

function searchAddress() {
    var address =  elStreet.value + " " + elZip.value + " " + elCity.value;

    if (geocoder) {
        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                setPosition(results[0].geometry.location);
                map.setCenter(results[0].geometry.location);
            }
        });
    }
}
                        
function setPosition(position) {
    if (!marker) {
        marker = new google.maps.Marker({
            map: map
        });
    }
    marker.setPosition(position);
    elZoom.value = map.getZoom();
    elLon.value = position.lng();
    elLat.value = position.lat();
}

google.maps.event.addDomListener(window, 'load', initialize);
//]]>
</script>
EOF;
        if($this->arrSettings['settingsGoogleMapType'] == 0) {
            $strMapyType0 = 'selected="selected"';
            $strMapyType1 = '';
            $strMapyType2 = '';
        } else if($this->arrSettings['settingsGoogleMapType'] == 1) {
            $strMapyType0 = '';
            $strMapyType1 = 'selected="selected"';
            $strMapyType2 = '';
        } else  {
            $strMapyType0 = '';
            $strMapyType1 = '';
            $strMapyType2 = 'selected="selected"';
        }

        $strSelectMapyType = '<option value="0" '.$strMapyType0.'>'.$_ARRAYLANG['TXT_MEDIADIR_SETTINGS_GOOGLE_MAP_TYPE_MAP'].'</option>';
        $strSelectMapyType .= '<option value="1" '.$strMapyType1.'>'.$_ARRAYLANG['TXT_MEDIADIR_SETTINGS_GOOGLE_MAP_TYPE_SATELLITE'].'</option>';
        $strSelectMapyType .= '<option value="2" '.$strMapyType2.'>'.$_ARRAYLANG['TXT_MEDIADIR_SETTINGS_GOOGLE_MAP_TYPE_HYBRID'].'</option>';

        $objTpl->setVariable(array(
            $this->moduleLangVar.'_SETTINGS_GOOGLE_START_POSITION' => $strGoogleMap,
            'TXT_'.$this->moduleLangVar.'_SETTINGS_GOOGLE_MAP_TYPE' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_GOOGLE_MAP_TYPE'],
            $this->moduleLangVar.'_SETTINGS_GOOGLE_MAP_TYPE' => $strSelectMapyType,
        ));
    }


    function settings_save_map($arrData)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $strValueLon = contrexx_addslashes($arrData['settingsGoogleMap']['lon']);
        $strValueLat = contrexx_addslashes($arrData['settingsGoogleMap']['lat']);
        $strValueZoom = contrexx_addslashes($arrData['settingsGoogleMap']['zoom']);

        $objRSSaveGoogle = $objDatabase->Execute("
                UPDATE
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_settings
                SET
                    value='".$strValueLat.",".$strValueLon.",".$strValueZoom."'
                WHERE
                    name='settingsGoogleMapStartposition'
                ");
        if ($objRSSaveGoogle === false) {
            return false;
        }

        $objRSSaveGoogle = $objDatabase->Execute("
                UPDATE
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_settings
                SET
                    value='".intval($arrData['settingsGoogleMapType'])."'
                WHERE
                    name='settingsGoogleMapType'
                ");
        if ($objRSSaveGoogle === false) {
            return false;
        }

        return true;
    }



    function settings_files($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG;

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_files.html');

        $objTpl->setVariable(array(
            'TXT_'.$this->moduleLangVar.'_SETTINGS_PICS_AND_FILES' => $_ARRAYLANG['TXT_MEDIADIR_PICS_AND_FILES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_THUMB_SIZE' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_THUMB_SIZE'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NUM_PICS_PER_GALLERY' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_NUM_PICS_PER_GALLERY'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ENCRYPT_FILENAME' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ENCRYPT_FILENAME'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_THUMB_SIZE_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_THUMB_SIZE_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NUM_PICS_PER_GALLERY_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_NUM_PICS_PER_GALLERY_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ENCRYPT_FILENAME_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ENCRYPT_FILENAME_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_IMAGE_FILESIZE' => $_ARRAYLANG['TXT_MARKETPLACE_SETTINGS_IMAGE_FILESIZE'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_IMAGE_FILESIZE_INFO' => $_ARRAYLANG['TXT_MARKETPLACE_SETTINGS_IMAGE_FILESIZE_INFO'],
        ));

        if($this->arrSettings['settingsEncryptFilenames'] == 1) {
            $strEncryptFilenamesOn = 'checked="checked"';
            $strEncryptFilenamesOff = '';
        } else {
            $strEncryptFilenamesOn = '';
            $strEncryptFilenamesOff = 'checked="checked"';
        }


        $objTpl->setVariable(array(
            $this->moduleLangVar.'_SETTINGS_THUMB_SIZE' => intval($this->arrSettings['settingsThumbSize']),
            $this->moduleLangVar.'_SETTINGS_NUM_PICS_PER_GALLERY' => $this->arrSettings['settingsNumGalleryPics'],
            $this->moduleLangVar.'_SETTINGS_ENCRYPT_FILENAMES_ON' => $strEncryptFilenamesOn,
            $this->moduleLangVar.'_SETTINGS_ENCRYPT_FILENAMES_OFF' => $strEncryptFilenamesOff,
            $this->moduleLangVar.'_SETTINGS_IMAGE_FILESIZE' => intval($this->arrSettings['settingsImageFilesize']),
        ));
    }



    function settings_entries($objTpl)
    {
        global $objDatabase, $_ARRAYLANG, $_CORELANG;

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_entries.html');

        $objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CONFIRM_NEW_ENTRIES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CONFIRM_NEW_ENTRIES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CONFIRM_NEW_ENTRIES_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CONFIRM_NEW_ENTRIES_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NUM_ENTRIES_PER_GROUP' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_NUM_ENTRIES_PER_GROUP'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NUM_ENTRIES_PER_GROUP_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_NUM_ENTRIES_PER_GROUP_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ENTRIES' => $_ARRAYLANG['TXT_MEDIADIR_ENTRIES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NUM' => $_ARRAYLANG['TXT_MEDIADIR_NUM'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_COMMUNITY_GROUP' => $_ARRAYLANG['TXT_MEDIADIR_COMMUNITY_GROUP'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NO_COMMUNITY_GROUPS' => $_ARRAYLANG['TXT_MEDIADIR_NO_COMMUNITY_GROUPS'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CONFIRM_UPDATED_ENTRIES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CONFIRM_UPDATED_ENTRIES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CONFIRM_UPDATED_ENTRIES_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CONFIRM_UPDATED_ENTRIES_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_COUNT_ENTRIES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_COUNT_ENTRIES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_COUNT_ENTRIES_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_COUNT_ENTRIES_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ALLOW_ADD_ENTRIES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ALLOW_ADD_ENTRIES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ALLOW_ADD_ENTRIES_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ALLOW_ADD_ENTRIES_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ADD_ONLY_COMMUNITY' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ADD_ONLY_COMMUNITY'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ADD_ONLY_COMMUNITY_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ADD_ONLY_COMMUNITY_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ALLOW_EDIT_ENTRIES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ALLOW_EDIT_ENTRIES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ALLOW_EDIT_ENTRIES_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ALLOW_EDIT_ENTRIES_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ALLOW_DEL_ENTRIES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ALLOW_DEL_ENTRIES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ALLOW_DEL_ENTRIES_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ALLOW_DEL_ENTRIES_INFO'],
            'TXT_'.$this->moduleLangVar.'_LATEST_ENTRIES' => $_ARRAYLANG['TXT_MEDIADIR_LATEST_ENTRIES'],
            'TXT_'.$this->moduleLangVar.'_POPULAR_HITS' => $_ARRAYLANG['TXT_MEDIADIR_POPULAR_HITS'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_LATEST_NUM_XML' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_LATEST_NUM_XML'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_LATEST_NUM_OVERVIEW' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_LATEST_NUM_OVERVIEW'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_LATEST_NUM_BACKEND' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_LATEST_NUM_BACKEND'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_LATEST_NUM_FRONTEND' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_LATEST_NUM_FRONTEND'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_POPULAR_NUM_FRONTEND' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_POPULAR_NUM_FRONTEND'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_POPULAR_NUM_RESTORE' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_POPULAR_NUM_RESTORE'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_LATEST_NUM_HEADLINES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_LATEST_NUM_HEADLINES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_ENTRIES_IN_ALL_LANG' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_ENTRIES_IN_ALL_LANG'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_ENTRIES_IN_ALL_LANG_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_ENTRIES_IN_ALL_LANG_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_PAGING_NUM_ENTRIES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_PAGING_NUM_ENTRIES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_PAGING_NUM_ENTRIES_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_PAGING_NUM_ENTRIES_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_DISPLAYDURATION' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_DEFAULT_DISPLAYDURATION'],
            'TXT_'.$this->moduleLangVar.'_DISPLAY_DURATION_ALWAYS' => $_ARRAYLANG['TXT_MEDIADIR_DISPLAYDURATION_ALWAYS'],
            'TXT_'.$this->moduleLangVar.'_DISPLAY_DURATION_PERIOD' => $_ARRAYLANG['TXT_MEDIADIR_DISPLAYDURATION_PERIOD'],
            'TXT_'.$this->moduleLangVar.'_DISPLAY_DURATION_FROM' => $_CORELANG['TXT_FROM'],
            'TXT_'.$this->moduleLangVar.'_DISPLAY_DURATION_TO' => $_CORELANG['TXT_TO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NOTIFICATION_DISPLAYDURATION' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_NOTIFICATION_DISPLAYDURATION'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_NOTIFICATION_DAYSBEFOR' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_NOTIFICATION_DISPLAYDURATION_DAYSBEFOR'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_VALUE_TYPE_DAY' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_DISPLAYDURATION_VALUE_TYPE_DAY'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_VALUE_TYPE_MONTH' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_DISPLAYDURATION_VALUE_TYPE_MONTH'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_VALUE_TYPE_YEAR' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_DISPLAYDURATION_VALUE_TYPE_YEAR'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_TRANSLATION_STATUS' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_TRANSLATION_STATUS'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_TRANSLATION_STATUS_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_TRANSLATION_STATUS_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_READY_TO_CONFIRM' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_READY_TO_CONFIRM'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_READY_TO_CONFIRM_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_READY_TO_CONFIRM_INFO'],
            'TXT_'.$this->moduleLangVar.'_LANGUAGES' => $_ARRAYLANG['TXT_MEDIADIR_LANGUAGES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ACTIVE_LANGUAGES' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ACTIVE_LANGUAGES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_MULTILANG_FRONTEND' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_MULTILANG_FRONTEND'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_MULTILANG_FRONTEND_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_MULTILANG_FRONTEND_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ENTRIEY_INDIVIDUAL_ORDER' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ENTRIEY_INDIVIDUAL_ORDER'],
        ));

        if($this->arrSettings['settingsConfirmNewEntries'] == 1) {
            $strConfirmEntriesOn = 'checked="checked"';
            $strConfirmEntriesOff = '';
        } else {
            $strConfirmEntriesOn = '';
            $strConfirmEntriesOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsConfirmUpdatedEntries'] == 1) {
            $strConfirmUpdatedEntriesOn = 'checked="checked"';
            $strConfirmUpdatedEntriesOff = '';
        } else {
            $strConfirmUpdatedEntriesOn = '';
            $strConfirmUpdatedEntriesOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsCountEntries'] == 1) {
            $strCountEntriesOn = 'checked="checked"';
            $strCountEntriesOff = '';
        } else {
            $strCountEntriesOn = '';
            $strCountEntriesOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsShowEntriesInAllLang'] == 1) {
            $strShowEntriesInAllLangOn = 'checked="checked"';
            $strShowEntriesInAllLangOff = '';
        } else {
            $strShowEntriesInAllLangOn = '';
            $strShowEntriesInAllLangOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsAllowAddEntries'] == 1) {
            $strAddEntriesOn = 'checked="checked"';
            $strAddEntriesOff = '';
        } else {
            $strAddEntriesOn = '';
            $strAddEntriesOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsAddEntriesOnlyCommunity'] == 1) {
            $strAddCommunityOn = 'checked="checked"';
            $strAddCommunityOff = '';
        } else {
            $strAddCommunityOn = '';
            $strAddCommunityOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsAllowEditEntries'] == 1) {
            $strEditEntriesOn = 'checked="checked"';
            $strEditEntriesOff = '';
        } else {
            $strEditEntriesOn = '';
            $strEditEntriesOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsAllowDelEntries'] == 1) {
            $strDelEntriesOn = 'checked="checked"';
            $strDelEntriesOff = '';
        } else {
            $strDelEntriesOn = '';
            $strDelEntriesOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsTranslationStatus'] == 1) {
            $strTransStatusOn = 'checked="checked"';
            $strTransStatusOff = '';
        } else {
            $strTransStatusOn = '';
            $strTransStatusOff = 'checked="checked"';
        }
        
        if($this->arrSettings['settingsReadyToConfirm'] == 1) {
            $strReadyToConfirmOn = 'checked="checked"';
            $strReadyToConfirmOff = '';
        } else {
            $strReadyToConfirmOn = '';
            $strReadyToConfirmOff = 'checked="checked"';
        }
        
        if($this->arrSettings['settingsFrontendUseMultilang'] == 1) {
            $strMultilangFrontendOn = 'checked="checked"';
            $strMultilangFrontendOff = '';
        } else {
            $strMultilangFrontendOn = '';
            $strMultilangFrontendOff = 'checked="checked"';
        }
        
        if($this->arrSettings['settingsIndividualEntryOrder'] == 1) {
            $strIndividualOrderOn = 'checked="checked"';
            $strIndividualOrderOff = '';
        } else {
            $strIndividualOrderOn = '';
            $strIndividualOrderOff = 'checked="checked"';
        }


        if(intval($this->arrSettings['settingsEntryDisplaydurationType']) == 1) {
            $strDisplaydurationAlways = 'selected="selected"';
            $strDisplaydurationPeriod = '';
            $strDisplaydurationShowPeriod = 'none';
            $intDisplaydurationValue = 0;
        } else {
            $strDisplaydurationAlways = '';
            $strDisplaydurationPeriod = 'selected="selected"';
            $strDisplaydurationShowPeriod = 'inline';
            $intDisplaydurationValue = intval($this->arrSettings['settingsEntryDisplaydurationValue']);

            switch (intval($this->arrSettings['settingsEntryDisplaydurationValueType'])) {
            	case 1:
	                $strDisplaydurationValueTypeDay = 'selected="selected"';
	                $strDisplaydurationValueTypeMonth = '';
	                $strDisplaydurationValueTypeYear = '';
            		break;
                case 2:
                    $strDisplaydurationValueTypeDay = '';
                    $strDisplaydurationValueTypeMonth = 'selected="selected"';
                    $strDisplaydurationValueTypeYear = '';
                    break;
                case 3:
                    $strDisplaydurationValueTypeDay = '';
                    $strDisplaydurationValueTypeMonth = '';
                    $strDisplaydurationValueTypeYear = 'selected="selected"';
                    break;
            }
        }

        if(intval($this->arrSettings['settingsEntryDisplaydurationNotification']) == 0) {
            $strDisplaydurationNotificationOff = 'selected="selected"';
            $strDisplaydurationNotificationOn = '';
            $strDisplaydurationNotificationValue = 0;
            $strDisplaydurationNotificationShowDaybefore = 'none';
        } else {
            $strDisplaydurationNotificationOff = '';
            $strDisplaydurationNotificationOn = 'selected="selected"';
            $strDisplaydurationNotificationValue = intval($this->arrSettings['settingsEntryDisplaydurationNotification']);
            $strDisplaydurationNotificationShowDaybefore = 'inline';
        }

        $objTpl->setVariable(array(
            $this->moduleLangVar.'_SETTINGS_CONFIRM_NEW_ENTRIES_ON' => $strConfirmEntriesOn,
            $this->moduleLangVar.'_SETTINGS_CONFIRM_NEW_ENTRIES_OFF' => $strConfirmEntriesOff,
            $this->moduleLangVar.'_SETTINGS_CONFIRM_UPDATED_ENTRIES_ON' => $strConfirmUpdatedEntriesOn,
            $this->moduleLangVar.'_SETTINGS_CONFIRM_UPDATED_ENTRIES_OFF' => $strConfirmUpdatedEntriesOff,
            $this->moduleLangVar.'_SETTINGS_COUNT_ENTRIES_ON' => $strCountEntriesOn,
            $this->moduleLangVar.'_SETTINGS_COUNT_ENTRIES_OFF' => $strCountEntriesOff,
            $this->moduleLangVar.'_SETTINGS_ALLOW_ADD_ENTRIES_OFF' => $strAddEntriesOff,
            $this->moduleLangVar.'_SETTINGS_ALLOW_ADD_ENTRIES_ON' => $strAddEntriesOn,
            $this->moduleLangVar.'_SETTINGS_ADD_ONLY_COMMUNITY_OFF' => $strAddCommunityOff,
            $this->moduleLangVar.'_SETTINGS_ADD_ONLY_COMMUNITY_ON' => $strAddCommunityOn,
            $this->moduleLangVar.'_SETTINGS_ALLOW_EDIT_ENTRIES_OFF' => $strEditEntriesOff,
            $this->moduleLangVar.'_SETTINGS_ALLOW_EDIT_ENTRIES_ON' => $strEditEntriesOn,
            $this->moduleLangVar.'_SETTINGS_ALLOW_DEL_ENTRIES_OFF' => $strDelEntriesOff,
            $this->moduleLangVar.'_SETTINGS_ALLOW_DEL_ENTRIES_ON' => $strDelEntriesOn,
            $this->moduleLangVar.'_SETTINGS_SHOW_ENTRIES_IN_ALL_LANG_OFF' => $strShowEntriesInAllLangOff,
            $this->moduleLangVar.'_SETTINGS_SHOW_ENTRIES_IN_ALL_LANG_ON' => $strShowEntriesInAllLangOn,
            $this->moduleLangVar.'_SETTINGS_LATEST_NUM_XML' => intval($this->arrSettings['settingsLatestNumXML']),
            $this->moduleLangVar.'_SETTINGS_LATEST_NUM_OVERVIEW' => intval($this->arrSettings['settingsLatestNumOverview']),
            $this->moduleLangVar.'_SETTINGS_LATEST_NUM_BACKEND' => intval($this->arrSettings['settingsLatestNumBackend']),
            $this->moduleLangVar.'_SETTINGS_LATEST_NUM_FRONTEND' => intval($this->arrSettings['settingsLatestNumFrontend']),
            $this->moduleLangVar.'_SETTINGS_POPULAR_NUM_FRONTEND' => intval($this->arrSettings['settingsPopularNumFrontend']),
            $this->moduleLangVar.'_SETTINGS_POPULAR_NUM_RESTORE' => intval($this->arrSettings['settingsPopularNumRestore']),
            $this->moduleLangVar.'_SETTINGS_LATEST_NUM_HEADLINES' => intval($this->arrSettings['settingsLatestNumHeadlines']),
            $this->moduleLangVar.'_SETTINGS_PAGING_NUM_ENTRIES' => intval($this->arrSettings['settingsPagingNumEntries']),
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_SELECT_ALWAYS' => $strDisplaydurationAlways,
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_SELECT_PERIOD' => $strDisplaydurationPeriod,
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_SHOW_PERIOD' => $strDisplaydurationShowPeriod,
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_VALUE' => $intDisplaydurationValue,
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_VALUE_TYPE_DAY' => $strDisplaydurationValueTypeDay,
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_VALUE_TYPE_MONTH' => $strDisplaydurationValueTypeMonth,
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_VALUE_TYPE_YEAR' => $strDisplaydurationValueTypeYear,
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_NOTIFICATION_OFF' => $strDisplaydurationNotificationOff,
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_NOTIFICATION_ON' => $strDisplaydurationNotificationOn,
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_NOTIFIVATION_SHOW_DAYBEFORE' => $strDisplaydurationNotificationShowDaybefore,
            $this->moduleLangVar.'_SETTINGS_DISPLAYDURATION_NOTIFICATION_VALUE' => $strDisplaydurationNotificationValue,
            $this->moduleLangVar.'_SETTINGS_TRANSLATION_STATUS_OFF' => $strTransStatusOff,
            $this->moduleLangVar.'_SETTINGS_TRANSLATION_STATUS_ON' => $strTransStatusOn,
            $this->moduleLangVar.'_SETTINGS_READY_TO_CONFIRM_ON' => $strReadyToConfirmOn,
            $this->moduleLangVar.'_SETTINGS_READY_TO_CONFIRM_OFF' => $strReadyToConfirmOff,
            $this->moduleLangVar.'_SETTINGS_MULTILANG_FRONTEND_ON' => $strMultilangFrontendOn,
            $this->moduleLangVar.'_SETTINGS_MULTILANG_FRONTEND_OFF' => $strMultilangFrontendOff,
            $this->moduleLangVar.'_SETTINGS_ENTRIEY_INDIVIDUAL_ORDER_ON' => $strIndividualOrderOn,
            $this->moduleLangVar.'_SETTINGS_ENTRIEY_INDIVIDUAL_ORDER_OFF' => $strIndividualOrderOff,
        ));

        if(empty($this->arrCommunityGroups)) {
            $objTpl->setVariable(array(
                'TXT_'.$this->moduleLangVar.'_SETTINGS_NO_COMMUNITY_GROUPS' => $_ARRAYLANG['TXT_MEDIADIR_NO_COMMUNITY_GROUPS'],
            ));
            $objTpl->parse('noCommunityGroupList');
        } else {
            foreach ($this->arrCommunityGroups as $intGroupId => $arrGroup) {
                if($arrGroup['type'] == 'frontend' && $arrGroup['active'] == 1) {
                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_SETTINGS_NUM_ENTRIES_GROUP_NAME' =>$arrGroup['name'],
                        $this->moduleLangVar.'_SETTINGS_NUM_ENTRIES' => $arrGroup['num_entries'],
                        $this->moduleLangVar.'_SETTINGS_NUM_ENTRIES_GROUP_ID' => $intGroupId,
                    ));
                    $objTpl->parse('communityGroupList');
                }
            }
        }
        
        $objLanguages = $objDatabase->Execute("SELECT id,lang,name,frontend,is_default FROM ".DBPREFIX."languages ORDER BY is_default ASC");
        $arrActiveLangs = array();
        $arrActiveLangs = explode(",",$this->arrSettings['settingsActiveLanguages']);
        if ($objLanguages !== false) {
            while (!$objLanguages->EOF) {
            	if(in_array($objLanguages->fields['id'], $arrActiveLangs)) {
            		$strLangStatus = 'checked="checked"';
            	} else {
            	   $strLangStatus = '';
                }
            	$objTpl->setVariable(array(
                    $this->moduleLangVar.'_SETTINGS_ACTIVE_LANG_ID' => intval($objLanguages->fields['id']),
                    $this->moduleLangVar.'_SETTINGS_ACTIVE_LANG_NAME' => htmlspecialchars($objLanguages->fields['name'], ENT_QUOTES, CONTREXX_CHARSET),
                    $this->moduleLangVar.'_SETTINGS_ACTIVE_LANG_STATUS' => $strLangStatus,
                ));
                
                $objTpl->parse('activeLanguageList');
                $objLanguages->MoveNext();
            }
        }

        $objTpl->parse('settings_content');
    }



    function settings_levels_categories($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG;

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_levels_categories.html');

        $objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_CATEGORY_DESC' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_CATEGORY_DESC'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_CATEGORY_IMG' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_CATEGORY_IMG'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CATEGORIES' => $_ARRAYLANG['TXT_MEDIADIR_CATEGORIES'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_CATEGORY_DESC_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_CATEGORY_DESC_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_CATEGORY_IMG_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_CATEGORY_IMG_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_CATEGORY_ORDER' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_CATEGORY_ORDER'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_LEVELS' => $_ARRAYLANG['TXT_MEDIADIR_LEVELS'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_LEVELS' => $_ARRAYLANG['TXT_MEDIADIR_LEVELS']." ".$_ARRAYLANG['TXT_MEDIADIR_ACTIVATE'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_LEVEL_DESC' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_LEVEL_DESC'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_LEVEL_IMG' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_LEVEL_IMG'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_LEVEL_ORDER' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_LEVEL_ORDER'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_LEVELS_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_LEVELS_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_LEVEL_IMG_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_LEVEL_IMG_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_SHOW_LEVEL_DESC_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_SHOW_LEVEL_DESC_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NUM_CATEGORIES_PER_GROUP' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_NUM_CATEGORIES_PER_GROUP'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NUM_CATEGORIES_PER_GROUP_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_NUM_CATEGORIES_PER_GROUP_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NUM_LEVELS_PER_GROUP' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_NUM_LEVELS_PER_GROUP'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NUM_LEVELS_PER_GROUP_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_NUM_LEVELS_PER_GROUP_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NUM' => $_ARRAYLANG['TXT_MEDIADIR_NUM'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_COMMUNITY_GROUP' => $_ARRAYLANG['TXT_MEDIADIR_COMMUNITY_GROUP'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_NO_COMMUNITY_GROUPS' => $_ARRAYLANG['TXT_MEDIADIR_NO_COMMUNITY_GROUPS'],
        ));

        $arrOrder = array(
            0 => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ORDER_USER'],
            1 => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ORDER_ABC'],
            2 => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ORDER_INDEX'],
        );

        if($this->arrSettings['settingsShowCategoryDescription'] == 1) {
            $strCategoryDescOn = 'checked="checked"';
            $strCategoryDescOff = '';
        } else {
            $strCategoryDescOn = '';
            $strCategoryDescOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsShowCategoryImage'] == 1) {
            $strCategoryImgOn = 'checked="checked"';
            $strCategoryImgOff = '';
        } else {
            $strCategoryImgOn = '';
            $strCategoryImgOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsShowLevels'] == 1) {
            $strLevelsOn = 'checked="checked"';
            $strLevelsOff = '';
        } else {
            $strLevelsOn = '';
            $strLevelsOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsShowLevelDescription'] == 1) {
            $strLevelDescOn = 'checked="checked"';
            $strLevelDescOff = '';
        } else {
            $strLevelDescOn = '';
            $strLevelDescOff = 'checked="checked"';
        }

        if($this->arrSettings['settingsShowLevelImage'] == 1) {
            $strLevelImgOn = 'checked="checked"';
            $strLevelImgOff = '';
        } else {
            $strLevelImgOn = '';
            $strLevelImgOff = 'checked="checked"';
        }

        $objTpl->setVariable(array(
            $this->moduleLangVar.'_SETTINGS_CATEGORY_IMG_ON' => $strCategoryImgOn,
            $this->moduleLangVar.'_SETTINGS_CATEGORY_IMG_OFF' => $strCategoryImgOff,
            $this->moduleLangVar.'_SETTINGS_CATEGORY_DESC_ON' => $strCategoryDescOn,
            $this->moduleLangVar.'_SETTINGS_CATEGORY_DESC_OFF' => $strCategoryDescOff,
            $this->moduleLangVar.'_SETTINGS_CATEGORY_ORDER' => $this->buildDropdownmenu($arrOrder, $this->arrSettings['settingsCategoryOrder']),
            $this->moduleLangVar.'_SETTINGS_LEVEL_IMG_ON' => $strLevelImgOn,
            $this->moduleLangVar.'_SETTINGS_LEVEL_IMG_OFF' => $strLevelImgOff,
            $this->moduleLangVar.'_SETTINGS_LEVEL_DESC_ON' => $strLevelDescOn,
            $this->moduleLangVar.'_SETTINGS_LEVEL_DESC_OFF' => $strLevelDescOff,
            $this->moduleLangVar.'_SETTINGS_LEVELS_ON' => $strLevelsOn,
            $this->moduleLangVar.'_SETTINGS_LEVELS_OFF' => $strLevelsOff,
            $this->moduleLangVar.'_SETTINGS_LEVEL_ORDER' => $this->buildDropdownmenu($arrOrder, $this->arrSettings['settingsLevelOrder']),
        ));

        if(empty($this->arrCommunityGroups)) {
            $objTpl->setVariable(array(
                'TXT_'.$this->moduleLangVar.'_SETTINGS_NO_COMMUNITY_GROUPS' => $_ARRAYLANG['TXT_MEDIADIR_NO_COMMUNITY_GROUPS'],
            ));
            $objTpl->parse('noCommunityGroupCategoryList');
        } else {
            foreach ($this->arrCommunityGroups as $intGroupId => $arrGroup) {
                if($arrGroup['type'] == 'frontend' && $arrGroup['active'] == 1) {
                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_SETTINGS_NUM_CATEGORIES_GROUP_NAME' =>$arrGroup['name'],
                        $this->moduleLangVar.'_SETTINGS_NUM_CATEGORIES' => $arrGroup['num_categories'],
                        $this->moduleLangVar.'_SETTINGS_NUM_CATEGORIES_GROUP_ID' => $intGroupId,
                    ));
                    $objTpl->parse('communityGroupCategoryList');


                    $objTpl->setVariable(array(
                        $this->moduleLangVar.'_SETTINGS_NUM_LEVELS_GROUP_NAME' =>$arrGroup['name'],
                        $this->moduleLangVar.'_SETTINGS_NUM_LEVELS' => $arrGroup['num_levels'],
                        $this->moduleLangVar.'_SETTINGS_NUM_LEVELS_GROUP_ID' => $intGroupId,
                    ));
                    $objTpl->parse('communityGroupLevelList');
                }
            }
        }

        $objTpl->parse('settings_content');
    }



    function settings_mails($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_mails.html');

        switch ($_GET['tpl']) {
            case 'delete_template':
                if(!empty($_GET['id'])) {
                    $objDelete = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_mails WHERE `id`='".intval($_GET['id'])."'");
                    if($objDelete !== false){
                        $this->strOkMessage = $_ARRAYLANG['TXT_MEDIADIR_MAIL_TEMPLATE']." ".$_ARRAYLANG['TXT_MEDIADIR_SUCCESSFULLY_DELETED'];
                    } else {
                        $this->strErrMessage = $_ARRAYLANG['TXT_MEDIADIR_MAIL_TEMPLATE']." ".$_ARRAYLANG['TXT_MEDIADIR_CORRUPT_DELETED'];
                    }
                }
                break;
        }

        if(!empty($_POST) && !isset($_POST['submitSettingsForm'])) {
            $objSetAsDefault = $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_mails SET `is_default`='0'");
            foreach ($_POST as $key => $intTemplateDefaultId) {
                $objSetAsDefault = $objDatabase->Execute("UPDATE ".DBPREFIX."module_".$this->moduleTablePrefix."_mails SET `is_default`='1', `active`='1' WHERE `id`='".intval($intTemplateDefaultId)."'");
            }
        }

        $objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_NEW_MAIL_TEMPLATE' => $_ARRAYLANG['TXT_MEDIADIR_NEW_MAIL_TEMPLATE'],
            'TXT_'.$this->moduleLangVar.'_STATUS' => $_CORELANG['TXT_STATUS'],
            'TXT_'.$this->moduleLangVar.'_TITLE' => $_ARRAYLANG['TXT_MEDIADIR_TITLE'],
            'TXT_'.$this->moduleLangVar.'_ACTION' => $_CORELANG['TXT_HISTORY_ACTION'],
            'TXT_'.$this->moduleLangVar.'_LANG' => $_CORELANG['TXT_ACCESS_LANGUAGE'],
            'TXT_'.$this->moduleLangVar.'_DEFAULT' => $_CORELANG['TXT_STANDARD'],
            'TXT_'.$this->moduleLangVar.'_CONFIRM_DELETE_DATA' => $_ARRAYLANG['TXT_MEDIADIR_CONFIRM_DELETE_DATA'],
            'TXT_'.$this->moduleLangVar.'_ACTION_IS_IRREVERSIBLE' => $_ARRAYLANG['TXT_MEDIADIR_ACTION_IS_IRREVERSIBLE'],
            'TXT_EDIT' => $_ARRAYLANG['TXT_MEDIADIR_EDIT'],
            'TXT_DELETE' => $_ARRAYLANG['TXT_MEDIADIR_DELETE'],
        ));

        $objTemplates = $objDatabase->Execute("
            SELECT
                id,title,lang_id,action_id,is_default,active
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_mails
            ORDER BY
                action_id ASC, title ASC
            ");

		if ($objTemplates !== false) {
			while (!$objTemplates->EOF) {
				$strTemplateTitle = htmlspecialchars($objTemplates->fields['title'], ENT_QUOTES, CONTREXX_CHARSET);
				$intTemplateLangId = intval($objTemplates->fields['lang_id']);
				$intTemplateActionId = intval($objTemplates->fields['action_id']);
				$intIsDefault = intval($objTemplates->fields['is_default']);
				$intStatus = intval($objTemplates->fields['active']);
				$intTemplateId = intval($objTemplates->fields['id']);

				//get lang name
				foreach ($this->arrFrontendLanguages as $key => $arrLang) {
				    if($arrLang['id'] == $intTemplateLangId) {
				        $strTemplateLang = $arrLang['name'];
				    }
        		}

        		//get action
        		$objAction = $objDatabase->Execute("SELECT name FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_mail_actions WHERE id='".$intTemplateActionId."' LIMIT 1 ");
        		if ($objAction !== false) {
        			$strTemplateAction = $_ARRAYLANG['TXT_MEDIADIR_MAIL_ACTION_'.strtoupper($objAction->fields['name'])];
        		}

        		if($intStatus == 1) {
        		    $strStatus = 'images/icons/status_green.gif';
        		    $intStatus = 0;
        		} else {
        		    $strStatus = 'images/icons/status_red.gif';
        		    $intStatus = 1;
        		}

        		if($intIsDefault == 1) {
        		    $strIsDefault = 'checked="checked"';
        		} else {
        		    $strIsDefault = '';
        		}

				//parse data variables
                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_TEMPLATE_ROW_CLASS' => $i%2==0 ? 'row1' : 'row2',
                    $this->moduleLangVar.'_TEMPLATE_ID' => $intTemplateId,
                    $this->moduleLangVar.'_TEMPLATE_STATUS' => $strStatus,
                    $this->moduleLangVar.'_TEMPLATE_SWITCH_STATUS' => $intStatus,
                    $this->moduleLangVar.'_TEMPLATE_LANG' => $strTemplateLang,
                    $this->moduleLangVar.'_TEMPLATE_TITLE' => $strTemplateTitle,
                    $this->moduleLangVar.'_TEMPLATE_ACTION' => $strTemplateAction,
                    $this->moduleLangVar.'_TEMPLATE_DEFAULT' => $strIsDefault,
                    $this->moduleLangVar.'_TEMPLATE_DEFAULT_NAME' => "templateDefault_".$intTemplateActionId,
                ));

                $i++;

                $objTpl->parse($this->moduleName.'MailTemplateList');
                $objTemplates->MoveNext();
			}
		}

		if($objTemplates->RecordCount() == 0) {
    		 $objTpl->setVariable(array(
                'TXT_'.$this->moduleLangVar.'_NO_ENTRIES_FOUND' => $_ARRAYLANG['TXT_MEDIADIR_NO_ENTRIES_FOUND']
            ));

            $objTpl->parse($this->moduleName.'MailTemplateNoEntries');
		}

        $objTpl->parse('settings_content');
    }



    function settings_modify_mail($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_modify_mail.html');

        //load teplate data
        if(isset($_GET['id']) && $_GET['id'] != 0) {
            $pageTitle = $_ARRAYLANG['TXT_MEDIADIR_EDIT_MAIL_TEMPLATE'];
            $intTemplateId = intval($_GET['id']);

            $objTemplate = $objDatabase->Execute("
                SELECT
                    title,content,recipients,lang_id,action_id
                FROM
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_mails
                WHERE
                    id='".$intTemplateId."'
                LIMIT 1
                ");
    		if ($objTemplat !== false) {
    			while (!$objTemplate->EOF) {
    				$strTemplateTitle = htmlspecialchars($objTemplate->fields['title'], ENT_QUOTES, CONTREXX_CHARSET);
    				$strTemplateContent = htmlspecialchars($objTemplate->fields['content'], ENT_QUOTES, CONTREXX_CHARSET);
    				$strTemplateRecipients = htmlspecialchars($objTemplate->fields['recipients'], ENT_QUOTES, CONTREXX_CHARSET);
    				$intTemplateLangId = intval($objTemplate->fields['lang_id']);
                    $intTemplateActionId = intval($objTemplate->fields['action_id']);
    				$intStatus = intval($objTemplate->fields['active']);
    				$objTemplate->MoveNext();
    			}
    		}

            //parse data variables
            $objTpl->setGlobalVariable(array(
                $this->moduleLangVar.'_TEMPLATE_ID' => $intTemplateId,
                $this->moduleLangVar.'_TEMPLATE_STATUS' => $intStatus,
                $this->moduleLangVar.'_TEMPLATE_TITLE' => $strTemplateTitle,
                $this->moduleLangVar.'_TEMPLATE_CONTENT' => $strTemplateContent,
                $this->moduleLangVar.'_TEMPLATE_RECIPIENTS' => $strTemplateRecipients,
            ));
        } else {
            $pageTitle = $_ARRAYLANG['TXT_MEDIADIR_NEW_MAIL_TEMPLATE'];
        }

        //get actions
        $arrActions = array();
        $objActions = $objDatabase->Execute("SELECT id, name FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_mail_actions");
		if ($objActions !== false) {
			while (!$objActions->EOF) {
				$arrActions[$objActions->fields['id']] = $_ARRAYLANG['TXT_MEDIADIR_MAIL_ACTION_'.strtoupper($objActions->fields['name'])];
				$objActions->MoveNext();
			}
		}

		//get languages
		$arrLanguages = array();
		foreach ($this->arrFrontendLanguages as $key => $arrLang) {
		    $arrLanguages[$arrLang['id']] = $arrLang['name'];
		}

        $objTpl->setVariable(array(
            'TXT_'.$this->moduleLangVar.'_PAGE_TITLE' => $pageTitle,
            'TXT_'.$this->moduleLangVar.'_ACTION' => $_CORELANG['TXT_HISTORY_ACTION'],
            'TXT_'.$this->moduleLangVar.'_LANG' => $_CORELANG['TXT_BROWSERLANGUAGE'],
            'TXT_'.$this->moduleLangVar.'_RECIPIENTS' => $_ARRAYLANG['TXT_MEDIADIR_RECIPIENTS'],
            'TXT_'.$this->moduleLangVar.'_TITLE' => $_ARRAYLANG['TXT_MEDIADIR_TITLE'],
            'TXT_'.$this->moduleLangVar.'_CONTENT' => $_CORELANG['TXT_CONTENT'],
            'TXT_'.$this->moduleLangVar.'_PLACEHOLDER' => $_ARRAYLANG['TXT_MEDIADIR_PLACEHOLDER'],
            'TXT_'.$this->moduleLangVar.'_USERNAME' => $_CORELANG['TXT_USER_NAME'],
            'TXT_'.$this->moduleLangVar.'_FIRSTNAME' => $_CORELANG['TXT_USER_FIRSTNAME'],
            'TXT_'.$this->moduleLangVar.'_LASTNAME' => $_CORELANG['TXT_USER_LASTNAME'],
            'TXT_'.$this->moduleLangVar.'_TITLE' => $_ARRAYLANG['TXT_MEDIADIR_TITLE'],
            'TXT_'.$this->moduleLangVar.'_LINK' => $_ARRAYLANG['TXT_MEDIADIR_LINK'],
            'TXT_'.$this->moduleLangVar.'_URL' => $_CORELANG['TXT_SETTINGS_DOMAIN_URL'],
            'TXT_'.$this->moduleLangVar.'_DATE' => $_CORELANG['TXT_DATE'],
            $this->moduleLangVar.'_TEMPLATE_ACTION' => $this->buildDropdownmenu($arrActions, $intTemplateActionId),
            $this->moduleLangVar.'_TEMPLATE_LANG' => $this->buildDropdownmenu($arrLanguages, $intTemplateLangId),
        ));

        $objTpl->parse('settings_content');
    }



    function settings_save_mail($arrData)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        $intTemplateId = intval($arrData['templateId']);
        $intTemplateAction = intval($arrData['templateAction']);
        $intTemplateLang = intval($arrData['templateLang']);
        $intTemplateRecipients = contrexx_addslashes($arrData['templateRecipients']);
        $intTemplateTitle = contrexx_addslashes($arrData['templateTitle']);
        $intTemplateContent = contrexx_addslashes($arrData['templateContent']);

        if(!empty($intTemplateId) && $intTemplateId != 0) {
            $objEditTemplate = $objDatabase->Execute("
                UPDATE
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_mails
                SET
                    title='".$intTemplateTitle."',
                    content='".$intTemplateContent."',
                    recipients='".$intTemplateRecipients."',
                    lang_id='".$intTemplateLang."',
                    action_id='".$intTemplateAction."'
                WHERE
                    id='".$intTemplateId."'
                ");
            if ($objEditTemplate === false) {
                return false;
            }
        } else {
            $objAddTemplate = $objDatabase->Execute("
                INSERT INTO
                    ".DBPREFIX."module_".$this->moduleTablePrefix."_mails
                SET
                    title='".$intTemplateTitle."',
                    content='".$intTemplateContent."',
                    recipients='".$intTemplateRecipients."',
                    lang_id='".$intTemplateLang."',
                    action_id='".$intTemplateAction."',
                    is_default=0,
                    active=0
                ");
            if ($objAddTemplate === false) {
                return false;
            }
        }

        parent::getSettings();
        parent::getCommunityGroups();

        return true;
    }



    function settings_forms($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase, $_LANGID;

        switch ($_GET['tpl']) {
            case 'delete_form':
                if(!empty($_GET['id'])) {
                    $objForms = new mediaDirectoryForm();
                    $strStatus = $objForms->deleteForm(intval($_GET['id']));

                    if($strStatus == true){
                        $this->strOkMessage = $_ARRAYLANG['TXT_MEDIADIR_FORM_TEMPLATE']." ".$_ARRAYLANG['TXT_MEDIADIR_SUCCESSFULLY_DELETED'];
                    } else {
                        $this->strErrMessage = $_ARRAYLANG['TXT_MEDIADIR_FORM_TEMPLATE']." ".$_ARRAYLANG['TXT_MEDIADIR_CORRUPT_DELETED'];
                    }
                }
                break;
        }

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_forms.html');

        $objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_NEW_FORM_TEMPLATE' => $_ARRAYLANG['TXT_MEDIADIR_NEW_FORM_TEMPLATE'],
            'TXT_'.$this->moduleLangVar.'_STATUS' => $_CORELANG['TXT_STATUS'],
            'TXT_'.$this->moduleLangVar.'_TITLE' => $_ARRAYLANG['TXT_MEDIADIR_TITLE'],
            'TXT_'.$this->moduleLangVar.'_DESCRIPTION' => $_CORELANG['TXT_DESCRIPTION'],
            'TXT_'.$this->moduleLangVar.'_ACTION' => $_CORELANG['TXT_HISTORY_ACTION'],
            'TXT_'.$this->moduleLangVar.'_ORDER' => $_CORELANG['TXT_CORE_SORTING_ORDER'],
            'TXT_'.$this->moduleLangVar.'_CONFIRM_DELETE_DATA' => $_ARRAYLANG['TXT_MEDIADIR_CONFIRM_DELETE_DATA'],
            'TXT_'.$this->moduleLangVar.'_FORM_DEL_INFO' => $_ARRAYLANG['TXT_MEDIADIR_FORM_DEL_INFO'],
            'TXT_'.$this->moduleLangVar.'_ACTION_IS_IRREVERSIBLE' => $_ARRAYLANG['TXT_MEDIADIR_ACTION_IS_IRREVERSIBLE'],
            'TXT_EDIT' => $_ARRAYLANG['TXT_MEDIADIR_EDIT'],
            'TXT_DELETE' => $_ARRAYLANG['TXT_MEDIADIR_DELETE'],
            'TXT_'.$this->moduleLangVar.'_SUBMIT' => $_CORELANG['TXT_SAVE'],
        ));

        $objForms = new mediaDirectoryForm();
        $objForms->listForms($objTpl, 1, null);


        $objTpl->parse('settings_content');
    }



    function settings_modify_form($objTpl)
    {
        global $_ARRAYLANG, $_CORELANG, $_LANGID, $objDatabase;

        $objTpl->addBlockfile($this->moduleLangVar.'_SETTINGS_CONTENT', 'settings_content', 'module_'.$this->moduleName.'_settings_modify_form.html');

        $objTpl->setGlobalVariable(array(
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS' => $_ARRAYLANG['TXT_MEDIADIR_INPUTFIELDS'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_FORM' => $_ARRAYLANG['TXT_MEDIADIR_FORM'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_PLACEHOLDER' => $_ARRAYLANG['TXT_MEDIADIR_PLACEHOLDER'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_GLOBAL_PLACEHOLDER_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_GLOBAL_PLACEHOLDER_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_PLACEHOLDER_INFO' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_PLACEHOLDER_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_FIELD_SHOW_IN' => $_ARRAYLANG['TXT_MEDIADIR_FIELD_SHOW_IN'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_ADD_NEW' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_INPUTFIELDS_ADD_NEW'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_ID' => $_CORELANG['TXT_GROUP_ID'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_SORT' => $_CORELANG['TXT_CORE_SORTING_ORDER'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_NAME' => $_ARRAYLANG['TXT_MEDIADIR_FIELD_NAME'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_TYPE' => $_ARRAYLANG['TXT_MEDIADIR_FIELD_TYPE'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_DEFAULTVALUE' => $_ARRAYLANG['TXT_MEDIADIR_DEFAULTVALUE'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_CONTEXT' => $_ARRAYLANG['TXT_MEDIADIR_VALUE_CONTEXT'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_CONTEXT_TOOLTIP' => $_ARRAYLANG['TXT_MEDIADIR_VALUE_CONTEXT_TOOLTIP'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_CHECK' => $_ARRAYLANG['TXT_MEDIADIR_VALUE_CHECK'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_MUSTFIELD' => $_ARRAYLANG['TXT_MEDIADIR_MUSTFIELD'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_ACTION' => $_CORELANG['TXT_HISTORY_ACTION'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELD_SYSTEM_FIELD_CANT_DELETE' => $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_INPUTFIELD_SYSTEM_FIELD_CANT_DELETE'],
            'TXT_'.$this->moduleLangVar.'_DELETE' => $_ARRAYLANG['TXT_MEDIADIR_DELETE'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_INPUTFIELDS_EXP_SEARCH' => $_ARRAYLANG['TXT_MEDIADIR_EXP_SEARCH'],
            $this->moduleLangVar.'_SETTINGS_INPUTFIELDS_DEFAULT_LANG_ID' => $_LANGID,
            $this->moduleLangVar.'_SETTINGS_FORM_DEFAULT_LANG_ID' => $_LANGID,
            'TXT_'.$this->moduleLangVar.'_NAME' =>  $_CORELANG['TXT_NAME'],
            'TXT_'.$this->moduleLangVar.'_DESCRIPTION' =>  $_CORELANG['TXT_DESCRIPTION'],
            'TXT_'.$this->moduleLangVar.'_PICTURE' =>  $_CORELANG['TXT_IMAGE'],
            'TXT_'.$this->moduleLangVar.'_BROWSE' =>  $_CORELANG['TXT_BROWSE'],
            'TXT_'.$this->moduleLangVar.'_MORE' =>  $_ARRAYLANG['TXT_MEDIADIR_MORE'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_PERMISSIONS' =>  $_CORELANG['TXT_PERMISSIONS'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_PERMISSIONS_INFO' =>  $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_PERMISSIONS_INFO'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_COMMUNITY_GROUP' =>  $_ARRAYLANG['TXT_MEDIADIR_COMMUNITY_GROUP'],
            'TXT_'.$this->moduleLangVar.'_SETTINGS_ALLOW_GHROUP_ADD_ENTRIES' =>  $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_ALLOW_GHROUP_ADD_ENTRIES'],
            'TXT_'.$this->moduleLangVar.'_CMD' =>  $_ARRAYLANG['TXT_MEDIADIR_CMD'],
            'TXT_'.$this->moduleLangVar.'_CMD_INFO' =>  $_ARRAYLANG['TXT_MEDIADIR_CMD_INFO'],
            'TXT_'.$this->moduleLangVar.'_USE_CATEGORY' =>  $_ARRAYLANG['TXT_MEDIADIR_USE_CATEGORY'],
            'TXT_'.$this->moduleLangVar.'_USE_CATEGORY_INFO' =>  $_ARRAYLANG['TXT_MEDIADIR_USE_CATEGORY_INFO'],
            'TXT_'.$this->moduleLangVar.'_USE_LEVEL' =>  $_ARRAYLANG['TXT_MEDIADIR_USE_LEVEL'],
            'TXT_'.$this->moduleLangVar.'_USE_LEVEL_INFO' =>  $_ARRAYLANG['TXT_MEDIADIR_USE_LEVEL_INFO'],
            $this->moduleLangVar.'_USE_CATEGORY_ON' => 'checked="checked"',
            $this->moduleLangVar.'_USE_LEVEL_ON' => 'checked="checked"',
            $this->moduleLangVar.'_USE_READY_TO_CONFIRM_ON' => 'checked="checked"',
            'TXT_'.$this->moduleLangVar.'_USE_READY_TO_CONFIRM' =>  $_ARRAYLANG['TXT_MEDIADIR_SETTINGS_READY_TO_CONFIRM'],
        ));

        if(isset($_GET['ajax'])) {
            $ajax = $_GET['ajax'];
        } else if (isset($_POST['ajax'])) {
            $ajax = $_POST['ajax'];
        } else {
            $ajax = null;
        }

        //ajax functions
        switch ($ajax) {
            case 'add':
                $objInputfields = new mediaDirectoryInputfield(intval($_GET['id']));
                $intInsertId = $objInputfields->addInputfield();

                die($intInsertId);
                break;

            case 'delete':
                $objInputfields = new mediaDirectoryInputfield(intval($_GET['id']));
                $intInsertId = $objInputfields->deleteInputfield($_GET['field']);
                
                die('1');
                break;

            case 'save':
                $objInputfields = new mediaDirectoryInputfield(intval($_POST['formId']));
                $strInputfields = $objInputfields->saveInputfields($_POST);

                die('1');
                break;

            case 'move':
                $objInputfields = new mediaDirectoryInputfield(intval($_GET['id']));
                $strInputfields = $objInputfields->moveInputfield($_GET['field'], $_GET['direction']);

                die('1');
                break;

            case 'refresh':
                $objInputfields = new mediaDirectoryInputfield(intval($_GET['id']));
                $strInputfields = $objInputfields->refreshInputfields($objTpl);

                //return
                echo $strInputfields;

                die();
                break;
        }

        //load form data
        if(intval($_GET['id']) != 0) {
            $pageTitle = $_ARRAYLANG['TXT_MEDIADIR_EDIT_FORM_TEMPLATE'];
            $intFormId = intval($_GET['id']);

            $objForm = new mediaDirectoryForm($intFormId);

            //parse data variables
            $objTpl->setGlobalVariable(array(
                $this->moduleLangVar.'_FORM_ID' => $intFormId,
                $this->moduleLangVar.'_FORM_NAME_MASTER' => contrexx_raw2xhtml($objForm->arrForms[$intFormId]['formName'][0]),
                $this->moduleLangVar.'_FORM_DESCRIPTION_MASTER' => contrexx_raw2xhtml($objForm->arrForms[$intFormId]['formDescription'][0]),
                $this->moduleLangVar.'_FORM_PICTURE' => $objForm->arrForms[$intFormId]['formPicture'],
                $this->moduleLangVar.'_FORM_CMD' => $objForm->arrForms[$intFormId]['formCmd'],
                $this->moduleLangVar.'_USE_CATEGORY_ON' => $objForm->arrForms[$intFormId]['formUseCategory'] == 1 ? 'checked="checked"' : '',
                $this->moduleLangVar.'_USE_CATEGORY_OFF' => $objForm->arrForms[$intFormId]['formUseCategory'] == 0 ? 'checked="checked"' : '',
                $this->moduleLangVar.'_USE_LEVEL_ON' => $objForm->arrForms[$intFormId]['formUseLevel'] == 1 ? 'checked="checked"' : '',
                $this->moduleLangVar.'_USE_LEVEL_OFF' => $objForm->arrForms[$intFormId]['formUseLevel'] == 0 ? 'checked="checked"' : '',
                $this->moduleLangVar.'_USE_READY_TO_CONFIRM_ON' => $objForm->arrForms[$intFormId]['formUseReadyToConfirm'] == 1 ? 'checked="checked"' : '',
                $this->moduleLangVar.'_USE_READY_TO_CONFIRM_OFF' => $objForm->arrForms[$intFormId]['formUseReadyToConfirm'] == 0 ? 'checked="checked"' : '',
                
            ));

            parent::getCommunityGroups();

            //permissions community groups
            if(empty($this->arrCommunityGroups)) {
                $objTpl->setVariable(array(
                    'TXT_'.$this->moduleLangVar.'_SETTINGS_NO_COMMUNITY_GROUPS' => $_ARRAYLANG['TXT_MEDIADIR_NO_COMMUNITY_GROUPS'],
                ));
                $objTpl->parse($this->moduleName.'FormNoCommunityGroup');
            } else {
                $i=0;
                foreach ($this->arrCommunityGroups as $intGroupId => $arrGroup) {
                    if($arrGroup['type'] == 'frontend' && $arrGroup['active'] == 1) {
                        if(intval($arrGroup['status_group'][$intFormId]) == 1) {
                            $strGroupStatus = 'checked="checked"';
                        } else {
                            $strGroupStatus = '';
                        }

                        $objTpl->setVariable(array(
                            $this->moduleLangVar.'_SETTINGS_COMMUNITY_GROUP_ROW_CLASS' => $i%2==0 ? 'row1' : 'row2',
                            'TXT_'.$this->moduleLangVar.'_SETTINGS_COMMUNITY_GROUP_NAME' => $arrGroup['name'],
                            $this->moduleLangVar.'_SETTINGS_COMMUNITY_GROUP_ACTIVE' => $strGroupStatus,
                            $this->moduleLangVar.'_SETTINGS_COMMUNITY_GROUP_ID' => $intGroupId,
                        ));
                        $i++;
                        $objTpl->parse($this->moduleName.'FormCommunityGroupList');
                    }
                }
            }

            //load inputfields data
            $objInputfields = new mediaDirectoryInputfield($intFormId);
            $objInputfields->listInputfields($objTpl, 1);
            $objInputfields->listPlaceholders($objTpl);
        } else {
            $pageTitle = $_ARRAYLANG['TXT_MEDIADIR_NEW_FORM_TEMPLATE'];

            $objTpl->hideBlock($this->moduleName.'InputfieldsForm');
        }

        //form name language block
        foreach ($this->arrFrontendLanguages as $key => $arrLang) {
            if(isset($intFormId)){
                $strFormName = empty($objForm->arrForms[$intFormId]['formName'][$arrLang['id']]) ? $objForm->arrForms[$intFormId]['formName'][0] : $objForm->arrForms[$intFormId]['formName'][$arrLang['id']];
            } else {
                $intFormId = '';
            }

            $objTpl->setVariable(array(
                $this->moduleLangVar.'_FORM_NAME_LANG_ID' => $arrLang['id'],
                'TXT_'.$this->moduleLangVar.'_FORM_NAME_LANG_NAME' => $arrLang['name'],
                'TXT_'.$this->moduleLangVar.'_FORM_NAME_LANG_SHORTCUT' => $arrLang['lang'],
                $this->moduleLangVar.'_FORM_NAME' => $strFormName,
            ));

            if(($key+1) == count($this->arrFrontendLanguages)) {
                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_MINIMIZE' =>  '<a href="javascript:ExpandMinimizeForm(\'formName\');">&laquo;&nbsp;'.$_ARRAYLANG['TXT_MEDIADIR_MINIMIZE'].'</a>',
                ));
            }

            $objTpl->parse($this->moduleName.'FormNameList');
        }

        //form decription language block
        foreach ($this->arrFrontendLanguages as $key => $arrLang) {
            if(isset($intFormId)){
                $strFormDescription = empty($objForm->arrForms[$intFormId]['formDescription'][$arrLang['id']]) ? $objForm->arrForms[$intFormId]['formDescription'][0] : $objForm->arrForms[$intFormId]['formDescription'][$arrLang['id']];
            } else {
                $intFormId = '';
            }

            $objTpl->setVariable(array(
                $this->moduleLangVar.'_FORM_DESCRIPTION_LANG_ID' => $arrLang['id'],
                'TXT_'.$this->moduleLangVar.'_FORM_DESCRIPTION_LANG_NAME' => $arrLang['name'],
                'TXT_'.$this->moduleLangVar.'_FORM_DESCRIPTION_LANG_SHORTCUT' => $arrLang['lang'],
                $this->moduleLangVar.'_FORM_DESCRIPTION' => $strFormDescription,
            ));

            if(($key+1) == count($this->arrFrontendLanguages)) {
                $objTpl->setVariable(array(
                    $this->moduleLangVar.'_MINIMIZE' =>  '<a href="javascript:ExpandMinimizeForm(\'formDescription\');">&laquo;&nbsp;'.$_ARRAYLANG['TXT_MEDIADIR_MINIMIZE'].'</a>',
                ));
            }

            $objTpl->parse($this->moduleName.'FormDescriptionList');
        }
        
        //use level block
        if($this->arrSettings['settingsShowLevels'] == 1) {
            $objTpl->touchBlock($this->moduleName.'FormUseLevel');
        } else {
            $objTpl->hideBlock($this->moduleName.'FormUseLevel');
        }
        
        //use ready to confirm block
        if($this->arrSettings['settingsReadyToConfirm'] == 1) {
            $objTpl->touchBlock($this->moduleName.'FormUseReadyToConfirm');
        } else {
            $objTpl->hideBlock($this->moduleName.'FormUseReadyToConfirm');
        }

        $objTpl->setVariable(array(
            'TXT_'.$this->moduleLangVar.'_PAGE_TITLE' => $pageTitle,
        ));

        $objTpl->parse('settings_content');
    }



    function saveSettings($arrSettings)
    {
        global $_ARRAYLANG, $_CORELANG, $objDatabase;

        foreach ($arrSettings as $strName => $varValue) {
            switch ($strName) {
                case 'settingsNumEntries':
                    $objSaveSettings = $objDatabase->Execute("TRUNCATE TABLE ".DBPREFIX."module_".$this->moduleTablePrefix."_settings_num_entries");

                    foreach ($varValue as $intGroupId => $strNum) {
                        $objSaveSettings = $objDatabase->Execute("
                            INSERT INTO
                                ".DBPREFIX."module_".$this->moduleTablePrefix."_settings_num_entries
                            SET
                                `group_id` = '".intval($intGroupId)."',
                                `num_entries` = '".contrexx_addslashes($strNum)."'
                            ");

                        if ($objSaveSettings === false) {
                            return false;
                        }
                    }
                    break;
                case 'settingsNumCategories':
                    $objSaveSettings = $objDatabase->Execute("TRUNCATE TABLE ".DBPREFIX."module_".$this->moduleTablePrefix."_settings_num_categories");

                    foreach ($varValue as $intGroupId => $strNum) {
                        $objSaveSettings = $objDatabase->Execute("
                            INSERT INTO
                                ".DBPREFIX."module_".$this->moduleTablePrefix."_settings_num_categories
                            SET
                                `group_id` = '".intval($intGroupId)."',
                                `num_categories` = '".contrexx_addslashes($strNum)."'
                            ");

                        if ($objSaveSettings === false) {
                            return false;
                        }
                    }
                    break;
                case 'settingsNumLevels':
                    $objSaveSettings = $objDatabase->Execute("TRUNCATE TABLE ".DBPREFIX."module_".$this->moduleTablePrefix."_settings_num_levels");

                    foreach ($varValue as $intGroupId => $strNum) {
                        $objSaveSettings = $objDatabase->Execute("
                            INSERT INTO
                                ".DBPREFIX."module_".$this->moduleTablePrefix."_settings_num_levels
                            SET
                                `group_id` = '".intval($intGroupId)."',
                                `num_levels` = '".contrexx_addslashes($strNum)."'
                            ");

                        if ($objSaveSettings === false) {
                            return false;
                        }
                    }
                    break;
                case 'settingsActiveLanguages':
                	$varValue = join(",",$varValue);
                default:
                    $objSaveSettings = $objDatabase->Execute("
                        UPDATE
                            ".DBPREFIX."module_".$this->moduleTablePrefix."_settings
                        SET
                            `value`='".contrexx_addslashes($varValue)."'
                        WHERE
                            `name`='".contrexx_addslashes($strName)."'
                    ");

                    if ($objSaveSettings === false) {
                        return false;
                    }
                    break;
            }
        }

        parent::getSettings();
        parent::getCommunityGroups();

        return true;
    }
}
