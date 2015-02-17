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
class Livecam extends LivecamLibrary
{
    /**
     * Template object
     *
     * @access private
     * @var object
     */
    var $_objTpl;

    /**
     * Status message
     *
     * @access public
     * @var string
     */
    var $statusMessage;

    /**
     * Archive thumbnail links
     *
     * @access private
     * @var array
     */
    var $_arrArchiveThumbs = array();

    /**
     * Action
     *
     * @access private
     * @var string
     */
    var $_action = '';

    /**
     * Picture template placeholder
     *
     * @access private
     * @var string
     */
    var $_pictureTemplatePlaceholder = 'livecamArchivePicture';

    /**
     * Date
     *
     * @access public
     * @var string
     */
    var $date;


    /**
     * The current Cam
     *
     * @var int
     */
    private $cam = 1;


    /**
     * Constructor
     *
     * @param  string $pageContent
     * @access public
     */
    function Livecam($pageContent)
    {
        $this->__construct($pageContent);
    }

    /**
     * PHP5 constructor
     * @param  string  $pageContent
     * @access public
     */
    function __construct($pageContent)
    {
        $this->pageContent = $pageContent;

        $this->_objTpl = new \Cx\Core\Html\Sigma('.');
        CSRF::add_placeholder($this->_objTpl);
        $this->_objTpl->setErrorHandling(PEAR_ERROR_DIE);

        $this->_getAction();
        $this->_getDate();

        // get the livecam settings
        $this->getSettings();
    }

    /**
     * Get action
     *
     * Get the action that should be executed
     *
     * @access private
     */
    function _getAction()
    {
        if (!empty($_GET['cmd'])) {
            $this->cam = intval($_GET['cmd']);
        } else {
            $this->cam = 1;
        }


        if (isset($_REQUEST['act'])) {
            if (is_array($_REQUEST['act'])) {
                $this->_action = key($_REQUEST['act']);
            } else {
                $this->_action = $_REQUEST['act'];
            }
        }
    }

    /**
     * Get date
     *
     * Get the date to be used
     *
     * @access private
     */
    function _getDate()
    {
        if ($this->_action == 'archive') {
            $this->date = contrexx_strip_tags($_REQUEST['date']);
        } else {
            $d = date("d");
            $m = date("m");
            $y = date("Y");

            $this->date = $y."-".$m."-".$d;
        }
    }

    /**
     * Get page
     *
     * Get the livecam page
     *
     * @access public
     * @return string
     */
    function getPage()
    {
        $this->_objTpl->setTemplate($this->pageContent);

        $this->_objTpl->setVariable(array(
            "CMD"                   => $this->cam
        ));
        $this->_objTpl->setGlobalVariable('LIVECAM_DATE', $this->date);

        switch ($this->_action) {
        case 'today':
            $this->_objTpl->hideBlock('livecamPicture');
            $this->_showArchive($this->date);
            break;

        case 'archive':
            $this->_objTpl->hideBlock('livecamPicture');
            $this->_showArchive($this->date);
            break;

        default:
            $this->_objTpl->hideBlock('livecamArchive');
            $this->_showPicture();
            break;
        }

        if (isset($this->statusMessage)) {
            $this->_objTpl->setVariable('LIVECAM_STATUS_MESSAGE', $this->statusMessage);
        }

        return $this->_objTpl->get();
    }

