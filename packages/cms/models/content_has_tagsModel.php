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
class content_has_tagsModel {
	private $content_idcontent;
	private $tags_idtags;
	function setcontent_idcontent($value) {
		$this->content_idcontent = $value;
	}
	function getcontent_idcontent() {
		return $this->content_idcontent;
	}
	function settags_idtags($value) {
		$this->tags_idtags = $value;
	}
	function gettags_idtags() {
		return $this->tags_idtags;
	}
	function listcontent_has_tags() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "content_has_tags" );
		// $db->addkey("ativo", 1);
		$i = 0;
		while ( $db->getcontent_idcontent () ) {
			$out ['content_idcontent'] [$i] = $db->getcontent_idcontent ();
			$out ['tags_idtags'] [$i] = $db->gettags_idtags ();
			$db->next ();
			$i ++;
		}
		return $out;
	}
	function load($content_idcontent) {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		// $db->debug(1);
		$db->settable ( "content_has_tags" );
		// $db->addkey("ativo", 1);
		$db->addkey ( "content_idcontent", $content_idcontent );
		$this->setcontent_idcontent ( $db->getcontent_idcontent () );
		$this->settags_idtags ( $db->gettags_idtags () );
	}
	function save() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "content_has_tags" );
		// $db->debug(1);
		if ($this->content_idcontent) {
			$db->addkey ( "content_idcontent", $this->content_idcontent );
		}
		$db->setcontent_idcontent ( $this->getcontent_idcontent () );
		$db->settags_idtags ( $this->gettags_idtags () );
		$db->save ();
		return $db->getlastinsertid ();
	}
}
