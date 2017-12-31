<?php
// licenca
$executerTimer = microtime ( true );
ini_set ( 'display_errors', 1 );
ini_set ( 'display_startup_errors', 1 );
error_reporting ( E_ALL & ~ E_NOTICE & ~ E_STRICT );
require_once ('lib/charConverter.php');
require_once ('lib/functions.php');
require_once ('lib/register.php');
require_once ('lib/security.php');
require_once ('lib/database.php');
if (file_exists ( 'config/config.php' )) {
	require_once ('config/config.php');
	require_once ('config/databases.php');
	require_once ('lib/mvcMain.php');
	session::set ( 'installMode', '0' );
} else {
	require_once ('lib/tempConfig.php');
	#require_once ('config/databases.php');
	require_once ('lib/mvcMain.php');
	session::set ( 'installMode', '1' );
}

session::init ();

$pathURI =  explode('/index.php',$_SERVER ['REQUEST_URI']);


$urlSession = $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'];

$_met = getUrlTarget($urlSession);

config::set('siteRoot', $_met['siteRoot']);
$_execute = $_met['controller'];
$_method = $_met['method'];

if ( is_https()) {
	config::set("siteRoot", str_replace('index.php/', '', 'https://' . $_SERVER['HTTP_HOST'] . $pathURI[0]));
}else{
	config::set("siteRoot", str_replace('index.php/', '', 'http://' . $_SERVER['HTTP_HOST'] . $pathURI[0]));
    if ( config::https()) {
    	header("location: https://" . $_SERVER ['HTTP_HOST'] . $pathURI[0]);
    }
    
}


if (session::get ( 'installMode' )) {
	$_execute = config::defaultController ();
	$_method = config::defaultMethod ();
} else {
	if (! $_execute) {
		$_execute = config::defaultController ();
	}
	
	if (! $_method) {
		$_method = config::defaultMethod ();
	}
}
$pkg = getPackageName ( $_execute );

if (! $pkg) {
	boot::init ( "sys", "errors", "notFound" );
	// die();
}
debug::log ( "$_execute/$_method" );
if ($pkg) {
	if ((accesspkg::$pkg () == "closed") or (access::$_execute () == "closed"))
		$runlevel = 0;
	if ((accesspkg::$pkg () == "open") or (access::$_execute () == "open"))
		$runlevel = 1;
	if ((accesspkg::$pkg () == "login") or (access::$_execute () == "login"))
		$runlevel = 2;
	if ((accesspkg::$pkg () == "admin") or (access::$_execute () == "admin"))
		$runlevel = 3;
	if ((config::defaultAccess () == "open") and ($runlevel == 0))
		$runlevel = 1;
	if ((config::defaultAccess () == "login") and ($runlevel == 0))
		$runlevel = 2;
	if ((config::defaultAccess () == "closed") and ($runlevel == 0))
		$runlevel = 0;
	
	switch ($runlevel) {
		case 1 :
			if (! boot::init ( $pkg, $_execute, $_method ))
				break;
		case 2 :
			if (session::get ( "logged" ) == "on") {
				$security = new auth ();
				if ($security->access ( $_execute . "/" . $_method, session::get ( 'login' ) )) {
					boot::init ( $pkg, $_execute, $_method );
				} else {
					$pkg = "sys";
					boot::init ( "sys", "denied", "index" );
				}
			} else {
				session::set('_execute', $_execute);
				session::set('_method', $_method);
				$_execute = 'login';
				$_method = 'index';
				$pkg = 'login';
				boot::init ( "login", "login", "index" );
			}
			break;
		case 3 :
			if ((session::get ( "logged" ) == "on")) {
				if ($security->accessAdmin ( $_execute . "/" . $_method, session::get ( 'login' ) )) {
					boot::init ( $pkg, $_execute, $_method );
				} else {
					$pkg = "system";
					boot::init ( "sys", "denied", "index" );
				}
			} else {
				$pkg = 'login';
				boot::init ( "login", "login", "index" );
			}
			break;
		default :
			boot::init ( "sys", "errors", "closed" );
			break;
	}
} else {
	boot::init ( "sys", "errors", "closed" );
}
?>