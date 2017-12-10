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

class auth implements securityCentral {

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

    function __construct() {
        $sql = "CREATE TABLE IF NOT EXISTS `users` (
				  `idusers` int(11) NOT NULL AUTO_INCREMENT,
				  `login` varchar(500) COLLATE utf8_bin DEFAULT NULL,
				  `userName` varchar(500) COLLATE utf8_bin DEFAULT NULL,
				  `secret` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
				  `idgroup` int(11) NOT NULL,
				  `idprofile` int(11) NOT NULL,
				  `dataCreate` datetime DEFAULT NULL,
				  `dateModify` datetime DEFAULT NULL,
				  `enable` int(11) DEFAULT NULL,
				  PRIMARY KEY (`idusers`),
				  KEY `fk_users_group1_idx` (`idgroup`),
				  KEY `fk_users_profile1_idx` (`idprofile`)
				) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        $db = new mydataobj();
        $db->setconn(database::kolibriDB());
        $db->query($sql);
        unset($db);
        $sql = "CREATE TABLE IF NOT EXISTS `groups` (
		  `idgroup` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(300) COLLATE utf8_bin DEFAULT NULL,
		  `enable` int(11) DEFAULT NULL,
		  PRIMARY KEY (`idgroup`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        $db = new mydataobj ();
        $db->setconn(database::kolibriDB());
        $db->query($sql);
        unset($db);
        $sql = "CREATE TABLE IF NOT EXISTS `profile` (
				  `idprofile` int(11) NOT NULL AUTO_INCREMENT,
				  `idgroup` int(11) NOT NULL,
				  `name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
				  `enable` varchar(45) COLLATE utf8_bin DEFAULT NULL,
				  `adminProfile` int(11) DEFAULT NULL,
				  `dataCreate` datetime DEFAULT NULL,
				  `dataModify` datetime DEFAULT NULL,
				  PRIMARY KEY (`idprofile`),
				  KEY `fk_profile_group_idx` (`idgroup`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        $db = new mydataobj ();
        $db->setconn(database::kolibriDB());
        $db->query($sql);
        unset($db);
        $sql = "CREATE TABLE IF NOT EXISTS  `acl` (
		  `idacl` int(11) NOT NULL AUTO_INCREMENT,
		  `page` varchar(45) COLLATE utf8_bin DEFAULT NULL,
		  `idprofile` int(11) NOT NULL,
		  `idgroup` int(11) NOT NULL,
		  `dataCreate` datetime DEFAULT NULL,
		  `dataModify` datetime DEFAULT NULL,
		  `enable` int(11) DEFAULT NULL,
		  PRIMARY KEY (`idacl`),
		  KEY `fk_acl_profile1_idx` (`idprofile`),
		  KEY `fk_acl_group1_idx` (`idgroup`)
		) ENGINE=MyISAM AUTO_INCREMENT=584762 DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        $db = new mydataobj ();
        $db->setconn(database::kolibriDB());
        $db->query($sql);
        unset($db);
    }

    public function setuserId($userId) {
        $this->userId = $userId;
    }

    public function userLoginExist($userLogin) {
        $db = new mydataobj ();
        $db->setconn(database::kolibriDB());
        $db->settable('users');
        $db->addkey('login', $userLogin);
        if ($db->getlogin()) {
            return true;
        } else {
            return false;
        }
        unset($db);
    }

    public function setuserLogin($login) {
        $this->userLogin = $login;
    }

    public function setuserName($userName) {
        $this->userName = $userName;
    }

    public function setuserActive($flag) {
        if ($flag) {
            $this->userActive = '1';
        } else {
            $this->userActive = '-1';
        }
    }

    public function authUser($userLogin, $clearPassword) {
        $db = new mydataobj ();
        //$db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('users');
        $db->addkey('login', $userLogin);
        $db->addkey('secret', md5($clearPassword));
        if ($db->getidusers()) {
        	
            return true;
        } else {
        	debug::log("user/pass Fail $userLogin"  .  md5($clearPassword) );
            return false;
        }
        unset($db);
    }

    public function getuserLogin() {
        return $this->userLogin;
    }

    public function getuserName() {
        return $this->userName;
    }

    public function getuserId() {
        return $this->userId;
    }

    public function getuserActive() {
        return $this->userActive;
    }

    public function getuserDataCreated() {
        return $this->userDataCreated;
    }

    public function getuserDataModified() {
        return $this->userDataModified;
    }

    public function saveUser() {
        $db = new mydataobj ();
        $db->setconn(database::kolibriDB());
        //$db->debug(1);
        $db->settable('users');
        if ($this->userId) {
            $db->addkey('idusers', $this->userId);
            $db->setdateModify(date('Y-m-d H:i:s'));
        } else {
            $db->setdataCreate(date('Y-m-d H:i:s'));
        }
        $db->setlogin($this->userLogin);
        $db->setuserName($this->userName);
        if (strlen($this->userPassword) > 0) {
            $db->setsecret(md5($this->userPassword));
        }
        $db->setidgroup($this->groupId);
        $db->setidprofile($this->profileId);
        $db->setenable($this->userActive);


        if ($this->userLogin and $this->groupId and $this->profileId) {
            $db->save();
        }
        if ( ! $this->userId) {
        	return $db->getlastinsertid();
        }else{
        	return $this->userId;
        }
    }

    public function setgroupId($groupId) {

        $this->groupId = $groupId;
    }

    public function setgroupName($groupName) {
        $this->groupName = $groupName;
    }

    public function setgroupActive($flag) {
        if ($flag) {
            $this->groupActive = '1';
        } else {
            $this->groupActive = '-1';
        }
    }

    public function listMembersGroup() {
        $db = new mydataobj ();
        $db->setconn(database::kolibriDB());
        //$db->debug(1);
        $db->settable('users');
        $db->addkey('idgroup', $this->groupId);
        $db->addkey('enable', 1);
        $i = 0;
        while ($db->getidusers()) {
            $out['iduser'][$i] = $db->getidusers();
            $out['login'][$i] = $db->getlogin();
            $out['username'][$i] = $db->getuserName();
            $out['idprofile'][$i] = $db->getidprofile();
            $out['datacreate'][$i] = $db->getdataCreate();
            $out['datemodify'][$i] = $db->getdateModify();
            $db->next();
            $i++;
        }
        return $out;
    }

    public function saveGroup() {
        $db = new mydataobj ();
        //$db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('groups');
        if ($this->groupId) {
            $db->addkey('idgroup', $this->groupId);
        }
        $db->setname($this->groupName);
        $db->setenable($this->groupActive);
        $db->save();
        return $db->getlastinsertid();
    }

    public function setprofileId($profileId) {
        $this->profileId = $profileId;
    }

    public function setprofileName($profileName) {
        $this->profileName = $profileName;
    }

    public function setprofileActive($flag) {
        if ($flag) {
            $this->profileActive = '1';
        } else {
            $this->profileActive = '-1';
        }
    }

    public function setprofileGroup($groupId) {
        $this->profileGroupId = $groupId;
    }

    public function listMembersProfile() {
        $db = new mydataobj ();
        //$db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('users');
        $db->addkey('idgroup', $this->groupId);
        $db->addkey('idprofile', $this->profileId);
        $db->addkey('enable', 1);
        $i = 0;
        while ($db->getidusers()) {

            $out['iduser'][$i] = $db->getidusers();
            $out['login'][$i] = $db->getlogin();
            $out['username'][$i] = $db->getuserName();
            $out['idprofile'][$i] = $db->getidprofile();
            $out['datacreate'][$i] = $db->getdataCreate();
            $out['datemodify'][$i] = $db->getdateModify();
            $db->next();
            $i++;
        }
        return $out;
    }

    public function saveProfile() {
        $db = new mydataobj ();
        //$db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('profile');
        if ($this->profileId) {
            $db->addkey('idprofile', $this->profileId);
            $db->setdataModify(date('Y-m-d H:i:s'));
        } else {
            $db->setdataCreate(date('Y-m-d H:i:s'));
            $db->setdataModify(date('Y-m-d H:i:s'));
        }
        $db->setname($this->profileName);
        if ($this->profileGroupId) {
            $db->setidgroup($this->profileGroupId);
        }
        $db->setenable($this->profileActive);
        $db->setadminProfile('');
        $db->save();
        return $db->getlastinsertid();
    }

    public function addAcl($obj, $groupId, $profileId) {
        $db = new mydataobj ();
       // $db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('acl');
        $db->setdataCreate(date('Y-m-d H:i:s'));
        $db->setdataModify(date('Y-m-d H:i:s'));
        $db->setidgroup($groupId);
        $db->setidprofile($profileId);
        $db->setpage($obj);
        $db->setenable(1);
        $db->save();
    }

    public function delAcl($idacl) {
        $db = new mydataobj ();
        $db->setconn(database::kolibriDB());
        $db->settable('acl');
        $db->addkey('idacl', $idacl);
         $db->setdataModify(date('Y-m-d H:i:s'));
        $db->setenable('-1');
        $db->save();
    }

    public function listAcl($groupId, $profileId) {
        $db = new mydataobj ();
       // $db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('acl');
        $db->addkey('idgroup', $groupId);
        $db->addkey('idprofile', $profileId);
        $db->addkey('enable', '1');
        $i = 0;
        while ($db->getidacl()) {
            $out['idacl'][$i] = $db->getidacl();
            $out['page'][$i] = $db->getpage();
            $out['Created'][$i] = $db->getdataCreate();
            $i++;
            $db->next();
        }
        return $out;
    }

    public function valideAcl($obj, $userLogin) {
        $sql = "SELECT * FROM acl 
                        inner join users on ( (acl.idgroup = users.idgroup) and (acl.idprofile = users.idprofile) )
                        where
                        acl.enable = 1 and
                        users.login = '$userLogin' and 
                        acl.page = '$obj'
                        ";

        
        $db = new mydataobj ();
        //$db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->query($sql);
        if ($db->getidacl()) {
            return true;
        } else {
            return false;
        }
    }

    public function getloggedGroupId() {
    session::init();
    	if ( session::get('login') ) {
    		$db = new mydataobj ();
    		//$db->debug(1);
    		$db->setconn(database::kolibriDB());
    		$db->settable('users');
    		$db->addkey('login', session::get('login'));
    		$db->addkey('enable', 1);
    		return $db->getidgroup();
    	}else{
    		return false;
    	}
    }
    
    public function getloggedProfileId(){
    	session::init();
    	if ( session::get('login') ) {
    		$db = new mydataobj ();
    		//$db->debug(1);
    		$db->setconn(database::kolibriDB());
    		$db->settable('users');
    		$db->addkey('login', session::get('login'));
    		$db->addkey('enable', 1);
    		return $db->getidprofile();
    	}else{
    		return false;
    	}
    }
    
    /*
     * This function is legacy from version before 0.7 
     */

    function valide($login, $pass) {

        return $this->authUser($login, $pass);
    }

    function access($controler, $login) {
        return $this->valideAcl($controler, $login);
    }

    function accessAdmin($controler, $login) {
        return $this->valideAcl($controler, $login);
    }

    function changePassword($login, $pass, $newPass) {
        if ($this->authUser($login, $pass)) {
            $this->userPassword = $newPass;
            return true;
        }else{
            return false;
        }
    }

    public function setpassword($passClean) {
        $this->userPassword = $passClean;
    }

    public function listAllGroups() {
        $db = new mydataobj ();
        //$db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('groups');
        $db->addkey('enable', 1);
        $i = 0;
        while ($db->getidgroup()) {
            $out['idgroup'][$i] = $db->getidgroup();
            $out['name'][$i] = $db->getname();
            $db->next();
            $i++;
        }
        return $out;
    }

    public function listProfiles($idGroup) {
        $db = new mydataobj ();
        // $db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('profile');
        $db->addkey('idgroup', $idGroup);
        $db->addkey('enable', 1);
        $i = 0;
        while ($db->getidgroup()) {
            $out['idprofile'][$i] = $db->getidprofile();
            $out['name'][$i] = $db->getname();
            $out['adminProfile'][$i] = $db->getadminProfile();
            $out['dataCreate'][$i] = $db->getdataCreate();
            $out['dataModify'][$i] = $db->getdataModify();
            $db->next();
            $i++;
        }
        return $out;
    }

    public function loadLogin($login) {
    	$db = new mydataobj ();
    	// $db->debug(1);
    	$db->setconn ( database::kolibriDB () );
    	$db->settable ( 'users' );
    	$db->addkey ( 'login', $login );
    	$this->setuserId ( $db->getidusers () . 'U' );
    	$db->addkey ( 'idusers', $idUser );
    	$this->setuserId ( $db->getidusers () );
    	$this->setuserName ( $db->getuserName () );
    	$this->setuserLogin ( $db->getlogin () );
    	$this->userDataCreated = $db->getdataCreate ();
    	$this->userDataModified = $db->getdateModify ();
    	$this->setgroupId ( $db->getidgroup () );
    	$this->setprofileId ( $db->getidprofile () );
    	
    	if (! $db->getidusers ()) {
    		$db->reset ();
    		$db->settable ( 'users' );
    		$db->addkey ( 'login', $login );
    		$this->setuserId ( $db->getidusers () . 'P' );
    		$this->setuserName ( $db->getuserName () );
    		$this->setuserLogin ( $db->getlogin () );
    		$this->userDataCreated = $db->getdataCreate ();
    		$this->userDataModified = $db->getdateModify ();
    		$this->setgroupId ( $db->getidgroup () );
    		$this->setprofileId ( $db->getidprofile () );
    	}
    }
    
    public function loadUser($idUser) {
        $db = new mydataobj ();
        // $db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('users');
        $db->addkey('idusers', $idUser);
        $this->setuserId($db->getidusers());
        $this->setuserName($db->getuserName());
        $this->setuserLogin($db->getlogin());
        $this->userDataCreated = $db->getdataCreate();
        $this->userDataModified = $db->getdateModify();
        $this->setgroupId($db->getidgroup());
        $this->setprofileId($db->getidprofile());
    }

    function getprofileId() {
        return $this->profileId;
    }

    function getgroupId() {
        return $this->groupId;
    }

    function loadProfile($profileid) {
        $db = new mydataobj ();
        //$db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('profile');
        $db->addkey('idprofile', $profileid);
        if ($db->getidprofile()) {
            $this->setprofileName($db->getname());
            $this->setgroupId($db->getidgroup());
            $this->setprofileId($profileid);
            $this->setprofileActive($db->getenable());
        }
    }

    function loadGroup($groupid) {
        $db = new mydataobj ();
        //$db->debug(1);
        $db->setconn(database::kolibriDB());
        $db->settable('groups');
        $db->addkey('idgroup', $groupid);
        $this->setgroupName($db->getname());
        $this->setuserActive($db->getenable());
        $this->groupId = $db->getidgroup();
    }

    function getgroupName() {
        return $this->groupName;
    }

    function getprofileName() {
        return $this->profileName;
    }

    function getPages() {

        $ctrl = getcwd() . "/packages/";
        // echo $ctrl;
        $fl = opendir($ctrl);
        while (false !== ($folder = readdir($fl))) {
            if (!($folder == ".") xor ( $folder == "..")) {

                if (is_dir($ctrl . "/" . $folder)) {
                    //echo "Abrindo " . $ctrl . $folder . "/controllers/<br>";
                    $pkg = opendir($ctrl . $folder . "/controllers/");
                    while (false !== ($folderSub = readdir($pkg))) {
                        if (!($folderSub == ".") xor ( $folderSub == "..")) {
                            list ( $file, $type ) = explode('.', $folderSub);

                            require_once($ctrl . "/" . $folder . "/controllers/" . $file . ".php");
                            $class_methods = get_class_methods($file);
                            foreach ($class_methods as $method_name) {
                                if ( $method_name != "__construct" ) {
                                    $out[] = $file . "/" . $method_name;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $out;
    }

}
