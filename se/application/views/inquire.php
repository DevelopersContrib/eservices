<? include('header.php'); ?>

<a name="top"></a>
<div class="container-fluid lead-reset-padd"  style="background: url(/img/bg-socialholdings.jpg) repeat;">
	<div class="row-fluid">
		<div class="wrap-ad" style="background: none repeat scroll 0 0 rgba(0, 0, 0, 0.8);">
			<div class="container overflow-ad">
				<div class="row-fluid">
					<div class="content-ad">
						<div style="margin-top: -40px;">
							<? if($logo!=''){ ?>
								<a href="http://<?=$domain?>"><img src="<?=$logo?>" alt="<?=$title?>" title="<?=$domain?>" style="max-width:500px" border="0" /></a>
							<? }else{ ?>
								<h1><?=ucwords($domain)?></h1>
							<? } ?>
							<h4>Learn more about Joining our Partner Network</h4>
						</div>
						
						<div class="section-heading-ttle text-left">
							<h2 style="padding-left:0;"><span id="_title">INQUIRE ABOUT</span> <?=ucwords($domain)?></h2>								
						</div>
						
						<div class="row-fluid">
							<div class="span12">
								<div id="non_terms" style="display:none">
									<div class="span4">
										<!-- about --><img id="l_about" class="ad-img" src="http://d2qcctj8epnr7y.cloudfront.net/images/marvinpogi/logo-ecorp2.png" style="margin: 30px 0 0 -50px;"/>
										
										<!-- contact --><iframe id="l_contactus" src="http://domaindirectory.com/servicepage/contactus2_form.php?domain=appcentre.com" frameborder="0" scrolling="no" style="display:none;width: 350px;background: whitesmoke;height: 500px;padding: 15px 0 0 15px;border-radius: 5px;margin-top: 30px;"></iframe>
									
										<!-- partner --><iframe id="l_partner" src="http://domaindirectory.com/servicepage/partners_form.php?domain=appcentre.com" frameborder="0" scrolling="no" style="display:none;width:350px;height:435px;border: none;background: whitesmoke;border-radius: 5px;margin-top: 30px;"></iframe>
									
										<!-- apply --><iframe id="l_apply" src="http://domaindirectory.com/servicepage/staffing_form.php?domain=appcentre.com" frameborder="0" scrolling="no" style="display:none;width:350px;height:470px;border:none;background: whitesmoke;border-radius: 5px;margin-top: 30px;"></iframe>
									</div>
									<div class="span7">
										<div id="r_about">
											<p class="p-desc stripe-text right text-left">
												<span class="p-intro"><?=ucwords($domain)?></span>
												is a venture of eCorp.com Inc.
												<br>
												<br>
												<?=$description?> 
												<br>
												<br>
												<span class="p-intro">eCorp</span> is the worlds largest virtual domain development incubator on the planet. Founded in 1996, we create, acquire, match, manage and liquidate premium domain assets and platforms. We build and manage world class web-based, domain centric operating businesses for clients and internal ventures. Learn more about our ventures, staffing opportunites and partnership models.
											</p>
											<br />
											<p class="p-desc stripe-text left text-left">
												<a href="http://globalventures.com" target="_blank" class="btn btn-primary btn-large">
													Learn about this site
												</a>
											</p>
										</div>
										<div id="r_apply" style="display:none;margin-left:50px;">
											<p class="p-desc stripe-text right text-left">
												<br>
												<br>
												<br>
												We are looking for the best of the best, Full-Time, Part-Time, Moonlighting, Contractual and Freelance.
												<br>
												<br>										
												We consult and manage over 100,000 domain name ventures and are always seeking Strategic Partnerships, Applications, Domains, Engineers, Developers, Specialist and just cool smart people around the Globe. Learn more about openings and opportunities with our partner companies and send us your resume or examples to accelerate the process.
												<br>
												<br>
												Learn more about openings and opportunities with our partner companies.
											</p>
										</div>
									</div>
								</div>
								<div id="f_terms" style="text-align: left;">
									
									<div class="span5">
										<iframe src="http://domaindirectory.com/servicepage/contactus2_form.php?domain=<?=$domain?>" frameborder="0" scrolling="no" style="width: 350px;background: whitesmoke;height: 500px;padding: 15px 0 0 15px;border-radius: 5px;margin-top: 30px;"></iframe>
									</div>
									
									<div class="span6">
										<p class="p-desc stripe-text right text-left">
										<?=ucwords($domain)?> platform is part of the Global Ventures Network. Founded in 1996, Global Ventures is the worlds largest virtual Domain Development Incubator on the planet and this includes <?=ucwords($domain)?> among others. 
										</p>
										<p class="p-desc stripe-text right text-left">
										If you would like to inquire about <?=ucwords($domain)?>  with regards to partnership, proposition, or any inquiry, please use the form on this page to do so.
										</p>
									</div>
									
								</div>
								<div id="f_privacy" style="display:none;text-align: left;">
									<?include('privacy-content.php')?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!--3rd section-->

<? include('footer.php'); ?>