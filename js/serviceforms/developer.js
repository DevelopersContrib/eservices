$(function(){		$('#developer_initialemail').focus();		$('#developer_btn_1').click(function(){            var initial_email = $('#developer_initialemail').val();			var emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;						$('#developer_warning1').html('');			            if (initial_email == ""){                $('#developer_warning1').html('* Please enter email*');                $('#developer_initialemail').focus();			}else if(!emailfilter.test(initial_email)){                $('#developer_warning1').html('* Invalid Email *');                $('#developer_initialemail').focus();            }else {				$("#developer_btn_1").attr('disabled', true);                 $.post('http://www.api.contrib.com/forms/fullcontactdetails',                       {initial_email:initial_email}                       ,function(data){                           $('#developer_firstname').val(data.fname);                           $('#developer_lastname').val(data.lname);                           $('#developer_email').val(initial_email);                           $('#developer_step1').hide();                           $('#developer_step2').show();                       }				);            }			});		$('#developer_btn_2').click(function(){                        var firstname = $('#developer_firstname').val();	            var lastname = $('#developer_lastname').val();	            var email = $('#developer_email').val();		            var country_id = $('#developer_country').val();			var country = $("#developer_country option:selected").text();            var city = $('#developer_city').val();	            var password = $('#developer_password').val();	            var password2 = $('#developer_password2').val();	            			var website = $('#developer_website').val();		            var emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;            var letters = /^[a-zA-Z ]+$/;            var alphanumeric = /^[0-9a-zA-Z ]+$/;            						            $('#developer_warning2').html('');			            if(firstname==''){                $('#developer_firstname').focus();				$('#developer_warning2').html('* First name is required *');                            }else if(!letters.test(firstname)){                $('#developer_firstname').focus();                $('#developer_warning2').html('* Accepts letters only *');                           }else if(firstname.length > 25){                $('#developer_firstname').focus();                $('#developer_warning2').html('* Name should have 3 to 25 characters *');                            }else if(firstname.length < 3 ){			                $('#developer_firstname').focus();                $('#developer_warning2').html('* Name should have 3 to 25 characters *');                            }else if(lastname==''){                $('#developer_lastname').focus();				$('#developer_warning2').html('* Last name is required *');                            }else if(!letters.test(lastname)){                $('#developer_lastname').focus();                $('#developer_warning2').html('* Accepts letters only *');                	            }else if(lastname.length > 25){                $('#developer_lastname').focus();                $('#developer_warning2').html('* Name should have 3 to 25 characters *');                            }else if(lastname.length < 3 ){			                $('#developer_lastname').focus();                $('#developer_warning2').html('* Name should have 3 to 25 characters *');                            }else if(email==''){                $('#developer_email').focus();				$('#developer_warning2').html('* Email is required *');                            }else if(!emailfilter.test(email)){                $('#developer_email').focus();                $('#developer_warning2').html('* Invalid email *');      			}else if(website != '' && validateURL(website)===false) {                $('#developer_website').focus();                $('#developer_warning2').html('* Enter a valid link for website*');            }else if(country_id==''){                $('#developer_country').focus();				$('#developer_warning2').html('* Country is required *');                            }else if(city==''){                $('#developer_city').focus();				$('#developer_warning2').html('* City is required *');                            }else if(!alphanumeric.test(city)){                $('#developer_city').focus();                $('#developer_warning2').html('* Alphanumeric only *');                            }else if(password==''){                $('#developer_password').focus();				$('#developer_warning2').html('* Password is required *');                            }else if (password.length < 5){                $('#developer_password').focus();                $('#developer_warning2').html('* Password should have atleast 5 characters *');                            }else if(password2==''){                $('#developer_password2').focus();				$('#developer_warning2').html('* Please confirm password *');                            }else if(password!=password2){                $('#developer_password2').focus();                $('#developer_warning2').html('* Password not match *');                            }else{ 				$("#developer_btn_2").attr('disabled', true);				$('#developer_step2').hide();				$('#developer_step3').show();			}           	});					$('#developer_back_3').click(function(){                        $('#developer_step3').hide();			$('#developer_step2').show();			$("#developer_btn_2").attr('disabled', false);						$('#developer_warning3').html('');	});    		$('#developer_btn_3').click(function(){		var message = $('#developer_message').val();		var partnertype = $('#developer_type').val();								if(partnertype == ""){			$('#developer_warning3').html('<center>* Please choose partnership type. *</center>');			$('#developer_type').focus();			}else if(message == ""){			$('#developer_warning3').html('<center>* Message is required. *</center>');			$('#developer_message').focus();		}else{			$('#developer_step4').show();			$('#developer_step3').hide();		}	});		$('button#developer_back_4').click(function(){		$('#developer_step3').show();		$('#developer_step4').hide();	});		$('#developer_btn_4').click(function(){				console.log("checking..");			var domain = $('#developer_domain').val();				var firstname = $('#developer_firstname').val();	            var lastname = $('#developer_lastname').val();	            var email = $('#developer_email').val();		            var country_id = $('#developer_country').val();	            var country = $("#developer_country option:selected").text();            var city = $('#developer_city').val();	            var password = $('#developer_password').val();	            var password2 = $('#developer_password2').val();	            			var company = $('#developer_company').val();			var website = $('#developer_website').val();		            var partnertype = $('#developer_type').val();			            var message = $('#developer_message').val();			var companytitle = $('#developer_company').val();            var companydesc = $('#developer_companydescription').val();            var companyimage = $('#developer_companyimage').val();            var companyurl = $('#developer_companyurl').val();            var emailfilter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;            var letters = /^[a-zA-Z ]+$/;            var alphanumeric = /^[0-9a-zA-Z ]+$/;                      			            $('#developer_warning3').html('');			            if(partnertype==''){	                				$('#developer_warning3').html('* Type of partnership is required *'); 				$('#developer_step4').hide();$('#developer_step3').show();$("#developer_btn_3").attr('disabled', false);					$('#developer_type').focus();				console.log('* Type of partnership *');                        }else if(message==''){	                $('#developer_message').focus();                $('#developer_warning3').html('* Message is required *'); 				$('#developer_step4').hide();$('#developer_step3').show();$("#developer_btn_3").attr('disabled', false);								console.log('* Message is required *');			}else if(website != '' && validateURL(website)===false) {                                $('#developer_warning2').html('* Enter a valid link for website*');				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);				$('#developer_website').focus();				console.log('* Enter a valid link *');			}else if(firstname==''){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_firstname').focus();				$('#developer_warning2').html('* First name is required *');      				console.log('* First name is required *');				            }else if(!letters.test(firstname)){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_firstname').focus();                $('#developer_warning2').html('* Accepts letters only *');      				console.log('* Accepts letters only *');				            }else if(firstname.length > 25){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_firstname').focus();                $('#developer_warning2').html('* Name should have 3 to 25 characters *');                				console.log('* Name should have 3 to 25 characters *');			}else if(firstname.length < 3 ){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_firstname').focus();                $('#developer_warning2').html('* Name should have 3 to 25 characters *');                				console.log('* Name should have 3 to 25 characters *');			}else if(lastname==''){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_lastname').focus();				$('#developer_warning2').html('* Last name is required *');                				console.log('* Last name is required *');			}else if(!letters.test(lastname)){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_lastname').focus();                $('#developer_warning2').html('* Accepts letters only *');                					console.log('* Accepts letters only *');			}else if(lastname.length > 25){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_lastname').focus();                $('#developer_warning2').html('* Name should have 3 to 25 characters *');                				console.log('*  Name should have 3 to 25 characters *');			}else if(lastname.length < 3 ){					$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_lastname').focus();                $('#developer_warning2').html('* Name should have 3 to 25 characters *');                				console.log('* Name should have 3 to 25 characters *');			}else if(email==''){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_email').focus();				$('#developer_warning2').html('* Email is required *');                				console.log('* Email is required *');			}else if(!emailfilter.test(email)){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_email').focus();                $('#developer_warning2').html('* Invalid email *');                				console.log('* Invalid email  *');					   }else if(country_id==''){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_country').focus();				$('#developer_warning2').html('* Country is required *');                				console.log('*  Country is required *');			}else if(city==''){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_city').focus();				$('#developer_warning2').html('* City is required *');                				console.log('*  City is required *');		   }else if(!alphanumeric.test(city)){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_city').focus();                $('#developer_warning2').html('* Alphanumeric only *');                				console.log('* Alphanumeric only *');			}else if(password==''){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_password').focus();				$('#developer_warning2').html('* Password is required *');                				console.log('* Password is required *');			}else if(password.length < 5){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_password').focus();                $('#developer_warning2').html('* Password should have atleast 5 characters *');                				console.log('* Password should have atleast 5 characters *');			}else if(password2==''){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_password2').focus();				$('#developer_warning2').html('* Please confirm password *');                				console.log('* Please confirm password *');			}else if(password!=password2){				$('#developer_step4').hide();$('#developer_step3').hide();$('#developer_step2').show();$("#developer_btn_2").attr('disabled', false);                $('#developer_password2').focus();                $('#developer_warning2').html('* Password not match *'); 				console.log('*  Password not match *');			}else if(companytitle==''){					$('#developer_company').focus();				$('#developer_warning4').html('* Company name is required *');				console.log('* Company name is required *');			}else if(!alphanumeric.test(companytitle)){				$('#developer_company').focus();				$('#developer_warning4').html('* Alphanumeric only *');				console.log('* Alphanumeric only *');			}else if(companydesc==''){					$('#developer_companydescription').focus();				$('#developer_warning4').html('* Company description is required *'); 				console.log('* Company description is required*');			}else if(companyimage==''){					$('#developer_companyimage').focus();				$('#developer_warning4').html('* Company image/logo is required *');			}else if(validateURL(companyimage)===false){				$('#developer_companyimage').focus();				$('#developer_warning4').html('* Invalid URL/link for company image *'); 			}else if(companyurl==''){					$('#developer_companyurl').focus();				$('#developer_warning4').html('* Company link is required *'); 				console.log('* Company link is required*');			}else if(validateURL(companyurl)===false){				$('#developer_companyurl').focus();				$('#developer_warning4').html('* Invalid company link *'); 				console.log('* Company link is required*');			}else{				$("#developer_btn_3").attr('disabled', true);				$("#developer_back_3").attr('disabled', true);							                $.post("http://www.api.contrib.com/forms/checkexist",{'field':'EmailAddress','value':email},function(data){					$('#developer_warning4').html('* Please wait. Checking in progress. * ');										if (data.status == 0){						$('#developer_warning4').html('* Please wait. Checking in progress. * ');							  						$.post('http://www.api.contrib.com/forms/save_partner',						   {								domain:domain,								firstname:firstname,								lastname:lastname,								email:email,								country_id:country_id,								country:country,								city:city,								password:password,								website:website,								companyurl:companyurl,								partnertype:partnertype,								message:message,								company:companytitle,								companydesc:companydesc,								companyimage:companyimage,								companyurl:companyurl														   }						   ,function(data){								if(data.success===true){									$('div#viewcontriblink').text('Thank you!');									$('div#viewcontriblink').html('<a href="http://www.contrib.com/account/autologinforms?email='+data.email+'&form=partnership"><button class="btn btn-success btn-lg">View your Contrib.com account now!</button></a>');									$('#developer_step4').hide();									$('#developer_final').show();								}else{									$('#developer_warning4').html('* '+data.result+' * ');									console.log('* '+data.result+' * ');									$("#developer_btn_3").attr('disabled', false);									$("#developer_back_3").attr('disabled', false);																	}						   }						);												                                              $.post("http://www.manage.vnoc.com/salesforce/addlead",                               {                                   'firstName':firstname,                                   'lastName':lastname,                                   'title':'',                                   'email':email,                                   'phone':'',                                   'street':'',                                   'city':city,                                   'country':country,                                   'state':'',                                   'zip':'',                                   'domain':domain,                                   'partner_type':partnertype,                                   'message':message,                                   'form_type':'VNOC Partnership'                               }                               ,function(data2){                                  // _gaq.push(['_trackEvent', 'Partnership', domain, 'Form Submission']);                                  // _gaq.push(['_trackEvent', 'Domains', 'Signup', domain]);                               }                              );	                                            }else{                        $('#developer_warning4').html('* Email already have an account. * <a href="http://www.contrib.com" target="_top">Please LOGIN here.</a>');						console.log('* Email already have an account. * <a href="http://www.contrib.com" target="_top">Please LOGIN here.</a>');						$("#developer_btn_3").attr('disabled', false);						$("#developer_back_3").attr('disabled', false);                    }                });				            }		 	});	});function validateURL(url){	return /^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(url);}