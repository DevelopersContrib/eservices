<?php

class Sitemap extends Controller {
	
	function index()
	{
		$api = $this->loadModel('ApiModel');
		$helper = $this->loadHelper('Url_helper');
		$info = $api->getdomaininfo();
		
		$template = $this->loadView('sitemap');
		$template->set('domain', $info['domain']);
		$template->render();
		
	}
    
}

?>
