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
 * Google Map
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_framework
 */

/**
 * Google Map
 *
 * @copyright   CONTREXX CMS - COMVATION AG
 * @author      COMVATION Development Team <info@comvation.com>
 * @package     contrexx
 * @subpackage  lib_framework
 */
class googleMap
{
    private $apiKey;

    private $mapModus = 'overview';
    private $mapDimensions;
    private $mapZoom = 1;
    private $mapCenter = 'var center = new google.maps.LatLng(0, 0)';
    private $mapId = 'googleMap';
    private $mapType = 'ROADMAP';
    private $mapClass;
    private $mapMarkers = array();
    private $mapIndex = 1;

    /**
     * Constructor
     */
    function __construct($modus)
    {
        global $_CONFIG;

        $this->apiKey = $_CONFIG['googleMapsAPIKey'];
    }


    function setMapModus($modus)
    {
        $this->mapModus = $modus;
    }
    
    function setMapIndex($index)
    {
        $this->mapIndex = $index;
    }
    
    function getMapIndex()
    {
        return $this->mapIndex;
    }

    function setMapId($id)
    {
        $this->mapId = $id;
    }



    function setMapDimensions($width, $height)
    {
        $this->mapDimensions = 'style="width: '.intval($width).'px; height: '.intval($height).'px;"';
    }



    function setMapStyleClass($class)
    {
        $this->mapClass = 'class="'.$class.'"';
    }



    function setMapZoom($zoom)
    {
        $this->mapZoom = intval($zoom);
    }



    function setMapCenter($lon, $lat)
    {
        $this->mapCenter = 'var center = new google.maps.LatLng('.$lat.', '.$lon.')';
    }



    function setMapType($type)
    {
        /*
        Types:
        [0] map
        [1] satellite
        [2] hybrid
        */

        switch ($type) {
            case 1:
                $this->mapType = 'SATELLITE';
                break;
            case 2:
                $this->mapType = 'HYBRID';
                break;
            case 0:
            default:
                $this->mapType = 'ROADMAP';
                break;
        }
    }



    function addMapMarker($id, $lon, $lat, $info, $hideInfo=true, $click=null, $mouseover=null, $mouseout=null, $icon=null)
    {
        $this->mapMarkers[$id]['lon'] = $lon;
        $this->mapMarkers[$id]['lat'] = $lat;
        $this->mapMarkers[$id]['info'] = $info;
        $this->mapMarkers[$id]['hideInfo'] = $hideInfo;
        $this->mapMarkers[$id]['click'] = $click;
        $this->mapMarkers[$id]['mouseover'] = $mouseover;
        $this->mapMarkers[$id]['mouseout'] = $mouseout;
        $this->mapMarkers[$id]['icon'] = $icon;
    }



    private function getMapMarkers()
    {
        foreach ($this->mapMarkers as $id => $marker) {
            if($marker['lon'] >= 0 && $marker['lat'] >= 0) {
                if ($marker['click'] != null) {
                    $click = "google.maps.event.addListener(marker$id, \"click\", function() {
                        ".$marker['click']."
                    });";
                } else {
                    $mouseover = '';
                }

                if ($marker['mouseover'] != null) {
                    $mouseover = "google.maps.event.addListener(marker$id, \"mouseover\", function() {
                        ".$marker['mouseover']."
                    });";
                } else {
                    $mouseover = '';
                }

                if ($marker['mouseout'] != null) {
                    $mouseout = "google.maps.event.addListener(marker$id, \"mouseout\", function() {
                        ".$marker['mouseout']."
                    });";
                } else {
                    $mouseout = '';
                }

                if (!$marker['hideInfo']) {
                    $showInfo = "infowindow_{$this->mapIndex}.setContent(info$id);infowindow_{$this->mapIndex}.open(map_{$this->mapIndex}, marker$id)";
                } else {
                    $showInfo = '';
                }

                $km = 10;
                $factor = 0.009009009009009;
                $dist = $km*$factor;

                $divLatPlus = $marker['lat']+$dist;
                $divLatMinus = $marker['lat']-$dist;
                $divLonPlus = $marker['lon']+$dist;
                $divLonMinus = $marker['lon']-$dist;
                
                $markers .= "                
                var point$id = new google.maps.LatLng(".$marker['lat'].", ".$marker['lon'].");
                var marker$id = new google.maps.Marker({
                        position: point$id,
                        map: map_".$this->mapIndex."
                });
                var info$id = '".$marker['info']."';

                ".$click."
                ".$mouseover."
                ".$mouseout."
                ".$showInfo."

                ";
            }
        }

        return $markers;
    }



    function getMap()
    {
        if($this->mapModus == 'search') {
            $map = self::getSearchMap();
        } else {
            $map = self::getOverviewMap();
        }

        return $map;
    }


    private function getOverviewMap()
    {
        $layer = '<div id="'.$this->mapId.'" '.$this->mapClass.' '.$this->mapDimensions.'></div>';

        $markers = $this->getMapMarkers();
        $map = "map_".$this->mapIndex;
        $initialize = "initialize_".$this->mapIndex;
        $tmpGoogleMapOnLoad = "tmpGoogleMapOnLoad_".$this->mapIndex;

        $layer .= <<<EOF
<script src="https://maps.googleapis.com/maps/api/js?key=$strKey&sensor=false&v=3"></script>
<script>
//<![CDATA[
var $map;

function $initialize() {
    $map = new google.maps.Map(document.getElementById("$this->mapId"));
    $this->mapCenter

    $map.setCenter(center);
    $map.setZoom($this->mapZoom);

    $map.setMapTypeId(google.maps.MapTypeId.$this->mapType);
    var infowindow_$this->mapIndex = new google.maps.InfoWindow();

    $markers
}

var $tmpGoogleMapOnLoad = window.onload; 
window.onload = function() { 
	if($tmpGoogleMapOnLoad){
		$tmpGoogleMapOnLoad();
    } 
    $initialize(); 
}
//]]>
</script>
EOF;
        return $layer;
    }



    private function getSearchMap()
    {
        return "not yet implemented";
    }
}
