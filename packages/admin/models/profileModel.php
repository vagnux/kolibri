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

class profileModel {
	private $idprofile;
	private $idgroup;
	private $name;
	private $enable;
	private $adminProfile;
	private $dataCreate;
	private $dataModify;
	function __construct($idprofile = '') {
                                   $sys = new auth();
                                   $sys->loadProfile($idprofile);
	}
	function save() {
                                $sys = new auth();
                                $sys->setprofileActive($this->enable);
                             
                                $sys->setprofileGroup($this->idgroup);
                                $sys->setprofileName($this->name);
                                $sys->saveProfile();
	}
	function listprofile($idGroup) {
                                $sys = new auth();
                                
                                return $sys->listProfiles($idGroup);
	}
                        function listGroups() {
                                $sys = new auth();
                                return $sys->listAllGroups();
                        }
                        function listUsersProfile($idProfile) {
                             $sys = new auth();
                             $sys->loadProfile($idProfile);
                             $groupId = $sys->getgroupId();
                             unset($sys);
                             $sys = new auth();
                             $sys->setgroupId($groupId);
                             $sys->setprofileId($idProfile);
                             return $sys->listMembersProfile();
                        }
                        function deleteProfile($idprofile){
                             $sys = new auth();
                           
                             $sys->loadProfile($idprofile);
                             $sys->setprofileActive(0);
                             $sys->saveProfile();
                        }
	function setname($name) {
		$this->name = $name;
	}
                        function setIdGroup($idGroup) {
                           
                            $this->idgroup = $idGroup;
                           
                        }
	function setadminProfile($idUser) {
		$this->adminProfile = $idUser;
	}
	function setenable($enable) {
		if ($enable) {
			$this->enable = 1;
		} else {
			$this->enable = 0;
		}
	}
	function getadminProfile($idProfile) {
		return $this->adminProfile;
	}
	function getname() {
		return $this->name;
	}
	function getenable() {
		return $this->enable;
	}
}