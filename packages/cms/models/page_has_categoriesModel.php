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
class page_has_categoriesModel {
	private $page_idpage;
	private $categories_idcategories;
	function setpage_idpage($value) {
		$this->page_idpage = $value;
	}
	function getpage_idpage() {
		return $this->page_idpage;
	}
	function setcategories_idcategories($value) {
		$this->categories_idcategories = $value;
	}
	function getcategories_idcategories() {
		return $this->categories_idcategories;
	}
	function listpage_has_categories() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "page_has_categories" );
		// $db->addkey("ativo", 1);
		$i = 0;
		while ( $db->getpage_idpage () ) {
			$out ['page_idpage'] [$i] = $db->getpage_idpage ();
			$out ['categories_idcategories'] [$i] = $db->getcategories_idcategories ();
			$db->next ();
			$i ++;
		}
		return $out;
	}
	function load($page_idpage) {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		// $db->debug(1);
		$db->settable ( "page_has_categories" );
		// $db->addkey("ativo", 1);
		$db->addkey ( "page_idpage", $page_idpage );
		$this->setpage_idpage ( $db->getpage_idpage () );
		$this->setcategories_idcategories ( $db->getcategories_idcategories () );
	}
	function save() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "page_has_categories" );
		// $db->debug(1);
		if ($this->page_idpage) {
			$db->addkey ( "page_idpage", $this->page_idpage );
		}
		$db->setpage_idpage ( $this->getpage_idpage () );
		$db->setcategories_idcategories ( $this->getcategories_idcategories () );
		$db->save ();
		return $db->getlastinsertid ();
	}
}
