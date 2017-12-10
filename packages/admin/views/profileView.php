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

class profileView {

    function listaGroups($groupArray) {
        $table = new htmlTable();
        page::addBody("<h3>Profile Manager</h3>");

        $i = 0;
        if (is_array($groupArray)) {
            foreach ($groupArray['idgroup'] as $ids) {
                $form = new formEasy();
                $groupArray['Control'][$i] = $form->formActionButton(config::siteRoot() . "/index.php/profile/groupProfile/", "Profiles", array("idgroup" => $ids));
                $i++;
            }
        }
        unset($groupArray['idgroup']);
        page::addBody($table->loadTable($groupArray));
        page::render();
    }

    function groupProfile($arrayProfile) {
        $form = new formEasy();
        page::addBody("<h3>Profile Manager</h3>");
        page::addBody($form->formActionButton(config::siteRoot() . "/index.php/profile/newProfile/", "New Profile", ''));
        if (is_array($arrayProfile)) {
            $i = 0;
            foreach ($arrayProfile['idprofile'] as $ids) {

                $arrayProfile['Del'][$i] = $form->formActionButton(config::siteRoot() . "/index.php/profile/delProfile/", "Delete", array("idprofile" => $ids));
                $arrayProfile['Users'][$i] = $form->formActionButton(config::siteRoot() . "/index.php/profile/listUsers/", "Users", array("idprofile" => $ids));
                $arrayProfile['ACL'][$i] = $form->formActionButton(config::siteRoot() . "/index.php/acl/profileAccess/", "ACL", array("idprofile" => $ids));
                $i++;
            }
        }
        $table = new htmlTable();
        unset($arrayProfile['idprofile']);
        unset($arrayProfile['adminProfile']);
        unset($arrayProfile['dataModify']);
        page::addBody($table->loadTable($arrayProfile));
        page::render();
    }

    function newProfile($arrayProfiles) {

        if (is_array($arrayProfiles)) {
            $i = 0;
            foreach ($arrayProfiles['idgroup'] as $id) {
                $groups [$i][0] = $id;
                $groups [$i][1] = $arrayProfiles['name'][$i];
                $i++;
            }
        }

        page::addBody("<h3>New profile</h3>");
        $form = new formEasy();
        $form->action(config::siteRoot() . "/index.php/profile/saveProfile/")->method("post")->openForm();
        $form->addText("Profine Name", 'profileName', '', 1);
        $form->addSelect("Group", 'idgroup', $groups, '', 1);
        $form->type("submit")->value("Save")->done();
        $form->closeForm();
        page::addBody($form->printform());
        page::render();
    }

}
