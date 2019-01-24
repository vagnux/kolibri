<?php
#use PHPMailer\PHPMailer\PHPMailer;

#require __DIR__ . "/../PHPMailer/PHPMailer/Exception.php";
#require __DIR__ . "/../PHPMailer/PHPMailer/PHPMailer.php";
#require __DIR__ . "/../PHPMailer/PHPMailer/SMTP.php";

// require __DIR__ . "/../PHPMailer/PHPMailer/POP3.php";

// use PHPMailer\PHPMailer\PHPMailer;
class myMail
{

    private $host = 'vps.yatode.com.br';

    private $port = 25;

    private $SMTPauth = false;

    private $username = 'sender';

    private $Password = 'A!S@1458sp753159';

    private $from = 'noresp@yatode.com.br';

    private $replyto = 'noresp@yatode.com.br';

    private $addAddress;

    private $subject;

    private $msg;

    function __construct()
    {
        $this->setusername('');
        $this->setPassword('');
    }

    function sethost($value)
    {
        $this->host = $value;
    }

    function setport($value)
    {
        $this->port = $value;
    }

    function setSMTPauth($value)
    {
        $this->SMTPauth = $value;
    }

    function setusername($value)
    {
        $this->username = $value;
    }

    function setPassword($value)
    {
        $this->Password = $value;
    }

    function setfrom($value)
    {
        $this->from = $value;
    }

    function setreplyto($value)
    {
        $this->replyto = $value;
    }

    function setaddAddress($value)
    {
        $this->addAddress = $value;
    }

    function setsubject($value)
    {
        $this->subject = $value;
    }

    function setmsg($value)
    {
        $this->msg = $value;
    }

    function send()
    {
        $mail = new PHPMailer();
        $mail->isSMTP();
      #$mail->SMTPSecure = 'tls';
      /*$mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );*/
        $mail->SMTPAuth = false;
        $mail->SMTPDebug = 2;
        #$mail->SetLanguage('br', __DIR__ . "/language/");
        $mail->Host = gethostbyname($this->host);
        $mail->Host = $this->host;
        $mail->Port = $this->port;
        $mail->SMTPAuth = $this->SMTPauth;
        $mail->Username = $this->username;
        $mail->Password = $this->Password;
        $mail->SetFrom($this->from, 'Yatode');
        $mail->AddReplyTo($this->replyto, 'Yatode');
        $mail->AddAddress($this->addAddress, 'Yatode');
        $mail->Subject = $this->subject;
        $mail->MsgHTML($this->msg);
        if (! $mail->send()) {
            $out = 'Mailer Error: ' . $mail->ErrorInfo . " : " . $mail->errorMessage ;
            debug::log($out);
            
            #page::addBody($mail->Host . ":" . $mail->Port . ":"  . $mail->Username . ":"  . $mail->Password . ":"  . $this->addAddress . ":" );
            page::addBody("$out : $this->addAddress");
            debug::log(":" . $this->username . ":" . $this->Password . ":");
            return $out;
        } else {
            debug::log('Message sent!');
            return 'Message sent!';
        }
    }
}