<?php
/*
 *  Copyright (C) 2016 vagner    
 * 
 *    This file is part of Kolibri.
 *
 *    Kolibri is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    Kolibri is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with Kolibri.  If not, see <http://www.gnu.org/licenses/>. 
 */

class googleMaps {
	private $latitude;
	private $longitude;
	private $idCanvas;
	function __construct() {
		page::addJsFile ( 'http://maps.google.com/maps/api/js?sensor=true' );
		$this->idCanvas = "_map_" .  rand(100,999);
	}
	function setLatitude($latitude) {
		$this->latitude = $latitude;
	}
	function setLongitude($longitude) {
		$this->longitude = $longitude;
	}
	function setlatlnOnFieldById($idField) {
		$code = "
				var x = document.getElementById(\"$idField\");
				function genLocation() {
			if (navigator.geolocation) {
        			navigator.geolocation.getCurrentPosition(showPosition);
    			} else { 
        			alert(\"Geolocation is not supported by this browser.\");
    			}			
		}
			function showPosition(position) {
    			x.value = position.coords.latitude + ':' + position.coords.longitude; 
				}
				";
		page::addJsScript ( $code );
		return '
				<script>
				genLocation();
				</script>
				';
	}
	function genMap() {
		
		if (($this->latitude == '') or ($this->longitude == '')) {
			//echo $this->latitude . $this->longitude;
			$code = "var map = null; 
				 var latitude = 0;
				 var longitude = 0;

		function myLocation$this->idCanvas() {
			if (navigator.geolocation) {
        		navigator.geolocation.getCurrentPosition(chamaMapa$this->idCanvas);
    			} else { 
        		alert(\"Geolocation is not supported by this browser.\");
    			}			
		}

		function showPosition$this->idCanvas(position) {
		    latitude = position.coords.latitude;
			longitude = position.coords.longitude;
		    //alert(latitude);
		}		
				
		function chamaMapa$this->idCanvas(position)
		{
			
			latitude = position.coords.latitude;
			longitude = position.coords.longitude;
			//alert(latitude);
				";
		} else {
			
			$code = "
				function chamaMapa$this->idCanvas()
					{
					latitude = $this->latitude;
					longitude = $this->longitude;
					//alert(latitude);	
			";
		}
		
		$code .= "
			var latlng = new google.maps.LatLng(latitude, longitude);
			   var myOptions = {
					zoom: 12,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				};
				map = new google.maps.Map( document.getElementById(\"$this->idCanvas\") , myOptions );
				map.setCenter( new google.maps.LatLng(latitude, longitude) );
				map.setZoom(17);
				map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
 
				geocoder = new google.maps.Geocoder();     
				geocoder.geocode({'location':latlng}, function(results, status){
					if( status = google.maps.GeocoderStatus.OK){
						latlng = results[0].geometry.location;
						markerInicio = new google.maps.Marker({position: latlng,map: map});    
						map.setCenter(latlng);
					}
				});
 
		}";
		
		page::addJsScript ( $code );
		if (($this->latitude == '') or ($this->longitude == '')) {
			return '<div id="'. $this->idCanvas . '" style="width: 100%; height: 500px"></div>
				<script>
				myLocation' . $this->idCanvas . '();
				</script>
				';
		} else {
			return '<div id="'. $this->idCanvas . '" style="width: 100%; height: 500px"></div>
				<script>
				chamaMapa' . $this->idCanvas . '();
				</script>
				';
		}
	}
}