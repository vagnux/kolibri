<?php

class yatodemail
{
    
    static function send($to,$from,$subject,$msg) {
        
        $r = new rest();
        $r->setcallPost();
        $r->seturl('http://mailservice.yatode.com.br/index.php/sendmail/');
        $secret = md5(date('Y-m-d') . "YatSec");
        $r->setto($to);
        $r->setfrom($from);
        $r->setsecret($secret);
        $r->setsubject($subject);
        $r->setmessage(base64_encode($msg));
        $r->run();
        
        
    }
    
    
}

