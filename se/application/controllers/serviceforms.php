<?php

class ServiceForms extends Controller {
	
	function partner()
	{
		
		$api = $this->loadModel('ApiModel');
		$helper = $this->loadHelper('Url_helper');
		$info = $api->getdomaininfo();
		$attr = $api->getattributes();
		$formdata = $api->getsignupformdata();
		//if ($formdata['success']){
    	 $rolesarray = $formdata['data']['roles'];
    	 $countriesarray = $formdata['data']['countries'];
    	 $industriesarray = $formdata['data']['industries'];
    	 $parnershiptypes = array('Sponsorship Marketing Partnerships','Distribution Marketing Partnerships','Affiliate Marketing Partnerships','Added Value Marketing Partnerships');
      //  }	
        
		$template = $this->loadView('serviceforms/service_partner');
		$template->set('countriesarray',$countriesarray);
		$template->set('rolesarray',$rolesarray);
		$template->set('industriesarray',$industriesarray);
		$template->set('parnershiptypes',$parnershiptypes);
		$template->set('formdata', $formdata);
		$template->set('info', $info);
		$template->set('attr', $attr);
		$template->set('base_url',$helper->base_url());
		$template->render();
	}
	
function staffing()
	{
		
		$api = $this->loadModel('ApiModel');
		$helper = $this->loadHelper('Url_helper');
		$info = $api->getdomaininfo();
		$attr = $api->getattributes();
		$formdata = $api->getsignupformdata();
		//if ($formdata['success']){
    	 $rolesarray = $formdata['data']['roles'];
    	 $countriesarray = $formdata['data']['countries'];
    	 $industriesarray = $formdata['data']['industries'];
    	 $parnershiptypes = array('Sponsorship Marketing Partnerships','Distribution Marketing Partnerships','Affiliate Marketing Partnerships','Added Value Marketing Partnerships');
       // }	
        
		$template = $this->loadView('serviceforms/service_staffing');
		$template->set('countriesarray',$countriesarray);
		$template->set('rolesarray',$rolesarray);
		$template->set('industriesarray',$industriesarray);
		$template->set('parnershiptypes',$parnershiptypes);
		$template->set('formdata', $formdata);
		$template->set('info', $info);
		$template->set('attr', $attr);
		$template->set('base_url',$helper->base_url());
		$template->render();
	}
	
function offer()
	{
		
		$api = $this->loadModel('ApiModel');
		$helper = $this->loadHelper('Url_helper');
		$info = $api->getdomaininfo();
		$attr = $api->getattributes();
		$formdata = $api->getsignupformdata();
		//if ($formdata['success']){
    	 $rolesarray = $formdata['data']['roles'];
    	 $countriesarray = $formdata['data']['countries'];
    	 $industriesarray = $formdata['data']['industries'];
    	 $parnershiptypes = array('Sponsorship Marketing Partnerships','Distribution Marketing Partnerships','Affiliate Marketing Partnerships','Added Value Marketing Partnerships');
     //   }	
        
		$template = $this->loadView('serviceforms/service_offer');
		$template->set('countriesarray',$countriesarray);
		$template->set('rolesarray',$rolesarray);
		$template->set('industriesarray',$industriesarray);
		$template->set('parnershiptypes',$parnershiptypes);
		$template->set('formdata', $formdata);
		$template->set('info', $info);
		$template->set('attr', $attr);
		$template->set('base_url',$helper->base_url());
		$template->render();
	}
	
function inquire()
	{
		
		$api = $this->loadModel('ApiModel');
		$helper = $this->loadHelper('Url_helper');
		$info = $api->getdomaininfo();
		$attr = $api->getattributes();
		$formdata = $api->getsignupformdata();
		//if ($formdata['success']){
    	 $rolesarray = $formdata['data']['roles'];
    	 $countriesarray = $formdata['data']['countries'];
    	 $industriesarray = $formdata['data']['industries'];
    	 $parnershiptypes = array('Sponsorship Marketing Partnerships','Distribution Marketing Partnerships','Affiliate Marketing Partnerships','Added Value Marketing Partnerships');
      //  }	
        
		$template = $this->loadView('serviceforms/service_inquire');
		$template->set('countriesarray',$countriesarray);
		$template->set('rolesarray',$rolesarray);
		$template->set('industriesarray',$industriesarray);
		$template->set('parnershiptypes',$parnershiptypes);
		$template->set('formdata', $formdata);
		$template->set('info', $info);
		$template->set('attr', $attr);
		$template->set('base_url',$helper->base_url());
		$template->render();
	}
    
}

?>