    /**
     * Show picture
     *
     * Either show the current picture of the livecam or one from the archive
     *
     * @access private
     */
    function _showPicture()
    {
        $this->camSettings = $this->getCamSettings($this->cam);
        //var_dump($this->camSettings);

        JS::activate("shadowbox", array('players' => array('img')));
        JS::activate('jqueryui');
        JS::registerCode("
            cx.ready(function() {
                cx.jQuery('input[name=date]').datepicker({dateFormat: 'yy-mm-dd'});
            });
        ");

        if ($this->camSettings['shadowboxActivate'] == 1) {
            $imageLink = $this->camSettings['currentImagePath'];
        } else {
            if (isset($_GET['file'])) {
                $archiveDate = substr($_GET['file'], 0, 10);
                $imageLink = 'index.php?section=livecam&act=archive&date='.$archiveDate;
            } else {
                $cmd = '';
                if (!empty($_GET['cmd'])) {
                    $cmd = '&amp;cmd='.intval($_GET['cmd']);
                }
                $imageLink = "?section=livecam$cmd&amp;act=today";
            }
        }

        $this->_objTpl->setVariable(array(
            'LIVECAM_CURRENT_IMAGE'      => isset($_GET['file']) ? ASCMS_PATH_OFFSET.$this->camSettings['archivePath'].'/'.$_GET['file'] : $this->camSettings['currentImagePath'],
            'LIVECAM_IMAGE_TEXT'        => isset($_GET['file']) ? contrexx_strip_tags($_GET['file']) : 'Aktuelles Webcam Bild',
            'LIVECAM_IMAGE_SHADOWBOX'   => $this->camSettings['shadowboxActivate'] == 1 ? 'shadowboxgallery' : '',
            'LIVECAM_IMAGE_LINK'        => $imageLink,
            'LIVECAM_IMAGE_SIZE'        => $this->camSettings['currentMaxSize'],
        ));
    }


    /**
     * Sort helper for sorting the thumbnails by time
     */
    function _sort_thumbs($a, $b) {
        $timea = $a['time'];
        $timeb = $b['time'];

        // No equal times to be expected, therefore
        // we don't check for equality.
        if ($timea < $timeb) {
            return 1;
        }
        return -1;
    }



    /**
     * Show archive
     *
     * Show the livecam archive from a specified date
     *
     * @access private
     * @param string $date
     */
    function _showArchive($date)
    {
		global $_ARRAYLANG;

        JS::activate("shadowbox", array('players' => array('img')));
        JS::activate('jqueryui');
        JS::registerCode("
            cx.ready(function() {
                cx.jQuery('input[name=date]').datepicker({dateFormat: 'yy-mm-dd'});
            });
        ");

        $this->camSettings = $this->getCamSettings($this->cam);
        $this->_getThumbs();

        if (count($this->_arrArchiveThumbs)>0) {
            $countPerRow;
            $picNr = 1;

            usort($this->_arrArchiveThumbs, array($this, '_sort_thumbs'));

            foreach ($this->_arrArchiveThumbs as $arrThumbnail) {
                if (!isset($countPerRow)) {
                    if (!$this->_objTpl->blockExists($this->_pictureTemplatePlaceholder.$picNr)) {
                        $this->_objTpl->parse('livecamArchiveRow');

                        $countPerRow = $picNr-1;
                        $picNr = 1;
                    }
                }

                $this->_objTpl->setVariable(array(
                    'LIVECAM_PICTURE_URL'       => $arrThumbnail['link_url'],
                    'LIVECAM_PICTURE_TIME'      => $arrThumbnail['time'],
                    'LIVECAM_THUMBNAIL_URL'     => $arrThumbnail['image_url'],
                    'LIVECAM_THUMBNAIL_SIZE'    => $this->camSettings['thumbMaxSize'],
                    'LIVECAM_IMAGE_SHADOWBOX'   => $this->camSettings['shadowboxActivate'] == 1 ? 'shadowbox[gallery]' : '',
                ));
                $this->_objTpl->parse($this->_pictureTemplatePlaceholder.$picNr);

                if (isset($countPerRow) && $picNr == $countPerRow) {
                    $picNr = 0;
                    $this->_objTpl->parse('livecamArchiveRow');
                }

                $picNr++;
            }
            $this->_objTpl->parse('livecamArchive');
        } else {
            $this->statusMessage = $_ARRAYLANG['TXT_LIVECAM_NO_PICTURES_OF_SELECTED_DAY'];
        }
    }

    /**
     * Get thumbnails
     *
     * Get the thumbnails from a day in the archive.
     * Create the thumbnails if they don't already exists.
     *
     * @access private
     */
    function _getThumbs()
    {

        $path = ASCMS_DOCUMENT_ROOT."/".$this->camSettings['archivePath'].'/'.$this->date.'/';
        $objDirectory = @opendir($path);
        $objFile = new File();
        $chmoded = false;

        if ($objDirectory) {
            while ($file = readdir ($objDirectory)) {
                if ($file != "." && $file != "..") {
                    //check and create thumbs
                    $thumb = ASCMS_DOCUMENT_ROOT.$this->camSettings['thumbnailPath'].'/tn_'.$this->date.'_'.$file;

                    if(!file_exists($thumb)){
                        if (!$chmoded) {
                            $objFile->setChmod(ASCMS_DOCUMENT_ROOT.$this->camSettings['archivePath'], ASCMS_PATH_OFFSET, $this->camSettings['thumbnailPath']);
                            $chmoded = true;
                        }

                        //create thumb
                        $im1 = @imagecreatefromjpeg($path.$file); //erstellt ein Abbild im Speicher
                        if ($im1) {  /* Pr�fen, ob fehlgeschlagen */
                            // check_jpeg($thumb, $fix=false );
                            $size = getimagesize($path.$file); //ermittelt die Gr��e des Bildes
                            $breite = $size[0]; //die Breite des Bildes
                            $hoehe = $size[1]; //die H�he des Bildes


                            $breite_neu = $this->camSettings['thumbMaxSize']; //die breite des Thumbnails
                            $factor = $breite/$this->camSettings['thumbMaxSize']; //berechnungsfaktor
                            $hoehe_neu = $size[1]/$factor; //die H�he des Thumbnails

                            //$im2=imagecreate($breite_neu,$hoehe_neu); //Thumbnail im Speicher erstellen
                            $im2 = @imagecreatetruecolor($breite_neu,$hoehe_neu);

                            imagecopyresized($im2, $im1, 0,0, 0,0,$breite_neu,$hoehe_neu, $breite,$hoehe);
                            imagejpeg($im2, $thumb); //Thumbnail speichern

                            imagedestroy($im1); //Speicherabbild wieder l�schen
                            imagedestroy($im2); //Speicherabbild wieder l�schen
                        }
                    }

                    //show pictures
                    $minHour = date('G',$this->camSettings['showFrom']);
                    $minMinutes = date('i',$this->camSettings['showFrom']);
                    $maxHour = date('G',$this->camSettings['showTill']);
                    $maxMinutes = date('i',$this->camSettings['showTill']);


                    $hour = substr($file,4,2);
                    $min = substr($file,13,2);
                    $min = !empty($min) ? $min : "00";
                    $time = $hour.":".$min."&nbsp;Uhr";

                    $minTime = mktime($minHour, $minMinutes);
                    $maxTime = mktime($maxHour, $maxMinutes);
                    $nowTime = mktime($hour, $min);

                    /*
                    * only show archive images if they are in range
                    */
                    if($nowTime <= $maxTime && $nowTime >= $minTime) {

                        if($this->camSettings['shadowboxActivate'] == 1) {
                            $linkUrl = ASCMS_PATH_OFFSET.$this->camSettings['archivePath'].'/'.$this->date.'/'.$file;
                        } else {
                            $linkUrl = '?section=livecam&amp;file='.$this->date.'/'.$file;
                        }

                        $arrThumbnail = array(
                            'link_url'    => $linkUrl,
                            'image_url'    => $this->camSettings['thumbnailPath']."/tn_".$this->date."_".$file,
                            'time'        => $time
                        );
                        array_push($this->_arrArchiveThumbs, $arrThumbnail);
                    }
                }
            }
            closedir($objDirectory);
        }
    }
}
?>
