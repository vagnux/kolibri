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

interface securityCentral  {
    
    /*
    private $userId;
    private $userLogin;
    private $userName;
    private $userPassword;
    private $userDataCreated;
    private $userDataModified;
    private $userLastLogon;
    private $userActive;
    private $groupId;
    private $groupName;
    private $groupMembers = array();
    private $groupDataCreated;
    private $groupDataModified;
    private $groupActive;
    private $profileId;
    private $profileName;
    private $profileGroupId;
    private $profleMembers;
    private $profileActive;
    private $aclRules = array();
    */
    
     
    public function setuserId($userId) ;
    public function userLoginExist($userLogin);
    public function setuserLogin($login);
    public function setuserName($userName);
    public function setuserActive($flag);
    public function authUser($userLogin,$cryptPassword);
    public function getuserLogin();
    public function getuserName();
    public function getuserId();
    public function getuserActive();
    public function getuserDataCreated();
    public function getuserDataModified();
    public function saveUser();
    public function setgroupId($groupId);
    public function setgroupName($groupName);
    public function setgroupActive($flag);
    public function listMembersGroup();
    public function saveGroup();
    public function setprofileId($profileId);
    public function setprofileName($profileName);
    public function setprofileActive($flag);
    public function setprofileGroup($groupId);
    public function listMembersProfile();
    public function saveProfile();
    public function addAcl($obj,$groupId,$profileId);
    public function delAcl($idacl);
    public function valideAcl($obj,$userLogin);
    public function listAllGroups();
    public function listProfiles($idGroup);
 
}