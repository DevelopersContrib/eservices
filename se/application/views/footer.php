
<div class="container-fluid lead-reset-padd" style="background: none repeat scroll 0 0 #505050;">
	<div class="row-fluid">
		<div class="adr-footer">
			<div>
				<div class="footer-links">
					<div class="row-fluid">
						<ul id="footer-ul-link" class="inline"><!--here-->
							<li><a href="<?php echo $base_url?>">Home</a></li>
							<li><a href="#top" id="_contactus">Inquire about this domain</a></li>
							<li><a href="<?php echo $base_url?>partners">Partner with us</a></li>
							<li><a href="#top" id="_apply">Apply now</a></li>
							<li><a href="<?php echo $base_url?>terms">Terms</a></li>							
							<li><a href="<?php echo $base_url?>referral">Referral</a></li>
						</ul>
					</div>
				</div>
				<p class="copyright">All content &copy; 2013 - 2014 <?=ucwords($info['domain'])?>. All rights reserved.</p>
				<div style="text-align:center"><?php echo $footer_banner?></div>
			</div>
		</div>
	</div>
</div><!--footer-->
 
<? if($attr['forsale']=='1'){ ?>
	<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner" style="background:url(http://d2qcctj8epnr7y.cloudfront.net/sheina/contrib/top-bg.png) repeat-x !important; font-size:13px; text-align:center;  font-family:Arial, Helvetica, Tahoma, sans-serif; font-weight:bold; height:auto;">
		<?=$attr['forsaletext']?> <a href="http://domaindirectory.com/servicepage/?domain=<?=$info['domain']?>" target="_blank" style="color:blue;">Inquire now</a>.
	</div>
	</div>
<? } ?>

<script type="text/javascript">
	$(document).ready(function(){
		var domain_name = $('#domain').val();
		$('#myTab').tab();
		$("#demo3").als({					
			visible_items: 3,
			scrolling_items: 1,
			orientation: "horizontal",
			circular: "yes",
			autoscroll: "yes",
			interval: 4000
		});
		
		getsocial(domain_name,'fb','http://d2qcctj8epnr7y.cloudfront.net/sheina/contrib/social_icons/1396251686_facebook_circle_color.png');
		getsocial(domain_name,'twitter','http://d2qcctj8epnr7y.cloudfront.net/sheina/contrib/social_icons/1396251704_twitter_circle_color.png');
		
	});
	
	function getsocial(domain_name,social,icon_src){
	
		$.getJSON('http://manage.vnoc.com/socialmedia/getDomainSocialsAPI/'+domain_name+'/'+social,function(data){
						var socialdata = data[0];
						if(socialdata.error == true){
							//do nothing
						}else if(socialdata.profile_url == ""){
							//do nothing
						}else if(socialdata.profile_url == "null" || socialdata.profile_url == null){
							//do nothing
						}else{
							$('#socials_container').append('&nbsp;<a href="'+socialdata.profile_url+'"><img src="'+icon_src+'" height="40px"></a>&nbsp;');
						}		
		});
	}
</script>
<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>
<script src="<?php echo $base_url?>js/jquery.als-1.1.min.js" type="text/javascript"></script>
<script src="<?php echo $base_url?>js/jquery.counter.js" type="text/javascript"></script>
<script src="<?php echo $base_url?>js/lead.js" type="text/javascript"></script>

<script>
$(function() {
	//$('.counter').counter();
});
</script>
</body>
</html>