<?php 
function createApiCall($url, $method, $headers, $data = array(),$user=null,$pass=null)
{
        if (($method == 'PUT') || ($method=='DELETE'))
        {
            $headers[] = 'X-HTTP-Method-Override: '.$method;
        }

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        if ($user){
         curl_setopt($handle, CURLOPT_USERPWD, $user.':'.$pass);
        } 

        switch($method)
        {
            case 'GET':
                break;
            case 'POST':
                curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'PUT':
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'PUT');
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($data));
                break;
            case 'DELETE':
                curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }
        $response = curl_exec($handle);
        return $response;
}
   $api_url = "http://api1.contrib.co/request/";
   $headers = array('Accept: application/json');
   
if (!file_exists('config-framework.php')) {
     
    $file = file_get_contents('config-template.php');
    
    $domain = $_SERVER["HTTP_HOST"]."".$_SERVER['REQUEST_URI'];//input sitename without www
    //$domain = 'http://www.javapoint.com';
    
    if(stristr($domain, '~') ===FALSE) {
    	$domain = $_SERVER["HTTP_HOST"];
        $domain = str_replace("http://","",$domain);
    	$domain = str_replace("www.","",$domain);
    	$key = md5($domain);
    }else {
       $key = md5('vnoc.com');
       $d = explode('~',$domain);
       $user = str_replace('/','',$d[1]);
        $host = $_SERVER["HTTP_HOST"];
		$host = str_replace("http://","",$host);
		$host = str_replace("www.","",$host);
		$url = $api_url.'getdomainbyusername?username='.$user.'&key='.$key.'&host='.$host;
       $result =  createApiCall($url, 'GET', $headers, array());
       $data_domain = json_decode($result,true);
       $error = 0;
       $domain =   $data_domain['data']['domain'];
    	
    }
    
    
    $data_domain = NULL;
    while ($data_domain == NULL){
      $url = $api_url.'getdomaininfo?domain='.$domain.'&key='.$key;
      $result = createApiCall($url, 'GET', $headers, array());
      $data_domain = json_decode($result,true);
    }
    
    if ($data_domain['success']){
    	$domainid = $data_domain['data']['DomainId'];
    	$domainname = $data_domain['data']['DomainName'];
    	$memberid = $data_domain['data']['MemberId'];
    	$title = $data_domain['data']['Title'];
    	$logo = $data_domain['data']['Logo'];
    	$description = $data_domain['data']['Description'];
    	$account_ga = $data_domain['data']['AccountGA'];
    	$description = stripslashes(str_replace('\n','<br>',$description));
    	
      $url2 = $api_url.'getdomainattributes?domain='.$domain.'&key='.$key;
      $result2 = createApiCall($url2, 'GET', $headers, array());
    	$data_domain2 = json_decode($result2,true);
    	
      if($data_domain2['success']){
    		$background_image = $data_domain2['data']['background_image_url'];
    		$top_description = $data_domain2['data']['top_description'];
    		$top_description = stripslashes(str_replace('\n','<br>',$top_description));
    		
    		$forsale = $data_domain2['data']['show_for_sale_banner'];
    		$forsaletext = $data_domain2['data']['for_sale_text'];
			$showforsaledefault = $data_domain2['data']['show_for_sale_banner_DefaultValue'];
    		$additional_html = $data_domain2['data']['additional_html'];
    	
    		if($forsaletext=='') $forsaletext = 'This domain belongs to the Global Ventures network. We have interesting opportunities for work, sponsors and partnerships.';
    		
    		 $url3 = $api_url.'GetPiwikId?domain='.$domain.'&key='.$key;
         $result3 = createApiCall($url3, 'GET', $headers, array());
    	   $data_domain3 = json_decode($result3,true);
         $piwik_id = $data_domain3['data']['idsite'];
     
     
    	}else{
    		$error++;
    	}
    			
         
		  
    }else {
    	$error++;
    }
    
    
    //get monetize ads from vnoc
    $url = $api_url.'getbannercode?d='.$domain.'&p=footer';
    $result = createApiCall($url, 'GET', $headers, array());
    $data_ads = json_decode($result,true);
    $footer_banner = html_entity_decode(base64_decode($data_ads['data']['content']));
    
    //get domain affiliate id
    $url = $api_url.'getdomainaffiliateid?domain='.$domain.'&key='.$key;
    $result = createApiCall($url, 'GET', $headers, array());
    $data_domain_affiliate = json_decode($result,true);
    if ($data_domain_affiliate['success']){
    	$domain_affiliate_id = $data_domain_affiliate['data']['affiliate_id'];
    }else {
    	$domain_affiliate_id = '391'; //contrib.com affiliate id
    }
    $domain_affiliate_link = 'http://referrals.contrib.com/idevaffiliate.php?id='.$domain_affiliate_id.'&url=http://www.contrib.com/signup/firststep?domain='.$domain;
    
    
    	
    //get Widget Users
    $url = $api_url.'getwidget?ma=users&key='.$key;
    $result = createApiCall($url, 'GET', $headers, array());
    $data_widget_users = json_decode($result,true);
    
    	
    //get Widget Jobs
    $url = $api_url.'getwidget?ma=jobs&key='.$key;
    $result = createApiCall($url, 'GET', $headers, array());
    $data_widget_jobs = json_decode($result,true);
    
    //get form option selects
    $url = $api_url.'getsignupformdata';
    $result = createApiCall($url, 'GET', $headers, array());
    $data_signup = json_decode($result,true);
    
    if ($data_signup['success']){
    	$rolesarray = $data_signup['data']['roles'];
    	$countriesarray = $data_signup['data']['countries'];
    	$industriesarray = $data_signup['data']['industries'];
    	$parnershiptypes = array('Sponsorship Marketing Partnerships','Distribution Marketing Partnerships','Affiliate Marketing Partnerships','Added Value Marketing Partnerships');
    }	
	
	//get related domains
	$url = $api_url.'getverticaldomains?domain='.$domain.'&key='.$key;
    $result = createApiCall($url, 'GET', $headers, array());
    $data_domains = json_decode($result,true);
	$related_domains = array();
	if ($data_domains['success']){
		$related_domains = $data_domains['data'];
	}
	
	//get related domains with logos only and with category slug
	$url = $api_url.'getrelateddomains?domain='.$domain.'&limit=20';
	$result = createApiCall($url, 'GET', $headers, array());
	$data = json_decode($result,true);
	$vertical_domains = array();
	if ($data['success']){
		$vertical_domains = $data['data'];
	}
	
	//get related domains with nologos and with category slug
	$url = $api_url.'getrelateddomainsnologo?domain='.$domain.'&limit=20';
	$result = createApiCall($url, 'GET', $headers, array());
	$data = json_decode($result,true);
	$vertical_domains_nologo = array();
	if ($data['success']){
		$vertical_domains_nologo = $data['data'];
	}
	
	//get fund campaigns
	$url = $api_url.'getfundcampaigns';
	$result = createApiCall($url, 'GET', $headers, array());
	$data = json_decode($result,true);
	$fundcampaigns = array();
	if ($data['success']){
		$fundcampaigns = $data['data'];
	}
	
    //create file
  
   $file = str_replace('{{DOMAIN}}',$domain , $file);
   $file = str_replace('{{DOMAIN_ID}}',$domainid , $file);
   $file = str_replace('{{MEMBER_ID}}',$memberid, $file);
   $file = str_replace('{{TITLE}}',$title, $file);
   $file = str_replace('{{LOGO}}',$logo, $file);
   $file = str_replace('{{DESCRIPTION}}',$description, $file);
   $file = str_replace('{{ACCOUNT_GA}}',$account_ga, $file);   
   $file = str_replace('{{PIWIK_ID}}',$piwik_id, $file);
   $file = str_replace('{{BACKGROUND_IMAGE}}',$background_image, $file);
   $file = str_replace('{{TOP_DESCRIPTION}}',$top_description, $file);
   $file = str_replace('{{SHOW_FOR_SALE}}',$forsale, $file);
   $file = str_replace('{{SHOW_FOR_SALE_DEFAULT}}',$showforsaledefault, $file);
   $file = str_replace('{{FOR_SALE_TEXT}}',$forsaletext, $file);
   $file = str_replace('{{ADDITIONAL_HTML}}',$additional_html, $file);
   $file = str_replace('{{FOOTER_BANNER}}',$footer_banner, $file);
   $file = str_replace('{{AFF_LINK}}',$domain_affiliate_link, $file);
   $file = str_replace('{{WIDGETS}}',var_export($data_widget_users, true), $file);
   $file = str_replace('{{JOBS}}',var_export($data_widget_jobs, true), $file);
   $file = str_replace('{{ROLES}}',var_export($rolesarray, true), $file);
   $file = str_replace('{{COUNTRIES}}',var_export($countriesarray, true) , $file);
   $file = str_replace('{{INDUSTRIES}}',var_export($industriesarray, true), $file);
   $file = str_replace('{{RELATED_DOMAINS}}',var_export($related_domains, true), $file);
   $file = str_replace('{{VERTICAL_DOMAINS}}',var_export($vertical_domains, true), $file);
   $file = str_replace('{{VERTICAL_DOMAINS_NOLOGO}}',var_export($vertical_domains_nologo, true), $file);
   $file = str_replace('{{FUND_CAMPAIGNS}}',var_export($fundcampaigns, true), $file);
   file_put_contents('config-framework.php', $file);
}

