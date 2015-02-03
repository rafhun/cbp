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
 * Livecam
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @version        1.0.0
 * @package     contrexx
 * @subpackage  module_livecam
 * @todo        Edit PHP DocBlocks!
 */

/**
 * Livecam
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author        Comvation Development Team <info@comvation.com>
 * @access        public
 * @version        1.0.0
 * @package     contrexx
 * @subpackage  module_livecam
 */
class LivecamManager extends LivecamLibrary
{
    var $_objTpl;
    var $_pageTitle;
    var $_strErrMessage = '';
    var $_strOkMessage = '';

    /**
    * Constructor
    */
    function LivecamManager()
    {
        $this->__construct();
    }

    private $act = '';
    /**
    * PHP5 constructor
    *
    * @global \Cx\Core\Html\Sigma
    * @global array
    * @global array
    */
    function __construct()
    {

        global $objTemplate, $_ARRAYLANG, $_CONFIG;

        $this->_objTpl = new \Cx\Core\Html\Sigma(ASCMS_MODULE_PATH.'/livecam/template');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);

        $this->getSettings();
/*
        what the fuck is this?
        if (isset($_POST['saveSettings'])) {
            $arrSettings = array(
                'blockStatus'    => isset($_POST['blockUseBlockSystem']) ? intval($_POST['blockUseBlockSystem']) : 0
            );
            $this->_saveSettings($arrSettings);
        }
        */

    }
    private function setNavigation()
    {
        global $objTemplate, $_ARRAYLANG;

        $objTemplate->setVariable("CONTENT_NAVIGATION", "
            <a href='index.php?cmd=livecam' class='".($this->act == '' ? 'active' : '')."'>".$_ARRAYLANG['TXT_CAMS']."</a>"."
            <a href='index.php?cmd=livecam&amp;act=settings' class='".($this->act == 'settings' ? 'active' : '')."'>".$_ARRAYLANG['TXT_SETTINGS']."</a>");
    }

    /**
     * Get page
     *
     * Get a page of the block system administration
     *
     * @access public
     * @global \Cx\Core\Html\Sigma
     * @global array
     */
    function getPage()
    {

/*
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        */
        global $objTemplate, $_CONFIG;

        if (!isset($_REQUEST['act'])) {
            $_REQUEST['act'] = '';
        }

        switch ($_REQUEST['act']) {
            case 'saveSettings':
                $this->saveSettings();
                CSRF::header("Location: index.php?cmd=livecam&act=settings");
                break;
            case 'settings':
                $this->settings();
                break;
            case 'saveCam':
                $this->saveCam();
                break;
            case 'cams':
            default:
                $this->showCams();
                break;
        }

        $objTemplate->setVariable(array(
            'CONTENT_TITLE'                => $this->_pageTitle,
            'CONTENT_OK_MESSAGE'        => $this->_strOkMessage,
            'CONTENT_STATUS_MESSAGE'    => $this->_strErrMessage,
            'ADMIN_CONTENT'                => $this->_objTpl->get()
        ));

        $this->act = $_REQUEST['act'];
        $this->setNavigation();
    }

    /**
     * Show the cameras
     *
     * @access private
     * @global array
     * @global array
     * @global array
     */
    function showCams()
    {
        global $_ARRAYLANG, $_CONFIG, $_CORELANG;

        $this->_pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('module_livecam_cams.html');

        $amount = $this->arrSettings['amount_of_cams'];

        $cams = $this->getCamSettings();

        $this->_objTpl->setGlobalVariable(array(
            'TXT_SETTINGS'            => $_ARRAYLANG['TXT_SETTINGS'],
            'TXT_CURRENT_IMAGE_URL'   => $_ARRAYLANG['TXT_CURRENT_IMAGE_URL'],
            'TXT_ARCHIVE_PATH'        => $_ARRAYLANG['TXT_ARCHIVE_PATH'],
            'TXT_SAVE'                => $_ARRAYLANG['TXT_SAVE'],
            'TXT_THUMBNAIL_PATH'      => $_ARRAYLANG['TXT_THUMBNAIL_PATH'],
            'TXT_SHADOWBOX_ACTIVE'     => $_CORELANG['TXT_ACTIVATED'],
            'TXT_SHADOWBOX_INACTIVE'   => $_CORELANG['TXT_DEACTIVATED'],
            'TXT_ACTIVATE_SHADOWBOX'   => $_ARRAYLANG['TXT_ACTIVATE_SHADOWBOX'],
            'TXT_ACTIVATE_SHADOWBOX_INFO'    => $_ARRAYLANG['TXT_ACTIVATE_SHADOWBOX_INFO'],
            'TXT_MAKE_A_FRONTEND_PAGE'    => $_ARRAYLANG['TXT_MAKE_A_FRONTEND_PAGE'],
            'TXT_CURRENT_IMAGE_MAX_SIZE'    => $_ARRAYLANG['TXT_CURRENT_IMAGE_MAX_SIZE'],
            'TXT_THUMBNAIL_MAX_SIZE'        => $_ARRAYLANG['TXT_THUMBNAIL_MAX_SIZE'],
            'TXT_CAM'                 => $_ARRAYLANG['TXT_CAM'],
            'MODULE_PATH'             => ASCMS_MODULE_WEB_PATH,
            'ASCMS_PATH_OFFSET'       => ASCMS_PATH_OFFSET,
            'ASCMS_PATH_OFFSET'       => ASCMS_PATH_OFFSET,
            'TXT_SUCCESS'             => $_CORELANG['TXT_SETTINGS_UPDATED'],
            'TXT_TO_MODULE'           => $_ARRAYLANG['TXT_LIVECAM_TO_MODULE'],
            'TXT_SHOWFROM'            => $_ARRAYLANG['TXT_LIVECAM_SHOWFROM'],
            'TXT_SHOWTILL'            => $_ARRAYLANG['TXT_LIVECAM_SHOWTILL'],
            'TXT_OCLOCK'              => $_ARRAYLANG['TXT_LIVECAM_OCLOCK'],
        ));

        for ($i = 1; $i<=$amount; $i++) {
            if ($cams[$i]['shadowboxActivate'] == 1) {
                $shadowboxActive = 'checked="checked"';
                $shadowboxInctive = '';
            } else {
                $shadowboxActive = '';
                $shadowboxInctive = 'checked="checked"';
            }

            $this->_objTpl->setVariable(array(
                'CAM_NUMBER'             => $i,
                'CURRENT_IMAGE_URL'      => $cams[$i]['currentImagePath'],
                'ARCHIVE_PATH'           => $cams[$i]['archivePath'],
                'THUMBNAIL_PATH'         => $cams[$i]['thumbnailPath'],
                'SHADOWBOX_ACTIVE'         => $shadowboxActive,
                'SHADOWBOX_INACTIVE'         => $shadowboxInctive,
                'CURRENT_IMAGE_MAX_SIZE' => $cams[$i]['maxImageWidth'],
                'THUMBNAIL_MAX_SIZE'     => $cams[$i]['thumbMaxSize'],
                'HOUR_FROM'              => $this->getHourOptions($cams[$i]['showFrom']),
                'MINUTE_FROM'            => $this->getMinuteOptions($cams[$i]['showFrom']),
                'HOUR_TILL'              => $this->getHourOptions((!empty($cams[$i]['showTill']) ? $cams[$i]['showTill'] : mktime(23))),
                'MINUTE_TILL'            => $this->getMinuteOptions((!empty($cams[$i]['showTill']) ? $cams[$i]['showTill'] : mktime(0, 59))),
            ));

            if (preg_match("/^https{0,1}:\/\//", $cams[$i]['currentImagePath'])) {
                $filepath = $cams[$i]['currentImagePath'];
                $this->_objTpl->setVariable("PATH", $filepath);
                $this->_objTpl->parse("current_image");
            } else {
                $filepath = ASCMS_PATH.$cams[$i]['currentImagePath'];
                if (file_exists($filepath) && is_file($filepath)) {
                    $this->_objTpl->setVariable("PATH", $cams[$i]['currentImagePath']);
                    $this->_objTpl->parse("current_image");
                } else {
                    $this->_objTpl->hideBlock("current_image");
                }
            }


            $this->_objTpl->parse("cam");

            /*
            $this->_objTpl->setVariable('BLOCK_USE_BLOCK_SYSTEM', $_CONFIG['blockStatus'] == '1' ? 'checked="checked"' : '');
            */
        }
    }

    /**
     * Save the cam's settings
     *
     */
    function saveCam()
    {
        global $objDatabase;

        $id = intval($_POST['id']);
        if (!$id) {
            return false;
        }
        $currentImagePath = $_POST['currentImagePath'];
        $maxImageWidth = intval($_POST['maxImageWidth']);
        $archivePath = $_POST['archivePath'];
        $thumbnailPath = $_POST['thumbnailPath'];
        $thumbMaxSize = intval($_POST['thumbMaxSize']);
        $shadowboxActivate = intval($_POST['shadowboxActivate']);
        $hourFrom = intval($_POST['hourFrom']);
        $hourTill = intval($_POST['hourTill']);
        $minuteFrom = intval($_POST['minuteFrom']);
        $minuteTill = intval($_POST['minuteTill']);
        $showFrom = mktime($hourFrom, $minuteFrom);
        $showTill = mktime($hourTill, $minuteTill);

        $query = " UPDATE ".DBPREFIX."module_livecam
                   SET currentImagePath = '".$currentImagePath."',
                       maxImageWidth = ".$maxImageWidth.",
                       archivePath = '".$archivePath."',
                       thumbnailPath = '".$thumbnailPath."',
                       thumbMaxSize = ".$thumbMaxSize.",
                       shadowboxActivate = '".$shadowboxActivate."',
                       showFrom = $showFrom,
                       showTill = $showTill
                   WHERE id = ".$id;
        if ($objDatabase->Execute($query) === false) {
            // return a 500 or so
            header("HTTP/1.0 500 Internal Server Error");
            die();
        }
        die();
    }

    /**
     * Show settings
     *
     */
    private function settings()
    {
        global $_ARRAYLANG, $objDatabase;

        $this->_pageTitle = $_ARRAYLANG['TXT_SETTINGS'];
        $this->_objTpl->loadTemplateFile('module_livecam_settings.html');

        /*
            i'd do this differently if i had the time and since there's
            only property i guess this isn't that bat
        */
        $query = "SELECT setvalue FROM ".DBPREFIX."module_livecam_settings
                    WHERE setname = 'amount_of_cams'";
        $result = $objDatabase->Execute($query);


        $this->_objTpl->setVariable(array(
            "TXT_SETTINGS"          => $_ARRAYLANG['TXT_SETTINGS'],
            "TXT_SAVE"              => $_ARRAYLANG['TXT_SAVE'],
            "TXT_NUMBER_OF_CAMS"    => $_ARRAYLANG['TXT_LIVECAM_NUMBER_OF_CAMS'],
            "NUMBER_OF_CAMS"        => $result->fields['setvalue']
        ));
    }


    /**
     * Save Settings
     *
     * @access private
     * @global ADONewConnection
     * @global array
     * @global array
     */
    private function saveSettings()
    {
        global $objDatabase, $_ARRAYLANG, $_CORELANG;

        $number_of_cams = intval($_POST['number_of_cams']);
        $this->save("amount_of_cams", $number_of_cams);

        for ($i = 1; $i<=$number_of_cams; $i++) {
            $query = "  SELECT id
                        FROM ".DBPREFIX."module_livecam
                        WHERE id = ".$i;
            $result = $objDatabase->Execute($query);
            if ($result->RecordCount() == 0) {
                $query = "  INSERT INTO ".DBPREFIX."module_livecam
                            (id, currentImagePath, archivePath, thumbnailPath,
                             maxImageWidth, thumbMaxSize, shadowboxActivate)
                            VALUES
                            (".$i.", '/webcam/cam".$i."/current.jpg',
                             '/webcam/cam".$i."/archive',
                             '/webcam/cam".$i."/thumbs', 400, 120, 1)";
                $objDatabase->Execute($query);
            }
        }

        $this->cleanUp($number_of_cams);
    }

    /**
     * Save
     *
     * Saves one option
     *
     * @access private
     * @global ADONewConnection
     */
    private function save($setname, $setval)
    {
        global $objDatabase;

        $setval = addslashes($setval);
        $setname = addslashes($setname);

        $query = "UPDATE ".DBPREFIX."module_livecam_settings
                SET setvalue = '$setval'
                WHERE setname = '$setname'";

        if (!$objDatabase->Execute($query)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Enter description here...
     *
     * @param unknown_type $number
     */
    private function cleanUp($number)
    {
        global $objDatabase;

        $query = " DELETE FROM ".DBPREFIX."module_livecam
                   WHERE id > ".$number;
        $objDatabase->Execute($query);
    }


    /**
     * gets the contents of a HTML select for a list of hours, if timestamp is set, it also gets the selected value
     *
     * @param integer $timestamp Time of the selected value
     * @return string HTML option list
     */
    private function getHourOptions($timestamp) {

        $hours = (!empty($timestamp) ? date('G', $timestamp) : 0);
        $options = "";
        for($i = 0; $i < 24; $i++) {
            $selected = "";
            if($hours == $i)
                    $selected = "selected='selected'";
            $options .= "<option value='$i' $selected>$i</option>";
        }
        return $options;
    }

    /**
     * gets the contents of a HTML select for a list of minutes, if timestamp is set, it also gets the selected value
     *
     * @param integer $timestamp Time of the selected value
     * @return string HTML option list
     */
    private function getMinuteOptions($timestamp) {
        $minutes = date('i', $timestamp);
        $options = "";

        for($i = 0; $i < 60; $i++) {
            $selected = "";
            if($minutes == $i)
                $selected = "selected='selected'";
            $options .= "<option value='$i' $selected>$i</option>";
        }
        return $options;
    }
}
?>
