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

class webCalendar {
	private $codeOut;
	private $defaultDate;
	private $buttonIcons = 'true';
	private $weekNumbers = 'false';
	private $editable;
	private $eventLimit;
	private $values;
	private $clickCode = '';
	function __construct() {
		
		/*
		 * <link href='../fullcalendar.css' rel='stylesheet' /> <link href='../fullcalendar.print.css' rel='stylesheet' media='print' /> <script src='../lib/moment.min.js'></script> <script src='../lib/jquery.min.js'></script> <script src='../fullcalendar.min.js'></script>
		 */
	    page::addJsFile ( '::siteroot::/vendors/fullcalendar/lib/jquery.min.js' );
		page::addCssFile ( '::siteroot::/vendors/fullcalendar/fullcalendar.css' );
		//page::addCssFile ( '::siteroot::/vendors/fullcalendar/fullcalendar.print.css' );
		page::addJsFile ( '::siteroot::/vendors/fullcalendar/lib/moment.min.js' );
		
		page::addJsFile ( '::siteroot::/vendors/fullcalendar/fullcalendar.min.js' );
		page::addJsFile ( '::siteroot::/vendors/fullcalendar/locale-all.js' );
		
		
		$this->clickCode = 'alert(\'View: \' + eventObj.id);';
		
		/*
		 * defaultDate: '2015-02-12', lang: pt-br, buttonIcons: false, // show the prev/next text weekNumbers: true, editable: true, eventLimit: true, // allow "more" link when too many events
		 */
		
		$this->codeOut = "<script>
				$(document).ready(function() {
					$('#calendar').fullCalendar({\n
                    eventStartEditable: false,
					header: {
						left: 'prev,next',
						center: 'title',
						right: '',

					},

                     eventClick: function(eventObj, calEvent, jsEvent, view) {
                       clickFunction(eventObj, calEvent, jsEvent, view);
                    },
                    
				";
	}
	
	function setclickCode($code) {
	    $this->clickCode = $code;
	}
	
	function setdefaultDate($defaultDate) {
		$this->defaultDate = $defaultDate;
	}
	function loadPreviews($scheduleArray) {
		$a = 0;
		$out = "events: [";
		foreach ( $scheduleArray as $line ) {
			if ($a > 0) {
				$out .= ",";
			}
			$a ++;
			$out .= "{\n";
			$b = 0;
			foreach ( $line as $key => $value ) {
				if ($b > 0) {
					$out .= ",\n";
				}
				$b ++;
				$out .= "$key: '$value'";
			}
			$out .= "\n}";
		}
		$out .= "\n]";
		$this->values .= $out;
	}
	function run() {
		if (! $this->defaultDate) {
			$this->defaultDate = date ( 'Y-m-d' );
		}
		;
		if (! $this->buttonIcons) {
			$this->buttonIcons = "false";
		}
		;
		if (! $this->weekNumbers) {
			$this->weekNumbers = "true";
		}
		;
		if (! $this->editable) {
			$this->editable = "true";
		}
		;
		if (! $this->eventLimit) {
			$this->eventLimit = "true";
		}
		;
		
		$this->codeOut .= "defaultDate: '" . $this->defaultDate . "',\n";
		$this->codeOut .= "lang: 'pt-BR',\n";
		$this->codeOut .= "locale: 'pt-BR',\n";
		$this->codeOut .= "buttonIcons: " . $this->buttonIcons . ",\n";
		$this->codeOut .= "weekNumbers: " . $this->weekNumbers . ",\n";
		$this->codeOut .= "editable: " . $this->editable . ",\n";
		$this->codeOut .= "eventLimit: " . $this->eventLimit . ",\n";
		$this->codeOut .= $this->values;
		
		$this->codeOut .= "});
		
							});
						
						</script>
				
							<style>
							#calendar {
										max-width: 900px;
										margin: 0 auto;
									}
							</style>
							<div id='calendar'></div>
							";
		
		
		$js = 'function clickFunction(eventObj, calEvent, jsEvent, view) {
        ' . $this->clickCode . ' 
        }';
	   page::addJsScript($js);
	
		
		return $this->codeOut;
	}
}