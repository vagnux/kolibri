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

class googleChart {
	private $width;
	private $height;
	private $title;
	private $subtitle;
	private $graphtype;
	private $matrix;
	
	
	function __construct() {
		page::addJsFile('https://www.google.com/jsapi');
		$this->width = 900;
		$this->height = 500;
	}
	
	function setWidth($width){
		if ( strlen($width) > 0 ) {
			$this->width = $width;
		}
	}
	
	function setHeight($height) {
		if ( strlen($height) > 0 ) {
			$this->height = $height;
		}
	}
	
	function setGraphType($type) {
		if ( strlen($type) > 0 ) {
			$this->type = $type;
		}
		
	}
	
	function loadMatrixData($matrix){
		if ( count($matrix) > 0 ) {
			$this->matrix = $matrix;
		}
	}
	
	function setTitle($title) {
		if ( strlen($title) > 0 ) {
			$this->title = $title;
		}
	}
	
	function setSubTitle($subtitle) {
		if ( strlen($subtitle) > 0 ) {
			$this->subtitle = $subtitle;
		}
	}
	
	private function genLineGraph(){
		$id = rand(100,999);
		$code = "google.load('visualization', '1.1', {packages: ['line']});\n
   				 google.setOnLoadCallback(drawChart);\n
					\n
   				 function drawChart() {\n
					\n
      				var data = new google.visualization.DataTable();\n";
		
		$x = 0;
		$y = 0;
		foreach ( $this->matrix as $key => $value ) {
				
			$columnsCode .= "data.addColumn('number', '$key');\n";
			$keys [] = $key;
				
			foreach ( $value as $line ) {
				$aux [$x] [$y] = $line;
				$x ++;
			}
			$y ++;
			$x = 0;
	
		}
		
		foreach ( $aux as $col ) {
		//print_r($col);
			if ( $x == 0 ) {
				$arraCodeLine .= "\n[";
			}
			foreach ( $col as $line ) {
				
				$arraCodeLine .= "$line,";
				$x ++;
			}
			$x=0;
			$arraCodeLine .= "],";
		}
		$arraCodeLine = substr("$arraCodeLine", 0, -1);
		$arraCodeLine .= ']';
		
		$arraCodeLine = substr("$arraCodeLine", 0, -1);
		$code .= $columnsCode;
		$code .= "data.addRows([";
		$code .= $arraCodeLine;
		$code .= "]);\n";
		
		$code .= "var options = {
	        chart: {
	          title: '$this->title',
	          subtitle: '$this->subtitle'
	        },
	        width: $this->width,
	        height: $this->height
	      };
	
	      var chart$id = new google.charts.Line(document.getElementById('linechart_material'));
	
	      chart$id.draw(data, options);
	    }";
		page::addJsScript($code);
	}
	
	private function genPieGraph(){
		
		$id = rand(100,999);
		
		$code = "google.load(\"visualization\", \"1\", {packages:[\"corechart\"]});
      			 google.setOnLoadCallback(drawChart);
     			 function drawChart() {

        		var data = google.visualization.arrayToDataTable([";
		
		foreach ($this->matrix as $key => $value) {
			if ( is_int($value)) {
				$code .= "\n['$key',$value],";
			}else{
				$code .= "\n['$key','$value'],";
			}
		}
		$code = substr("$code", 0, -1);
		$code .= "]);

        var options = {
          title: '$this->title',
          is3D: true,
        };

        var chart$id = new google.visualization.PieChart(document.getElementById('piechart'));

        chart$id.draw(data, options);
      }";
		page::addJsScript($code);
	}
	
	function genChart() {
		if ( $this->type == "line") {
			$this->genLineGraph();
			return '<div id="linechart_material"></div>';
		}
		
		if ( $this->type == "pie") {
			$this->genPieGraph();
			return "<div id=\"piechart\" style=\"width: " . $this->width . "px; height: " . $this->height . "px;\"></div>";
		}
		
	}
	
}