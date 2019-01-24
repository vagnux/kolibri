<?php

class notify
{

    private static $loaded = 0;

    static function loadApi()
    {
        $js = " function notifyMe(msg) {
		  // Let's check if the browser supports notifications
		  if (!(\"Notification\" in window)) {
		    console.log(\"This browser does not support desktop notification\");
		  }
            
		  // Let's check whether notification permissions have alredy been granted
		  else if (Notification.permission === \"granted\") {
		    // If it's okay let's create a notification
		    var notification = new Notification(msg);
		  }
            
		  // Otherwise, we need to ask the user for permission
		  else if (Notification.permission !== 'denied' || Notification.permission === \"default\") {
		    Notification.requestPermission(function (permission) {
		      // If the user accepts, let's create a notification
		      if (permission === \"granted\") {
		        var notification = new Notification(msg);
		      }
		    });
		  }
            
		  // At last, if the user has denied notifications, and you
		  // want to be respectful there is no need to bother them any more.
		}";
        page::addJsScript($js);

        self::$loaded = 1;
    }

    static function sendMessage($text)
    {
        if (! self::$loaded) {
            self::loadApi();
        }

        $js = '
        document.addEventListener("DOMContentLoaded", function(event){
        notifyMe("' . $text . '");
        });';

        page::addJsScript($js);
    }
}

