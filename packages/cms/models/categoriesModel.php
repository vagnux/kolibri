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
class categoriesModel {
	private $idcategories;
	private $categoriesName;
	function setidcategories($value) {
		$this->idcategories = $value;
	}
	function getidcategories() {
		return $this->idcategories;
	}
	function setcategoriesName($value) {
		$this->categoriesName = $value;
	}
	function getcategoriesName() {
		return $this->categoriesName;
	}
	function listcategories() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "categories" );
		// $db->addkey("ativo", 1);
		$i = 0;
		while ( $db->getidcategories () ) {
			$out ['idcategories'] [$i] = $db->getidcategories ();
			$out ['categoriesName'] [$i] = $db->getcategoriesName ();
			$db->next ();
			$i ++;
		}
		return $out;
	}
	function load($idcategories) {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		// $db->debug(1);
		$db->settable ( "categories" );
		// $db->addkey("ativo", 1);
		$db->addkey ( "idcategories", $idcategories );
		$this->setidcategories ( $db->getidcategories () );
		$this->setcategoriesName ( $db->getcategoriesName () );
	}
	function save() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "categories" );
		// $db->debug(1);
		if ($this->idcategories) {
			$db->addkey ( "idcategories", $this->idcategories );
		}
		$db->setidcategories ( $this->getidcategories () );
		$db->setcategoriesName ( $this->getcategoriesName () );
		$db->save ();
		return $db->getlastinsertid ();
	}
}
