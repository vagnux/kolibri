<?php

/*
 * Copyright (C) 2016 Vagner Rodrigues
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.
 */
namespace auth {

	class userObject extends \stdClass {
		private $users_idusers;
		private $objectName;
		private $jsonObject;
		public function install() {
			$sql = "CREATE TABLE `userObject` (
			  `users_idusers` int(11) NOT NULL,
			  `objectName` varchar(100) DEFAULT NULL,
			  `jsonObject` blob DEFAULT NULL,
			  KEY `fk_userObject_users1_idx` (`users_idusers`),
			  CONSTRAINT `fk_userObject_users1` FOREIGN KEY (`users_idusers`) REFERENCES `users` (`idusers`) ON DELETE NO ACTION ON UPDATE NO ACTION
			) ENGINE=InnoDB DEFAULT CHARSET=latin1;

						";
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->query ( $sql );
			unset ( $db );
		}
		function __construct($users_idusers, $objectName) {
			
			if ($users_idusers and $objectName) {
				$this->users_idusers = $users_idusers;
				$this->objectName = $objectName;
				$this = $this->loadObject ( $users_idusers, $objectName );
			}
		}
		private function setusers_idusers($value) {
			$this->users_idusers = $value;
		}
		private function getusers_idusers() {
			return $this->users_idusers;
		}
		private function setobjectName($value) {
			$this->objectName = $value;
		}
		private function getobjectName() {
			return $this->objectName;
		}
		private function setjsonObject($value) {
			$this->jsonObject = $value;
		}
		private function getjsonObject() {
			return $this->jsonObject;
		}
		private function listuserObject() {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "userObject" );
			$this->setusers_idusers ( $db->getusers_idusers () );
			// $db->addkey("ativo", 1);
			$i = 0;
			while ( $db->getusers_idusers () ) {
				$out ['users_idusers'] [$i] = $db->getusers_idusers ();
				$out ['objectName'] [$i] = $db->getobjectName ();
				$out ['jsonObject'] [$i] = $db->getjsonObject ();
				$db->next ();
				$i ++;
			}
			return $out;
		}
		private function load($users_idusers, $objectName) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			// $db->debug(1);
			$db->settable ( "userObject" );
			$db->addkey ( "users_idusers", $users_idusers );
			$db->addkey ( "objectName", $objectName );
			
			$this->setusers_idusers ( $db->getusers_idusers () );
			$this->setobjectName ( $db->getobjectName () );
			$this->setjsonObject ( $db->getjsonObject () );
		}
		private function delete($users_idusers, $objectName) {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "userObject" );
			$db->addkey ( 'users_idusers', $users_idusers );
			$db->addkey ( 'objectName', $objectName );
			$db->delete ();
		}
		private function saveData() {
			$db = new \mydataobj ();
			$db->setconn ( \database::kolibriDB () );
			$db->settable ( "userObject" );
			$this->delete ( $this->getusers_idusers (), $this->getobjectName () );
			$db->setusers_idusers ( $this->getusers_idusers () );
			$db->setobjectName ( $this->getobjectName () );
			$db->setjsonObject ( $this->getjsonObject () );
			$db->save ();
		}
		private function loadObject($users_idusers, $objectName) {
			$obj = new \stdClass ();
			$this->load ( $users_idusers, $objectName );
			$obj = json_decode ( $this->getjsonObject () );
			return $obj;
		}
		private function saveObject($users_idusers, $objectName, $obj) {
			$this->setusers_idusers ( $users_idusers );
			$this->setobjectName ( $objectName );
			$this->setjsonObject ( json_encode ( $obj ) );
			$this->saveData ();
		}
		function save() {
			if ($this->users_idusers and $this->objectName) {
				$this->saveObject ( $this->users_idusers, $this->objectName, $this );
			}
		}
	}
}
