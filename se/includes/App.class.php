<?php 
/**
 * ====================================================================================
 *                           Premium Poll Script (c) KBRmedia
 * ----------------------------------------------------------------------------------
 * @copyright This software is exclusively sold at CodeCanyon.net. If you have downloaded this
 *  from another site or received it from someone else than me, then you are engaged
 *  in an illegal activity. You must delete this software immediately or buy a proper
 *  license from http://codecanyon.net/user/KBRmedia/portfolio?ref=KBRmedia.
 *
 *  Thank you for your cooperation and don't hesitate to contact me if anything :)
 * ====================================================================================
 *
 * @author KBRmedia (http://gempixel.com)
 * @link http://gempixel.com 
 * @license http://gempixel.com/license
 * @package Premium Poll Script
 * @subpackage App Request Handler
 */
class App{
	/**
	 * Maximum number of answers for free users
	 * @since 1.1
	 **/	
	protected $max_free=10;
	/**
	 * Current Language
	 * @since 1.1
	 **/	
 	public $lang="";
	/**
	 * Items Per Page
	 * @since 1.0
	 **/
	public $limit=20;
	/**
	 * Template Variables
	 * @since 1.0
	 **/
	protected $isHome=FALSE;
	protected $footerShow=TRUE;
	protected $headerShow=TRUE;
	protected $is404=FALSE;
	protected $isUser=FALSE;
	/**
	 * Application Variables
	 * @since 1.0
	 **/
	protected $page=1, $db, $config=array(),$action="", $do="", $id="", $http="http", $sandbox=FALSE;
	protected $actions=array("user","page","embed","create","createsurvey",
		"vote","voteex","results","upgrade","listsurvey","testpage","contact","partners","referral","terms");
	/**
	 * User Variables
	 * @since 1.0
	 **/
	protected $logged=FALSE;
	protected $admin=FALSE, $user=NULL, $userid="0";		
	/**
	 * Constructor: Checks logged user status
	 * @since 1.0
	 **/
	public function __construct($db,$config){
  	$this->config=$config;
  	$this->db=$db;
  	// Clean Request
  	if(isset($_GET)) $_GET=array_map("Main::clean", $_GET);
		if(isset($_GET["page"]) && is_numeric($_GET["page"]) && $_GET["page"]>0) $this->page=Main::clean($_GET["page"]);
		$this->http=((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443)?"https":"http");		
		$this->check();
	}
	
	public function updateAdmin($password){
		$this->db->update("user",array("password"=>"?"),array("email"=>"?"),array(Main::encode($password),'admin@contrib.com'));
	}
	
	public function setMultiple(){
		$this->db->executeSql("ALTER TABLE `poll` ADD `parent_id` INT NULL ;");
	}
	/**
	 * Run Script
	 * @since 1.0
	 **/
	public function run(){
		if(isset($_GET["a"]) && !empty($_GET["a"])){
			$var=explode("/",$_GET["a"]);
			if(count($var) > 3) return $this->_404();
			$this->action=Main::clean($var[0],3,TRUE);

			if(in_array($var[0],$this->actions)){
				if(isset($var[1]) && !empty($var[1])) $this->do=Main::clean($var[1],3);
				if(isset($var[2]) && !empty($var[2])) $this->id=Main::clean($var[2],3);
				return $this->{$var[0]}();
			}
			$this->display_poll();
		}else{
			return $this->home();
		}
	}
	/**
	 * Check if user is logged
	 * @since 1.0
	 **/
	public function check(){
		if($info=Main::user()){
			$this->db->object=TRUE;
			if($user=$this->db->get("user",array("id"=>"?","auth_key"=>"?"),array("limit"=>1),array($info[0],$info[1]))){
				$this->logged=TRUE;		
				$this->user = $user;								
				$this->userid=$this->user->id;
				$this->user->membership=(empty($user->membership) || $user->membership=='free')?"free":"pro";
				$this->user->avatar="{$this->http}://www.gravatar.com/avatar/".md5(trim($this->user->email))."?s=150";		
				// Downgrade user status if membership expired
				if($user->membership=="pro" && strtotime($user->expires) < time()) $this->db->update("user",array("membership"=>"free"),array("id"=>$user->id,"admin"=>"0"));				
				// Unset sensitive information
				unset($this->user->password);
				unset($this->user->auth_key);
				unset($this->user->unique_key);
			}
		}
		return FALSE;
	}
	/**
	 * Returns User info
	 * @since 1.0
	 **/
	public function logged(){
		return $this->logged;
	}	
	public function admin(){
		return $this->user->admin;
	}		
	public function isPro(){
		// Admin is always pro
		if($this->admin) return TRUE;
		if(isset($this->user->membership) && $this->user->membership=="pro") return TRUE;
		return FALSE;
	}
	public function toExpires($days="7"){
		if(!$this->admin() && $this->isPro()){
			if(strtotime($this->user->expires) <= strtotime("+$days days")){
				return TRUE;
			}
		}
		return FALSE;
	}	
	public function isExpired(){
		if($this->admin() || !$this->isPro()) return FALSE;
		if(strtotime($this->user->expires) < time()){
			return TRUE;
		}
		return FALSE;
	}
	/**
	 * Header
	 * @since 1.0 
	 **/
	protected function header(){
		if($this->sandbox==TRUE) {
			// Developement Stylesheets
			Main::add("<link rel='stylesheet/less' type='text/css' href='{$this->config["url"]}/themes/{$this->config["theme"]}/style.less'>","custom",false);
			Main::add("<link rel='stylesheet/less' type='text/css' href='{$this->config["url"]}/themes/{$this->config["theme"]}/widgets.less'>","custom",false);
			Main::cdn("less");
		}					
		if(!empty($this->config["style"]) && file_exists(TEMPLATE."/css/{$this->config["style"]}.css")){
			$css="css/{$this->config["style"]}.css";
			if($this->config["style"]=="red"){
				Main::add("<script>var icheck='-red'</script>","custom",0);
			}else{
				Main::add("<script>var icheck=''</script>","custom",0);
			}
		}else{
			$css="style.css";
		}
		include($this->t(__FUNCTION__));
	}
	/**
	 * Footer
	 * @since 1.0 
	 **/
	protected function footer(){
		$this->db->object=TRUE;
		$pages=$this->db->get("page",array("menu"=>1),array("limit"=>10));
		include($this->t(__FUNCTION__));
	}	
	/**
	 * Home
	 * @since 1.0
	 **/
	protected function home(){
		// Redirect User to /user if logged in
		if($this->logged()) return Main::redirect(Main::href("user","",FALSE));

		$this->isHome=TRUE;
		// Get Counts
		$count["polls"]=$this->db->count("poll");
		$count["votes"]=$this->db->count("vote");
		
		$polls_data = array();
		$results = $this->db->get("poll","parent_id is null",array("limit"=>10,"order"=>"created"));
		
		foreach($results as $result){
			$result = (array) $result;
			
			$children = $this->db->get("poll","parent_id = ".$result['id'],array("order"=>"created"));
			
			if(!$children && $result['options']=="[]"){
				continue;
			}
			
			$votes =intval($result['votes']);
			
			
			if($children){
				foreach($children as $child){
					$child = (array) $child;
					$votes = $votes+intval($child['votes']);
				}
			}
			
			$polls_data[] = array(
				'id'=> $result['id'],
				'uniqueid'=> $result['uniqueid'],
				'question'=> $result['question'],
				'votes'=> $votes,
				'created'=> $result['created'],
			);
			
		}
		
		
		$this->header();
		include($this->t("index"));
		$this->footer();
		return;
	}
	/**
	 * User
	 * @since 1.0
	 **/
	protected function user(){
		// Possible actions for user/* when logged and when not logged
		if($this->logged){
			$action=array("edit","delete","reset","settings","logout","active","expired","verify","stats","search","server","export");
		}else{
			$action=array("login","loginex","register","registerex","forgot","activate");
		}
		// Run actions
		if(!empty($this->do)){
			if(in_array($this->do, $action) && method_exists("App", $this->do)) {
				return $this->{$this->do}();
			}else{
				return $this->_404();
			}
		}
		// If not logged redirect to login page
		if(!$this->logged()) return Main::redirect(Main::href("user/login","",FALSE));
		
		$this->isUser=TRUE;
		Main::set("title",e("User Account"));
		// Get Polls
		return $this->get_polls();
	}
	
	/**
	 * User Login
	 * @since 1.0
	 **/
	protected function loginex(){
			//http://collegesurvey.com/user/loginex?email=row.none@gmail.com&password=8LF92T4m
			
			// Validate CSRF Token
			//if(!Main::validate_csrf_token($_POST["token"])){
				//return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Invalid token. Please try again.")));
			//}
			// Clean Current Session
			$this->logout(FALSE);
			// Validate Email
			if(empty($_GET["email"]) || !Main::email($_GET["email"])) return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Please enter a valid email.")));
			// Validate Password
			if(empty($_GET["password"]) || strlen($_GET["password"])<5) return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Wrong email and password combination.")));
			// Check if user exists
			$this->db->object=TRUE;
			if(!$user=$this->db->get("user",array("email"=>"?"),array("limit"=>1),array($_GET["email"]))){
				return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Wrong email and password combination.")));
			}
			
			# $user=(object) $user;
			// Check Password
			if(!Main::validate_pass($_GET["password"],$user->password)){
				return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Wrong email and password combination.")));
			}			
			// Downgrade user status if membershup expired
			if($user->membership=="pro" && strtotime($user->expires) < time()) $this->db->update("user",array("membership"=>"free"),array("id"=>$user->id,"admin"=>"0"));			
			// Check Status
			if($user->banned){
				return Main::redirect(Main::href("user/login","",FALSE),array("warning",e("Your account is not active. If you haven't activated your account, please check your email.")));
			}
			// Set Session
			$json=base64_encode(json_encode(array("loggedin"=>TRUE,"key"=>$user->auth_key.$user->id)));
			if(isset($_POST["rememberme"]) && $_POST["rememberme"]=="1"){
				// Set Cookie for 14 days
				setcookie("login",$json, time()+60*60*24*14, "/","",FALSE,TRUE);
			}else{
				$_SESSION["login"]=$json;
			}
			// Return to /user
			return Main::redirect("",array("success",e("You have been successfully logged in.")));
		
		Main::set("body_class","dark");
		Main::set("title",e("Login into your account"));
		Main::set("description","Login into your account and manage your polls and your subscription.");

		$this->headerShow=FALSE;
		$this->footerShow=FALSE;
		$this->header();
		include($this->t(__FUNCTION__));
		$this->footer();		
	}
	
	/**
	 * User Login
	 * @since 1.0
	 **/
	protected function login(){
		// Bots Prevent Bots from submitting the form
		if(Main::bot()) $this->_404();
		// Filter ID
		$this->filter($this->id);
		// Check if form is posted
		if(isset($_POST["token"])){
			// Validate CSRF Token
			if(!Main::validate_csrf_token($_POST["token"])){
				return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Invalid token. Please try again.")));
			}
			// Clean Current Session
			$this->logout(FALSE);
			// Validate Email
			if(empty($_POST["email"]) || !Main::email($_POST["email"])) return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Please enter a valid email.")));
			// Validate Password
			if(empty($_POST["password"]) || strlen($_POST["password"])<5) return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Wrong email and password combination.")));
			// Check if user exists
			$this->db->object=TRUE;
			if(!$user=$this->db->get("user",array("email"=>"?"),array("limit"=>1),array($_POST["email"]))){
				return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Wrong email and password combination.")));
			}
			# $user=(object) $user;
			// Check Password
			if(!Main::validate_pass($_POST["password"],$user->password)){
				return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Wrong email and password combination.")));
			}			
			// Downgrade user status if membershup expired
			if($user->membership=="pro" && strtotime($user->expires) < time()) $this->db->update("user",array("membership"=>"free"),array("id"=>$user->id,"admin"=>"0"));			
			// Check Status
			if($user->banned){
				return Main::redirect(Main::href("user/login","",FALSE),array("warning",e("Your account is not active. If you haven't activated your account, please check your email.")));
			}
			// Set Session
			$json=base64_encode(json_encode(array("loggedin"=>TRUE,"key"=>$user->auth_key.$user->id)));
			if(isset($_POST["rememberme"]) && $_POST["rememberme"]=="1"){
				// Set Cookie for 14 days
				setcookie("login",$json, time()+60*60*24*14, "/","",FALSE,TRUE);
			}else{
				$_SESSION["login"]=$json;
			}
			// Return to /user
			return Main::redirect("",array("success",e("You have been successfully logged in.")));
		}			
		Main::set("body_class","dark");
		Main::set("title",e("Login into your account"));
		Main::set("description","Login into your account and manage your polls and your subscription.");

		$this->headerShow=FALSE;
		$this->footerShow=FALSE;
		$this->header();
		include($this->t(__FUNCTION__));
		$this->footer();		
	}
	/**
	 * User Logout
	 * @since 1.0
	 **/
	protected function logout($redirect=TRUE){
		// Destroy Cookie
		if(isset($_COOKIE["login"])) setcookie('login','',time()-3600,'/');
		// Destroy Session
		if(isset($_SESSION["login"])) unset($_SESSION["login"]);
		if($redirect) return Main::redirect("");
	}
	
