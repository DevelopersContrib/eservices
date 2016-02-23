<?include('header.php')?>
<?$partners_list = $partners['data'];?>
<style type="text/css">
	.blckBckgrnd{
		background: rgba(0,0,0,0.5);
		padding: 20px 15px;
		margin-bottom: 10px;
		box-shadow: 0 0 3px rgba(255, 255, 255, 0.4)
	}
</style>

<div class="container-fluid lead-reset-padd"  style="background: url(<?echo $base_url?>img/bg-socialholdings.jpg) repeat;">
    <div class="row-fluid">
        <div class="wrap-ad" style="background: none repeat scroll 0 0 rgba(0, 0, 0, 0.8);">
            <div class="container overflow-ad">
                <div class="row-fluid">
                    <div style="position:relative;">
                        <div class="animated rotateIn r-d badge-postn">
                            <a href="<?=$domain_affiliate_link;?>" target="_blank" alt="Contrib">
                                <img src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/badge-contrib-3.png">
                            </a>
                        </div>
                    </div>
                    <div class="content-ad" style="text-align: justify;">
                        <div style="margin-top: -40px;" class="text-center">
                          	<? if($info['logo']!=''){ ?>
								<a href="http://<?=$info['domain']?>"><img src="<?=$info['logo']?>" alt="<?=$info['title']?>" title="<?=$info['domain']?>" style="max-width:500px" border="0" /></a>
							<? }else{ ?>
								<h1><?=ucwords($info['domain'])?></h1>
							<? } ?>
                            <h4>Learn more about Joining our Partner Network</h4>
                        </div>
                        <a name="top"></a>


                        <div class="row-fluid text-center">
                        	<button type="button" id="show_partner_dialog" class="btn btn-large btn-primary" data-toggle="modal" data-target="#form-container">
                        		Join Our Partner Network
                        	</button>
                        	<br/>
                        </div>
                        <br/>
                        <div class="padd-banner">
                            <div class="row-fluid">
                                <div class="span2">
                                    &nbsp;
                                </div>
                                <div class="span8">
                                    <div class="row-fluid blckBckgrnd">
                                        <div class="span4">
                                            <a href="http://contrib.com">
                                                <img src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-contrib-green13.png" alt="Contrib.com" />
                                            </a>
                                        </div><!-- span4 -->
                                        <div class="span8">
                                            <h3><a href="http://contrib.com">Contrib.com</a></h3>
                                            <p>
                                                Our network of Contributors power our domains. Browse through our Marketplace of People, Partnerships,Proposals and Brands and find your next great opportunity. Join Free Today.
                                            </p>
                                        </div><!-- span8 -->
                                    </div>

                                    <div class="row-fluid blckBckgrnd">
                                        <div class="span4">
                                            <a href="http://globalventures.com">
                                                <img src="http://d2qcctj8epnr7y.cloudfront.net/images/lucille/logo-gv-re283x35.png" alt="GlobalVentures.com" />
                                            </a>
                                        </div><!-- span4 -->
                                        <div class="span8">
                                            <h3><a href="http://globalventures.com">GlobalVentures.com</a></h3>
                                            <p>
                                                Global Ventures owns a premium network of 20,000 websites and powerful tools to help you build successful companies quickly.
                                                Some of the things we offer you include a great domain name with targeted traffic, unique business model, equity ownership, and flexible, performance based compensation. You just need to bring your knowledge, passion and work smart.
                                            </p>
                                            <p>
                                                With over 17 years of internet experience, we built a network of over 20,000 websites and created dozens of successful businesses. We would love to work on the next cutting-edge projects with great companies and talented people.
                                            </p>
                                        </div><!-- span8 -->
                                    </div>

                                    <div class="row-fluid blckBckgrnd">
                                        <div class="span4">
                                            <a href="http://ifund.com">
                                                <img src="http://www.contrib.com/uploads/logo/ifund.png" alt="iFund.com" />
                                            </a>
                                        </div><!-- span4 -->
                                        <div class="span8">
                                            <h3><a href="http://ifund.com">iFund.com</a></h3>
                                            <p>
                                                iFund is a software as a service crowdfunding platform. iFund is not a registered broker-dealer and does not offer investment
                                                advice or advise on the raising of capital through securities offerings. iFund does not recommend or otherwise suggest that any
                                                investor make an investment in a particular company, or that any company offer securities to a particular investor. iFund takes no part in the negotiation or execution of transactions for the purchase or sale of securities, and at no time has possession of funds or securities. No securities transactions are executed or negotiated on or through the iFund platform.
                                                iFund receives no compensation in connection with the purchase or sale of securities.
                                            </p>
                                        </div><!-- span8 -->
                                    </div>

                                    <div class="row-fluid blckBckgrnd">
                                        <div class="span4">
                                            <a href="http://ichallenge.com">
                                                <img src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/logo-ichallenge1.png" alt="iChallenge.com" />
                                            </a>
                                        </div><!-- span4 -->
                                        <div class="span8">
                                            <h3><a href="http://ichallenge.com">iChallenge.com</a></h3>
                                            <p>
                                                The best internet challenges. Solve and win online prizes.
                                            </p>
                                        </div><!-- span8 -->
                                    </div>



                                    <!-- start dynmic partners -->


                                    <?if(isset($partners_list)){?>
										<?foreach($partners_list AS $partner_detail):?>
										<div class="row-fluid blckBckgrnd">
											<div class="span4">
												<a href="<?echo $partner_detail['url'];?>">
													<img src="<?echo $partner_detail['image'];?>" alt="<?echo $partner_detail['company_name'];?>">
												</a>
											</div><!-- span4 -->
											<div class="span8">
												<h3><a href="<?echo $partner_detail['url'];?>"><?echo $partner_detail['company_name'];?></a></h3>
												<p><?echo $partner_detail['summary'];?></p>
												<p><?echo $partner_detail['description'];?></p>
											</div><!-- span8 -->
										</div>
										<?endforeach;?>
									<?}?>
                                    <!-- dynamic partners -->
                                </div>
                                <div class="span2">
                                    &nbsp;
                                </div>
                            </div><!-- row-fluid -->
                        </div><!-- padd-banner -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--3rd section-->

<?include('footer_outer.php');?>