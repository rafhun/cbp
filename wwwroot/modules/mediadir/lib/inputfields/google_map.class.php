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
 * Media Directory Inputfield Google Map Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      Comvation Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 * @todo        Edit PHP DocBlocks!
 */

/**
 * @ignore
 */
require_once ASCMS_MODULE_PATH . '/mediadir/lib/inputfields/inputfield.interface.php';

/**
 * Media Directory Inputfield Google Map Class
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  module_mediadir
 */
class mediaDirectoryInputfieldGoogle_map extends mediaDirectoryLibrary implements inputfield
{
    public $arrPlaceholders = array('TXT_MEDIADIR_INPUTFIELD_NAME','MEDIADIR_INPUTFIELD_VALUE','MEDIADIR_INPUTFIELD_LINK', 'MEDIADIR_INPUTFIELD_LINK_HREF');

    private $imagePath;
    private $imageWebPath;

    /**
     * Constructor
     */
    function __construct()
    {
        $this->imagePath = constant('ASCMS_'.$this->moduleConstVar.'_IMAGES_PATH').'/';
        $this->imageWebPath = constant('ASCMS_'.$this->moduleConstVar.'_IMAGES_WEB_PATH') .'/';
    }

    function getInputfield($intView, $arrInputfield, $intEntryId=null)
    {
        global $objDatabase,$_CORELANG, $_ARRAYLANG, $_LANGID, $objInit, $_CONFIG;

        switch ($intView) {
            default:
            case 1:
                //modify (add/edit) View
                $intId = intval($arrInputfield['id']);
                parent::getSettings();

                if(isset($intEntryId) && $intEntryId != 0) {
                    $objInputfieldValue = $objDatabase->Execute("
                        SELECT
                            `value`
                        FROM
                            ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
                        WHERE
                            field_id=".$intId."
                        AND
                            entry_id=".$intEntryId."
                        LIMIT 1
                    ");
                    $strValue  = htmlspecialchars($objInputfieldValue->fields['value'], ENT_QUOTES, CONTREXX_CHARSET);
                    $arrValues = explode(',', $strValue);

                    $strValueLat = empty($arrValues[0]) ? 0 : $arrValues[0];
                    $strValueLon = empty($arrValues[1]) ? 0 : $arrValues[1];
                    $strValueZoom = empty($arrValues[2]) ? 0 : $arrValues[2];
                    $strValueStreet = empty($arrValues[3]) ? '' : $arrValues[3];
                    $strValueCity = empty($arrValues[4]) ? '' : $arrValues[4];
                    $strValueZip = empty($arrValues[5]) ? '' : $arrValues[5];

                } else {
                    $objSettingsRS = $objDatabase->Execute("SELECT value FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_settings WHERE name='settingsGoogleMapStartposition'");
                    if ($objSettingsRS !== false) {
                        $strValue = htmlspecialchars($objSettingsRS->fields['value'], ENT_QUOTES, CONTREXX_CHARSET);
                    }
                    $arrValues = explode(',', $strValue);

                    $strValueLat = empty($arrValues[0]) ? 0 : $arrValues[0];
                    $strValueLon = empty($arrValues[1]) ? 0 : $arrValues[1];
                    $strValueZoom = empty($arrValues[2]) ? 0 : $arrValues[2];
                }

                $strMapId       = $this->moduleName.'Inputfield_'.$intId.'_map';
                $strLonId       = $this->moduleName.'Inputfield_'.$intId.'_lon';
                $strLatId       = $this->moduleName.'Inputfield_'.$intId.'_lat';
                $strZoomId      = $this->moduleName.'Inputfield_'.$intId.'_zoom';
                $strStreetId    = $this->moduleName.'Inputfield_'.$intId.'_street';
                $strZipId       = $this->moduleName.'Inputfield_'.$intId.'_zip';
                $strCityId      = $this->moduleName.'Inputfield_'.$intId.'_city';
                $strKey         = $_CONFIG['googleMapsAPIKey'];

                if($objInit->mode == 'backend') {
                    $strInputfield .= '<table cellpadding="0" cellspacing="0" border="0" class="'.$this->moduleName.'TableGoogleMap">';
                    $strInputfield .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_STREET'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][street]" id="'.$strStreetId.'" value="'.$strValueStreet.'" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_CITY'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][place]" id="'.$strZipId.'"  value="'.$strValueZip.'" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_ZIP'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][zip]" id="'.$strCityId.'" value="'.$strValueCity.'" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '<tr><td style="border: 0px;"><br /></td><td style="border: 0px;"><input type="button" onclick="searchAddress();" name="'.$this->moduleName.'Inputfield['.$intId.'][search]" id="'.$this->moduleName.'Inputfield_'.$intId.'_search" value="'.$_CORELANG['TXT_SEARCH'].'" /></td></tr>';
                    $strInputfield .= '<tr><td style="border: 0px;" coldpan="2"><br /></td></tr>';
                    $strInputfield .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_LON'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][lon]" id="'.$strLonId.'"  value="'.$strValueLon.'" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_LAT'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][lat]" id="'.$strLatId.'" value="'.$strValueLat.'" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '<tr><td style="border: 0px;">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_ZOOM'].':&nbsp;&nbsp;</td><td style="border: 0px; padding-bottom: 2px;"><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][zoom]" id="'.$strZoomId.'" value="'.$strValueZoom.'" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '</table><br />';
                    $strInputfield .= '<div id="'.$strMapId.'" style="border: solid 1px #0A50A1; width: 418px; height: 300px;"></div>';

                } else {
                    $strInputfield  = '<div class="'.$this->moduleName.'GoogleMap" style="float: left; height: auto ! important;">';
                    $strInputfield .= '<fieldset class="'.$this->moduleName.'FieldsetGoogleMap">';
                    $strInputfield .= '<legend>'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_SEARCH_ADDRESS'].'</legend>';
                    $strInputfield .= '<table cellpadding="0" cellspacing="0" border="0" class="'.$this->moduleName.'TableGoogleMap">';
                    $strInputfield .= '<tr><td>'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_STREET'].':&nbsp;&nbsp;</td><td><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][street]" id="'.$strStreetId.'" class="'.$this->moduleName.'InputfieldGoogleMapLarge" value="" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '<tr><td>'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_CITY'].':&nbsp;&nbsp;</td><td><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][place]" id="'.$strZipId.'" class="'.$this->moduleName.'InputfieldGoogleMapLarge" value="" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '<tr><td>'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_ZIP'].':&nbsp;&nbsp;</td><td><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][zip]" id="'.$strCityId.'" class="'.$this->moduleName.'InputfieldGoogleMapSmall" value="" onfocus="this.select();" /><input type="button" onclick="searchAddress();" name="'.$this->moduleName.'Inputfield['.$intId.'][search]" id="'.$this->moduleName.'Inputfield_'.$intId.'_search" value="'.$_CORELANG['TXT_SEARCH'].'" /></td></tr>';
                    $strInputfield .= '<tr><td coldpan="2"><br /></td></tr>';
                    $strInputfield .= '<tr><td>'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_LON'].':&nbsp;&nbsp;</td><td><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][lon]" id="'.$strLonId.'" class="'.$this->moduleName.'InputfieldGoogleMapLarge" value="'.$strValueLon.'" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '<tr><td>'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_LAT'].':&nbsp;&nbsp;</td><td><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][lat]" id="'.$strLatId.'" class="'.$this->moduleName.'InputfieldGoogleMapLarge" value="'.$strValueLat.'" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '<tr><td>'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLE_MAP_ZOOM'].':&nbsp;&nbsp;</td><td><input type="text" name="'.$this->moduleName.'Inputfield['.$intId.'][zoom]" id="'.$strZoomId.'" class="'.$this->moduleName.'InputfieldGoogleMapSmall" value="'.$strValueZoom.'" onfocus="this.select();" /></td></tr>';
                    $strInputfield .= '</table>';
                    $strInputfield .= '</fieldset>';
                    $strInputfield .= '</div>';
                    $strInputfield .= '<div class="'.$this->moduleName.'GoogleMap" style="float: left; height: auto ! important;">';
                    $strInputfield .= '<div id="'.$strMapId.'" class="map"></div>';
                    $strInputfield .= '</div>';
                }
                
                $strInputfield .= <<<EOF
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
            map: map,
            draggable:true,
            animation: google.maps.Animation.DROP
        });
        setPosition(new google.maps.LatLng($strValueLat, $strValueLon));
    }

    google.maps.event.addListener(marker, 'dragend', function(event){
        if(event.latLng.lat()){
           elLat.value = event.latLng.lat();
        }
        if(event.latLng.lng()){
           elLon.value = event.latLng.lng();
        }
        map.setCenter(new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()));
    });
    
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
                return $strInputfield;

                break;
        }
    }



    function saveInputfield($intInputfieldId, $arrValue)
    {
        global $objInit;

        $lat  = floatval($arrValue['lat']);
        $lon  = floatval($arrValue['lon']);
        $zoom = floatval($arrValue['zoom']);
        $street = $arrValue['street'];
        $zip = $arrValue['zip'];
        $city = $arrValue['place'];
        $strValue = $lat.','.$lon.','.$zoom.','.$street.','.$zip.','.$city;

        return $strValue;
    }

    function deleteContent($intEntryId, $intIputfieldId)
    {
        global $objDatabase;

        $objDeleteInputfield = $objDatabase->Execute("DELETE FROM ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields WHERE `entry_id`='".intval($intEntryId)."' AND  `field_id`='".intval($intIputfieldId)."'");

        if($objDeleteEntry !== false) {
            return true;
        } else {
            return false;
        }
    }



    function getContent($intEntryId, $arrInputfield, $arrTranslationStatus)
    {
         global $objDatabase, $_CONFIG, $_ARRAYLANG;

        $intId = intval($arrInputfield['id']);

        $objInputfieldValue = $objDatabase->Execute("
            SELECT
                `value`
            FROM
                ".DBPREFIX."module_".$this->moduleTablePrefix."_rel_entry_inputfields
            WHERE
                field_id=".$intId."
            AND
                entry_id=".$intEntryId."
            LIMIT 1
        ");

        $strValue  = htmlspecialchars($objInputfieldValue->fields['value'], ENT_QUOTES, CONTREXX_CHARSET);
        $arrValues = explode(',', $strValue);

        $strValueLat = $arrValues[0];
        $strValueLon = $arrValues[1];
        $strValueZoom = $arrValues[2];
        $strValueLink = '<a href="http://maps.google.com/maps?q='.$strValueLat.','.$strValueLon.'" target="_blank">'.$_ARRAYLANG['TXT_MEDIADIR_GOOGLEMAPS_LINK'].'</a>';
        $strValueLinkHref = 'http://maps.google.com/maps?q='.$strValueLat.','.$strValueLon;

        if(!empty($strValue)) {
            $objGoogleMap = new googleMap();
            $objGoogleMap->setMapId($this->moduleName.'Inputfield_'.$intId.'_map');
            $objGoogleMap->setMapStyleClass('map');
            $objGoogleMap->setMapZoom($strValueZoom);
            $objGoogleMap->setMapCenter($strValueLon, $strValueLat);

            $objGoogleMap->addMapMarker($intId, $strValueLon, $strValueLat, null, true);

            $arrContent['TXT_'.$this->moduleLangVar.'_INPUTFIELD_NAME'] = htmlspecialchars($arrInputfield['name'][0], ENT_QUOTES, CONTREXX_CHARSET);
            $arrContent[$this->moduleLangVar.'_INPUTFIELD_VALUE'] = $objGoogleMap->getMap();
            $arrContent[$this->moduleLangVar.'_INPUTFIELD_LINK'] = $strValueLink;
            $arrContent[$this->moduleLangVar.'_INPUTFIELD_LINK_HREF'] = $strValueLinkHref;
        } else {
            $arrContent = null;
        }

        return $arrContent;
    }



    function getJavascriptCheck()
    {
        parent::getSettings();

        $fieldName = $this->moduleName."Inputfield_";
        $strJavascriptCheck = <<<EOF

            case 'google_map':
                value_lon = document.getElementById('$fieldName' + field + '_lon').value;
                value_lat = document.getElementById('$fieldName' + field + '_lat').value;
                value_zoom = document.getElementById('$fieldName' + field + '_zoom').value;

                if ((value_lon == "" || value_lat == "" || value_zoom == "") && isRequiredGlobal(inputFields[field][1], value)) {
                    isOk = false;
                	if (value_lon == "" && isRequiredGlobal(inputFields[field][1], value)) {
                    	document.getElementById('$fieldName' + field + '_lon').style.border = "#ff0000 1px solid";
                    }

                    if (value_lat == "" && isRequiredGlobal(inputFields[field][1], value)) {
                    	document.getElementById('$fieldName' + field + '_lat').style.border = "#ff0000 1px solid";
                    }

                    if (value_zoom == "" && isRequiredGlobal(inputFields[field][1], value)) {
                    	document.getElementById('$fieldName' + field + '_zoom').style.border = "#ff0000 1px solid";
                    }
                }  else {
                	document.getElementById('$fieldName' + field + '_lon').style.borderColor = '';
                	document.getElementById('$fieldName' + field + '_lat').style.borderColor = '';
                	document.getElementById('$fieldName' + field + '_zoom').style.borderColor = '';
                }

                break;

EOF;
        return $strJavascriptCheck;
    }
    
    
    function getFormOnSubmit($intInputfieldId)
    {
        return null;
    }
}