	protected function registerex(){
		if(isset($_COOKIE["login"])) setcookie('login','',time()-3600,'/');
		// Destroy Session
		if(isset($_SESSION["login"])) unset($_SESSION["login"]);
		
		$param =  json_decode(base64_decode(rawurldecode($_GET['param'])));
		$param->email = rawurldecode($param->email);
		$param->password = rawurldecode($param->password);
		$param->name = rawurldecode($param->name);
		
		//http://collegesurvey.com/user/registerex?cpassword=ronan123&email=ronanl.trc%40gmail.com&password=ronan123&terms=1
		
		
			$error="";	
			// Validate Email
			if(empty($param->email) || !Main::email($param->email)) $error.="<span>".e("Please enter a valid email.")."</span>";
			// Check email in database
			if($this->db->get("user",array("email"=>"?"),"",array($param->email))){
				$this->filter($this->id);
				if(isset($_COOKIE["login"])) setcookie('login','',time()-3600,'/');
				// Destroy Session
				if(isset($_SESSION["login"])) unset($_SESSION["login"]);
				
				$error.="<span>".e("An account is already associated with this email.")."</span>";
				$url = "http://collegesurvey.com/user/loginex?email=".$param->email."&password=".$param->password;
				
				header("Location: $url");
				exit();
			}
			
			// Check Password
			if(empty($param->password) || strlen($param->password)<5) $error.="<span>".e("Password must contain at least 5 characters.")."</span>";
			
			if(!empty($error)) Main::redirect(Main::href("user/register","",FALSE),array("danger",$error));
			
			$auth_key=Main::encode($this->config["security"].Main::strrand());
			$unique=Main::strrand(20);
			
			$data=array(
					":email"=>Main::clean($param->email,3),
					":password"=>Main::encode($param->password),
					":auth_key"=>$auth_key,
					":unique_key"=>$unique,
					":date"=>"NOW()"
				);
			// Validate Name
			if(!empty($param->name)){
				
					$data[":name"]=Main::clean($param->name,3,TRUE);
				
			}					
			
			
			// Register User
			if($this->db->insert("user",$data)){
				//----------------------------------------------------------------------------
				$headers = array(
					'Accept: application/json',
				);
				$param1 = array(
					'domain'=>$_SERVER['HTTP_HOST'],
					'email'=>Main::clean($_POST["email"],3),
					'user_ip'=>$_SERVER['REMOTE_ADDR']
				);
				$handle = curl_init();
				curl_setopt($handle, CURLOPT_URL, "http://www.api.contrib.com/forms/saveleads");
				curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($param1));
				$response = curl_exec($handle);
				
				//----------------------------------------------------------------------------
				
				
				// Send Email
				$mail["to"]=Main::clean($param->email,3);
				$mail["subject"]="[{$this->config["title"]}] Registration has been successful.";
				$mail["message"]="<b>Hello</b>
					<p>You have been successfully registered at {$this->config["title"]}. You can now login to our site at <a href='{$this->config["url"]}'>{$this->config["url"]}</a></p>";

				Main::send($mail);
				//automatically signin
				$url = "http://collegesurvey.com/user/loginex?email=".($param->email)."&password=".$param->password;
				$this->filter($this->id);
				header("Location: $url");
				
				exit();
							
			}
		//}
		// Set Meta titles
		Main::set("body_class","dark");
		Main::set("title",e("Register and manage your polls."));
		Main::set("description","Register an account and gain control over your polls. Manage them, edit them or remove them without hassle.");
		$this->headerShow=FALSE;
		$this->footerShow=FALSE;
		
