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
class content_has_categoriesModel {
	private $content_idcontent;
	private $categories_idcategories;
	function setcontent_idcontent($value) {
		$this->content_idcontent = $value;
	}
	function getcontent_idcontent() {
		return $this->content_idcontent;
	}
	function setcategories_idcategories($value) {
		$this->categories_idcategories = $value;
	}
	function getcategories_idcategories() {
		return $this->categories_idcategories;
	}
	function listcontent_has_categories() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "content_has_categories" );
		// $db->addkey("ativo", 1);
		$i = 0;
		while ( $db->getcontent_idcontent () ) {
			$out ['content_idcontent'] [$i] = $db->getcontent_idcontent ();
			$out ['categories_idcategories'] [$i] = $db->getcategories_idcategories ();
			$db->next ();
			$i ++;
		}
		return $out;
	}
	function load($content_idcontent) {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		// $db->debug(1);
		$db->settable ( "content_has_categories" );
		// $db->addkey("ativo", 1);
		$db->addkey ( "content_idcontent", $content_idcontent );
		$this->setcontent_idcontent ( $db->getcontent_idcontent () );
		$this->setcategories_idcategories ( $db->getcategories_idcategories () );
	}
	function save() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "content_has_categories" );
		// $db->debug(1);
		if ($this->content_idcontent) {
			$db->addkey ( "content_idcontent", $this->content_idcontent );
		}
		$db->setcontent_idcontent ( $this->getcontent_idcontent () );
		$db->setcategories_idcategories ( $this->getcategories_idcategories () );
		$db->save ();
		return $db->getlastinsertid ();
	}
}