include "./config-framework.php";

$key = md5($domain);
$url = $api_url.'getpartners?domain='.$domain.'&key='.$key;
	$result = createApiCall($url, 'GET', $headers, array());
	$partners_result = json_decode($result,true);
	$partners = array();  
	if ($partners_result['success']){
		$partners = $partners_result;
	}	
  
	//get number of leads for counter
    $url = $api_url.'getdomainleadscount?domain='.$domain.'&key='.$key;
    $result = createApiCall($url, 'GET', $headers, array());
    $data_follow_count = json_decode($result,true);
    if ($data_follow_count['success']){
    	$follow_count = ($data_follow_count['data']['leads'] + 1 ) * 25;
    }else {
    	$follow_count = 1 * 25;
    }

if(defined('ENV')){
$config['base_url'] = 'http://localhost/leadv2/'; // Base URL including trailing slash (e.g. http://localhost/)
}else{
$config['base_url'] = '/';	
}
$config['default_controller'] = 'home'; // Default controller to load
$config['error_controller'] = 'error'; // Controller used for errors (e.g. 404, 500 etc)

$config['db_host'] = ''; // Database host (e.g. localhost)
$config['db_name'] = ''; // Database name
$config['db_username'] = ''; // Database username
$config['db_password'] = ''; // Database password

?>