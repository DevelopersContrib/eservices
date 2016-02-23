<?php

class Referral extends Controller {
	
	function index()
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
		$template = $this->loadView('referral');		
		$metatitle = 'Referral';
		$template->set('metatitle', $metatitle);
		$template->set('info', $info);
		$template->set('attr', $attr);
		$template->set('domain_affiliate_link',$api->getaffiliatelink());
		$template->set('follow_count',$api->getleadscount());
		$template->set('data_widget_users',$api->getwidgets('users'));
		$template->set('data_widget_jobs',$api->getwidgets('jobs'));
		$template->set('countriesarray',$countriesarray);
		$template->set('rolesarray',$rolesarray);
		$template->set('industriesarray',$industriesarray);
		$template->set('parnershiptypes',$parnershiptypes);
		$template->set('formdata', $formdata);
		$template->set('footer_banner', $api->getbanner());
		$template->set('forsale', $api->getbanner());
		$template->set('base_url',$helper->base_url());
		$template->set('partners',$api->getpartners());
		$template->render();
	}
    
}

?>
