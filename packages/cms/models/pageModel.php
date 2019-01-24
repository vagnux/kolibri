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
class pageModel {
	private $idpage;
	private $pageName;
	private $templateName;
	private $templateCode;
	private $customJavaScript;
	private $customCss;
	private $published;
	private $dateCreated;
	private $dateModify;
	function setidpage($value) {
		$this->idpage = $value;
	}
	function getidpage() {
		return $this->idpage;
	}
	function setpageName($value) {
		$this->pageName = $value;
	}
	function getpageName() {
		return $this->pageName;
	}
	function settemplateName($value) {
		$this->templateName = $value;
	}
	function gettemplateName() {
		return $this->templateName;
	}
	function settemplateCode($value) {
		$this->templateCode = $value;
	}
	function gettemplateCode() {
		return $this->templateCode;
	}
	function setcustomJavaScript($value) {
		$this->customJavaScript = $value;
	}
	function getcustomJavaScript() {
		return $this->customJavaScript;
	}
	function setcustomCss($value) {
		$this->customCss = $value;
	}
	function getcustomCss() {
		return $this->customCss;
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
	function listpage() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "page" );
		// $db->addkey("ativo", 1);
		$i = 0;
		while ( $db->getidpage () ) {
			$out ['idpage'] [$i] = $db->getidpage ();
			$out ['pageName'] [$i] = $db->getpageName ();
			$out ['templateName'] [$i] = $db->gettemplateName ();
			$out ['templateCode'] [$i] = $db->gettemplateCode ();
			$out ['customJavaScript'] [$i] = $db->getcustomJavaScript ();
			$out ['customCss'] [$i] = $db->getcustomCss ();
			$out ['published'] [$i] = $db->getpublished ();
			$out ['dateCreated'] [$i] = $db->getdateCreated ();
			$out ['dateModify'] [$i] = $db->getdateModify ();
			$db->next ();
			$i ++;
		}
		return $out;
	}
	function load($idpage) {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		// $db->debug(1);
		$db->settable ( "page" );
		// $db->addkey("ativo", 1);
		$db->addkey ( "idpage", $idpage );
		$this->setidpage ( $db->getidpage () );
		$this->setpageName ( $db->getpageName () );
		$this->settemplateName ( $db->gettemplateName () );
		$this->settemplateCode ( $db->gettemplateCode () );
		$this->setcustomJavaScript ( $db->getcustomJavaScript () );
		$this->setcustomCss ( $db->getcustomCss () );
		$this->setpublished ( $db->getpublished () );
		$this->setdateCreated ( $db->getdateCreated () );
		$this->setdateModify ( $db->getdateModify () );
	}
	function save() {
		$db = new mydataobj ();
		$db->setconn ( database::kolibriDB () );
		$db->settable ( "page" );
		// $db->debug(1);
		if ($this->idpage) {
			$db->addkey ( "idpage", $this->idpage );
		}
		$db->setidpage ( $this->getidpage () );
		$db->setpageName ( $this->getpageName () );
		$db->settemplateName ( $this->gettemplateName () );
		$db->settemplateCode ( $this->gettemplateCode () );
		$db->setcustomJavaScript ( $this->getcustomJavaScript () );
		$db->setcustomCss ( $this->getcustomCss () );
		$db->setpublished ( $this->getpublished () );
		$db->setdateCreated ( $this->getdateCreated () );
		$db->setdateModify ( $this->getdateModify () );
		$db->save ();
		return $db->getlastinsertid ();
	}
}
