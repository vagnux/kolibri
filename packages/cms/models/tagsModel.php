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
class tagsModel {
	private $idtags;
	private $tagName;
	function setidtags($value) {
		$this->idtags = $value;
	}
	function getidtags() {
		return $this->idtags;
	}
	function settagName($value) {
		$this->tagName = $value;
	}
	function gettagName() {
		return $this->tagName;
	}
	function listtags() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "tags" );
		// $db->addkey("ativo", 1);
		$i = 0;
		while ( $db->getidtags () ) {
			$out ['idtags'] [$i] = $db->getidtags ();
			$out ['tagName'] [$i] = $db->gettagName ();
			$db->next ();
			$i ++;
		}
		return $out;
	}
	function load($idtags) {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		// $db->debug(1);
		$db->settable ( "tags" );
		// $db->addkey("ativo", 1);
		$db->addkey ( "idtags", $idtags );
		$this->setidtags ( $db->getidtags () );
		$this->settagName ( $db->gettagName () );
	}
	function save() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "tags" );
		// $db->debug(1);
		if ($this->idtags) {
			$db->addkey ( "idtags", $this->idtags );
		}
		$db->setidtags ( $this->getidtags () );
		$db->settagName ( $this->gettagName () );
		$db->save ();
		return $db->getlastinsertid ();
	}
}
