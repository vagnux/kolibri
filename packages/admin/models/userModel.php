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


class userModel extends model {

    function listGroups() {
        $sysUsers = new auth();

        return $sysUsers->listAllGroups();
    }

    function userList($groupId) {
        $sysUsers = new auth();
        $sysUsers->setgroupId($groupId);
        return $sysUsers->listMembersGroup();
    }

    function userEdit($iduser) {
        $sysUsers = new auth();
        $sysUsers->loadUser($iduser);
        $out['login'] = $sysUsers->getuserLogin();
         $out['userid'] = $sysUsers->getuserId();
        $out['userName'] = $sysUsers->getuserName();
        $out['groupid'] = $sysUsers->getgroupId();
        $out['profileid'] = $sysUsers->getprofileId();
        $s = new auth();
        $s->loadGroup($out['groupid']);
        $out['groupName'] = $s->getgroupName();
        unset($s);
        $s = new auth();
        $s->loadProfile($out['groupid']);
        $out['profileName'] = $s->getprofileName();
        unset($s);
        $out['dataCreated'] = $sysUsers->getuserDataCreated();
        $out['dataModified'] = $sysUsers->getuserDataModified();
        return $out;
    }

    function getgroupList() {
        $sys = new auth();
        return $sys->listAllGroups();
    }

    function getprofileList($idGroup) {
        $sys = new auth();
        return $sys->listProfiles($idGroup);
    }

    function saveUser($login, $userName, $groupId, $profileId, $oldPass, $newPass, $userId = '') {
        $sys = new auth();
        if ($userId) {
            $sys->setuserId($userId);
        } 
        if (!$sys->userLoginExist($login)) {
            
            $sys->setuserLogin($login);
            $sys->setuserName($userName);
            $sys->setgroupId($groupId);
            $sys->setprofileId($profileId);
             $sys->setpassword($newPass);
             $sys->setuserActive(1);
             $sys->saveUser();
            return true;
        } else {
            return false;
        }
    }

}