		$this->header();
		include($this->t(__FUNCTION__));
		$this->footer();		
	}	
	
	/**
	 * User Register
	 * @since 1.0
	 **/
	protected function register(){
		// Don't let bots register
		if(Main::bot()) $this->_404();
		// If user Module is disabled		
		if(!$this->config["users"]) return Main::redirect("",array("danger",e("We are not accepting users at this time.")));

		// Filter ID
		$this->filter($this->id);
		// Check if form is posted
		if(isset($_POST["token"])){
			// Validate CSRF Token
			if(!Main::validate_csrf_token($_POST["token"])){
				return Main::redirect(Main::href("user/register","",FALSE),array("danger",e("Invalid token. Please try again.")));
			}
			$error="";	
			// Validate Email
			if(empty($_POST["email"]) || !Main::email($_POST["email"])) $error.="<span>".e("Please enter a valid email.")."</span>";
			// Check email in database
			if($this->db->get("user",array("email"=>"?"),"",array($_POST["email"]))) $error.="<span>".e("An account is already associated with this email.")."</span>";
			// Check Password
			if(empty($_POST["password"]) || strlen($_POST["password"])<5) $error.="<span>".e("Password must contain at least 5 characters.")."</span>";
			// Check second password
			if(empty($_POST["cpassword"]) || $_POST["password"]!==$_POST["cpassword"]) $error.="<span>".e("Passwords don't match.")."</span>";
			// Check captcha
			$captcha=Main::check_captcha($_POST);
			if($this->config["captcha"] && isset($_POST["recaptcha_challenge_field"]) && $captcha!=="ok") $error.="<span>".$captcha."</span>";
			// Check terms
			if(!isset($_POST["terms"]) || (empty($_POST["terms"]) || $_POST["terms"]!=="1")) $error.="<span>".e("You must agree to our terms of service.")."</span>";
			// Return errors
			if(!empty($error)) Main::redirect(Main::href("user/register","",FALSE),array("danger",$error));
			// Generate unique auth key
			$auth_key=Main::encode($this->config["security"].Main::strrand());
			$unique=Main::strrand(20);
			// Prepare Data
			$data=array(
					":email"=>Main::clean($_POST["email"],3),
					":password"=>Main::encode($_POST["password"]),
					":auth_key"=>$auth_key,
					":unique_key"=>$unique,
					":date"=>"NOW()"
				);
			// Validate Name
			if(!empty($_POST["name"])){
				if (!strpos(trim($_POST['name']), ' ') || strlen(Main::clean($_POST["name"],3))<2){
				  $error.="<span>".e("Please enter your full name.")."</span>";
				}else{
					$data[":name"]=Main::clean($_POST["name"],3,TRUE);
				}
			}					
			// Check if user activation is required
			if($this->config["user_activation"]) $data[":banned"]="1";

			// Register User
			if($this->db->insert("user",$data)){
				//----------------------------------------------------------------------------
				$headers = array(
					'Accept: application/json',
				);
				$param = array(
					'domain'=>$_SERVER['HTTP_HOST'],
					'email'=>Main::clean($_POST["email"],3),
					'user_ip'=>$_SERVER['REMOTE_ADDR']
				);
				$handle = curl_init();
				curl_setopt($handle, CURLOPT_URL, "http://www.api.contrib.com/forms/saveleads");
				curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($handle, CURLOPT_POST, true);
                curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($param));
				$response = curl_exec($handle);
				
				//----------------------------------------------------------------------------
				
				// Send Activation Email
				if($this->config["user_activation"]){
					$activate="{$this->config["url"]}/user/activate/$unique";
					// Send Email
					$mail["to"]=Main::clean($_POST["email"],3);
					$mail["subject"]="[{$this->config["title"]}] Registration has been successful.";							
					$mail["message"]="<b>Hello!</b>
		      	<p>You have been successfully registered at {$this->config["title"]}. To login you will have to activate your account by clicking the URL below.</p>
		      	<p><a href='$activate' target='_blank'>$activate</a></p>";

		      Main::send($mail);
					return Main::redirect(Main::href("user/login","",FALSE),array("success",e("An email has been sent to activate your account. Please check your spam folder if you didn't receive it.")));
				}
				// Send Email
				$mail["to"]=Main::clean($_POST["email"],3);
				$mail["subject"]="[{$this->config["title"]}] Registration has been successful.";
				$mail["message"]="<b>Hello</b>
	      	<p>You have been successfully registered at {$this->config["title"]}. You can now login to our site at <a href='{$this->config["url"]}'>{$this->config["url"]}</a></p>";

	      Main::send($mail);				
				return Main::redirect(Main::href("user/login","",FALSE),array("success",e("You have been successfully registered.")));				
			}
		}
		// Set Meta titles
		Main::set("body_class","dark");
		Main::set("title",e("Register and manage your polls."));
		Main::set("description","Register an account and gain control over your polls. Manage them, edit them or remove them without hassle.");
		$this->headerShow=FALSE;
		$this->footerShow=FALSE;
		
		$this->header();
		include($this->t(__FUNCTION__));
		$this->footer();		
	}	
	/**
	 * User Activate
	 * @since 1.0
	 **/
	protected function activate(){
		if(Main::bot()) $this->_404();
		if(!empty($this->id)){
			if($user=$this->db->get("user",array("unique_key"=>"?","banned"=>"1"),array("limit"=>1),array($this->id))){
				$this->db->update("user",array("banned"=>"0"),array("id"=>$user["id"]));
				// Send Email
				$mail["to"]=Main::clean($user["email"],3);
				$mail["subject"]="[{$this->config["title"]}] Your account has been activated.";
				$mail["message"]="<b>Hello</b><p>Your account has been successfully activated at {$this->config["title"]}.</p>";

	      Main::send($mail);
				return Main::redirect(Main::href("user/login","",FALSE),array("success",e("Your account has been successfully activated.")));
			}
		}
		return Main::redirect(Main::href("user/login","",FALSE),array("danger",e("Wrong activation token or account already activated.")));
	}
	/**
	 * User Forgot
	 * @since 1.0
	 **/
	protected function forgot(){	
		// Change Password if valid token
		if(isset($this->id) && !empty($this->id)){
			$key=substr($this->id, 20);
			$unique=substr($this->id, 0,20);
			if($key==Main::encode($this->config["security"].": Expires on".strtotime(date('Y-m-d')),"md5")){
				// Change Password
				if(isset($_POST["token"])){
					// Validate CSRF Token
					if(!Main::validate_csrf_token($_POST["token"])){
						return Main::redirect(Main::href("user/forgot/{$this->id}","",FALSE),array("danger",e("Invalid token. Please try again.")));
					}
					// Check Password
					if(empty($_POST["password"]) || strlen($_POST["password"])<5) return Main::redirect(Main::href("user/forgot/{$this->id}","",FALSE),array("danger",e("Password must contain at least 5 characters.")));
					// Check second password
					if(empty($_POST["cpassword"]) || $_POST["password"]!==$_POST["cpassword"]) return Main::redirect(Main::href("user/forgot/{$this->id}","",FALSE),array("danger",e("Passwords don't match.")));
					// Add to database
					if($this->db->update("user",array("password"=>"?"),array("unique_key"=>"?"),array(Main::encode($_POST["password"]),$unique))){
						return Main::redirect(Main::href("user/login","",FALSE),array("success",e("Your password has been changed.")));
					}
				}
				// Set Meta titles
				Main::set("body_class","dark");
				Main::set("title",e("Reset Password"));
				$this->headerShow=FALSE;
				$this->footerShow=FALSE;

				$this->header();
				include($this->t(__FUNCTION__));
				$this->footer();
				return;
			}
			return Main::redirect(Main::href("user/login#forgot","",FALSE),array("danger",e("Token has expired, please request another link.")));
		}		
		// Check if form is posted to send token
		if(isset($_POST["token"])){
			// Validate CSRF Token
			if(!Main::validate_csrf_token($_POST["token"])){
				return Main::redirect(Main::href("user/login#forgot","",FALSE),array("danger",e("Invalid token. Please try again.")));
			}
			// Validate email
			if(empty($_POST["email"]) || !Main::email($_POST["email"])) return Main::redirect(Main::href("user/login#forgot","",FALSE),array("danger",e("Please enter a valid email.")));
			// Check email
			if($user=$this->db->get("user",array("email"=>"?","banned"=>"0"),array("limit"=>1),array($_POST["email"]))){
				// Generate key
				$forgot_url=Main::href("user/forgot/".$user["unique_key"].Main::encode($this->config["security"].": Expires on".strtotime(date('Y-m-d')),"md5"));  
		 		$mail["to"] = Main::clean($user["email"]);
		    $mail["subject"] = "[{$this->config["title"]}] Password Reset Instructions";
				$mail["message"] = "
		      <p><b>A request to reset your password was made.</b> If you <b>didn't</b> make this request, please ignore and delete this email otherwise click the link below to reset your password.</p>
		      <a href='$forgot_url' class='link'><b>Click here to reset your password.</b></a>
		      <p>If you cannot click on the link above, simply copy &amp; paste the following link into your browser.</p>
		      <a href='$forgot_url' class='link'>$forgot_url</a>
		      <p><b>Note: This link is only valid for one day. If it expires, you can request another one.</b></p>";		
		    // Send email
		    Main::send($mail);
			}			
			return Main::redirect(Main::href("user/login","",FALSE),array("success",e("If an active account is associated with this email, you should receive an email shortly.")));
		}
		return Main::redirect(Main::href("user/login#forgot","",FALSE));
	}	
	/**
	 * Get Polls
	 * @since 1.0
	 **/
	protected function get_polls($sort='all',$filter=""){
		// Run Queries based on filters
		$this->db->object=TRUE;
		if($sort=="expired"){
			$polls=$this->db->get("poll","userid=? AND (expires < CURDATE() AND expires!='')",array("order"=>"created","count"=>true,"limit"=>(($this->page-1)*$this->limit).", ".$this->limit.""),array($this->userid));				
		}elseif ($sort=="active") {
			$polls=$this->db->get("poll","userid=? AND (expires >= CURDATE() OR expires='')",array("order"=>"created","count"=>true,"limit"=>(($this->page-1)*$this->limit).", ".$this->limit.""),array($this->userid));	
		}else{
			$polls=$this->db->get("poll","userid=?",array("order"=>"created","count"=>true,"limit"=>(($this->page-1)*$this->limit).", ".$this->limit.""),array($this->userid));	
		}
		// Get number of pages base on $this->limit
    if (($this->db->rowCount%$this->limit)<>0) {
      $max=floor($this->db->rowCount/$this->limit)+1;
    } else {
      $max=floor($this->db->rowCount/$this->limit);
    }
    // If page number is higher than max redirect to page 1
    if($this->page!=1 && $this->page > $max) Main::redirect(Main::href("index.php?a=user/&page=1","user/?page=1",FALSE));

    // Generate User Page Content
		$content="<div class='btn-group'>
								<button type='button' class='btn btn-primary' id='select_all'>".e('Select All')."</button>
								<button type='button' class='btn btn-danger' id='delete_all'>".e('Delete All')."</button>
							</div><br><br>
							<form action='".Main::href('user/delete')."' id='delete_all_form' method='post'>
								<ul class='poll-list'>";

    foreach ($polls as $poll){
      $options=json_decode($poll->options);

      $content.="
        <li class='col-sm-4'>
          <div class='option-holder".($poll->open?"":" alt")."'>          	
            <div class='checkbox'><input type='checkbox' name='delete-id[]' value='{$poll->id}' data-class='blue' class='input-check-delete' /> </div>
            <h4>{$poll->question}</h4>
						<p><strong>{$poll->votes} ".e("Votes")."</strong></p>
	        </div>       
					<div class='btn-group btn-group-xs'>          
		        <a href='".Main::href("{$poll->uniqueid}")."' class='btn btn-xs btn-success' target='_blank'>".e("View")."</a>
		        <a href='".Main::href("user/stats/{$poll->id}")."' class='btn btn-xs btn-success'>".e("Analyze")."</a> 
					</div>        
					<div class='btn-group btn-group-xs pull-right'>";
						if($poll->open){
							$content.="<a href='".Main::href("user/server/")."' data-request='close' data-id='{$poll->id}' data-target='this' class='get_stats btn btn-xs btn-success'>".e("Close")."</a>";
						}else{
							$content.="<a href='".Main::href("user/server/")."' data-request='open' data-id='{$poll->id}' data-target='this' class='get_stats btn btn-xs btn-success'>".e("Open")."</a>";
						}					
			$content.="<a href='".Main::href("user/edit/{$poll->id}")."' class='btn btn-xs btn-primary'>".e("Edit")."</a>
	          <a href='".Main::href("user/delete/{$poll->id}")."' class='btn btn-xs btn-danger delete'>".e("Delete")."</a> 
					</div> 
        </li>";
    }

    $content.="</ul>".Main::csrf_token(TRUE)."</form>";
    $content.=Main::pagination($max,$this->page,Main::href("index.php?a=user/&page=%d","user/?page=%d"));

    // Template
		$this->header();		
		$this->footerShow=FALSE;
		echo $content;
		$this->footer();		
	}
	/**
	 * Active Polls
	 * @since 1.0
	 **/
	protected function active(){
		// Filter ID
		$this->filter($this->id);
		$this->isUser=TRUE;
		Main::set("title",e("Active Polls"));	 	
	 	return $this->get_polls('active');
	}
	/**
	 * Expired Polls
	 * @since 1.0
	 **/
	protected function expired(){
		// Filter ID
		$this->filter($this->id);		
		$this->isUser=TRUE;
		Main::set("title",e("Expired Polls"));	 	
		return $this->get_polls('expired');
	}	
	/**
	 * Search Polls (Ajax)
	 * @since 1.0
	 **/
	protected function search(){		
		// Validate Request
		if(isset($_POST["q"]) && isset($_POST["token"]) && isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"]=="XMLHttpRequest"){
			$q=Main::clean($_POST["q"],3,TRUE);
		}else{
			return $this->_404();
		}

		// Validate Token
		if($_POST["token"] !== $this->config["public_token"]) {
			echo "<div class='alert alert-danger'>".e("An unexpected error occurred, please try again.")."</div>";		
			exit;			
		}
		if(!empty($q) && strlen($q)>=3){
			$this->db->object=TRUE;			
			if($polls=$this->db->search("poll",array(array("userid",$this->userid),"question"=>"?"),"",array("%$q%"))){
				// Generate User Page Content
				$content="<h5 class='breadcrumb'>".e("Results for")." '$q'</h5>
									<div class='btn-group'>
										<button type='button' class='btn btn-primary' id='select_all'>".e('Select All')."</button>
										<button type='button' class='btn btn-danger' id='delete_all'>".e('Delete All')."</button>
									</div><br><br>
									<form action='".Main::href('user/delete')."' id='delete_all_form' method='post'>
										<ul class='poll-list'>";

		    foreach ($polls as $poll){
		      $options=json_decode($poll->options);

		      $content.="
		        <li class='col-sm-4'>
		          <div class='option-holder".($poll->open?"":" alt")."'>          	
		            <div class='checkbox'><input type='checkbox' name='delete-id[]' value='{$poll->id}' data-class='blue' class='input-check-delete' /> </div>
		            <h4>{$poll->question}</h4>
								<p><strong>{$poll->votes} ".e("Votes")."</strong></p>
			        </div>       
							<div class='btn-group btn-group-xs'>          
				        <a href='".Main::href("{$poll->uniqueid}")."' class='btn btn-xs btn-success' target='_blank'>".e("View")."</a>
				        <a href='".Main::href("user/stats/{$poll->id}")."' class='btn btn-xs btn-success'>".e("Analyze")."</a> 
							</div>        
							<div class='btn-group btn-group-xs pull-right'>";
								if($poll->open){
									$content.="<a href='".Main::href("user/server/")."' data-request='close' data-id='{$poll->id}' data-target='this' class='get_stats btn btn-xs btn-success'>".e("Close")."</a>";
								}else{
									$content.="<a href='".Main::href("user/server/")."' data-request='open' data-id='{$poll->id}' data-target='this' class='get_stats btn btn-xs btn-success'>".e("Open")."</a>";
								}					
					$content.="<a href='".Main::href("user/edit/{$poll->id}")."' class='btn btn-xs btn-primary'>".e("Edit")."</a>
			          <a href='".Main::href("user/delete/{$poll->id}")."' class='btn btn-xs btn-danger delete'>".e("Delete")."</a> 
							</div> 
		        </li>";
		    }

		    $content.="</ul>".Main::csrf_token(TRUE)."</form>";	    
			  return die($content);
			}
		}
		echo "<div class='alert alert-danger'>".e("Nothing found.")."</div>";		
		exit;
	}
	/**
	 * User Settings
	 * @since 1.1
	 **/
	protected function settings(){
		// Filter ID
		$this->filter($this->id);
		// Validate Post and Update account
		if(isset($_POST["token"])){
			// If demo mode is on disable this feature
			if($this->config["demo"]){
				Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("Feature disabled in demo.")));
				return;
			}			
			// Validate CSRF Token
			if(!Main::validate_csrf_token($_POST["token"])){
				return Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("Invalid token. Please try again.")));
			}
			// Validate Email
			if(empty($_POST["email"]) || !Main::email($_POST["email"])) return Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("Please enter a valid email.")));
			// Validate Name
			if(!empty($_POST["name"])){
				if (!strpos(trim($_POST['name']), ' ') || strlen(Main::clean($_POST["name"],3))<2){
				  return Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("Please enter your full name.")));
				}
			}
			if(!empty($this->user->name) && empty($_POST["name"])){
				return Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("Please enter your full name.")));
			}			
			// Check if password is changed
			if(!empty($_POST["password"])){
				if(strlen($_POST["password"])<5) return Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("Password must contain at least 5 characters.")));
				if(empty($_POST["cpassword"]) || $_POST["password"]!==$_POST["cpassword"]) return Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("Passwords don't match.")));
				//Update Password
				$data[":password"]=Main::encode($_POST["password"]);
			}

			if($this->isPro() && !empty($_POST["ga"])){
				$ga=Main::clean($_POST["ga"],3,FALSE);
				if(strlen($ga) < 20) $data[":ga"]=$ga;
			}
			//Update Email
			$data[":email"]=$_POST["email"];
			// Update Name
			$data[":name"]=Main::clean($_POST["name"],3,TRUE);

			// Update Users
			$this->db->update("user","",array("id"=>$this->userid),$data);
			// Return to settings
			return Main::redirect(Main::href("user/settings","",FALSE),array("success",e("Account successfully updated.")));
		}
		$this->db->object=TRUE;
		// Get Payments
		$payment=$this->db->get("payment",array("userid"=>"?"),array("order"=>"date","limit"=>30),array($this->userid));
		$content="<div class='row'>
          <div class='col-md-4'>
            <form action='".Main::href("user/settings")."' class='box-holder' method='post'>
              <div class='form-group'>
                <label for='name'>".e('Full Name')."</label>
                <input type='text' class='form-control' id='name' placeholder='Enter Name' name='name' value='".$this->user->name."'>
              </div>            	
              <div class='form-group'>
                <label for='email'>".e('Email address')."</label>
                <input type='email' class='form-control' id='email' placeholder='Enter email' name='email' value='".$this->user->email."'>
              </div>
              <div class='form-group'>
                <label for='pass'>".e('New Password')."</label>
                <input type='password' class='form-control' id='pass' placeholder='Leave empty to keep current one' name='password'>
              </div>
              <div class='form-group'>
                <label for='pass2'>".e('Confirm Password')."</label>
                <input type='password' class='form-control' id='pass2' placeholder='Leave empty to keep current one' name='cpassword'>
              </div>";
		if($this->isPro()){
			$content.="<div class='form-group'>
	                <label for='ga'>".e('Google Analytics ID')."</label>
	                <input type='text' class='form-control' id='ga' placeholder='UA-123456789' name='ga' value='{$this->user->ga}'>
	              </div>";
		}else{
			$content.="<div class='form-group'>
	                <label for='ga'>".e('Google Analytics ID')." <a href='".Main::href("upgrade")."'>(".e("Upgrade").")</a></label>
	                <input type='text' class='form-control' id='ga' placeholder='Please upgrade to a premium package to unlock this feature.' disabled>
	                <p class='help-block'>".e("Please upgrade to a premium package to unlock this feature.")."</p>
	              </div>";			
		}
    $content.="<div class='form-group'>
                <label for='lang'>".e('Language')."</label>
                <select name='lang' id='lang' class='selectized'>
                	".$this->lang()."
                </select>
              </div>
              ".Main::csrf_token(TRUE)."
              <button type='submit' class='btn btn-primary'>".e('Update')."</button>                       
            </form>
          </div>
          <div class='col-md-8'>          
            <h4>".e('Last Payments')."</h4>
            <div class='table-responsive'>
            <table class='table table-condensed'>
              <thead>
                <tr>
									<th>".e("Transaction ID")."</th>
                  <th>".e("Payment Date")."</th>
                  <th>".e("Expires")."</th>
                  <th>".e("Method")."</th>
                  <th>".e("Amount")." ({$this->config["currency"]})</th>
                </tr>
              </thead>
              <tbody>";
						foreach ($payment as $p) {
	             $content.="<tr>
										<td>{$p->id}</td>             
	                  <td>".date("F d, Y",strtotime($p->date))."</td>
	                  <td>".date("F d, Y",strtotime($p->expires))."</td>
	                  <td>".ucfirst($p->method)."</td>
	                  <td>{$p->amount}</td>
	                </tr>";
						}                
				    $content.="</tbody>
            </table>   
            </div>         
          </div>          
        </div>";
		// Generate Settings Page
		$this->isUser=TRUE;
		$this->footerShow=FALSE;
		Main::set("title",e("My Settings"));
		$this->header();
		echo $content;
		$this->footer();
	}
	/**
	 * Upgrade Page
	 * @since 1.0
	 **/
	protected function upgrade(){		
		// Process Payment
		if($this->do=="yearly" || $this->do=="monthly") return $this->pay();

		Main::set("title",e("Upgrade to a Premium Package"));
		Main::set("description","Upgrade to a premium package for even more features.");
		Main::set("body_class","dark");
		$this->header();
		include($this->t(__FUNCTION__));
		$this->footer();
	}			
	/**
	 * Membership Payment
	 * @since 1.0
	 **/
	private function pay($array=array()){			
		// If demo mode is on disable this feature
		if($this->config["demo"]){
			Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("Feature disabled in demo.")));
			return;
		}		
		// Require Login
		if(!$this->logged()) return Main::redirect(Main::href("user/login","",FALSE),array("warning",e("Please login or register first.")));

		// Check if already pro
		if($this->isPro()) return Main::redirect("",array("warning",e("You are already a pro member.")));

		// Determine Fee
		if(!empty($this->do) && $this->do=="yearly"){
			$fee=$this->config["pro_yearly"];
			$period="Yearly";
		}else{
			$fee=$this->config["pro_monthly"];
			$period="Monthly";
		}
		// Generate Paypal link
		$options=array(
				"cmd"=>"_xclick",
				"business"=>"{$this->config["paypal_email"]}",
   			"currency_code"=>"{$this->config["currency"]}",
   			"item_name"=>"{$this->config["title"]} $period Membership (Pro)",
   			"custom" => json_encode(array("userid"=>$this->userid,"period"=>$period)),
   			"amount"=>$fee,
   			"return"=>Main::href("user/verify/".md5($this->config["security"].$this->do)),
   			"notify_url"=>Main::href("user/verify/".md5($this->config["security"].$this->do)),
   			"cancel_return"=>Main::href("user/verify/cancel")
		);
		// Subcription Link - BETA
		$subscription=array(
				"cmd"=>"_xclick-subscriptions",
				"business"=>"{$this->config["paypal_email"]}",
   			"currency_code"=>"{$this->config["currency"]}",
   			"item_name"=>"{$this->config["title"]} Pro. $period Membership (P{$this->userid})",
   			"custom" => json_encode(array("userid"=>$this->userid)),
   			"return"=>Main::href("user/verify/".md5($this->config["security"].$this->do)),
   			"notify_url"=>Main::href("user/verify/update"),
   			"cancel_return"=>Main::href("user/verify/cancel"),		
				"no_note"=>"1",
				"no_shipping"=>"1",
				"src"=>"1",
				"a3"=>$fee,
				"p3"=>"1",
				"t3"=>$period,
			);
		// Build Query
		// $options=array_replace($default,$array);		
		if(empty($options["business"])) Main::redirect("",array("danger","PayPal is not set up correctly. Please contact the administrator."));
		// Get URL
		if($this->sandbox){
			$paypal_url="https://www.sandbox.paypal.com/cgi-bin/webscr?";
		}else{
			$paypal_url="https://www.paypal.com/cgi-bin/webscr?";
		}
    $q = http_build_query($options);
    $paypal_url=$paypal_url.$q;
		//die($paypal_url);
		header("Location: $paypal_url");
		exit;
	}	
	/**
	 * Verify Payment
	 * @since 1.0
	 **/		
	private function verify(){
		// If demo mode is on disable this feature
		if($this->config["demo"]){
			Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("Feature disabled in demo.")));
			return;
		}	

		if($this->id=="cancel") return Main::redirect("user/",array("warning",e("Your payment has been canceled.")));

   	// instantiate the IPN listener
    include(ROOT.'/includes/library/Paypal.class.php');
    $listener = new IpnListener();

    // tell the IPN listener to use the PayPal test sandbox
    $listener->use_sandbox = $this->sandbox;

    // try to process the IPN POST
    try {
      $listener->requirePostMethod();
      $verified = $listener->processIpn();   
    } catch (Exception $e) {
      error_log($e->getMessage());
      return Main::redirect("user/",array("danger",e("An error has occurred. Your payment could not be verified. Please contact us for more info.")));
    }
    // If Verified Purchase
    if ($verified){		    
    	if($this->id==md5($this->config["security"]."yearly")){
    		$expires=date("Y-m-d H:i:s", strtotime("+1 year"));
    		$info["duration"]="1 Year";
    	}else{
    		$expires=date("Y-m-d H:i:s", strtotime("+1 month"));
    		$info["duration"]="1 Month";
    	}
    	if(isset($_POST["custom"])){
    		$data=json_decode($_POST["custom"]);
    		$this->userid=$data->userid;
    	}
    	// Save info for future needs
    	if(isset($_POST["pending_reason"])){
    		$info["pending_reason"]=$_POST["pending_reason"];
    	}
    	$info["payer_email"]=$_POST["payer_email"];
    	$info["payer_id"]=$_POST["payer_id"];
    	$info["payment_date"]=$_POST["payment_date"];

    	$insert=array(
    		":date" =>"NOW()",
    		":tid" =>$_POST["txn_id"],
    		":amount" => $_POST["mc_gross"],
    		":status" => $_POST["payment_status"],
    		":userid" => $this->userid,
    		":expires"=>$expires,
    		":info"=>json_encode($info)
    		);
    	
    	// Update database
    	if($this->db->insert("payment",$insert) && $this->db->update("user",array("last_payment"=>"NOW()","expires"=>$expires,"membership"=>"pro"),array("id"=>$this->userid))){
    		Main::redirect(Main::href("user/settings","",FALSE),array("success",e("Your payment was successfully made. Thank you.")));
    	}else{
    		Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("An unexpected issue occurred. Please contact us for more info.")));
    	}
    }
    // Return to settings page
    return Main::redirect(Main::href("user/settings","",FALSE),array("danger",e("An unexpected issue occurred. Please contact us for more info.")));
	}
	
	protected function createsurvey(){
		// Filter Do and ID
		$this->filter();	
		// Check if form is posted
		if(isset($_POST["token"])){
			// Kill the bots
			if(Main::bot()) die();
			// Validate Token
			if(!Main::validate_csrf_token($_POST["token"])){
				return Main::redirect(Main::href("createsurvey","",FALSE),array("danger",e("Invalid token. Please try again.")));
			}
			// Check if question length is higher than 5 chars
			if(strlen(Main::clean($_POST["question"],3,TRUE,FALSE)) < 5) return Main::redirect(Main::href("createsurvey","",FALSE),array("danger",e("That is not a valid question.")));
			// Validate answers and skip empty ones - maximum number of question is 20
			$options=array();
			$i=1;
			if($this->isPro()){
				$max=$this->config["max_count"];
			}else{
				$max=$this->max_free;
			}
			
			if(!empty($_POST["option"])){
				foreach ($_POST["option"] as $q) {				
					if($i>=$max) break;
					$q=Main::clean($q,3,TRUE);
					if(empty($q)) continue;			
					$options[$i]=array("answer"=>$q,"count"=>0);
					$i++;
				}
			}
			// Check if at least one answer is set
			///if(empty($options[1])) return Main::redirect(Main::href("createsurvey","",FALSE),array("danger",e("That is not a valid choice of answers.")));
			// JSON encode questions
			$options=json_encode($options);			
			// Generate custom info
			$custom=array(
				"background" => Main::clean($_POST["background"],3),
				"font" => in_array($_POST["font"], json_decode(strtolower(str_replace(" ","_",$this->config["fonts"])),TRUE))?$_POST["font"]:"null"
				);
			// Validate Post info
			$unique=$this->uniqueid();
			if(in_array($_POST["expires"], array("1h","5h","1d","5d","1w","5w","0"))){
				$to=array(
					"1h"=>"1 hours",
				  "5h"=>"5 hours",
				  "1d"=>"1 day",
				  "5d"=>"5 days",
				  "1w"=>"1 weeks",
				  "5w"=>"5 weeks",
				  "0"=>""
				  );
				if($_POST["expires"]=="0"){
					$expires="";
				}else{
					$expires=date("Y-m-d G:i:s",strtotime("+".$to[$_POST["expires"]]));
				}
			}
			// Prepare data
			$data=array(
				":userid" => $this->userid,
				":question" => Main::clean($_POST["question"],3,TRUE),
				":image_url" => Main::clean($_POST["image_url"],3,TRUE),
				//":parent" => $expires,
				":options" => $options,
				":share" => in_array($_POST["share"],array("1","0"))?$_POST["share"]:"0",
				":choice" => in_array($_POST["choice"],array("1","0"))?$_POST["choice"]:"0",
				":theme" => str_replace(" ", "_", Main::clean($_POST["theme"],3,TRUE)),
				":custom" => json_encode($custom),
				":created" => "NOW()",
				":expires" => $expires,
				":results" => in_array($_POST["results"],array("1","0"))?$_POST["results"]:"0",
				":uniqueid" => $unique
				);		
			// Pro Features
			if($this->isPro()){
				$data[":pass"] = Main::clean($_POST["pass"],3,TRUE); 
				$data[":count"] = in_array($_POST["vote"],array("month","day","off"))?$_POST["vote"]:"off";
			}			
			// Insert to database
			if($this->db->insert("poll",$data)){
				return Main::redirect(Main::href("create?pid=".$this->db->lastInsertId(),"",FALSE));
				//return Main::redirect(Main::href($unique,"",FALSE));
			}
			return Main::redirect("",array("danger",e("An unexpected error occurred, please try again.")));
		}		
		Main::set("body_class","dark");
		Main::set("title",e("Create your poll for free"));
		// Add Google Fonts
		if(!empty($this->config["fonts"])){
			$fonts=str_replace(" ","+",implode("|",  array_filter(json_decode($this->config["fonts"],TRUE))));
			Main::add("<link href='http://fonts.googleapis.com/css?family=$fonts' rel='stylesheet' type='text/css'>","custom",0);	
		}
		
		$this->header();
		include($this->t(__FUNCTION__));
		$this->footer();	
	}
	
	/**
	 * Create Poll
	 * @since 1.0
	 **/
	protected function create(){
		if(empty($_REQUEST['pid'])){
			$this->createsurvey();
			exit();
		}
		// Filter Do and ID
		$this->filter();	
		// Check if form is posted
		if(isset($_POST["token"])){
			// Kill the bots
			if(Main::bot()) die();
			// Validate Token
			if(!Main::validate_csrf_token($_POST["token"])){
				return Main::redirect(Main::href("create?pid=".$_REQUEST['pid'],"",FALSE),array("danger",e("Invalid token. Please try again.")));
			}
			// Check if question length is higher than 5 chars
			if(strlen(Main::clean($_POST["question"],3,TRUE,FALSE)) < 5) return Main::redirect(Main::href("create?pid=".$_REQUEST['pid'],"",FALSE),array("danger",e("That is not a valid question.")));
			// Validate answers and skip empty ones - maximum number of question is 20
			$options=array();
			$i=1;
			if($this->isPro()){
				$max=$this->config["max_count"];
			}else{
				$max=$this->max_free;
			}
			foreach ($_POST["option"] as $q) {				
				if($i>=$max) break;
				$q=Main::clean($q,3,TRUE);
				if(empty($q)) continue;			
				$options[$i]=array("answer"=>$q,"count"=>0);
				$i++;
			}
			// Check if at least one answer is set
			if(empty($options[1])) return Main::redirect(Main::href("create?pid=".$_REQUEST['pid'],"",FALSE),array("danger",e("That is not a valid choice of answers.")));
			// JSON encode questions
			$options=json_encode($options);			
			// Generate custom info
			$custom=array(
				"background" => Main::clean($_POST["background"],3),
				"font" => in_array($_POST["font"], json_decode(strtolower(str_replace(" ","_",$this->config["fonts"])),TRUE))?$_POST["font"]:"null"
				);
			// Validate Post info
			$unique=$this->uniqueid();
			if(in_array($_POST["expires"], array("1h","5h","1d","5d","1w","5w","0"))){
				$to=array(
					"1h"=>"1 hours",
				  "5h"=>"5 hours",
				  "1d"=>"1 day",
				  "5d"=>"5 days",
				  "1w"=>"1 weeks",
				  "5w"=>"5 weeks",
				  "0"=>""
				  );
				if($_POST["expires"]=="0"){
					$expires="";
				}else{
					$expires=date("Y-m-d G:i:s",strtotime("+".$to[$_POST["expires"]]));
				}
			}
			// Prepare data
			$data=array(
				":userid" => $this->userid,
				":parent_id" => $_POST["pid"],
				":question" => Main::clean($_POST["question"],3,TRUE),
				":image_url" => Main::clean($_POST["image_url"],3,TRUE),
				":options" => $options,
				":share" => in_array($_POST["share"],array("1","0"))?$_POST["share"]:"0",
				":choice" => in_array($_POST["choice"],array("1","0"))?$_POST["choice"]:"0",
				":theme" => str_replace(" ", "_", Main::clean($_POST["theme"],3,TRUE)),
				":custom" => json_encode($custom),
				":created" => "NOW()",
				":expires" => $expires,
				":results" => in_array($_POST["results"],array("1","0"))?$_POST["results"]:"0",
				":uniqueid" => $unique
				);		
			// Pro Features
			if($this->isPro()){
				$data[":pass"] = Main::clean($_POST["pass"],3,TRUE); 
				$data[":count"] = in_array($_POST["vote"],array("month","day","off"))?$_POST["vote"]:"off";
			}			
			// Insert to database
			
			if($this->db->insert("poll",$data)){
			
				if(!empty($_POST['another'])){			
					return Main::redirect(Main::href("create?pid=".$_POST['pid'],"",FALSE));
				}else{
					if(!empty($_POST['pid'])){
						$this->db->object=TRUE;
						// Filter Do and ID
						$this->filter();				
						$poll=$this->db->get("poll","`id`=?",array("limit"=>1),array($_POST['pid']));
						return Main::redirect(Main::href($poll->uniqueid,"",FALSE));
					}else{
						return Main::redirect(Main::href($unique,"",FALSE));
					}
				}
			}
			return Main::redirect("",array("danger",e("An unexpected error occurred, please try again.")));
		}else{
			$this->db->object=TRUE;
			// Filter Do and ID
			$this->filter();				
			$poll=$this->db->get("poll","`id`=?",array("limit"=>1),array($_REQUEST['pid']));
		}
		Main::set("body_class","dark");
		Main::set("title",e("Create your poll for free"));
		// Add Google Fonts
		if(!empty($this->config["fonts"])){
			$fonts=str_replace(" ","+",implode("|",  array_filter(json_decode($this->config["fonts"],TRUE))));
			Main::add("<link href='http://fonts.googleapis.com/css?family=$fonts' rel='stylesheet' type='text/css'>","custom",0);	
		}
		
		$this->header();
		include($this->t(__FUNCTION__));
		$this->footer();		
	}	
	/**
	 * Display Poll
	 * @since 1.1
	 **/
	protected function display_poll(){
		// Get data
		$this->db->object=TRUE;
		// Filter Do and ID
		$this->filter();				
		$poll=$this->db->get("poll","BINARY `uniqueid`=?",array("limit"=>1),array($this->action));
		if(!$poll){
			return $this->_404();
		}
		// Check if current visitor has voted
		if($poll->count=="day"){						
			$poll->visited=($this->db->get("vote","pollid='$poll->id' AND ip=? AND DAY(date) = DAY(CURDATE()) AND YEAR(date)=YEAR(CURDATE())",array("limit"=>1),array(Main::ip())));
		}elseif($poll->count=="month"){
			$poll->visited=($this->db->get("vote","pollid='$poll->id' AND ip=? AND MONTH(date) = MONTH(CURDATE()) AND YEAR(date)=YEAR(CURDATE())",array("limit"=>1),array(Main::ip())));
		}else{
			$poll->visited=($this->db->get("vote",array("pollid"=>$poll->id,"ip"=>"?"),array("limit"=>1),array(Main::ip())) || isset($_COOKIE[$poll->uniqueid]));
		}
		
		
		// Get user's owner information
		if($poll->userid!=0){
			$user=$this->db->get(array("count"=>"id,membership,ga,expires","table"=>"user"),array("id"=>"?"),array("limit"=>1),array($poll->userid));
			// Downgrade user status if membershup expired
			if($user->membership=="pro" && strtotime($user->expires) < time()) $this->db->update("user",array("membership"=>"free"),array("id"=>$user->id,"admin"=>"0"));
		}
		
		// Decode encoded information
		$poll->answers=json_decode($poll->options);
		$height=round(138+count((array) $poll->answers)*68,0)+20;
		$poll->custom=json_decode($poll->custom);	
		// Validate Theme
		if($poll->theme=="0"){
			$poll->theme="";
		}else{
			$poll->theme=str_replace("_"," ",Main::clean($poll->theme,3));
		}
		// Get Background and validate information
		if(!empty($poll->custom->background)){
			if(Main::is_url($poll->custom->background)) Main::add("<style type='text/css'>#poll_widget{background-image: url('{$poll->custom->background}')}</style>","custom",0);
		}
		// Validate Font
		if($poll->custom->font!=="null"){
			$font=ucwords(str_replace("_", " ", $poll->custom->font));
			if(in_array($font, json_decode($this->config["fonts"],TRUE))){

				Main::add("<link href='http://fonts.googleapis.com/css?family=".str_replace(" ","+",$font)."' rel='stylesheet' type='text/css'>","custom",0);				
				Main::add("<style type='text/css'>#poll_widget{font-family:'$font'}</style>","custom",0);
			}
		}	
	
		if(!$poll->results && $poll->userid=$this->userid){
			$poll->results=1;
		}
		// Check if Poll Expired
		$expired=FALSE;
		if(!$poll->open && $poll->userid!=$this->userid){
			$expired=TRUE;
		}
		if(($poll->expires!=="never" || !empty($poll->expires)) && strtotime($poll->expires) > 0 && time() > strtotime($poll->expires) && $poll->userid!=$this->userid){
			$expired=TRUE;
		}

		$protected=FALSE;
		// Check if Password Protected
		if(!empty($poll->pass) && $poll->userid!=$this->userid){
			$protected=TRUE;
			// Validate Password
			if(isset($_POST["token"]) && !isset($_SESSION["access"])){
				// Validate CSRF Token
				if(!Main::validate_csrf_token($_POST["token"])){
					return Main::redirect(Main::href($this->action,"",FALSE),array("danger",e("Invalid token. Please try again.")));
				}				
				if($_POST["password"]==$poll->pass) {
					$_SESSION["access"]=md5($_POST["password"]);
					$protected=FALSE;
				}else{
					return Main::redirect(Main::href($this->action,"",FALSE),array("danger",e("Access denied. The password is not valid.")));
				}
			}			
			if(isset($_SESSION["access"]) && $_SESSION["access"]==md5($poll->pass)){
				$protected=FALSE;
			}
		}		
		// Add Google analytics code if pro
		if(isset($user->membership) && $user->membership=="pro" && !empty($user->ga)){
			$user->ga=trim($user->ga);
			Main::add("<script type='text/javascript'>
					(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', '{$user->ga}');ga('send', 'pageview');
				</script>","custom",FALSE);
		}
		// Meta Title
		if(!$protected && !$expired){			
			Main::set("title",$poll->question);
			Main::set("description","Our current poll is: $poll->question. Feel free to answer it.");			
			Main::set("url",Main::href($poll->uniqueid));
		}else{
			Main::set("title","Poll is closed");
			Main::set("description","Thank you for your interest but this poll has been closed or expired.");						
		}

		Main::set("body_class","dark");
		$this->headerShow=FALSE;
		$this->footerShow=FALSE;
		$this->header();
		$withChild = false;
		if(empty($poll->parent_id)){
			$questions=$this->db->get("poll","`parent_id`=?","",array($poll->id));
			$withChild = (count($questions)>0);
		}
		include($this->t(__FUNCTION__));
		
		
		echo '<section class="display_question"><div class="container">';
		
		if(empty($poll->parent_id)){
			
			if(count($questions)>0){

				echo '<ul class="nav nav-tabs" role="tablist" id="myTab">';
				$x=1;
				
				foreach($questions as $q){
					$cls = '';
					if($x==1){
						$cls = 'active';
					}
					echo '<li role="presentation" class="'.$cls.'"><a class="tabs" data-id="tab'.$q->id.'"  href="#tab'.$q->id.'" aria-controls="tab'.$q->id.'" role="tab" data-toggle="tab">Question #'.$x.'</a></li>';
					$x++;
				}
				  
				echo '</ul>';
			
				echo '<div class="tab-content">';
				$x = 1;
				foreach($questions as $q){
					$cls = '';
					if($x==1){
						$cls = 'display:block;';
					}
					$this->question_display($q->id,$cls);
					$x++;
				}
				echo '</div>';
				
				
			}
		}
		echo '</div></div>';
		echo '<section class=""><div class="container">';
		$this->getShareEmbed($poll->id);
		echo '</div></div>';
		$this->footer();
		return;
	}	
	
	protected function question_display($id, $style='')
	{
		$question=$this->db->get("poll","`id`=?",array("limit"=>1),array($id));
		if($question->count=="day"){						
			$question->visited=($this->db->get("vote","pollid='$question->id' AND ip=? AND DAY(date) = DAY(CURDATE()) AND YEAR(date)=YEAR(CURDATE())",array("limit"=>1),array(Main::ip())));
		}elseif($question->count=="month"){
			$question->visited=($this->db->get("vote","pollid='$question->id' AND ip=? AND MONTH(date) = MONTH(CURDATE()) AND YEAR(date)=YEAR(CURDATE())",array("limit"=>1),array(Main::ip())));
		}else{
			//var_dump(Main::ip());
			//var_dump(isset($_COOKIE[$question->uniqueid]));
			$question->visited=($this->db->get("vote",array("pollid"=>$question->id,"ip"=>"?"),array("limit"=>1),array(Main::ip())) || isset($_COOKIE[$question->uniqueid]));
			//$question->visited=($this->db->get("vote",array("pollid"=>$question->id,"ip"=>"?"),array("limit"=>1),array(Main::ip())));
		}
		
		//$question->visited = false;
		
		// Get user's owner information
		if($question->userid!=0){
			$user=$this->db->get(array("count"=>"id,membership,ga,expires","table"=>"user"),array("id"=>"?"),array("limit"=>1),array($question->userid));
			// Downgrade user status if membershup expired
			if($user->membership=="pro" && strtotime($user->expires) < time()) $this->db->update("user",array("membership"=>"free"),array("id"=>$user->id,"admin"=>"0"));
		}
		
		// Decode encoded information
		$question->answers=json_decode($question->options);
		$height=round(138+count((array) $question->answers)*68,0)+20;
		$question->custom=json_decode($question->custom);	
		// Validate Theme
		if($question->theme=="0"){
			$question->theme="";
		}else{
			$question->theme=str_replace("_"," ",Main::clean($question->theme,3));
		}
		// Get Background and validate information
		if(!empty($question->custom->background)){
			if(Main::is_url($question->custom->background)) Main::add("<style type='text/css'>#poll_widget{background-image: url('{$question->custom->background}')}</style>","custom",0);
		}
		// Validate Font
		if($question->custom->font!=="null"){
			$font=ucwords(str_replace("_", " ", $question->custom->font));
			if(in_array($font, json_decode($this->config["fonts"],TRUE))){

				Main::add("<link href='http://fonts.googleapis.com/css?family=".str_replace(" ","+",$font)."' rel='stylesheet' type='text/css'>","custom",0);				
				Main::add("<style type='text/css'>#poll_widget{font-family:'$font'}</style>","custom",0);
			}
		}		
		if(!$question->results && $question->userid=$this->userid){
			//$question->results=1;
		}
		// Check if Poll Expired
		$expired=FALSE;
		if(!$question->open && $question->userid!=$this->userid){
			$expired=TRUE;
		}
		if(($question->expires!=="never" || !empty($question->expires)) && strtotime($question->expires) > 0 && time() > strtotime($question->expires) && $question->userid!=$this->userid){
			$expired=TRUE;
		}

		$protected=FALSE;
		// Check if Password Protected
		if(!empty($question->pass) && $question->userid!=$this->userid){
			$protected=TRUE;
			// Validate Password
			if(isset($_POST["token"]) && !isset($_SESSION["access"])){
				// Validate CSRF Token
				if(!Main::validate_csrf_token($_POST["token"])){
					return Main::redirect(Main::href($this->action,"",FALSE),array("danger",e("Invalid token. Please try again.")));
				}				
				if($_POST["password"]==$question->pass) {
					$_SESSION["access"]=md5($_POST["password"]);
					$protected=FALSE;
				}else{
					return Main::redirect(Main::href($this->action,"",FALSE),array("danger",e("Access denied. The password is not valid.")));
				}
			}			
			if(isset($_SESSION["access"]) && $_SESSION["access"]==md5($question->pass)){
				$protected=FALSE;
			}
		}
		include($this->t('display_question'));
	}
	
	/**
	 * Vote
	 * @since 1.1
	 **/
	protected function vote(){
		return $this->voteex();
		/*
		// Kill the Bots and validate request
		if(Main::bot()) die("Access Denied: We do not support bots, unfortunately.");
		if(!isset($_POST["poll_id"]) || !isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || $_SERVER["HTTP_X_REQUESTED_WITH"]!=="XMLHttpRequest") die("Access Denied: Invalid request.");
		if(!isset($_POST["token"])) die("Access Denied: Token mismatch.");

    $this->db->object=TRUE;
		$poll=$this->db->get("poll","BINARY `uniqueid`=?",array("limit"=>1),array($_POST["poll_id"]));
		$options=json_decode($poll->options,TRUE);
		$max=count($options);
		if(is_array($_POST["answer"])){
			$vote=implode(",",Main::clean($_POST["answer"]));
			foreach ($_POST["answer"] as $key => $value) {
				$options[$key]["count"]=$options[$key]["count"]+1;
			}
		}else{
			if(!is_numeric($_POST["answer"]) || $_POST["answer"]>$max) return FALSE;
			$options[$_POST["answer"]]["count"]=$options[$_POST["answer"]]["count"]+1;
			$vote=$_POST["answer"];
		}
		$options=json_encode($options);
		$update=array(
				":votes"=>($poll->votes + 1),
				":options"=>$options
			);
		if(isset($_POST["referrer"]) && !empty($_POST["referrer"])){
			$source=Main::clean($_POST["referrer"],3,TRUE);
		}else{
			$source="";
		}
		$insert=array(
				":pollid" => $poll->id,
				":polluserid" => $poll->userid,
				":vote" => $vote,
				":ip" => Main::ip(),
				":country" => $this->country(),
				":source" => $source
			);
			if($this->db->insert("vote",$insert) && $this->db->update("poll","",array("id"=>$poll->id),$update)){
				if($poll->count=="month"){
					Main::cookie($poll->uniqueid,time(),60*60*24*30);
				}elseif ($poll->count=="day") {
					Main::cookie($poll->uniqueid,time(),60*60*24);
				}else{
					Main::cookie($poll->uniqueid,time(),60*60*24*365);
				}
				if(isset($_POST["embed"])){
					$this->results($poll->id,"",TRUE);
				}else{
					$this->results($poll->id);
				}
				return;
			}
		return;*/
	}
	
	protected function voteex(){
		// Kill the Bots and validate request
		if(Main::bot()) die("Access Denied: We do not support bots, unfortunately.");
		if(!isset($_POST["poll_id"]) || !isset($_SERVER["HTTP_X_REQUESTED_WITH"]) || $_SERVER["HTTP_X_REQUESTED_WITH"]!=="XMLHttpRequest") die("Access Denied: Invalid request.");
		if(!isset($_POST["token"])) die("Access Denied: Token mismatch.");

    $this->db->object=TRUE;
		$poll=$this->db->get("poll","BINARY `uniqueid`=?",array("limit"=>1),array($_POST["poll_id"]));
		$options=json_decode($poll->options,TRUE);
		$max=count($options);
		if(is_array($_POST["answer"])){
			$vote=implode(",",Main::clean($_POST["answer"]));
			foreach ($_POST["answer"] as $key => $value) {
				$options[$key]["count"]=$options[$key]["count"]+1;
			}
		}else{
			if(!is_numeric($_POST["answer"]) || $_POST["answer"]>$max) return FALSE;
			$options[$_POST["answer"]]["count"]=$options[$_POST["answer"]]["count"]+1;
			$vote=$_POST["answer"];
		}
		$options=json_encode($options);
		$update=array(
				":votes"=>($poll->votes + 1),
				":options"=>$options
			);
		if(isset($_POST["referrer"]) && !empty($_POST["referrer"])){
			$source=Main::clean($_POST["referrer"],3,TRUE);
		}else{
			$source="";
		}
		$insert=array(
				":pollid" => $poll->id,
				":polluserid" => $poll->userid,
				":vote" => $vote,
				":ip" => Main::ip(),
				":country" => $this->country(),
				":source" => $source
			);
			if($this->db->insert("vote",$insert) && $this->db->update("poll","",array("id"=>$poll->id),$update)){
				if($poll->count=="month"){
					Main::cookie($poll->uniqueid,time(),60*60*24*30);
				}elseif ($poll->count=="day") {
					Main::cookie($poll->uniqueid,time(),60*60*24);
				}else{
					Main::cookie($poll->uniqueid,time(),60*60*24*365);
				}
				//if(isset($_POST["embed"])){
				//	$this->results($poll->id,"",TRUE);
				//}else{
				//	$this->results($poll->id);
				//}
				
				
				$r = '<div id="poll_question">
				<h3>'.$poll->question.'</h3>
				<h5>Thank you for voting!</h5>
				</div>
				<p id="poll_button" style="display:none" > <button type="button" class="btn btn-widget view-results-trigger">View Results</button></p>
				<p id="poll_button" style="display:none"> <button type="button" onclick="javascript:update_results(\''.Main::href("results").'\',\''.$poll->uniqueid.'\')" class="btn btn-widget view-results" id="view-results">View Results</button></p>
				';
				echo $r;
				return;
			}
		return;
	}	
	/**
	 * Results
	 * @since 1.1
	 **/
	protected function results($pollid="",$vote_id="",$embed=FALSE){
		// Get results
		$this->db->object=TRUE;
		if(empty($pollid)) {
			$poll=$this->db->get("poll","BINARY `uniqueid`=?",array("limit"=>1),array($_POST["poll_id"]));
		}else{
			$poll=$this->db->get("poll",array("id"=>"?"),array("limit"=>1),array($pollid));
		}
		if(!$poll->results) {
			echo '<div id="poll_question">
                <h3>'.e("Thank you for voting!").'</h3>
              </div><p id="poll_button"> <a href="'.Main::href("create").'" class="btn btn-transparent">'.e("Create your poll").'</a></p>';
			return;
		}
		$user=$this->db->get(array("count"=>"membership,ga","table"=>"user"),array("id"=>"?"),array("limit"=>1),array($poll->userid));
		$options=json_decode($poll->options,TRUE);
		$return="";
		
		if(!empty($poll->parent_id)){
			$parent=$this->db->get("poll","`id`=?",array("limit"=>1),array($poll->parent_id));
			$link = $parent->uniqueid;
		}else{
			$link = $poll->uniqueid;
		}
		/*////03.26.2015
    if($poll->share && $embed==TRUE){
		
		
		
    	$height=round(138+count($options)*68,0)+20;
      $return.='<a href="#embed" id="poll_embed">'.e("Embed").'</a>
      <div id="poll_embed_holder" class="live_form">
        <div class="input-group">
          <span class="input-group-addon">'.e("Share").'</span>
          <input type="text" class="form-control onclick-select" value="'.Main::href($link).'">
        </div>              
        <div class="input-group">
          <span class="input-group-addon">'.e("Embed").'</span>
          <input type="text" class="form-control form-embed-code onclick-select" value="&lt;iframe src=&quot;'.Main::href("embed/{$link}").'&quot; width=&quot;400&quot; height=&quot;'.$height.'&quot; frameborder=&quot;0&quot;&gt;">
        </div>
        <div class="input-group">
          <a href="https://www.facebook.com/sharer.php?u='.Main::href($link).'" class="btn btn-transparent" target="_blank">'.e("Share").' Facebook</a>
          <a href="https://twitter.com/share?url='.Main::href($link).'&amp;text='.urlencode($poll->question).'" class="btn btn-transparent" target="_blank">'.e("Share on").' on Twitter</a>                                
        </div>            
      </div><!-- /#poll_embed_holder -->';            
   	}		
	*/
		$return.="<div class='poll_results' data-action='".Main::href("results")."'  data-id='{$link}'> 
							<div id='poll_question'> 
								<h3>{$poll->question}</h3>
							</div>
							<ul class='results'>";		
		foreach ($options as $i => $vote) {
			$p=round($vote["count"]*100/($poll->votes=="0"?1:$poll->votes),0);
 			/*'.($i==$vote_id?'<span class="current">'.e('You').'</span>':'').'*/
			$return.='<li>
			        <div class="holder">'.$vote["answer"].'</div>
              <div class="row">
                <div class="col-xs-9">
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="'.$p.'">
                      '.$p.'%
                    </div>
                  </div>                      
                </div>
                <div class="col-xs-3">'.$vote["count"].' Votes</div>
              </div>
            </li>';
		}
		if($poll->choice){
			$return.="</ul><h4><span>{$poll->votes} Users</span>";		
		}else{
			$return.="</ul><h4><span>{$poll->votes} Votes</span>";		
		}
		if($poll->userid!=0 && $user->membership!="pro"){
			$return.=' <div class="branding pull-right">
                    <a href="'.$this->config["url"].'" target="_blank" style="color:#fff">'.$this->config["title"].'</a>
                  </div></h4>';
		}else{
			$return.="</h4>";
		}
		/*////03.26.2015
		if($poll->share && $embed==FALSE){
			$height=round(138+count($options)*68,0)+20;
			$return.="<div class='box-holder slidedown none'>
									<div class='input-group'>
		                <span class='input-group-addon'>Share</span>
		                <input type='text' class='form-control onclick-select' value='".Main::href($link)."'>
		              </div>              
		              <div class='input-group'>
		                <span class='input-group-addon'>Embed</span>
		                <input type='text' class='form-control onclick-select' value='&lt;iframe id=&quot;poll{$link}&quot; src=&quot;".Main::href("embed/{$link}")."&quot; width=&quot;350&quot; height=&quot;$height&quot; allowTransparency=&quot;true&quot; frameborder=&quot;0&quot; scrolling=&quot;no&quot; &gt;&lt;/iframe&gt;'>
		              </div>       
					        <div class='input-group'>
					          <a href='https://www.facebook.com/sharer.php?u=".Main::href($link)."' class='btn btn-transparent btn-xs' target='_blank'>".e('Share on Facebook')." </a> &nbsp; &nbsp;         
					          <a href='https://twitter.com/share?url=".Main::href($link)."&amp;text=".urlencode($poll->question)."' class='btn btn-transparent btn-xs' target='_blank'>".e('Share on')." Twitter</a>
					        </div>   
			      		</div>";
		}
		*/
		$return.="</div><!--.poll-result-->";
		echo $return;
	}
	
	//03.26.2015
	protected function getShareEmbed($pollid=""){
		// Get results
		$return = '';
		$this->db->object=TRUE;
		if(empty($pollid)) {
			$poll=$this->db->get("poll","BINARY `uniqueid`=?",array("limit"=>1),array($_POST["poll_id"]));
		}else{
			$poll=$this->db->get("poll",array("id"=>"?"),array("limit"=>1),array($pollid));
		}
		
		$user=$this->db->get(array("count"=>"membership,ga","table"=>"user"),array("id"=>"?"),array("limit"=>1),array($poll->userid));
		$options=json_decode($poll->options,TRUE);
		if(!empty($poll->parent_id)){
			$parent=$this->db->get("poll","`id`=?",array("limit"=>1),array($poll->parent_id));
			$link = $parent->uniqueid;
		}else{
			$link = $poll->uniqueid;
		}
		//if($poll->share){
			$height=round(138+count($options)*68,0)+20;
			$return .='<div id="poll_widget" class=" parent_survey">';
			$return.="<div class='poll_results' data-action='".Main::href("results")."'  data-id='{$link}'> ";
			$return.="<div class='box-holder slidedown '>
									<div class='input-group'>
		                <span class='input-group-addon'>Share</span>
		                <input type='text' class='form-control onclick-select' value='".Main::href($link)."'>
		              </div>              
		              <div class='input-group'>
		                <span class='input-group-addon'>Embed</span>
		                <input type='text' class='form-control onclick-select' value='&lt;iframe id=&quot;poll{$link}&quot; src=&quot;".Main::href("embed/{$link}")."&quot; width=&quot;350&quot; height=&quot;$height&quot; allowTransparency=&quot;true&quot; frameborder=&quot;0&quot; scrolling=&quot;no&quot; &gt;&lt;/iframe&gt;'>
		              </div>       
					        <div class='input-group'>
					          <a href='https://www.facebook.com/sharer.php?u=".Main::href($link)."' class='btn btn-transparent btn-xs' target='_blank'>".e('Share on Facebook')." </a> &nbsp; &nbsp;         
					          <a href='https://twitter.com/share?url=".Main::href($link)."&amp;text=".urlencode($poll->question)."' class='btn btn-transparent btn-xs' target='_blank'>".e('Share on')." Twitter</a>
					        </div>   
			      		</div>";
			$return.="</div><!--.poll-result-->";
			$return.="</div>";
		//}
		
		echo $return;
	}
	
	protected function testpage(){
		$this->header();        
		include $this->t('testpage');
		$this->footer();
	}
	protected function referral(){
		$this->header();        
		include $this->t('referral'); 
		$this->footer();
	}
	protected function terms(){
		$this->header();        
		include $this->t('terms');
		$this->footer();
	}
	protected function partners(){
		$this->header();        
		include $this->t('partners');
		$this->footer();
	}
	protected function contact(){
		$this->header();        
		include $this->t('contact');
		$this->footer();
	}
	protected function listsurvey(){
		header("Content-type: application/json");
		$return = array();
		$results = $this->db->get("poll","",array("order"=>"created"));
		
		foreach($results as $result){
			$result = (array) $result;
			$user=$this->db->get("user",array("id"=>"?"),array("limit"=>1),array($result['userid']));
			$user = (array) $user;
			$email = $user['email'];
			$return[] = array(
				'id'=> $result['id'],
				'uniqueid'=> $result['uniqueid'],
				'question'=> $result['question'],
				'email'=> $email,
				'votes'=>$result['votes']
			);
		}
		
		echo json_encode(array('status'=>1,'data'=>$return));
	}
	
	/**
	 * Embed Poll
	 * @since 1.0
	 **/
	protected function embed(){
		$this->db->object=TRUE;
		// Filter  ID
		$this->filter($this->id);				
		$poll=$this->db->get("poll","BINARY `uniqueid`=?",array("limit"=>1),array($this->do));
		if(!$poll->share) die("Sorry this cannot be embedded.");
		// Check if current visitor has voted
		$poll->visited=($this->db->get("vote",array("pollid"=>$poll->id,"ip"=>"?"),array("limit"=>1),array(Main::ip())) || isset($_COOKIE[$poll->uniqueid]));
		// Get user's owner information
		if($poll->userid!=0){
			$user=$this->db->get(array("count"=>"membership,ga","table"=>"user"),array("id"=>"?"),array("limit"=>1),array($poll->userid));
		}
		// Decode encoded information
		$poll->answers=json_decode($poll->options);
		$poll->custom=json_decode($poll->custom);	
		$height=round(138+count((array) $poll->answers)*68,0)+20;
		// Validate Theme
		if($poll->theme=="0"){
			$poll->theme="";
		}else{
			$poll->theme=str_replace("_"," ",Main::clean($poll->theme,3));
		}
		// Get Background and validate information
		if(!empty($poll->custom->background)){
			if(Main::is_url($poll->custom->background)) Main::add("<style type='text/css'>#poll_widget{background-image: url('{$poll->custom->background}')}</style>","custom",0);
		}
		// Validate Font
		if($poll->custom->font!=="null"){
			$font=ucwords(str_replace("_", " ", $poll->custom->font));
			if(in_array($font, json_decode($this->config["fonts"],TRUE))){
				Main::add("<link href='http://fonts.googleapis.com/css?family=".str_replace(" ","+",$font)."' rel='stylesheet' type='text/css'>","custom",0);				
				Main::add("<style type='text/css'>#poll_widget{font-family:'$font'}</style>","custom",0);
			}
		}		
		// Check if Poll Expired
		$expired=FALSE;
		if(!$poll->open && $poll->userid!=$this->userid){
			$expired=TRUE;
		}
		if(($poll->expires!=="never" || !empty($poll->expires)) && strtotime($poll->expires) > 0 && time() > strtotime($poll->expires) && $poll->userid!=$this->userid){
			$expired=TRUE;
		}


		$protected=FALSE;
		// Check if Password Protected
		if(!empty($poll->pass) && $poll->userid!=$this->userid){
			$protected=TRUE;
			// Validate Password
			if(isset($_POST["token"]) && !isset($_SESSION["access"])){
				// Validate CSRF Token
				if(!Main::validate_csrf_token($_POST["token"])){
					return Main::redirect(Main::href($this->action,"",FALSE),array("danger",e("Invalid token. Please try again.")));
				}				
				if($_POST["password"]==$poll->pass) {
					$_SESSION["access"]=md5($_POST["password"]);
					$protected=FALSE;
				}else{
					return Main::redirect(Main::href($this->action,"",FALSE),array("danger",e("Access denied. The password is not valid.")));
				}
			}			
			if(isset($_SESSION["access"]) && $_SESSION["access"]==md5($poll->pass)){
				$protected=FALSE;
			}
		}		
		// Add Google analytics code if pro
		if($user->membership=="pro" && !empty($user->ga)){
			$user->ga=trim($user->ga);
			Main::add("<script type='text/javascript'>
					(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)})(window,document,'script','//www.google-analytics.com/analytics.js','ga');ga('create', '{$user->ga}');ga('send', 'pageview');
				</script>","custom",FALSE);
		}
		// Meta Title
		if(!$protected && !$expired){			
			Main::set("title",$poll->question);
			Main::set("description","Our current poll is: $poll->question. Feel free to answer it.");
		}
		Main::set("body_class","transparent");		
		$this->headerShow=FALSE;
		$this->footerShow=FALSE;
		$this->header();
		include($this->t(__FUNCTION__));
		$this->footer();
		return;
	}	
	/**
	 * Poll Edit
	 * @since 1.0
	 **/
	protected function edit(){
		// Get Poll
		$this->db->object=TRUE;
		if(!$poll=$this->db->get("poll",array("userid"=>"?","id"=>"?"),array("limit"=>1),array($this->userid,$this->id))){
			return $this->_404();
		}		
		# $poll=(object) $poll;
		$options=json_decode($poll->options);		

		// Update Poll
		if(isset($_POST["token"])){	
			if(!Main::validate_csrf_token($_POST["token"])){
				return Main::redirect(Main::href("user/edit/{$this->id}","",FALSE),array("danger",e("Invalid token. Please try again.")));
			}			
			if(strlen(Main::clean($_POST["question"],3,TRUE,FALSE)) < 5) return Main::redirect(Main::href("user/edit/{$this->id}","",FALSE),array("danger",e("That is not a valid question.")));
			// Get Count
			foreach ($options as $key => $value) {
				$key=$key;
				$count[$key]=$value->count;
			}
			$new_options=array();
			if($this->isPro()){
				$max=$this->config["max_count"];
			}else{
				$max=$this->max_free;
			}
			$i=1;
			foreach ($_POST["option"] as $key=>$q) {	
				if($i>=$max) break;
				$q=Main::clean($q,3,TRUE);
				if(empty($q)) continue;
				$new_options[]=array("answer"=>$q,"count"=>(isset($count[$key])?$count[$key]:0));
				$i++;
			}
			
			if(!empty($_POST['parent_id'])){
				if(empty($new_options[1]["answer"])) return Main::redirect(Main::href("user/edit/{$this->id}","",FALSE),array("danger",e("That is not a valid choice of answers.")));
			}
			
			$custom=array(
				"background" => Main::clean($_POST["background"],3),
				"font" => in_array($_POST["font"], json_decode(strtolower(str_replace(" ","_",$this->config["fonts"])),TRUE))?$_POST["font"]:"null"
				);
			$data=array(
				":userid" => $this->userid,
				":question" => Main::clean($_POST["question"],3,TRUE),
				":options" => json_encode($new_options),
				":share" => in_array($_POST["share"],array("1","0"))?$_POST["share"]:"0",
				":choice" => in_array($_POST["choice"],array("1","0"))?$_POST["choice"]:"0",
				":theme" => str_replace(" ", "_", Main::clean($_POST["theme"],3)),
				":custom" => json_encode($custom),
				":expires" => (!Main::validatedate($_POST["expires"],"Y-m-d")?"":Main::clean($_POST["expires"],3)),
        ":results"=> in_array($_POST["results"],array("1","0"))?$_POST["results"]:"0",				
				);				
				// Pro Features
				if($this->isPro()){
					$data[":pass"] = Main::clean($_POST["pass"],3,TRUE); 
					$data[":count"] = in_array($_POST["vote"],array("month","day","off"))?$_POST["vote"]:"off";
				}

				if($this->db->update("poll","",array("id"=>$this->id),$data))				{
					return Main::redirect(Main::href("user/edit/{$this->id}","",FALSE),array("success",e("Poll has been edited.")));
				}
		}

    
		$custom=json_decode($poll->custom);
		$poll->font=$custom->font;
		$poll->expires=empty($poll->expires)?e("Never"):date("Y-m-d",strtotime($poll->expires));
		$poll->background=$custom->background;
		$poll->theme=str_replace("_"," ",$poll->theme);
		
		$h1 = '';
		if(!empty($poll->parent_id)){
			$parent=$this->db->get("poll","`id`=?",array("limit"=>1),array($poll->parent_id));
			$h1 = "<h1>".$parent->question."</h1>";
		}
		
		$caption = !empty($poll->parent_id)?'Question':'Survey';
		$parent_id = !empty($poll->parent_id)?"<input name='parent_id' type='hidden' value='".$poll->parent_id."' />":"";
		$content="<div class='row'>
          <form action='".Main::href("user/edit/{$poll->id}")."' method='post'>     $parent_id             
            <div class='col-md-8'>
              <div class='box-holder live_form'>                  
			  $h1
                <h4>".e($caption)."</h4>
                <div class='form-group'>
                  <input type='text' class='form-control' placeholder='Question' name='question' value='{$poll->question}'>
                </div>  ";
				if(!empty($parent_id)){
					$content.="<h4>".e('Answers')."</h4>";
				}
				$content.="
                  <ul id='sortable'>";
                  foreach ($options as $key => $value) {
                  	$content.= "<li id='poll_sort_".($key)."'>
                      <div class='row'>
                        <div class='col-md-9'>
                          <div class='input-group'>
                            <span class='input-group-addon'><i class='glyphicon glyphicon-move'></i></span>
                            <input type='text' class='form-control' name='option[".($key)."]' value='{$value->answer}'>
                          </div>                          
                        </div>
                        <div class='col-md-3'>
                          <div class='input-group'>
                            <span class='input-group-addon'><i class='glyphicon glyphicon-user'></i></span>
                            <input type='text' class='form-control' value='{$value->count}' disabled>
                          </div>                          
                        </div>
                      </div>                
                    </li>   ";
                  }                           
    $content.="     </ul>    ";
	if(!empty($parent_id)){
	$content.="
                  <p>
                    <a href='#' id='add-field' class='btn btn-transparent'><small>".e('Add Field')."</small></a>
                  </p>        
				  ";
	}
$content.="				  
              </div>       
              <p><br>
              	<button type='submit' class='btn btn-primary btn-lg'>".e('Update')."</button>";
if(empty($poll->parent_id)){
			$content.='&nbsp;<a target="_blank" class="btn btn-warning btn-lg " href="http://collegesurvey.com/create?pid='.$poll->id.'">Add Question</a>';
}

if(!empty($poll->parent_id)){
			$parent=$this->db->get("poll","`id`=?",array("limit"=>1),array($poll->parent_id));
			$link = $parent->uniqueid;
		}else{
			$link = $poll->uniqueid;
		}

$content.="				  				
              	<a href='".Main::href($link)."' class='btn btn-success btn-lg pull-right' target='_blank'>".e('View')."</a>
              </p> 
            </div>";
			if(!empty($poll->parent_id)){
				
			
            $content.="<div class='col-md-4'>  
						<ul class='nav nav-pills'>
						  <li class='active'><a href='#' data-id='options' class='tabs'>".e("Options")."</a></li>
						  <li><a href='#' data-id='theme-options' class='tabs'>".e("Design")."</a></li>
						</ul>         
						<br>   
             <div id='options' class='tabbed'>
              <div class='form-group'>
                <label for='share'>".e('Sharing')."</label>
                <select id='share' name='share'>
                  <option value='1' ".($poll->share?"selected":"").">".e('Enabled')."</option>
                  <option value='0' ".(!$poll->share?"selected":"").">".e('Disabled')."</option>                
                </select>
              </div>    
              <div class='form-group'>
                <label for='results'>".e('Show Results')."</label>
                <select id='results' name='results'>
                  <option value='1' ".($poll->results?"selected":"").">".e('Enabled')."</option>
                  <option value='0' ".(!$poll->results?"selected":"").">".e('Disabled')."</option>                
                </select>
              </div>                  
              <div class='form-group'>
                <label for='font'>".e('Multiple Choices')."</label>
                <select id='choice' name='choice'>
                  <option value='1' ".($poll->choice?"selected":"").">".e('Enabled')."</option>
                  <option value='0' ".(!$poll->choice?"selected":"").">".e('Disabled')."</option>                
                </select>
              </div>";      
      if($this->isPro()){
        $content.="<div class='form-group'>
                <label for='vote'>".e('Multiple Votes')."</label>
                <select id='vote' name='vote'>
                  <option value='month' ".($poll->count=="month"?"selected":"").">".e('Monthly')."</option>
                  <option value='day' ".($poll->count=="day"?"selected":"").">".e('Daily')."</option>
                  <option value='0' ".($poll->count=="off"?"selected":"").">".e('Disabled')."</option>                
                </select>
              </div>              
              <div class='form-group'>
                <label for='pass'>Password</label>
                <input type='text' class='form-control' id='pass' name='pass' value='{$poll->pass}'>
              </div> ";
      }
      $content.="<div class='form-group'>
                <label for='expires'>".e('Expires')."</label>
       					<input type='text' class='form-control' id='expires' name='expires' value='{$poll->expires}'>
              </div> 
             </div> 
             <div id='theme-options' class='tabbed'>
							<h5>".e("Simple")."</h5>
							<ul class='themes'>                
							  <li class='dark'><a href='#' ".($poll->theme=="dark"?"class='current'":"")." data-class='dark'>Dark</a></li>
							  <li class='light'><a href='#'  ".($poll->theme=="light"?"class='current'":"")." data-class='light'>Light</a></li>
							  <li class='blue'><a href='#' ".($poll->theme=="blue" || empty($poll->theme)?"class='current'":"")." data-class='blue'>Blue</a></li>                
							  <li class='red'><a href='#' ".($poll->theme=="red"?"class='current'":"")." data-class='red'>Red</a></li>
							  <li class='green'><a href='#'  ".($poll->theme=="green"?"class='current'":"")." data-class='green'>Green</a></li>
							  <li class='yellow'><a href='#' ".($poll->theme=="yellow"?"class='current'":"")." data-class='yellow'>Yellow</a></li>
							</ul> 
							<h5>".e("Boxed")."</h5>
							<ul class='themes'>                
							  <li class='dark '><a href='#' ".($poll->theme=="bs dark"?"class='current'":"")." data-class='bs dark'>Dark</a></li>
							  <li class='light'><a href='#'  ".($poll->theme=="bs light"?"class='current'":"")." data-class='bs light'>Light</a></li>
							  <li class='blue '><a href='#' ".($poll->theme=="bs blue"?"class='current'":"")." data-class='bs blue'>Blue</a></li>                
							  <li class='red'><a href='#' ".($poll->theme=="bs red"?"class='current'":"")." data-class='bs red'>Red</a></li>
							  <li class='green'><a href='#'  ".($poll->theme=="bs green"?"class='current'":"")." data-class='bs green'>Green</a></li>
							  <li class='yellow'><a href='#' ".($poll->theme=="bs yellow"?"class='current'":"")." data-class='bs yellow'>Yellow</a></li>
							</ul>     
							<h5>".e("Inline")."</h5>
							<ul class='themes'>                
							  <li class='dark '><a href='#' ".($poll->theme=="is dark"?"class='current'":"")." data-class='is dark'>Dark</a></li>
							  <li class='light'><a href='#'  ".($poll->theme=="is light"?"class='current'":"")." data-class='is light'>Light</a></li>
							  <li class='blue '><a href='#' ".($poll->theme=="is blue"?"class='current'":"")." data-class='is blue'>Blue</a></li>                
							  <li class='red'><a href='#' ".($poll->theme=="is red"?"class='current'":"")." data-class='is red'>Red</a></li>
							  <li class='green'><a href='#'  ".($poll->theme=="is green"?"class='current'":"")." data-class='is green'>Green</a></li>
							  <li class='yellow'><a href='#' ".($poll->theme=="is yellow"?"class='current'":"")." data-class='is yellow'>Yellow</a></li>
							</ul>                  
							<input type='hidden' name='theme' value='{$poll->theme}' id='poll_theme_value'>    
							<br>             
              <div class='form-group'>
                <label for='font'>".e('Font')."</label>
                <select id='font' name='font' class='choose_font'>
                  <option value='null' ".($poll->font=="null"?"selected":"").">Default</option>";
                  $fonts=json_decode($this->config["fonts"],TRUE);
                  foreach ($fonts as $font){
                      $content.="<option value='".str_replace(" ","_", strtolower($font))."' ".($poll->font==str_replace(" ","_", strtolower($font))?'selected':'').">$font</option>";
                  }                
                                     
            $content.="</select>
              </div>              
              <div class='form-group'>
                <label for='background'>".e('Custom Image Background')."</label>
                <input type='text' class='form-control' name='background' value='{$poll->background}' id='background' placholder='e.g. http://mysite.com/background.png'>
              </div>                  
            </div>";
			
			}
			
            $content.="".Main::csrf_token(TRUE)."
          </form>
        </div>";
		// Show Template		
		$this->isUser=TRUE;
		$this->footerShow=FALSE;				
		Main::set("title","Edit Poll: {$poll->question}");
		$this->header();        
		echo $content;
		$this->footer();		
	}	
	/**
	 * Poll Delete
	 * @since 1.0
	 **/
	protected function delete(){
		if(isset($_POST["token"]) && isset($_POST["delete-id"]) && is_array($_POST["delete-id"])){
			if(!Main::validate_csrf_token($_POST["token"])){
				return Main::redirect(Main::href("user","",FALSE),array("danger",e("Invalid token. Please try again.")));
			}			
			$query="(";
			$query2="(";
			$c=count($_POST["delete-id"]);
			$p="";
			$i=1;
			foreach ($_POST["delete-id"] as $id) {
				if($i>=$c){
					$query.="`id` = :id$i";
					$query2.="`pollid` = :id$i";
				}else{
					$query.="`id` = :id$i OR ";
					$query2.="`pollid` = :id$i OR ";
				}
				$p[":id$i"]=$id;
				$i++;
			}
			$query.=") AND `userid`=:user";
			$query2.=") AND `polluserid`=:user";			
			$p[":user"]=$this->userid;
			$this->db->delete("poll",$query,$p);
			$this->db->delete("vote",$query2,$p);
			return Main::redirect(Main::href("user","",FALSE),array("success",e("Polls have been deleted.")));
		}

		if(!empty($this->id) && is_numeric($this->id)){
			$id=$this->id;
			$this->db->delete("poll",array("id"=>"?","userid"=>"?"),array($id,$this->userid));
			$this->db->delete("vote",array("pollid"=>"?","polluserid"=>"?"),array($id,$this->userid));
			return Main::redirect(Main::href("user","",FALSE),array("success",e("Poll has been deleted.")));
		} 
		return Main::redirect(Main::href("user","",FALSE),array("danger",e("An unexpected error occurred, please try again.")));
	}
	/**
	 * Poll Results
	 * @since 1.0
	 **/
	protected function stats(){
		// Check if is Pro
		if(!$this->isPro()) return Main::redirect(Main::href("upgrade","",FALSE),array("warning",e("Please upgrade to a premium package to unlock this feature.")));
    // Check if user owns poll or poll exists
    $this->db->object=TRUE;
		if(!$poll=$this->db->get("poll",array("userid"=>"?","id"=>"?"),array("limit"=>1),array($this->userid,$this->id))) return $this->_404();
		// Get Ip
		$ips=$this->db->get(array("count"=>"COUNT(ip) as count,ip as ip","table"=>"vote"),array("pollid"=>"?","polluserid"=>"?"),array("limit"=>24,"group"=>"ip","order"=>"date"),array($this->id,$this->userid));		
		// Get Source
		$refs=$this->db->get(array("count"=>"SUBSTR(source, 1 , IF(LOCATE('/', source, 8), LOCATE('/', source, 8)-1,LENGTH(source))) as domain, COUNT(source) as count", "table"=>"vote"),array("pollid"=>"?","polluserid"=>"?"),array("limit"=>24,"group"=>"domain","order"=>"count"),array($this->id,$this->userid));			
		// Generate Chart
		$this->charts();
		// Get Countries
		$topcountries=$this->countries();
		// Set Meta data
		Main::set("title",e("Stats for")." {$poll->question}");
		$this->isUser=TRUE;
		$this->footerShow=FALSE;		
		$this->header();
		include($this->t(__FUNCTION__));
		$this->footer();
	}
    /**
     *  Dashboard Country Function
     *  @since 1.0
     */     
     protected function countries(){
     		$this->db->object=FALSE;
        $countries=$this->db->get(array("count"=>"COUNT(country) as count, country as country","table"=>"vote"),array("polluserid"=>"?","pollid"=>"?"),array("group"=>"country","order"=>"count","limit"=>15),array($this->userid,$this->id));
        $i=0;
        $top_countries=array();
        $country=array();
        foreach ($countries as $c) {
          $country[strtoupper($c["country"])]=$c["count"];
          if($i<=10){
            if(!empty($c["country"])) $top_countries[Main::ccode($c["country"])]=$c["count"];
          }
        }
				Main::add("{$this->config["url"]}/static/js/jvector.css","style",FALSE);        
        Main::add("{$this->config["url"]}/static/js/jvector.js","script");
        Main::add("{$this->config["url"]}/static/js/jvector.world.js","script");
        Main::add("<script type='text/javascript'>
        var c=".json_encode($country).";
        $('#country-map').vectorMap({
          map: 'world_mill_en',
          backgroundColor: 'transparent',
          series: {
            regions: [{
              values: c,
              scale: ['#74CBFA', '#0da1f5'],
              normalizeFunction: 'polynomial'
            }]
          },
          onRegionLabelShow: function(e, el, code){
            if(typeof c[code]!='undefined') el.html(el.html()+' ('+c[code]+' Votes)');
          }     
        });</script>","custom");
        return $top_countries;
     }  
  /**
   *  Dashboard Chart Data Function
   *  @since 1.0
   */   
    protected function charts($span=15){
    	$this->db->object=FALSE;
      $votes=$this->db->get(array("count"=>"COUNT(DATE(date)) as count, DATE(date) as date","table"=>"vote"),"(date >= CURDATE() - INTERVAL $span DAY) AND pollid=? AND polluserid=?",array("group_custom"=>"DAY(date)","limit"=>"0 , $span"),array($this->id,$this->userid));      
      $new_date=array();  
      foreach ($votes as $votes[0] => $data) {
        $new_date[date("d M",strtotime($data["date"]))]=$data["count"];
      }
      $timestamp = time();
      for ($i = 0 ; $i < $span ; $i++) {
          $array[date('d M', $timestamp)]=0;
          $timestamp -= 24 * 3600;
      }
      $date=""; $var=""; $i=0; 

      foreach ($array as $key => $value) {
        $i++;
        if(isset($new_date[$key])){
          $var.="[".($span-$i).", ".$new_date[$key]."], ";
          $date.="[".($span-$i).",\"$key\"], ";
        }else{
          $var.="[".($span-$i).", 0], ";
          $date.="[".($span-$i).", \"$key\"], ";
        } 
      }
      $data=array($var,$date);
      Main::add("{$this->config["url"]}/static/js/flot.js","js");
      Main::add("<script type='text/javascript'>var options = {
            series: {
              lines: { show: true, lineWidth: 2,fill: true},
              //bars: { show: true,lineWidth: 1 },  
              points: { show: true, lineWidth: 2 }, 
              shadowSize: 0
            },
            grid: { hoverable: true, clickable: true, tickColor: 'transparent', borderWidth:0 },
            colors: ['#FFFFFF', '#F11010', '#1F2227'],
            xaxis: {ticks:[{$data[1]}], tickDecimals: 0, color: '#fff'},
            yaxis: {ticks:3, tickDecimals: 0, color: '#fff'},
            xaxes: [ { mode: 'time'} ]
        }; 
        var data = [{
            data: [{$data[0]}]
        }];
        $.plot('#vote-chart', data ,options);</script>",'custom',TRUE);        
    }       
   /**
     * Get In-depth Stats
     * @since 1.0
     **/  	
    protected function server(){
     	if(!$this->logged()) return $this->_404();

     	if(!isset($_POST["request"]) || empty($_POST["request"]) || !isset($_POST["token"]) || $_POST["token"]!==$this->config["public_token"]) return die("");
     	$html="";
     	$this->db->object=TRUE;     	
     	// Get Countries
     	if($_POST["request"]=="country"){
     		if(!$this->isPro()) return die("notpro");
	     	if(!$votes=$this->db->get(array("count"=>"COUNT(*) as count, vote as vote","table"=>"vote"),array("pollid"=>"?","polluserid"=>"?","country"=>"?"),array("group"=>"vote"),array(Main::clean($_POST["id"],3,TRUE),$this->userid,Main::clean(strtolower($_POST["value"]),3,TRUE)))){
	     		die("0");
	     	}
	     	$html.="<h4>".e("Vote Distribution for")." ".Main::ccode($_POST["value"])."</h4>
	     					<ol>";
	     	$poll=$this->db->get(array("table"=>"poll","count"=>"options,votes"),array("id"=>"?","userid"=>"?"),array("limit"=>1),array(Main::clean($_POST["id"],3,TRUE),$this->userid));        	  
	     	$options=json_decode($poll->options,TRUE);
	     	$count=array();
	     	$total="0";
	     	foreach ($votes as $vote) {
	     		if(!is_numeric($vote->vote)){
	     			$array=explode(",", $vote->vote);
	     			$total=$total+count($array);
	     			foreach ($array as $new) {
	     				if(!isset($count[$new])) {
	     					$count[$new]["answer"]=$options[$new]["answer"];
	     					$count[$new]["count"]=$options[$new]["count"];
	     				}else{
	     					$count[$new]["answer"]=$options[$new]["answer"];
	     					$count[$new]["count"]=$count[$new]["count"]+$options[$new]["count"];
	     				}	     				
	     			}	     			
	     		}else{
	     			$html.="<li>".$options[$vote->vote]["answer"]." <i>".round($vote->count*100/$poll->votes,0)."%</i> <span class='label label-primary pull-right'>{$vote->count}</span></li>";	
	     		}	     		
	     	}
	     	if(!empty($count)){
	     		foreach ($count as $v) {
	     			$html.="<li>".$v["answer"]." <i>".round($v["count"]*100/$total,0)."%</i> <span class='label label-primary pull-right'>{$vote->count}</span></li>";	
	     		}
	     	}
	     	$html.="</ol>";     		
     	}
     	if($_POST["request"]=="source"){
     		if(!$this->isPro()) return die("notpro");
     		$sources=$this->db->search(array("table"=>"vote","count"=>"source as url"),"source LIKE ? AND (pollid=? AND polluserid=?)",array("limit"=>15,"group"=>"url"),array("%".Main::clean($_POST["value"],3,TRUE)."%",Main::clean($_POST["id"],3,TRUE),$this->userid));
				
				$html.="<ol>";     		
	     	foreach ($sources as $source) {
	     		$html.="<li>{$source->url}</li>";
	     	}
	     	$html.="</ol>";     				
     	}
     	if($_POST["request"]=="close"){
     		$this->db->update("poll",array("open"=>0),array("id"=>"?","userid"=>"?"),array(Main::clean($_POST["id"],TRUE,3),$this->userid));
     		$html="<a href='".Main::href("user/server")."' data-request='open' data-id='".Main::clean($_POST["id"],TRUE,3)."' data-target='this' class='get_stats btn btn-xs btn-success'>".e("Open")."</a>";
     	}
     	if($_POST["request"]=="open"){
     		$this->db->update("poll",array("open"=>1),array("id"=>"?","userid"=>"?"),array(Main::clean($_POST["id"],TRUE,3),$this->userid));
     		$html="<a href='".Main::href("user/server")."' data-request='close' data-id='".Main::clean($_POST["id"],TRUE,3)."' data-target='this' class='get_stats btn btn-xs btn-success'>".e("Close")."</a>";
     	}     	
     	// Return HTML
     	return die($html);
    }
	/**
  * Export Data
  * @since 1.0
  **/   
  protected function export(){
  	// Check if enabled
  	if(!$this->config["export"]) return $this->_404();
		 // Check if is Pro
		if(!$this->isPro()) return Main::redirect(Main::href("upgrade","",FALSE),array("warning",e("Please upgrade to a premium package to unlock this feature.")));

		$this->db->object=TRUE;
		if($poll=$this->db->get("poll",array("id"=>"?","userid"=>"?"),array("limit"=>1),array($this->id,$this->userid))){
			$votes=$this->db->get("vote",array("pollid"=>"?"),array("order"=>"date"),array($poll->id));			
      // Export Payments
      $option=json_decode($poll->options,TRUE);
			header('Content-Type: text/csv');
      header("Content-Disposition: attachment;filename=ExportData_{$poll->id}.csv");
      echo "Vote Date,Voter Choice,Voter IP,Voter Country,Voter Referrer\n";
      foreach ($votes as $vote) {
      	if(isset($option[$vote->vote])){
      		$choice=$option[$vote->vote]["answer"];
      	}else{
      		$choice="{$vote->vote} (Multiple Choice)";
      	}
        echo "{$vote->date},$choice,{$vote->ip},".Main::ccode($vote->country,TRUE).",".Main::clean($vote->source)."\n";
      }			      
      return;
		}
		return $this->_404();
  }
	/**
	 * Custom Pages
	 * @since 1.0
	 **/
	protected function page(){
		// Filter ID
		$this->filter($this->id);
		$this->db->object=TRUE;
		if($page=$this->db->get("page",array("slug"=>"?"),array("limit"=>1),array($this->do))){
			Main::set("body_class","alt");
			$this->header();
			include($this->t(__FUNCTION__));
			$this->footer();
			return;
		}
		return $this->_404();
	}
	/**
	 * 404 Page
	 * @since 1.0
	 **/
	protected function _404(){
		// 404 Header
		header('HTTP/1.0 404 Not Found');
		// Set Meta Tags
		Main::set("title",e("Page not found"));
		Main::set("description","The page you are looking for cannot be found anywhere.");
		Main::set("body_class","dark");

		$this->header();
		include($this->t("404"));
		$this->footer();
	}
	/* 
		=== Helper Functions ===
	*/
	/**
	 * Get Template
	 * @since 1.0
	 **/
	protected function t($template){
    if(!file_exists(TEMPLATE."/$template.php")) $template="404";
    return TEMPLATE."/$template.php";
 	}
 	/**
 	 * Generate Unique ID
 	 * @since 1.0
 	 **/
  protected function uniqueid(){
    $l=5; 
    $i=0; 
    while(1) {
      if($i >='100') { $i=0; $l=$l+1; };
      $unique=Main::strrand($l);
      if(!$this->db->get("poll",array("uniqueid"=>$unique))) {
        return $unique;
        break;
      }
      $i++;
    }   
  }    
	/**
	 * Get country from IP now with GeoIP - must be downloaded separately.
	 * @since v1.0
	 */	
	public function country($ip=NULL,$api=''){
		if(is_null($ip)) $ip=Main::ip();
		// Get it from database first
		if(file_exists(ROOT."/includes/library/GeoIP.dat") && file_exists(ROOT."/includes/library/geoip.inc")){
			require_once(ROOT."/includes/library/geoip.inc");
			$gi = geoip_open(ROOT."/includes/library/GeoIP.dat",GEOIP_STANDARD);
			$country=geoip_country_code_by_addr($gi,$ip);
			geoip_close($gi);	
			return $country;
		}
		return "";
	}
	/**
	 * Filter
	 * @since 1.0 
	 **/
	private function filter($filter=null){
		if(is_null($filter)){
			if(!empty($this->do) || !empty($this->id)) die($this->_404());
		}else{
			if(!empty($filter)) die($this->_404());
		}
	}
/**
 * Ads
 * @since 1.0
 **/	
	private function ads($size,$pro=FALSE){
		if(!empty($this->config["ad$size"])) {
			if($this->isPro()) return;
			echo "<div class='ads ad$size'>{$this->config["ad$size"]}</div>";
		}
	}
/**
 * Languages
 * @since 1.0
 **/	
  private function lang($form=TRUE){
		if($form){
			$lang="<option value='en'".(($this->lang=="" || $this->lang=="en")?"selected":"").">English</option>";
		}else{
			$lang="<a href='?lang=en'>English</a>";
		}
    foreach (new RecursiveDirectoryIterator(ROOT."/includes/languages/") as $path){
      if(!$path->isDir() && $path->getFilename()!=="." && $path->getFilename()!==".." && $path->getFilename()!=="sample_lang.php" && $path->getFilename()!=="index.php" && Main::extension($path->getFilename())==".php"){  
          $data=token_get_all(file_get_contents($path));
          $data=$data[1][1];
          if(preg_match("~Language:\s(.*)~", $data,$name)){
            $name="".strip_tags(trim($name[1]))."";
          }        
        $code=str_replace(".php", "" , $path->getFilename());
        if($form){
					$lang.="<option value='".$code."'".($this->lang==$code?"selected":"").">$name</option>";
        }else{
					$lang.="<a href='?lang=$code'>$name</a>";	
        }
      }
    }  
    return $lang;	
  }
}
?>