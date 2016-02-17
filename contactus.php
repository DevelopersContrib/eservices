<?php include 'header-pages.php'; ?>

<title>Contact <?=$domain?></title>
	<meta name="title" content="Contact <?=$domain?> " />
	<meta name="description" content="Contact <?=$domain?> today." />
	<style>
	.blocker {
    top: 55px !important;
}
.form-wrapper {
    border: 1px dashed #EEE;
}
.iw-icon {  
    padding: 15px 0px !important;
}
.iw-hover:hover #hover-content {  
    margin-left: -9px;
}
	</style>
    </head>
<body>

<? include 'navigation.php'; ?>
      <section class="content-top-margin page-title page-title-small bg-gray">
            <div class="container">
                <div class="row">
                    <div style="visibility: visible; animation-duration: 300ms; animation-name: fadeInUp;" class="col-md-8 col-sm-12 wow fadeInUp animated" data-wow-duration="300ms">
                        <!-- page title -->
                        <h1 class="black-text">Contact <?=$domain?></h1>
                        <!-- end page title -->
                    </div>
                    <div style="visibility: visible; animation-duration: 600ms; animation-name: fadeInUp;" class="col-md-4 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none animated" data-wow-duration="600ms">
                        <!-- breadcrumb -->
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li><a href="/contactus">Contact</a></li>
                        </ul>
                        <!-- end breadcrumb -->
                    </div>
                </div>
            </div>
        </section>		
		 <!-- content section -->
        <section class="wow fadeIn">
            <div class="container">
				<div class="row">
                    <div class="col-md-5 col-sm-8 text-center center-col">
                        <p class="title-large text-uppercase letter-spacing-1 black-text font-weight-600">Contact Us Today</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-8 col-xs-11 center-col xs-no-padding">
					<script type="text/javascript" src="http://tools.contrib.com/contactform?d=<?echo $domain?>"></script>
					</div>
				</div>
			</div>
		</section>		
            
    
    
    <script type="text/javascript" charset="utf-8">
        	$(document).ready(function(){
        		$('#email').click(function(){
        			$(this).attr("placeholder","");
        		});
        		
        		$('#pagesubmit').hide();
        		$('#pagesubmit').removeClass('hidden');
        		$('#btnsubmit').click(function(){
        			$('#signupform').submit();
        		});
        		$('#signupform').submit(function(){
        			
        			var email = $('#email').val();
        			var user_ip = $('#user_ip').val();
        			var indexof = email.indexOf("@");
        			var name = email.slice(0,indexof);
        			var domain = $('#domain').val(); 
        			
        			
        			if(email==''){
        				alert('Email is Required.');
        				$('#email').focus();
        				return false;
        			}else if(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(email)==false){
        				alert('Please enter a valid email address.');
        				$('#email').focus();
        				return false;
        			}else{
        				
        				$("#signupform").hide();	
        				$('#response_wait').show();
        				$("#pagesubmit").slideDown('normal');
        				
        			//DOMAINDI LEADS		
        			jQuery.ajax({
        				type: "post",url: "http://www.api.contrib.com/forms/saveleads",
        				data: {'email':email, 'domain':domain,'user_ip':user_ip},
        				success: function(res){
        					$('#response_wait').hide();
        					console.log(res);
        					
        					$("#loading").hide();
        					
        					if(res.success=='false'){
        						$('#response').append('<div class="span12 text-center" id="response">Something went wrong. Sorry for the inconvenience.</div>');
        					}else if(res.success=='success'){
        						
        						
        						$('#pemail').val(email);
        						$('#response').css('display','block');
        						
        					}else{
        						$('#response').append('<div class="span12 text-center" id="response">'+res.success+'<br><br>Visit our <a href="http://www.contrib.com/brand/details/'+domain+'" target="_blank">'+domain.toUpperCase()+' brand page</a> for further details. <br><br>Thank you! <br><br></div>');
        					}
        					
        				}});	
        			
        				// SALESFORCE LEAD
        				$.post("http://www.manage.vnoc.com/salesforce/addlead",
        				{
        					'firstName':name,
        					'lastName':name,
        					'title':'',
        					'email':email,
        					'phone':'',
        					'street':'',
        					'city':'',
        					'country':'',
        					'state':'',
        					'zip':'',
        					'domain':domain,
        					'form_type':'Contrib Lead Template'
        					
        				},function(data2){
        					console.log(data2);
        				}
        				);
        				
        				
        				return false;
        				
        			}
        			
        			return false;

        		});

        });

</script>
                    <!-- end form -->
                </div>
            </div>
        </section>
        <!-- end contact us section -->
<? include 'footer.php'; ?>     
