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




/*
 *  Templete default
 */

//config::set("theme","default");
config::set("theme","barton");




/*
 * 
 * set another vars ... 
 * 
 */

config::set("","");

// Show exec time PHP script 
config::set("showexectime", 0);


//Website URL
config::set("siteRoot",'http://' . $_SERVER['HTTP_HOST'] . '/kolibri/Kolibri-v0.8/');
#config::set("siteRoot",'http://127.0.0.1:7980/kolibri/v0.7');

// Default Controller 
config::set("defaultController","start");

// Default Metlhod
config::set("defaultMethod", "index");

// Recapcha Config 
// Get this on https://www.google.com/recaptcha
config::set("recapchaSiteKey","6LfMNhETAAAAAHIrw2zFRXIq-_Yx0r6vzSeJTbTB");
config::set("recapchaSecretKey","6LfMNhETAAAAACVBjRyshmZDA0Bk4sHz2rADJvnd");
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

config::set("defaultAccess","open");

accesspkg::add("login","open");
accesspkg::add("pkgTest","open");
accesspkg::add("sys","open");
accesspkg::add("public","open");

# access::add("foo","open");
# access::add("bar","login");
# access::add("faa","closed");
access::add("ctrlTest","login");

