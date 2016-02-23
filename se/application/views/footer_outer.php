<link rel="stylesheet" type="text/css" href="/css/serviceforms/contactus.css">

<div class="modal modal2 hide fade in" id="form-container">
 
  <div class="modal-header mh-2">
	<button type="button" class="close close-2" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 class="text-center" id="form-header"><i class="icon-envelope-alt"></i> Contact Us Today !</h3>
  </div>
	
  <div class="modal-body mb-2">
    <div id="form-container-partner" style="display:none;">
		<div class="wrap-form2">
		<?include('serviceform/partner.php')?>
		</div>
	</div>
	<div id="form-container-inquire" style="display:none;">
		<?include('serviceform/contact_us.php')?>
	</div>
	<div id="form-container-staffing" style="display:none;">
		<div class="wrap-form2">
		<?include('serviceform/staffing.php')?>
		</div>
	</div>
  </div>
</div>	

<script type="text/javascript">
	
	$(function(){
		$('button#show_partner_dialog, a#_partner').click(function(){
			hideOtherForms();
			$('#form-header').html("<i class='icon-envelope-alt'></i> Submit Partnership Application");
			$('#form-container-partner').css('display','block');
		});
		
		$('a#_contactus').click(function(){
			hideOtherForms();
			$('#form-header').html("<i class='icon-envelope-alt'></i> Send Inquiry");
			$('#form-container-inquire').css('display','block');
		});
		
		$('a#_apply').click(function(){
			hideOtherForms();
			$('#form-header').html("<i class='icon-envelope-alt'></i>  Submit Team Application");
			$('#form-container-staffing').css('display','block');
		});
			
	});
	
	function hideOtherForms(){
		$('#form-container-partner').css('display','none');
		$('#form-container-inquire').css('display','none');
		$('#form-container-staffing').css('display','none');
	}

</script>	

<div class="container-fluid lead-reset-padd" style="background: none repeat scroll 0 0 #505050;">
	<div class="row-fluid">
		<div class="adr-footer">
			<div>
				<div class="footer-links">
					<div class="row-fluid">
						<ul id="footer-ul-link" class="inline"><!--here-->
							<li><a href="<?php echo $base_url?>">Home</a></li>
							<li><a id="_contactus" data-toggle="modal" data-target="#form-container">Inquire about this domain</a></li>
							<li><a href="<?php echo $base_url?>partners">Partner with us</a></li>
							<li><a id="_apply" data-toggle="modal" data-target="#form-container">Apply now</a></li>
							<li><a href="<?php echo $base_url?>terms">Terms</a></li>							
							<li><a href="<?php echo $base_url?>referral">Referral</a></li>
							<li><a href="<?php echo $base_url?>fund">Fund our ventures</a></li>
							<li><a href="<?php echo $base_url?>developers">Developers</a></li>
						</ul>
					</div>
				</div>
				<p class="copyright">All content &copy; 2013 - 2016 <?=ucwords($info['domain'])?>. All rights reserved.</p>
				<div style="text-align:center"><?php echo $footer_banner?></div>
			</div>
		</div>
	</div>
</div><!--footer-->
 

<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="<?php echo $base_url?>js/lead.js" type="text/javascript"></script>


</body>
</html>