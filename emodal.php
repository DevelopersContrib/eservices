<?php 
include 'includes/class.db.php';
include 'includes/functions.php';
$page = $_POST['page'];
$id = $_POST['id'];
$info = getmodalvars($page,$id);
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h2 class="modal-title text-center" id="myModalLabel"><?php echo $info['title']?></h2>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <p class="text-center">
                <?php echo $info['description']?> 
            </p>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <img class="img-responsive" src="<?php echo $info['image']?>" alt="">
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <br />
            <div class="media">
                <div class="media-left media-middle">
                    <div class="media-object">
                        <div class="num-obj">
                            <i class="fa fa-edit"></i>
                        </div>
                    </div>
                </div>
                <div class="media-body">
                    <h4 class="media-heading mb-header-cust">
                        Sign-up
                        <i class="fa fa-check text-danger"></i>
                    </h4>
                </div>
            </div>
            <div class="media">
                <div class="media-left media-middle">
                    <div class="media-object">
                        <div class="num-obj">
                            <i class="fa fa-desktop"></i>
                        </div>
                    </div>
                </div>
                <div class="media-body">
                    <h4 class="media-heading mb-header-cust">
                        Join contrib
                        <i class="fa fa-check text-danger"></i>
                    </h4>
                </div>
            </div>
            <div class="media">
                <div class="media-left media-middle">
                    <div class="media-object">
                        <div class="num-obj">
                            <i class="fa fa-money"></i>
                        </div>
                    </div>
                </div>
                <div class="media-body">
                    <h4 class="media-heading mb-header-cust">
                        Contribute to get paid
                        <i class="fa fa-check text-danger"></i>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <div class="row">
        <div class="col-md-12" id="form_signup">
                <div class="input-group input-group-lg">
	                <input type="text" id="email" name="email" class="form-control" placeholder="Name@example.com">
	                <input type="hidden" id="domain" value="eservices.com">
                    <input type="hidden" id="user_ip" value="<?php echo $_SERVER['REMOTE_ADDR']?>">
		                                
	                <span class="input-group-btn">
	                    <a class="btn btn-danger" id="btn-submit" href="javascript:void(0)" onclick="submitform()">
	                        <i class="fa fa -edit"></i>
	                        Sign-up now!
	                    </a>
	                </span>
	            </div><!-- /input-group -->
          <div id="response_wait" class="hide">
           <div class="span12" style="width:100%;text-align:center;margin:20px 0 35px 0;color:red;min-height:20px;font-size:18px;" id="loading">Processing . . . Please wait . . .</div>
           </div>
           
        </div>
        <div class="col-md-12 text-center hide" id="success_signup">
            <h3 class="text-danger" style="margin-bottom: 10px;">Thanks, your spot is reserved!</h3>
            <p class="text-danger" style="line-height: 24px; padding-bottom: 0px;">Share eservices.com with you friends to move up in line and reserve your username.</p>
           	<form target="_blank" action="http://www.contrib.com/signup/follow/eservices.com" method="post">
            <button class="btn btn-warning">Continue to Follow Eservices.com Brand</button>
            </form>
        </div>
    </div>
</div>
<script>
function submitform(){
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
		
		$('#btn-submit').prop('disabled', true);	
		$('#response_wait').removeClass('hide');
		
	//DOMAINDI LEADS		
	jQuery.ajax({
		type: "post",url: "http://www.contrib.com/forms/saveleads",
		data: {'email':email, 'domain':domain,'user_ip':user_ip},
		success: function(res){
			$('#response_wait').addClass('hide');
			console.log(res);
			
			
			if(res.success=='false'){
				$('#form_signup').append('<div class="span12 text-center" id="response" style="color:red">Something went wrong. Sorry for the inconvenience.</div>');
			}else if(res.success=='success'){
				//$('#form_signup').show();
				$('#form_signup').addClass('hide');
				$('#success_signup').removeClass('hide');
				
			}else{
				$('#form_signup').append('<div class="span12 text-center" id="response">'+res.success+'<br><br>Visit our <a href="http://www.contrib.com/brand/details/'+domain+'" target="_blank">'+domain.toUpperCase()+' brand page</a> for further details. <br><br>Thank you! <br><br></div>');
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
			'form_type':'Eservices'
			
		},function(data2){
			console.log(data2);
		}
		);
		
		
		return false;
		
	}
}
</script>