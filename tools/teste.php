<?php

/*
 * Copyright (C) 2016 vagner
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
error_reporting(E_ALL & ~ E_NOTICE & ~ E_STRICT);
$path = realpath(dirname(__FILE__));

require_once ($path . '/../plugins/debug/debug.php');
require_once ($path . '/../lib/database.php');
require_once ($path . '/../lib/functions.php');
require_once ($path . '/../lib/register.php');
require_once ($path . '/../lib/security.php');
require_once ($path . '/../lib/mvcMain.php');
require_once ($path . "/../config/config.php");
require_once ($path . "/../config/databases.php");
require_once ($path . "/../plugins/mydataobj/mydataobj.php");

$conection = $argv[1];
$table = $argv[2];

$db = new mydataobj();
$db->setconn(database::kolibriDB());
$db->debug(1);
$db->settable("menuItem");


while ($db->getidMenuItem()) {
    print("--->");
    print($db->getitemName() . "<br>");
    $db->next();
}
/*
$db->reset();
$db->settable("acl");

$db->setpage('foca');
$db->setidprofile(1);
$db->setidgroup(1);
$db->save();

print_r("Last ID: " .  $db->getlastinsertid());


