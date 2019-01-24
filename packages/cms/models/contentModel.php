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
class contentModel {
	private $idcontent;
	private $page_idpage;
	private $contentName;
	private $content;
	private $published;
	private $dateCreated;
	private $dateModify;
	function setidcontent($value) {
		$this->idcontent = $value;
	}
	function getidcontent() {
		return $this->idcontent;
	}
	function setpage_idpage($value) {
		$this->page_idpage = $value;
	}
	function getpage_idpage() {
		return $this->page_idpage;
	}
	function setcontentName($value) {
		$this->contentName = $value;
	}
	function getcontentName() {
		return $this->contentName;
	}
	function setcontent($value) {
		$this->content = $value;
	}
	function getcontent() {
		return $this->content;
	}
	function setpublished($value) {
		$this->published = $value;
	}
	function getpublished() {
		return $this->published;
	}
	function setdateCreated($value) {
		$this->dateCreated = $value;
	}
	function getdateCreated() {
		return $this->dateCreated;
	}
	function setdateModify($value) {
		$this->dateModify = $value;
	}
	function getdateModify() {
		return $this->dateModify;
	}
	function listcontent() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "content" );
		// $db->addkey("ativo", 1);
		$i = 0;
		while ( $db->getidcontent () ) {
			$out ['idcontent'] [$i] = $db->getidcontent ();
			$out ['page_idpage'] [$i] = $db->getpage_idpage ();
			$out ['contentName'] [$i] = $db->getcontentName ();
			$out ['content'] [$i] = $db->getcontent ();
			$out ['published'] [$i] = $db->getpublished ();
			$out ['dateCreated'] [$i] = $db->getdateCreated ();
			$out ['dateModify'] [$i] = $db->getdateModify ();
			$db->next ();
			$i ++;
		}
		return $out;
	}
	function load($idcontent) {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		// $db->debug(1);
		$db->settable ( "content" );
		// $db->addkey("ativo", 1);
		$db->addkey ( "idcontent", $idcontent );
		$this->setidcontent ( $db->getidcontent () );
		$this->setpage_idpage ( $db->getpage_idpage () );
		$this->setcontentName ( $db->getcontentName () );
		$this->setcontent ( $db->getcontent () );
		$this->setpublished ( $db->getpublished () );
		$this->setdateCreated ( $db->getdateCreated () );
		$this->setdateModify ( $db->getdateModify () );
	}
	function save() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "content" );
		// $db->debug(1);
		if ($this->idcontent) {
			$db->addkey ( "idcontent", $this->idcontent );
		}
		$db->setidcontent ( $this->getidcontent () );
		$db->setpage_idpage ( $this->getpage_idpage () );
		$db->setcontentName ( $this->getcontentName () );
		$db->setcontent ( $this->getcontent () );
		$db->setpublished ( $this->getpublished () );
		$db->setdateCreated ( $this->getdateCreated () );
		$db->setdateModify ( $this->getdateModify () );
		$db->save ();
		return $db->getlastinsertid ();
	}
}
