<?php
error_reporting(E_ERROR | E_PARSE);
class setup extends controller {
	function __construct() {
		parent::__construct ();
	}
	function index() {
		if (! is_writable ( getcwd () . '/config' )) {
			$msg = getcwd () . '/config is not writable !';
		}
		
		$v = new setupView ();
		$v->index ( $msg );
	}
	function save() {
		if (! is_writable ( getcwd () . '/config' )) {
			$msg = getcwd () . '/config is not writable !';
			$v = new setupView ();
			$v->index ( $msg );
		} else {
			if ($this->request ['secMode'] != 1) {
				// Secure mode Login !
				
				$myfile = fopen ( getcwd () . '/config/config.php', "w" );
				
				$file = "<?php
						
/*
*  Copyright (C) 2016 vagner 
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
//--------------------------------------------------------------------------------------------
/*
  Templete default
*/
//config::set(\"theme\",\"default\");
config::set(\"theme\",\"barton\");
//--------------------------------------------------------------------------------------------
/*
* 
* set another vars ... 
* 
*/
config::set(\"\",\"\");
//--------------------------------------------------------------------------------------------
// Show exec time PHP script 
config::set(\"showexectime\", 0);";
				$url = $this->request ['siteUrl'];
				$file .= "
//Website URL
config::set(\"siteRoot\",'$url');
//--------------------------------------------------------------------------------------------";
				
				$siteName = $this->request ['siteName'];
				$file .= "
//Website Name
config::set(\"siteName\",'$siteName');
//--------------------------------------------------------------------------------------------";
				
				$file .= "
// Default Controller
config::set(\"defaultController\",\"start\");
//--------------------------------------------------------------------------------------------
// Default Metlhod
config::set(\"defaultMethod\", \"index\");
//--------------------------------------------------------------------------------------------
// Recapcha Config 
// Get this on https://www.google.com/recaptcha
config::set(\"recapchaSiteKey\",\"\");
config::set(\"recapchaSecretKey\",\"\");
//--------------------------------------------------------------------------------------------
/*
 * 
 *  In this place you can configure access mode for some packages or Controllers 
 * 
 *  the modes is  open, login and closed
 *  
 *  open : the access for public
 *  
 *  login :  Login access is necessary to access 
 *  
 *  closed :  Deny all access
 *   
 *  admin : For acces to Admin user type
 *  
 *  if is not set on package or controller the DefaultAccess is apply
 *  
 */
//--------------------------------------------------------------------------------------------";

				$file .= "
						
config::set(\"defaultAccess\",\"open\");
								
accesspkg::add(\"login\",\"open\");
accesspkg::add(\"pkgTest\",\"open\");
accesspkg::add(\"sys\",\"open\");
accesspkg::add(\"public\",\"open\");

# access::add(\"foo\",\"open\");
# access::add(\"bar\",\"login\");
# access::add(\"faa\",\"closed\");
access::add(\"ctrlTest\",\"login\");";
				
				fwrite ( $myfile, $file );
				fclose ( $myfile );
				
				page::addBody ( "Terminei..." );
				page::render ();
			} else {
				
				$dbType = $this->request ['kdbServerType'];
				$dbHost = $this->request ['kdbServerHost'];
				$dbPort = $this->request ['kdbServerPort'];
				$dbUser = $this->request ['kdbServerUser'];
				$dbPass = $this->request ['kdbServerPass'];
				$dbData = $this->request ['kdbServerData'];
				
				database::add('kolibriDB',"$dbType","$dbHost" , "$dbPort", "$dbUser", "$dbPass", "$dbData");
				$links = mysqli_connect ( $dbHost, $dbUser, $dbPass, $dbData, $dbPort )	or die ( $this->fail() );
				
				if ( database::kolibriDB()) {
					$auth = new auth ();
					// creating groups
					$auth->setgroupName ( 'Admin Group' );
					$auth->setgroupActive ( 1 );
					$gpid = $auth->saveGroup ();
					
					// creating profile
					$auth->setprofileName ( "Admin profile" );
					$auth->setprofileGroup ( $gpid );
					$auth->setprofileActive ( 1 );
					$profId = $auth->saveProfile ();
					
					// creating ACLS
					$auth->addAcl ( 'acl/aclRemove', $gpid, $profId );
					$auth->addAcl ( 'acl/newAcl', $gpid, $profId );
					$auth->addAcl ( 'acl/profileAccess', $gpid, $profId );
					$auth->addAcl ( 'acl/saveAcl', $gpid, $profId );
					$auth->addAcl ( 'group/delGroup', $gpid, $profId );
					$auth->addAcl ( 'group/index', $gpid, $profId );
					$auth->addAcl ( 'group/newGroup', $gpid, $profId );
					$auth->addAcl ( 'group/saveGroup', $gpid, $profId );
					$auth->addAcl ( 'menuManager/delete', $gpid, $profId );
					$auth->addAcl ( 'menuManager/deleteItem', $gpid, $profId );
					$auth->addAcl ( 'menuManager/index', $gpid, $profId );
					$auth->addAcl ( 'menuManager/itens', $gpid, $profId );
					$auth->addAcl ( 'menuManager/menuNew', $gpid, $profId );
					$auth->addAcl ( 'menuManager/menuNewItem', $gpid, $profId );
					$auth->addAcl ( 'menuManager/saveItem', $gpid, $profId );
					$auth->addAcl ( 'menuManager/saveMenu', $gpid, $profId );
					$auth->addAcl ( 'profile/delProfile', $gpid, $profId );
					$auth->addAcl ( 'profile/groupProfile', $gpid, $profId );
					$auth->addAcl ( 'profile/index', $gpid, $profId );
					$auth->addAcl ( 'profile/listUsers', $gpid, $profId );
					$auth->addAcl ( 'profile/newProfile', $gpid, $profId );
					$auth->addAcl ( 'profile/profileName', $gpid, $profId );
					$auth->addAcl ( 'profile/saveProfile', $gpid, $profId );
					$auth->addAcl ( 'users/ajaxGroup', $gpid, $profId );
					$auth->addAcl ( 'users/ajaxProfile', $gpid, $profId );
					$auth->addAcl ( 'users/index', $gpid, $profId );
					$auth->addAcl ( 'users/listUser', $gpid, $profId );
					$auth->addAcl ( 'users/profileName', $gpid, $profId );
					$auth->addAcl ( 'users/saveUser', $gpid, $profId );
					$auth->addAcl ( 'users/userEdit', $gpid, $profId );
					
					// creating users
					$auth->setuserLogin ( 'admin' );
					$auth->setuserName ( 'System Admin' );
					$auth->setgroupId ( $gpid );
					$auth->setprofileId ( $profId );
					$auth->setpassword ( $this->request ['adminPassB'] );
					$auth->saveUser ();
					
					$menu = new menuGen ();
					$idMenu = $menu->addMenu ( 'nav' );
					//addItemMenu($idMenu, $itemName, $address, $idParent = 0, $class, $name, $id, $icon, $idgroup = '', $idprofile = '')
					$menu->addItemMenu ( $idMenu, 'Groups', '::siteroot::/index.php/group/index/', '', '', '', '', 'glyphicon glyphicon-user' );
					$menu->addItemMenu ( $idMenu, 'Menu Editor', '::siteroot::/index.php/menuManager/index/', '','', '', '', 'glyphicon glyphicon-th-list' );
					$menu->addItemMenu ( $idMenu, 'Profiles', '::siteroot::/index.php/profile/index/', '', '','', '', 'glyphicon glyphicon-tags' );
					$menu->addItemMenu ( $idMenu, 'Users', '::siteroot::/index.php/users/index/', '', '', '','', 'glyphicon glyphicon-user' );
					
					
					// secure mode Open !
					$myfile = fopen ( getcwd () . '/config/databases.php', "w" );
					
				
					
					$file = "<?php
					
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
					
					
					/*
					* Here add connection to mysql using the above syntax
					* datababase::add(conectionName, host, port, user, pass, database);
					*/
					
					database::add(\"kolibriDB\",\"$dbType\" , \"$dbHost\", \"$dbPort\", \"$dbUser\", \"$dbPass\", \"$dbData\");
					#database::add(\"kolibriDB\",\"sqlite\" , __DIR__ . \"../data/menu.sqlite\", \"\", \"\", \"\", \"kolibri\");";
					fwrite ( $myfile, $file );
					fclose ( $myfile );
					
					$myfile = fopen ( getcwd () . '/config/config.php', "w" );
					
					$file = "<?php
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
//--------------------------------------------------------------------------------------------
/*
 *  Templete default
 */
//config::set(\"theme\",\"default\");
config::set(\"theme\",\"barton\");
//--------------------------------------------------------------------------------------------
/*
 *
 * set another vars ...
 *
 */
config::set(\"\",\"\");
//--------------------------------------------------------------------------------------------
// Show exec time PHP script
config::set(\"showexectime\", 0);";
					$url = $this->request ['siteUrl'];
					$file .= "//Website URL
					config::set(\"siteRoot\",'$url');
					//--------------------------------------------------------------------------------------------";
					
					$siteName = $this->request ['siteName'];
					$file .= "//Website Name
					config::set(\"siteName\",'$siteName');
					//--------------------------------------------------------------------------------------------";
					
					$file .= "// Default Controller
config::set(\"defaultController\",\"start\");
//--------------------------------------------------------------------------------------------
// Default Metlhod
config::set(\"defaultMethod\", \"index\");
//--------------------------------------------------------------------------------------------
// Recapcha Config
// Get this on https://www.google.com/recaptcha
config::set(\"recapchaSiteKey\",\"\");
config::set(\"recapchaSecretKey\",\"\");
//--------------------------------------------------------------------------------------------
/*
 *
 *  In this place you can configure access mode for some packages or Controllers
 *
 *  the modes is  open, login and closed
 *
 *  open : the access for public
 *
 *  login :  Login access is necessary to access
 *
 *  closed :  Deny all access
 *
 *  admin : For acces to Admin user type
 *
 *  if is not set on package or controller the DefaultAccess is apply
 *
 */
//--------------------------------------------------------------------------------------------";
					
					$file .= "
					
config::set(\"defaultAccess\",\"login\");
					
accesspkg::add(\"login\",\"open\");
accesspkg::add(\"pkgTest\",\"open\");
accesspkg::add(\"sys\",\"open\");
accesspkg::add(\"public\",\"open\");
					
# access::add(\"foo\",\"open\");
# access::add(\"bar\",\"login\");
# access::add(\"faa\",\"closed\");
access::add(\"ctrlTest\",\"login\");";
					
					fwrite ( $myfile, $file );
					fclose ( $myfile );
					page::addBody ( "Configuração concluida" );
				}else{
					page::addBody ( "ERRO !  Impossível acesso ao banco de dados" );
				}
				
				
				
				page::render ();
			}
		}
	}
	function fail() {
		page::addBody("Database access error"); 
		page::render();
	}
}