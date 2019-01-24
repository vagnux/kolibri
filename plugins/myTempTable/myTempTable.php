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

class myTempTable {
	private $tempTable;
	private $fields = array ();
	function setTableName($tempTable) {
		$this->tempTable = $tempTable;
	}
	function loadArray($myArray, $query) {
		$tableName = $this->tempTable . '_' . date ( 'Ymd' );
		
		if (is_array ( $myArray )) {
			$sql = "CREATE TEMPORARY TABLE `$tableName` ( ";
			$x = 0;
			foreach ( $myArray as $k => $v ) {
				if ($x > 0)
					$sql .= ",";
				
				$this->fields [] = $k;
				$sql .= " `$k` VARCHAR(50) NOT NULL";
				$x ++;
			}
			$sql .= ");";
			$db = new mydataobj ();
			$db->debug ( 1 );
			$db->setconn ( database::kolibriDB () );
			// $db->debug(1);
			
			$db->query ( $sql );
			debug::log ( "\n\n----------------------------" );
			
			$lines = count ( $myArray [$this->fields [0]] );
			debug::log ( "Linhas $lines" );
			for($i = 0; $i <= $lines; $i ++) {
				if ($myArray [$this->fields [0]] [$i]) {
					$sql = "insert into `$tableName` ";
					$sqlv = " values (";
					foreach ( $this->fields as $field ) {
						
						$sqlv .= "'" . $myArray [$field] [$i] . "',";
						// debug::log('->' . $field . "=" . $myArray[$field][$i]);
					}
					// $sql = substr($sql,0, -1);
					// $sql .= ')';
					
					$sqlv = substr ( $sqlv, 0, - 1 );
					$sqlv .= ')';
					
					$sql = $sql . $sqlv . ';';
					debug::log ( "---->$sql\n\n" );
					$db->query ( $sql );
				}
			}
		}
		if (strlen ( $query )) {
			debug::log ( "\n\n----------------------------" );
			$query = str_replace ( $this->tempTable, $this->tempTable . '_' . date ( 'Ymd' ), $query );
			
			$db->query ( $query );
			
			$i = 0;
			while ( $db->{'get' . $this->fields [0]} () ) {
				foreach ( $this->fields as $campo ) {
					$out [$campo] [$i] = $db->{'get' . $campo} ();
				}
				$db->next ();
				$i ++;
			}
			
			return $out;
		}
	}
}