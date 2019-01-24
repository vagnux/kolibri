<?php

class recoveryPass extends controller
{

    function index()
    {
        $v = new recoveryPassView();
        $v->formMail();
    }

    function send()
    {
        $sys = new auth();
        $sys->users->loadLogin($this->request['mailLogin']);

        if ($sys->users->getidusers()) {

            $rash = md5($sys->users->getidusers() . date('Y-m-d H:i:s'));
            $db = new mydataobj();
            $db->setconn(database::kolibriDB());
            $db->setidusers($sys->users->getidusers());
            $db->setdateCreate(date('Y-m-d H:i:s'));
            $db->setrash($rash);
            $db->save();

            $to = $sys->users->getlogin();
            $from = 'norepy@yatode.com.br';
            $subject = config::siteName() . " Recuperar a senha " . date('d/m/Y');
            $link = config::siteRoot() . "/index.php/recoveryPass/change/?target=$rash";
            $userName = $sys->users->getuserName();
            $logo = config::siteRoot() . '/' . config::logoSite();

            $msg = "
            <img src='$logo'>
            <h3>Alterar senha</h3>
            Ol&aacute; $userName.<br>
            Para alterar a senha acesse o link abaixo ou copie e cole na barra de endere&ccedil;o do seu navegador<br>


            <a href='$link'>$link</a><br><br>
            ";
            unset($db);
            $db = new mydataobj();
            $db->setconn(database::kolibriDB());
            $db->settable('passRecovery');
            $db->debug(1);
            $db->setidusers($sys->users->getidusers());
            $db->setdateCreate(date('Y-m-d H:i:s'));
            $db->setrash($rash);
            $db->setusado('-1');
            $db->save();
            
            yatodemail::send($to, $from, $subject, $msg);
            
            
            
            page::addJsScript('alert("Um email foi enviado para sua caixa de mensagem com um link para troca de email")');
            $this->index();
            
        } else {

            page::addJsScript('alert("Desculpe mas este login não existe")');
            $this->index();
        }
    }
    
    function change() {
        
        
        if ( $this->request['target']) {
            
            $db = new mydataobj();
            $db->setconn(database::kolibriDB());
            $db->settable('passRecovery');
            $db->addkey('rash', $this->request['target']);
            $db->addkey('usado', '-1');
            $db->debug(1);
            if ( $db->getidusers()) {
                $v = new recoveryPassView();
                $v->changePass($this->request['target']);
            }else{
                page::addBody("<p> Link invalido ou já utilizado </p>");
                page::render();
            }
            
            
        }
        
        
    }
    
    
    function changePass() {
        
        if ( $this->request['rash']) {
            
            $db = new mydataobj();
            $db->setconn(database::kolibriDB());
            $db->settable('passRecovery');
            $db->addkey('rash', $this->request['rash']);
            $db->addkey('usado', '-1');
            
            if ( $db->getidusers()) {
                $id = $db->getidpassRecovery();
                $sys = new auth();
                $sys->users->load($db->getidusers());
                $sys->users->setPassword($this->request['passwordA']);
                $sys->users->save();
                $db->setusado('1');
                $db->save();                
                
                
                page::addBody("<p> Senha alterada com sucesso</p>");
                page::render();
            
            }else{
                page::addBody("<p> Link invalido ou já utilizado </p>");
                page::render();
            }
            
            
        }else{
            page::addBody("<p> Link invalido ou já utilizado </p>");
            page::render();
        }
        
    }
}

