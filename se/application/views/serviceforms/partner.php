<script src="<?php echo $base_url?>js/serviceforms/partner.js"></script>

<div class="row-fluid">
	<div class="partnerMainCont" id="partner_step1">
        <h2 class="ttleCapt">Partner with <?=ucwords($info['domain'])?></h2>
        <div class="formDesc">
            <small>
                When you submit your registration, you can quickly partner with <?=ucfirst($info['domain'])?>. This is a great way to build your service and at the same way add value to this asset.  
            </small>
        </div>
        <div class="stepsMain">
            <div class="step text-center">
                <h4>Step 1: <i class="icon-file-alt"></i> Submit Your Partnership Application</h4>
                <p>You will receive an email when we feel our partnership will be win-win.</p>
            </div>
            <div class="step text-center">
                <h4>Step 2: <i class="icon-tasks"></i> Join a Team</h4>
                <p>Once your partnership proposal is something we could take on, we will make you part of our team and our partner.</p>
            </div>
        </div>
        <div class="row-fluid">
            <form class="" onsubmit="return false;">
                <div class="emailContainer">
                    <div class="pull-left s3Input">
                        <input class="s1Input input-block-level" type="text" id="partner_initialemail" placeholder="Enter e-mail address" />
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="form-actions f-a-style">
                    <span class="pull-left text-error" id="partner_warning1"></span>
                    <button type="submit" class="btn blue pull-right" id="partner_btn_1">Apply Today <i class="icon-circle-arrow-right"></i></button>
                </div>
            </form>
        </div>
    </div> 
	<div class="partnerMainCont" id="partner_step2" style="display:none">
        <h2 class="ttleCapt">Partner with <?=ucwords($info['domain'])?></h2>
        <div class="formDesc">
            <small>
                When you submit your registration, you can quickly partner with <?=ucfirst($info['domain'])?>. This is a great way to build your service and at the same way add value to this asset.  
            </small>
        </div>
		<form class="" onsubmit="return false;">
			<div class="row-fluid">						
				<div class="formTwo 1">
					<label for="partner_firstname" class="control-label">
						First Name <i class="text-error">*</i>
					</label>
					<input class="s1Input input-block-level" type="text" id="partner_firstname" />
				</div>
				<div class="formTwo">
					<label for="partner_lastname" class="control-label">
						Last Name <i class="text-error">*</i>
					</label>
					<input class="s1Input input-block-level" type="text" id="partner_lastname" />
				</div>
				<div class="formTwo 1">	
					<label for="partner_email" class="control-label">
						Email <i class="text-error">*</i>
					</label>
					<input class="s1Input input-block-level" type="text" id="partner_email" placeholder="Email" />
				</div>
				<div class="formTwo">	
					<label for="partner_website" class="control-label">
						Website
					</label>
					<input class="s1Input input-block-level" type="text" id="partner_website" />
				</div>					
				<div class="formTwo 1">		
					<label for="partner_country" class="control-label">
						Country <i class="text-error">*</i>
					</label>
					<select class="selectS2 input-block-level" name="" id="partner_country">
						<option value=""></option>									
						<?php for($ci=0;$ci<sizeof($countriesarray);$ci++){ ?>											
						<option value="<?=$countriesarray[$ci]['country_id']?>"><?=$countriesarray[$ci]['name']?></option>
						<?php } ?>
					</select>
				</div>
				<div class="formTwo">	
					<label for="partner_city" class="control-label">
						City <i class="text-error">*</i>
					</label>
					<input class="s1Input input-block-level" type="text" id="partner_city" />
				</div>
				<div class="formTwo 1">		
					<label for="partner_password" class="control-label">
						Password <i class="text-error">*</i>
					</label>
					<input class="s1Input input-block-level" type="password" id="partner_password" />
				</div>
				<div class="formTwo">	
					<label for="partner_cpassword" class="control-label">
						Confirm Password <i class="text-error">*</i>
					</label>
					<input class="s1Input input-block-level" type="password" id="partner_password2" />
				</div>					
			</div>
			<div class="row-fluid"style="margin-top: 10px;">
				<div class="requiredFieldError" id="partner_warning2"></div>
				<div class="form2Button">
					<button type="submit" class="btn blue" id="partner_btn_2" style="float: right;">Next <i class="icon-circle-arrow-right"></i></button>
				</div>
			</div>
		</form>
    </div>       
	<div class="partnerMainCont" id="partner_step3" style="display:none">
        <h2 class="ttleCapt">Partner with <?=ucwords($info['domain'])?></h2>
        <div class="formDesc">
            <small>
                When you submit your registration, you can quickly partner with <?=ucfirst($info['domain'])?>. This is a great way to build your service and at the same way add value to this asset.  
            </small>
        </div>
		<form class="" onsubmit="return false;">
			<div class="row-fluid">	
				<div class="formTwo" style="width:99%">
					<label for="partner_type" class="control-label">
						Partnership Type <i class="text-error">*</i>
					</label>
					<select class="selectS2 input-block-level" name="" id="partner_type">
						<option value=""></option>
						<?php foreach ($parnershiptypes as $type){ ?>
						<option value="<?php echo $type;?>"><?php echo $type;?></option>
						<?php } ?>
					</select>
				</div>
							
				<div class="formTwo" style="width:99%">	
					<label for="partner_message" class="control-label">
						Why we should partner with you? <i class="text-error">*</i>
					</label>
					<textarea class="textS2 input-block-level" id="partner_message" rows="4"></textarea>
				</div>
			</div>
			<div class="row-fluid">
				<div class="requiredFieldError" id="partner_warning3"></div>							
				<div class="form2Button">
					<button type="button" class="btn blue" style="float: right;" id="partner_btn_3">Next <i class="icon-circle-arrow-right"></i></button>
					<button type="button" class="btn blue" id="partner_back_3"><i class="icon-circle-arrow-left"></i>Back</button>   
				<input type="hidden" id="partner_domain" value="<?=$info['domain']?>">
				</div>
			</div>
		</form>
	</div>
	
	<div class="partnerMainCont" id="partner_step4" style="display:none">
                    <h2 class="ttleCapt">Partner with <?=ucwords($info['domain'])?></h2>
                    <div class="formDesc">
                        <small>
                            When you submit your registration, you can quickly partner with <?=ucfirst($info['domain'])?>. This is a great way to build your service and at the same way add value to this asset.  
                        </small>
                    </div>
					<form class="" onsubmit="return false;">
						<div class="row-fluid" style="display:inline-block">	
							<div class="formTwo" style="width:99%">
								<label for="" class="control-label">
									Company Title <i class="text-error">* title/name of your company to promote.</i>
								</label>
								<input class="s1Input input-block-level" type="text" id="partner_company" />		
							</div>
							<div class="formTwo formTwoNew" style="width:99%">
								<label for="" class="control-label">
									Company Description <i class="text-error">* a short summary of your company.</i>
								</label>
								<textarea class="textS2 input-block-level" id="partner_companydescription" rows="3" style="font-size: 12px;margin-bottom: 0;"></textarea>	
							</div>
							<div class="formTwo formTwoNew" style="width:99%">
								<label for="" class="control-label">
									Company Image <i class="text-error">* URL/link to your company&#39;s image or logo</i>
								</label>
								<input class="s1Input input-block-level" type="text" id="partner_companyimage" />							
							</div>
							<div class="formTwo formTwoNew" style="width:99%">
								<label for="partner_companyurl" class="control-label">
									Company Link <i class="text-error">* allows us to promote your company</i>
								</label>
								<input class="s1Input input-block-level" type="text" id="partner_companyurl" />							
							</div>
						</div>
						<div class="row-fluid">
							<div class="requiredFieldError" id="partner_warning4_" style="font-size: 11px;font-weight:bold"></div>							
							<div class="form2Button">
								<button type="button" class="btn blue" style="float: right;" id="partner_btn_4">Apply Today <i class="icon-circle-arrow-right"></i></button>
								<button type="button" class="btn blue" id="partner_back_4"><i class="icon-circle-arrow-left"></i>Back</button>   
							<input type="hidden" id="partner_domain" value="<?=$info['domain']?>">
							</div>
						</div>
					</form>
	</div>
	
 	<div class="partnerMainCont" id="partner_final" style="display:none">
		<h2 class="ttleCapt">Partner with <?=ucwords($info['domain'])?></h2>
		<hr />
		<h2 class="text-error text-center">Thank you for your Partnership application.</h2>
		<div class="formDesc2 text-center">
			<small>
				<b>Step 1:</b> Please <a href="/referral">login</a> to get your referral widgets. <br><b>Step 2:</b>You are now minutes away to joining <?=ucwords($info['domain'])?> team. All you need to do right now is click the link in the <span class="text-info">Verification email</span> that we have just sent you. If you still haven&rsquo;t received it, please check your spam inbox. Your verification link will redirect you to our <a href="http://www.contrib.com" target="_blank">Marketpalce hub</a> where you can login and check out your application status. <br><b>Step 3:</b>You can now take part in actually building out an asset by sending proposals, partnering with brands, joining teams. 
			</small>
		</div>
	</div>
</div>
<!--end partner-->	
