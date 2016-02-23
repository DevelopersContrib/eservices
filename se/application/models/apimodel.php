<?php
include("php_fast_cache.php");

class ApiModel extends Model {
	
	private $api_url = "http://api1.contrib.co/request/";
	private $headers = array('Accept: application/json');
	
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
	
	function getdomain(){
		global $domain;
	 	return $domain;
	}

	function getkey(){
		return md5($this->getdomain());
	}
	
	function getdomaininfo(){
		global $domainid;
        global $title;
        global $logo;
        global $description;
        global $account_ga;
        global $description;
		global $domain;
			  	$info['domainid'] = $domainid;
		    	$info['domain'] = $domain;
		    	$info['title'] = $title;
		    	$info['logo'] = $logo;
		    	$info['description'] = $description;
		    	$info['account_ga'] = $account_ga;
		    	$info['description'] = stripslashes(str_replace('\n','<br>',$info['description']));
		
		return $info;
   }
   
	
   
	function getattributes(){
		
		global $background_image;
        global $top_description;
        global $forsale;
        global $showforsaledefault;
        global $forsaletext;
        global $additional_html;
        
		    	
		    	$info['background_image'] = $background_image;
    		    $info['top_description'] = $top_description;
    		    $info['top_description'] = stripslashes(str_replace('\n','<br>',$info['top_description']));
    		
    		    $info['forsale'] = $forsale;
    		    $info['forsaletext'] = $forsaletext;
    		    $info['showforsaledefault'] = $showforsaledefault;
    		    $info['additional_html'] = $additional_html;
    	
    		    if($info['forsaletext']=='') $info['forsaletext'] = 'This domain belongs to the Global Ventures network. We have interesting opportunities for work, sponsors and partnerships.';
    
       return $info;
   }
   
	function getbanner(){
		    $url = $this->api_url.'getbannercode?d='.$this->getdomain().'&p=footer';
		    $result = $this->createApiCall($url, 'GET', $this->headers, array());
		    $data_ads = json_decode($result,true);
            $banner = html_entity_decode(base64_decode($data_ads['data']['content']));
	       
        return $banner;
	}
   
	
	function getaffiliatelink(){
		global $domain_affiliate_link;
		
        return $domain_affiliate_link;
	}
	
	function getwidgets($type){
		global $data_widget_users;
        global $data_widget_jobs;
		$widgets = array();
		$widgets['users'] = $data_widget_users;
		$widgets['jobs'] = $data_widget_jobs;
		return $widgets[$type];
	}
	
	function getsignupformdata(){
		global $rolesarray ;
        global $countriesarray;
        global $industriesarray;
        
		$formdata = array();
	    $formdata['data']['roles'] = $rolesarray;
		$formdata['data']['countries'] = $countriesarray;
		$formdata['data']['industries'] = $industriesarray;
		
        return $formdata;
	}
   
	function getpartners(){
		    $result = $this->createApiCall($url, 'GET', $this->headers, array());
		    $partners_result = json_decode($result,true);
		    $partners = array();  
	        if ($partners_result['success']){
		          $partners = $partners_result;
	         }	
        return $partners;
	}
	
	function getleadscount(){
        
		    $url = $this->api_url.'getdomainleadscount?domain='.$this->getdomain().'&key='.$this->getkey();
		    $result = $this->createApiCall($url, 'GET', $this->headers, array());
		    $data_follow_count = json_decode($result,true);
			 if ($data_follow_count['success']){
			    	$leads = ($data_follow_count['data']['leads'] + 1 ) * 25;
			    }else {
			    	$leads = 1 * 25;
			}
	    return $leads;
	}
	
	
	function createrobots(){
		//	generate robots.txt if not exist
		$filename = ROOT_DIR .'/robots.txt';
		//if(!(file_exists($filename))) {
		$my_file = ROOT_DIR .'/robots.txt';
		$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
		$data = '---BEGIN ROBOTS.TXT ---
		User-Agent: *
		Disallow:
		
		Sitemap: http://'.$this->getdomain().'/sitemap
		--- END ROBOTS.TXT ----';
		fwrite($handle, $data);
	}
	
	function getverticaldomains(){
		    $url = 'http://api2.contrib.com/request/getverticaldomains?domain='.$this->getdomain().'&key='.$this->getkey();
		    $result = $this->createApiCall($url, 'GET', $this->headers, array());
		    $data_domains = json_decode($result,true);
			 if ($data_domains['success']){
			    $related_domains = $data_domains['data'];
			}
	    return $related_domains;
	}
   
   function getrelatedverticals(){
		/*$url = $this->api_url.'getrelateddomains?domain='.$this->getdomain().'&limit=20';
		$result = $this->createApiCall($url, 'GET', $this->headers, array());
		$data = json_decode($result,true);
		$related_domains = array();
		if ($data['success']){
			$related_domains = $data['data'];
		}*/
		global $vertical_domains;
		
		return $vertical_domains;        
	}
	
   function getrelatedverticalsnologo(){
		/*$url = $this->api_url.'getrelateddomainsnologo?domain='.$this->getdomain().'&limit=20';
		$result = $this->createApiCall($url, 'GET', $this->headers, array());
		$data = json_decode($result,true);
		$related_domains = array();
		if ($data['success']){
			$related_domains = $data['data'];
		}*/
		
		global $vertical_domains_nologo;
		
		return $vertical_domains_nologo;         
	}
	
	function getfundcampaigns(){
		
		global $fundcampaigns; 
		
		return $fundcampaigns; 
	}
	   
} //end of model
?>
