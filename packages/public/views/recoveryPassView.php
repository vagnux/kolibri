<?php


class recoveryPassView
{
    
    function formMail() {
        
        page::addBody("<h3>Recuperar Senha</h3>");
        
        $form = new formEasy();
        $form->method('post')
        ->action(config::siteRoot() . "/index.php/recoveryPass/send/")
        ->openForm();
        $form->addText("Seu login (e-mail)", 'mailLogin', '');
        $form->type('submit')
        ->value('Enviar')
        ->class('btn btn-primary')
        ->done();
        $form->closeForm();
        page::addBody( $form->printform() );
        page::render();
    }
    
    
    function changePass($hash) {
        
        $form = new formEasy();
        $form->method('post')
        ->action(config::siteRoot() . "/index.php/recoveryPass/changePass/")
        ->openForm();
        $form->addPasswordCad("Senha", 'password', '');
        $form->type('hidden')->name('rash')->value($hash)->done();
        $form->type('submit')
        ->value('Enviar')
        ->class('btn btn-primary')
        ->done();
        $form->closeForm();
        page::addBody( $form->printform() );
        page::render();
        
    }
    
}

