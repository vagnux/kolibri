<?php
class chart {
	
	private $dataArray;
	private $obj;
	
	
	function __construct() {
		error_reporting(E_ERROR | E_PARSE);		
	}
	
	
	function __call($name, $arguments) {
		foreach ( $arguments as $v ) {
			if (isset ( $v )) {
				$out = $v;
			}
		}
		
		if (substr ( $name, 0, 3 ) == 'get') {
			
			$param = substr ( $name, 3 );
			
			return $this->obj->{$param};
		}
		
		if (substr ( $name, 0, 3 ) == 'set') {
			$key = substr ( $name, 3 );
			$param = substr ( $name, 3 );
			$this->obj->{$param} =   $out ;
			
		}
	}
	
	function getJson() {
		return  json_encode($this->obj);
	}
	function reset() {
		$this->obj= null;
	}
	
}