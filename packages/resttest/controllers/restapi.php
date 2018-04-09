<?php 

class restapi extends controller {
	
	function receiver() {
		
		 $out['saida'] = 1;
		 $out['valor'] = 16565;
		 $out['tipo'] = $this->requestType;
		 $out['enviado'] = $this->request;
		 $out['dados'] = base64_encode(date('s'));
		 debug::log(json_encode($out));
		 page::addBody(json_encode($out));
		 page::renderAjax();
		 
	}
	
	
	function index() {
		
		
		$r = new rest();
		$r->setcallPut();
		$r->seturl(config::siteRoot() . "/index.php//restapi/receiver/");
		$r->run();
		
		$form = new formEasy();
		$form->action(config::siteRoot() . "/index.php//restapi/receiver/")->method('PUT')->openform();
		$form->addText("Campo1", 'campo1', $value);
		$form->addText("Campo2", 'campo2', $value);
		$form->type('submit')->value('OK')->done();
		page::addBody($form->printform());
		page::render();
		
	}
	
	
}