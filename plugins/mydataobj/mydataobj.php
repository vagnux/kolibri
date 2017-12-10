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

class mydataobj {
    private $conn;
    private $readonly;
    private $fields = array ();
    private $query;
    private $result;
    private $table;
    private $keys = array ();
    private $debugdata = 0;
    private $fieldsloaded = 0;
    private $conType = 'mysql';
    private $hostOrFilename;
    private $order = array ();
    function __call($method, $value) {
        foreach ( $value as $v ) {
            if (isset ( $v )) {
                $out = $v;
            }
        }
        
        if (substr ( $method, 0, 3 ) == 'get') {
            // echo "chamando get $method $param<br>";
            $param = substr ( $method, 3 );
            
            return $this->getvalueKey ( $param );
        }
        
        if (substr ( $method, 0, 3 ) == 'set') {
            $key = substr ( $method, 3 );
            return $this->setvalue ( $key, addslashes ( $out ) );
        }
    }
    function __constructor() {
        $this->reset;
    }
    function setDataArray($myarray){
        foreach ( $myarray as $keyName => $keyValue) {
            $this->setvalue($keyName,$keyValue);
        }
    }
    function settable($table) {
        $this->table = $table;
        return $this->table;
    }
    function connect($hostOrFilename, $user, $pass, $db, $table) {
        if ($this->conType == 'mysql') {
            $this->conn = mysqli_connect ( $hostOrFilename, $user, $pass, $db );
            // mysql_select_db ( $db, $this->conn );
            if ($this->debugdata) {
                debug::log("Connection" . mysqli_error ( $this->conn ));
                
            }
            $this->table = $table;
        }
        if ($this->conType == 'sqlite') {
            $this->conn = new SQLite3 ( $hostOrFilename );
            $this->hostOrFilename = $hostOrFilename;
        }
        return $this->conn;
    }
    function setconType($type) {
        $this->conType = $type;
    }
    function setconn($conn) {
        $this->conn = $conn;
    }
    function query($sql, $conn = '') {
        if (! $conn) {
            $conn = $this->conn;
        }
        
        if ($this->debugdata) {
            debug::log("QUERY: $sql");
            
        }
        
        $this->readonly = 1;
        $this->query = $sql;
        if ($this->conType == 'mysql') {
            $result = mysqli_query ( $conn, $sql );
            if ( ! $result) {
                debug::log("Error description: $sql " . mysqli_error($conn));
            }
        }
        if ($this->conType == 'sqlite') {
            $sqlite = $this->conn;
            $result = $sqlite->query ( $sql );
        }
        $this->result = $result;
        return $this->result;
    }
    function debug($mode) {
        if ($mode) {
            $this->debugdata = 1;
        } else {
            $this->debugdata = 0;
        }
    }
    private function getfields($result = '') {
        if (! $this->query) {
            $result = $this->selectquery;
        }
        
        if (! $result) {
            $result = $this->result;
        }
        
        if ($result) {
            
            if ($this->conType == 'mysql') {
                
                $numcols = mysqli_field_count ( $this->conn );
                if ($this->debugdata) {
                    debug::log("Fields found on query " . $numcols);
                    
                }
            }
            if ($this->conType == 'sqlite') {
                
                $numcols = $result->numColumns ();
            }
            
            for($x = 0; $x < $numcols; $x ++) {
                
                if ($this->conType == 'mysql') {
                    
                    $myField = mysqli_fetch_field_direct ( $result, $x );
                    
                    $fieldarray [$x] = $myField->name;
                    
                }
                if ($this->conType == 'sqlite') {
                    
                    $fieldarray [$x] = $result->columnName ( $x );
                }
                
            }
            return $fieldarray;
        } else {
            if ($this->debugdata) {
                debug::log("ERROR: impossibile to get fields name from table " . $this->table);
                
            }
        }
    }
    private function fetch_assoc($result = '') {
        if (! $result) {
            $result = $this->result;
        }
        
        if ($result) {
            if ($this->conType == 'mysql') {
                return mysqli_fetch_array ( $result );
            }
            if ($this->conType == 'sqlite') {
                return $result->fetchArray ( SQLITE3_ASSOC );
            }
        } else {
            if ($this->debugdata) {
                debug::log("ERROR: impossibile to get fields name from query " . $this->query );
                
            }
            return '';
        }
    }
    function next($result = '') {
        $this->fieldsloaded = 0;
        if ($this->debugdata) {
            debug::log("Next executed");
            
        }
    }
    private function getvalueKey($key) {
        if (! $this->result) {
            
            if ($this->debugdata) {
                debug::log("No result for get$key()");
                
            }
            
            if (! $this->query) {
                
                if ($this->debugdata) {
                    debug::log("Calling select query");
                    
                }
                
                $this->result = $this->selectquery ();
            }
        }
        
        
        
        if ($this->fieldsloaded == 0) {
            
            $data = $this->fetch_assoc ( $this->result );
            $fields = $this->getfields ( $this->result );
            
            
            
            if (is_array ( $fields )) {
                foreach ( $fields as $f ) {
                    $this->fields [$f] = $data [$f];
                    if ($this->debugdata) {
                        debug::log("Dataget: [$f] = " . $data [$f]);
                        
                    }
                }
            }
            $this->fieldsloaded = 1;
        }
        
        return $this->fields [$key];
    }
    private function setvalue($key, $value) {
        if ($value === '0') {
            $this->fields [$key] = '0';
        } else {
            $this->fields [$key] = $value;
        }
        
        return $this->fields [$f];
    }
    function reset() {
        $this->result = '';
        $this->keys = '';
        $this->query = '';
        unset ( $this->fields );
        $this->fields = array ();
        $this->readonly = '';
        $this->fieldsloaded = 0;
        unset ( $this->keys );
        unset ( $this->fields );
        $this->keys = array ();
        $this->fields = array ();
        if ($this->conType == 'sqlite') {
            $this->conn->close ();
            unset ( $this->conn );
            $this->conn = new SQLite3 ( $this->hostOrFilename );
        }
        if ($this->debugdata) {
            debug::log("Reset executed");
            
        }
    }
    function save() {
        if (count ( $this->keys ) > 0) {
            
            $query = $this->updatequery ();
            if ( $this->debugdata ) {
                debug::log("starting  query : " . $query);
            }
            $this->query ( $query );
            
        } else {
            $query = $this->insertquery ();
            if ( $this->debugdata ) {
                debug::log("starting query.. : " . $query);
            }
            $this->query ( $query );
            
            if ($this->conType == 'mysql') {
                $sql = "SELECT LAST_INSERT_ID() AS insertID ";
                $this->query ( $sql );
                $res = $this->fetch_assoc ( $this->return );
                // $this->lastinsertid = $res['insertID'];
                $this->fields ['lastinsertid'] = $res ['insertID'];
            }
            
            if ($this->conType == 'sqlite') {
                $sqlite = $this->conn;
                $this->fields ['lastinsertid'] = $sqlite->lastInsertRowID ();
                $this->fieldsloaded = 1;
            }
        }
    }
    function addkey($key, $value) {
        $this->keys [$key] = $value;
    }
    function delkey($key) {
        $aux = '';
        
        foreach ( array_keys ( $this->keys ) as $a ) {
            
            if ($a != $key) {
                
                $aux [$a] = $this->keys [$a];
            }
        }
        
        $this->keys = '';
        $this->keys = array ();
        $this->keys = $aux;
    }
    private function insertquery() {
        if ($this->conType == 'mysql') {
            if ( $this->debugdata ) {
                debug::log("mysql selected");
            }
            $sql = "show fields from $this->table";
        }
        
        if ($this->conType == 'sqlite') {
            if ( $this->debugdata ) {
                debug::log("sqlite selected");
            }
            $sql = "PRAGMA table_info('$this->table')";
        }
        
        if ( $this->debugdata ) {
            debug::log("running query : " . $sql);
        }
        $result = $this->query ( $sql );
        
        $sql = '';
        $fieldList = '';
        $v = 0;
        while ( $res = $this->fetch_assoc ( $result ) ) {
            
            if ($this->conType == 'mysql') {
                $field = $res ['Field'];
            }
            if ($this->conType == 'sqlite') {
                $field = $res ['name'];
            }
            
            if (! $v) {
                if ($this->fields [$field]) {
                    $sql .= "'" . $this->fields [$field] . "'";
                    $fieldList .= $field;
                    $v ++;
                }
            } else {
                if ($this->fields [$field]) {
                    $sql .= ",'" . $this->fields [$field] . "'";
                    $fieldList .= "," . $field;
                }
            }
        }
        
        if ($this->conType == 'mysql') {
            $sqlQuery = "insert into $this->table ($fieldList) values ($sql)";
        }
        if ($this->conType == 'sqlite') {
            $sqlQuery = "insert into $this->table ($fieldList) values ($sql)";
        }
        
        return $sqlQuery;
    }
    private function updatequery() {
        $sql = "show fields from $this->table";
        
        $result = $this->query ( $sql );
        
        $sql = " update $this->table set ";
        $v = 0;
        while ( $res = $this->fetch_assoc ( $result ) ) {
            
            // echo "Campo " . $res['Field'] . "<br>";
            $field = $res ['Field'];
            
            if (! $v) {
                if (array_key_exists ( $field, $this->fields )) {
                    $sql .= " $field='" . $this->fields [$field] . "'";
                    $v ++;
                }
            } else {
                if (array_key_exists ( $field, $this->fields )) {
                    $sql .= ", $field='" . $this->fields [$field] . "'";
                }
            }
        }
        
        $sql .= " where ";
        
        $aux = '';
        
        $and = 0;
        
        foreach ( array_keys ( $this->keys ) as $a ) {
            
            if (! $and) {
                if ( is_array($this->keys [$a])) {
                    $elements = $this->keys [$a];
                    $str = '';
                    foreach ( $elements as $item) {
                        $str .= "'$item',";
                    }
                    $str = substr($str, 0,-1);
                    $sql .= " $a in (" . $this->keys [$a] . ")";
                }else{
                    $sql .= " $a='" . $this->keys [$a] . "'";
                }
                $and ++;
            } else {
                if ( is_array($this->keys [$a])) {
                    $elements = $this->keys [$a];
                    $str = '';
                    foreach ( $elements as $item) {
                        $str .= "'$item',";
                    }
                    $str = substr($str, 0,-1);
                    $sql .= " and $a in (" . $this->keys [$a] . ")";
                }else{
                    $sql .= " and $a='" . $this->keys [$a] . "'";
                }
            }
        }
        
        return $sql;
    }
    private function selectquery() {
        $sql = "select * from $this->table";
        
        if (count ( $this->keys )) {
            
            $sql .= " where ";
            $and = 0;
            
            foreach ( array_keys ( $this->keys ) as $a ) {
                
                if (! $and) {
                    if ( is_array($this->keys [$a])) {
                        $elements = $this->keys [$a];
                        $str = '';
                        foreach ( $elements as $item) {
                            $str .= "'$item',";
                        }
                        $str = substr($str, 0,-1);
                        $sql .= " $a in (" . $this->keys [$a] . ")";
                    }else{
                        $sql .= " $a='" . $this->keys [$a] . "'";
                    }
                    $and ++;
                } else {
                    if ( is_array($this->keys [$a])) {
                        $elements = $this->keys [$a];
                        $str = '';
                        foreach ( $elements as $item) {
                            $str .= "'$item',";
                        }
                        $str = substr($str, 0,-1);
                        $sql .= " and $a in (" . $this->keys [$a] . ")";
                    }else{
                        $sql .= " and $a='" . $this->keys [$a] . "'";
                    }
                }
            }
        }
        $and = 0;
        if (count ( $this->order )) {
            $sql .= " order by ";
            foreach ( $this->order as $o ) {
                if (! $and) {
                    $sql .= $o;
                    $and ++;
                } else {
                    $sql .= "," . $o;
                }
            }
            $sql .= " asc";
        }
        
        if ($this->debugdata) {
            debug::log("$sql");
            
        }
        // echo "Debug $sql<br>";
        $this->result = $this->query ( $sql );
        return $this->result;
    }
    function delete() {
        if ($this->table) {
            if (count ( array_keys ( $this->keys ) ) > 0) {
                $and = 0;
                foreach ( array_keys ( $this->keys ) as $a ) {
                    
                    if (! $and) {
                        if ( is_array($this->keys [$a])) {
                            $elements = $this->keys [$a];
                            $str = '';
                            foreach ( $elements as $item) {
                                $str .= "'$item',";
                            }
                            $str = substr($str, 0,-1);
                            $sql .= "  $a in (" . $this->keys [$a] . ")";
                        }else{
                            $sql .= "  $a='" . $this->keys [$a] . "'";
                        }
                        $and ++;
                    } else {
                        if ( is_array($this->keys [$a])) {
                            $elements = $this->keys [$a];
                            $str = '';
                            foreach ( $elements as $item) {
                                $str .= "'$item',";
                            }
                            $str = substr($str, 0,-1);
                            $sql .= " and $a in (" . $this->keys [$a] . ")";
                        }else{
                            $sql .= " and $a='" . $this->keys [$a] . "'";
                        }
                    }
                }
                
                $deleteQuery = "delete from " . $this->table . " where " . $sql;
                $this->query ( $deleteQuery );
            }
        }
    }
    function addorder($key) {
        if ($this->debugdata) {
            debug::log("Add order $key");
            
        }
        array_push ( $this->order, $key );
    }
}

?>
