<?php
include "includes/main_functions_test.php";
$dir = new DIR_LIB();
if(isset ($_REQUEST['count'])){
    die($dir->CountLeads($_REQUEST['domain']));
}
$email = $_REQUEST['email'];
$domain = $_REQUEST['domain'];
$user_ip = $_REQUEST['user_ip'];

//add codes to check if the email is already saved in database..
// if already in database, skipp save line
  $save = "success";
  
//else if new email

$save = $dir->SaveLeads($email,$domain,$user_ip);
	
if($save=="success"){
	$admin_emails = '';
	$admin = $dir->GetAdminData();
	for($x =0;$x<count($admin);$x++){
            if($admin_emails!='') $admin_emails .= ',';
            $admin_emails .= $admin[$x]['admin_email'];
	}
	
	
    $to = $email; 
    $from = ucwords($domain); 
    $subject = "Your ".ucwords($domain)." Subscription"; 
    $contactname = $name;
	
	
		/* GET LOGO */
			$logo='';
			$api_url = "http://contrib.com/api/";
			$key = md5($domain);
			
			//require('curl_client.php');
			$max_redirect = 3;  // Skipable: default => 3
			$client = new Curl_Client(array(

				CURLOPT_FRESH_CONNECT => 1,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_USERAGENT => ''

			), $max_redirect);
			
			$url = $api_url.'getdomaininfo?domain='.$domain.'&key='.$key;
			$client->get($url);
			$result = $client->currentResponse('body');
			$data_domain = json_decode($result,true);
			$error = 0;
			
			if (!$data_domain['error'])
			{
				$logo = $data_domain[0]['Logo'];
			}
			
			if($logo=='') $logo = ucwords($domain);
			else $logo = '<img src="'.$logo.'" height="70px">';
			
		/* END GET LOGO*/
			
	$message = '<table cellspacing="0" border="0" style="background: #f1f0e8;" cellpadding="0" width="100%">
	
	<tr>
		<td>
			<table cellspacing="0" bgcolor="#484845" width="100%" cellpadding="0">
				<tr>
					<td height="50" valign="top">
						<table cellspacing="0" align="center" width="600" cellpadding="0">
							<tr>
								<td class="header-text" align="center" style="color: #FFF; font-family: Verdana; font-size: 10px; text-transform: uppercase; padding: 0 20px;">
									<br /><a href="http://'.ucfirst($domain).'" style="color: #00ffff; text-decoration: none;">'.ucfirst($domain).'</a> is a member of <a href="http://domaindirectory.com" style="color: #00ffff; text-decoration: none;">DomainDirectory.com</a> and a venture of <a href="http://globalventures.com" style="color: #00ffff; text-decoration: none;">GlobalVentures.com</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	
	<tr>
		<td>
			<table cellspacing="0" width="100%" cellpadding="0">
				<tr>
					<td valign="top">
						<table cellspacing="0" align="center" width="600" cellpadding="0">
							<tr>
								<td class="main-title" style="padding: 0 20px; font-size: 28px; text-align: center; font-family: Georgia; text-transform: uppercase; letter-spacing: 6px;">
									<br />'.$logo.'
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td valign="top">
						<table cellspacing="0" align="center" width="600" cellpadding="0">
							<tr>
								<td class="date" valign="top" style="color: #999; text-transform: uppercase; text-align: center; font-size: 11px; font-family: Verdana;">
									'.date("F d, Y").'<br /><br />
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
	
	<tr>
		
		<td valign="top">

			<table cellspacing="0" border="0" align="center" cellpadding="0" width="600" >
				<tr>
					<td>
						<table cellspacing="0" border="0" cellpadding="0" width="600" >
							<tr>
								<td valign="top" width="220" bgcolor="#e5e4dc">
									<table cellspacing="0" bgcolor="#e5e4dc" width="220" cellpadding="0">
										
										<tr>
											<td valign="top">
												<img src="http://domaindirectory.com/images/sidebar-top-left.gif" alt="" />
											</td>
										</tr>
										
										<tr>
											<td valign="top">
												<table cellspacing="0" cellpadding="0">
													<tr>
														<td style="padding: 0 0 0 20px;">
															<br />
															<strong class="subtitle" style="display: block; font-size: 11px; font-family: Verdana; text-transform: uppercase; margin: 0 0 10px 0;">Please check out <a href="http://globalventures.com" style="text-decoration: none;color: inherit;">Global Ventures</a> other great companies and Opportunities below.</strong>
															<table cellspacing="0" border="0" cellpadding="0">
																<tr>
																	<td height="20"><img src="http://domaindirectory.com/images/bullet.gif" alt="" style="border: 0;" /></td>
																	<td class="list" ><a style="color: #cc0000; text-transform: uppercase; font-size: 11px; text-decoration: none; font-family: Verdana;" href="http://referrals.com">Referrals.com</a></td>
																</tr>
																<tr>
																	<td height="20"><img src="http://domaindirectory.com/images/bullet.gif" alt="" style="border: 0;" /></td>
																	<td class="list" ><a style="color: #cc0000; text-transform: uppercase; font-size: 11px; text-decoration: none; font-family: Verdana;" href="http://handyman.com">HandyMan.com</a></td>
																</tr>
																<tr>
																	<td height="20"><img src="http://domaindirectory.com/images/bullet.gif" alt="" style="border: 0;" /></td>
																	<td class="list" ><a style="color: #cc0000; text-transform: uppercase; font-size: 11px; text-decoration: none; font-family: Verdana;" href="http://venturecamp.com">VentureCamp.com</a></td>
																</tr>
																<tr>
																	<td height="20"><img src="http://domaindirectory.com/images/bullet.gif" alt="" style="border: 0;" /></td>
																	<td class="list" ><a style="color: #cc0000; text-transform: uppercase; font-size: 11px; text-decoration: none; font-family: Verdana;" href="http://domainpower.com">DomainPower.com</a></td>
																</tr>
																<tr>
																	<td height="20"><img src="http://domaindirectory.com/images/bullet.gif" alt="" style="border: 0;" /></td>
																	<td class="list" ><a style="color: #cc0000; text-transform: uppercase; font-size: 11px; text-decoration: none; font-family: Verdana;" href="http://talentdirect.com">TalentDirect.com</a></td>
																</tr>
																<tr>
																	<td><br /></td>
																	<td><br /></td>
																</tr>
															</table>
														</td>

													</tr>
													
												</table>
												
											</td>
										</tr>
									
										<tr>
											<td valign="top">
												<img src="http://domaindirectory.com/images/sidebar-bottom-left.gif" alt="" />
											</td>
										</tr>
									
									</table>
								</td>
								<td valign="top" width="450" bgcolor="#fff">
									<table cellspacing="0" style="background: #fff;" width="450" cellpadding="0">
										
										<tr>
											<td valign="top" width="344"><img src="http://domaindirectory.com/images/spacer.gif" alt="" /></td>
											<td valign="top" width="6" align="right">
												<img src="http://domaindirectory.com/images/top-right.gif" alt="" />
											</td>
										</tr>
										
										<tr>
											<td class="content-copy" valign="top" style="padding: 0 20px; color: #000; font-size: 14px; font-family: Georgia; line-height: 20px;" colspan="2">
												<br />
																Thank you for your interest on <a href="http://'.$domain.'">'.ucwords($domain).'</a>! 
																<br /><br />
																If you want to get the latest updates from this domain, please feel free to sign up by clicking the link below and start following '.ucwords($domain).' or any of the 16 thousand assets that we have on Contrib.com.
																<br /><br />
																<a href="http://www.contrib.com/signup/follow/'.$domain.'">Click here to start following '.$domain.'!</a> 
																<br / > or copy this link to your browser:
																<br /><a href="http://www.contrib.com/signup/follow/'.$domain.'">http://www.contrib.com/signup/follow/'.$domain.'</a>
																<br /><br />
																Have a great day! 
																<br><br>
																Contrib.com Team.
																<br><br><br>
											</td>
										</tr>	
										
										<tr>
											<td><br /><br /></td>
										</tr>
										
										<tr>
											<td valign="top" width="344" height="6"><img src="http://domaindirectory.com/images/spacer.gif" alt="" /></td>
											<td valign="top" width="6" height="6" align="right">
												<img src="http://domaindirectory.com/images/bottom-right.gif" alt="" />
											</td>
										</tr>
									</table>
								</td>
							</tr>

						</table>
					</td>
				</tr>
			</table>
			
		</td>
	
	</tr>
	<tr>
		<td valign="top">
			<table cellspacing="0" width="100%" cellpadding="0">
				<tr>
					<td valign="top">
						<br />
					</td>
				</tr>
				<tr>
					<td valign="top" bgcolor="#484845">
						<table cellpadding="0" cellspacing="0" width="600" align="center" style="color:#555;font-family:Arial,sans-serif;font-size:12px;line-height:22px;padding:10px;color:white">
									<tbody>
										<tr>
										<td width="120">Connect with us:</td>
										<td width="35"><img src="http://domaindirectory.com/servicepage/images/facebook.png" width="24" height="24" border="0" alt=""></td>
										<td width="80"><a style="color:white;text-decoration:none" href="'.$fb_page.'">Facebook</a> </td>
										<td width="35"><img src="http://domaindirectory.com/servicepage/images/twitter.png" width="24" height="24" border="0" alt=""></td>
										<td width="80"><a style="color:white;text-decoration:none" href="'.$twitter_page.'">Twitter</a> </td>
										<td width="35"><img src="http://domaindirectory.com/servicepage/images/contact.png" width="24" height="24" border="0" alt=""></td>
										<td width="90"><a style="color:white;text-decoration:none" href="http://domaindirectory.com/contactus.html">Contact Us</a></td>
										</tr>
									</tbody>
								</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>

</table>';
	 

   //end of message 
    $headers = "From: $from <admin@contrib.com>\r\n"; 
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
    //options to send to cc+bcc 
    //$headers .= "Cc: [email]maa@p-i-s.cXom[/email]"; 
    //$headers .= "Bcc: [email]email@maaking.cXom[/email]"; 
    // now let's send the email. 
    mail($to, $subject, $message, $headers); 
    echo "Your email will never be sold and kept strictly for notification when we launch!";
}else{
	echo $save;
}

?>