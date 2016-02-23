<? include_once('header.php'); ?>
<style type="text/css">
    .u-vr2 li{
        margin-bottom: 30px;
    }
    .u-vr2 li img{
        max-height: 50px;
    }
    .u-vr2.text-2 li{
        margin-bottom: 10px;
        font-size: 18px;
    }
    .u-vr2.text-2 i{
        font-size: 14px;
    }
</style>
<div style="position:relative;">
    <div class="animated rotateIn r-d badge-postn">
        <a href="<?=$domain_affiliate_link;?>" target="_blank" alt="Contrib">
            <img src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/badge-contrib-3.png">
        </a>
    </div>
</div>
<div class="container-fluid lead-reset-padd">
    <div class="row-fluid">
        <div id="wrap-lead-bckgrnd">
            <div class="content">
                <? if($info['logo']!=''){ ?>
                <a href="http://<?=$info['domain']?>"><img class="img-domain" src="<?=$info['logo']?>" alt="<?=$info['title']?>" title="<?=$info['domain']?>"/></a>					
                <? }else{ ?>
                <h1><?=ucwords($info['domain'])?></h1>
                <? } ?>
                <h2>
					<br><br>
                    <? if(str_replace(' ','',$attr['top_description'])!=''){
						echo $attr['top_description'];
					}else if(str_replace(' ','',$info['description'])!=''){
						echo $info['description'];
					}else{
						echo 'Learn more about Joining our Partner Network.';
					} ?>
                </h2>
                <div class="row-fluid" id="leadcontent">
				
                    <form class="form-inline" id="leadform" style="margin: 0;">
                        <div class="wrap-email-input">
                            <div class="input-append email-glow control-group success">							
                                <input class="input-xlarge input-lg" id="email" type="text" placeholder="email@yahoo.com" style="width: 325px;">
                                <input type="hidden" id="refid" value="0">
                                <input type="hidden" id="domain" value="<?php echo $info['domain']?>">
                                <input type="hidden" id="user_ip" value="<?php echo $_SERVER['REMOTE_ADDR']?>">
                                <button class="btn btn-danger btn-lg" id="submitLead" type="button">Join Now!</button>							
                            </div>
                            <div class="arrw-rela hidden-phone">
                                <div class="arrw-point-white">
                                    
                                </div>
                            </div>
                        </div>
                    </form>	
					
					<div class=" text-center" id="response" style="display:none">
						<h3>Thanks, your spot is reserved!</h3> 
						<br><br>
							Share <?php echo $info['domain']?> with you friends to move up in line and reserve your username.
						<br><br>
						
						<?if($attr['additional_html'] != ""):?>
							<?echo base64_decode($attr['additional_html'])?>
						<?endif;?>
						<br><br>
						<form target="_blank" action="http://www.contrib.com/signup/follow/<?php echo $info['domain']?>" method="post">
							<input type="hidden" id="pemail" name="email" value=""/>
							<button class="btn btn-warning">Continue to Follow <?php echo $info['domain']?> Brand</button>
						</form>
						<br>
						<div style="padding:10px;width:30%;opacity:.9;margin:0px auto;background:#fafafa;border-radius:8px;color:#000 !important;">
							<p>To share with your friends, click &ldquo;Share&rdquo; and &ldquo;Tweet&rdquo;:</p>
							<a href="http://twitter.com/share" class="twitter-share-button" data-count="none">Tweet</a>
							
						<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
						<iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2F'+domain+'%2F&amp;layout=standard&amp;show_faces=true&amp;width=450&amp;action=like&amp;font&amp;colorscheme=light&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:80px;" allowTransparency="true"></iframe>
						<div id="sharebuttons"><span id="facebook" style="margin:0 0 10px 60px"></span><span id="twitter"></span></div>
						
						</div>
						<div class="clearfix"></div>
						<p><small>Your email will never be sold and kept strictly for notification when we launch!</small></p>
					</div>
					
                </div>
                <div class="row-fluid">
                    <div id="social">
                        <table style="border:0px;width: 350px;margin: 0 auto;">
                            <tr>
                                <td valign='top' style='width:15%;'>
                                    <script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
                                    <script type="IN/Share" data-url="http://www.linked.com"></script>
                                </td>
                                <td valign='top' style='width:85%;'>
                                    
                                    <!-- AddThis Button BEGIN -->
                                    <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                                        <a class="addthis_button_preferred_1"></a>
                                        <a class="addthis_button_preferred_2"></a>
                                        <a class="addthis_button_preferred_3"></a>
                                        <a class="addthis_button_preferred_4"></a>
                                        <a class="addthis_button_compact"></a>
                                        <a class="addthis_counter addthis_bubble_style"></a>
                                    </div>
                                    <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>
                                    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-517895f814f07260"></script>
                                    <!-- AddThis Button END -->
                                </td>    
                            </tr>
                        </table>
                    </div>
                </div>
                <center style="margin: 15px 30px 20px 30px;">
                    <span class="counter counter-analog" data-direction="up" data-interval="1" data-format="9999999" data-stop="<?=$follow_count?>">
                        <span class="part part0">
                            <?
							$count = 7;
							$digits = strlen($follow_count);
							$splittedString = str_split($follow_count);
							for($i=$count; $i>0; $i--){
								if($i==$digits){
									for($j=0;$j<$digits;$j++){						
										echo '<span class="digit digit'.$splittedString[$j].'"></span>';
									}	
									break;					
								}else{
									echo '<span class="digit digit0"></span>';
								}
							}
                            ?>
                        </span>	
                    </span>
                </center>
				<div id="socials_container" style="text-align:center;margin-top:20px"><span id="follow_us"></span>&nbsp;</div>
			</div>
            
            
        </div>
    </div>
</div>
<div class="container">
    <div class="row-fluid text-center lead-ttle-top">
        <h1 class="brdr-lead">
            <?=ucwords($info['domain'])?> Opportunity 
        </h1>
    </div>
    <div class="row-fluid">
        <div class="span6 well">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#lc" data-toggle="tab">Latest Contribution</a></li>
                <li><a href="#discussions" data-toggle="tab">Discussions</a></li>
                <li><a href="#people" data-toggle="tab">People</a></li>
                <li><a href="#jobs" data-toggle="tab">Jobs</a></li>
            </ul>
            
            <div class="tab-content">
                <div class="tab-pane active" id="lc">
                    <br>
                    <script src="http://tools.contrib.com/cwidget?d=<?echo $info['domain'] ?>&p=ur&c=lc"></script>
                </div>
                <div class="tab-pane" id="discussions">
                    <br>
                    <script type="text/javascript" src="http://tools.contrib.com/cwidget/forum?f=all&l=3"></script>
                </div>
                <div class="tab-pane" id="people">
					<div class="wrap-thumb">
					<?php 
          foreach ($data_widget_users['data'] as $w) {
             	$widu_username = $w['Username'];
    					$widu_fname = $w['FirstName'];
    					$widu_country = $w['country'];
          
					?>
					<div class="user_wrap-thumb-content">
					<a href="http://www.contrib.com/people/me/<?=$widu_username?>" class="user_a-cont"><h4 class="user_ellipsis user_head-h4"><span class="user_label user_label-warning"><?=ucfirst($widu_fname)?></span>&nbsp;
					<small><span style="font-size: 11px;">FROM</span> <?=ucwords($widu_country) ?></small></h4></a>
					</div>
					<?php } ?>
					</div>				
				</div>
                <div class="tab-pane" id="jobs">
					<div class="wrap-thumb">
					<?php  
          foreach ($data_widget_jobs['data'] as $j){
  					$widj_domain = $j['domain_name'];
  					$widj_jobid = $j['job_id'];
  					$widj_title = $j['title'];
  					?>
					<div class="job_wrap-thumb-content">													
					<a href="http://www.contrib.com/brand/jobs/<?=$widj_domain?>/<?=$widj_jobid?>" class="job_a-cont"><h5 class="job_ellipsis job_head-h5"><span class="job_label job_label-important"><?=ucwords($widj_domain)?></span> <small><span style="font-size: 11px;">NEEDS</span> <?=$widj_title?></small></h5></a>
					</div>
					<?php } ?>
					</div>
				</div>
            </div>  
        </div>
        
        <div class="span6">
            <br /><br />
            <div class="row-fluid">
                <div class="span4 features">
                    <div class="media"><a class="pull-left" href="http://www.contrib.com/signup/follow/<?=ucwords($info['domain'])?>" target="_blank">
                        <img class="media-object img-phone" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/icon-50x50-contrib-market2.png" alt="Marketplace" style="padding-bottom: 40px;"></a>
                        <h4 class="media-heading">Contrib Marketplace </h4>
                        <p>Browse Jobs, Ideas and Micro Tasks.</p></div> 
                </div>
                <div class="span4 features">
                    <div class="media">
                        <a class="pull-left" href="http://www.contrib.com/signup/follow/<?=ucwords($info['domain'])?>" target="_blank">
                            <img class="media-object img-phone" alt="Contribute" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/icon-50x50-contrib-contribute2.png" style="padding-bottom: 40px;">
                        </a>
                        <h4 class="media-heading">Contribute</h4>
                        <p>Contribute using your skills, services, apps and/or capital.
                        </p>
                    </div>
                </div>
                <div class="span4 features">
                    <div class="media">
                        <a class="pull-left" href="http://www.contrib.com/signup/follow/<?=ucwords($info['domain'])?>" target="_blank">
                            <img class="media-object img-phone" alt="Make Money through Contribution" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/icon-50x50-contrib-money2.png" style="padding-bottom: 40px;">
                        </a>
                        <h4 class="media-heading">Earn Equity</h4>
                        <p>Get equity for your hard work and be the next success story!</p>
                    </div>
                </div>
            </div>            
            <div class="clearfix"></div>
            <br />      
            <p class="p-desc p-phone">
                We envision people around the world with complementary skills, passion, time and resources coworking 
                online with targeted premium assets just like <?=ucwords($info['domain'])?>. </p> 
            
        </div>
    </div>  
    
</div>
<div class="container-fluid" style="background:none repeat scroll 0 0 #F2F2F2;margin-top: 50px;">
    <div class="row-fluid">	
        <div class="row-fluid featre-scroll">
            <div class="absolute-scroll">
                <h3 style="text-align: center;margin: 30px 0 5px;">Follow, Build, and Help Launch<i>!</i></h3>
                <p>
                    <b>Follow <?=ucwords($info['domain'])?></b> and other great ventures on the Contrib platform.
                    <br><br>
                    <b>Build <?=ucwords($info['domain'])?></b> and Help cofound a relevant new Startup, Part-Time.
                    <br><br>
                    <b>Launch <?=ucwords($info['domain'])?></b> and you could be front and center in the process. Launch <?=ucwords($info['domain'])?> with us today!
                </p>
                <p class="text-center">
                    <a href="http://contrib.com/brand/details/<?=$info['domain']?>" target="_blank" class="btn btn-primary btn-large phne-s1">
                        Learn about <?=ucwords($info['domain'])?>
                    </a>
                </p>
            </div>
        </div>
        <div class="row-fluid">
            <div class="wrap-hori-scroll">
                <div class="als-container" id="demo3">
                    <div class="als-viewport">
                        <ul class="als-wrapper">
                            <li class="als-item"><a href="http://applications.net" target="_blank"><img src="http://d2qcctj8epnr7y.cloudfront.net/images/framework/applicationsnet.png" alt="applications.net" title="applications.net" /></a></li>
                            <li class="als-item"><a href="http://consultants.com" target="_blank"><img src="http://d2qcctj8epnr7y.cloudfront.net/images/framework/consultants.png" alt="consultants.com" title="consultants.com" /></a></li>
                            <li class="als-item"><a href="http://globalventures.com" target="_blank"><img src="http://d2qcctj8epnr7y.cloudfront.net/images/framework/globalventures.png" alt="globalventures.com" title="globalventures.com" /></a></li>
                            <li class="als-item"><a href="http://photostream.com" target="_blank"><img src="http://d2qcctj8epnr7y.cloudfront.net/images/framework/photostream.png" alt="photostream.com" title="photostream.com" /></a></li>
                            <li class="als-item"><a href="http://referrals.com" target="_blank"><img src="http://d2qcctj8epnr7y.cloudfront.net/images/framework/referrals.png" alt="referrals.com" title="referrals.com" /></a></li>
                            <li class="als-item"><a href="http://venturecamp.com" target="_blank"><img src="http://d2qcctj8epnr7y.cloudfront.net/images/framework/venturecamp.png" alt="venturecamp.com" title="venturecamp.com" /></a></li>
                            <li class="als-item"><a href="http://virtualinterns.com" target="_blank"><img src="http://d2qcctj8epnr7y.cloudfront.net/images/framework/virtualinterns.png" alt="virtualinterns.com" title="virtualinterns.com" /></a></li>
                            <li class="als-item"><a href="http://wellnesschallenge.com" target="_blank"><img src="http://d2qcctj8epnr7y.cloudfront.net/images/framework/wellnesschallenge.png" alt="wellnesschallenge.com" title="wellnesschallenge.com" /></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--Scrolling-->
<div class="container" style="background:none repeat scroll 0 0 #fff;">
    <div class="row-fluid text-center lead-ttle-top">
        <h1 class="brdr-lead">
            <?=ucwords($info['domain'])?> Team
        </h1>
    </div>
    <p class="p-desc">
        <?=ucwords($info['domain'])?> is a bit different than most startups.  We are small, diverse team working remotely and loving what we do.  We only cowork with others who also have this same passion.
        <br><br>
        <?=ucwords($info['domain'])?> seeks to contract and hire the best people and then trust them: it's the thinking behind the work at their own time policy. 
        <br><br>
        The <?=ucwords($info['domain'])?> team loves building things and focus on being the most productive individual, not the amount of time spent in the office. We put a lot of effort into making <?=ucwords($info['domain'])?> a fun place to work for people who like getting things done. So if you're game with this then enter your email address and be a part of the global team.
    </p>

</div><!--2nd section-->

<? if(sizeof($vertical_domains)>0){ ?>
<div class="container-fluid" style="background:none repeat scroll 0 0 #F2F2F2;padding-bottom:25px;">
    <div class="row-fluid">
        <div class="container">
            <div class="row-fluid">
                <div class="row-fluid text-center lead-ttle-top">
                    <h1 class="brdr-lead">
                        Other Brands on <?=str_replace('-',' ',$vertical_domains[0]['slug'])?> Vertical
                    </h1>
                </div>
                <div class="row-fluid">
                    <div class="span-12">
                        <div class="row-fluid">
                            <div class="span6">
                                <div class="row-fluid">
                                    <div class="span6">
                                        <ul class="unstyled u-vr2">
											<? $row_cnt = 0; ?>
											<? shuffle($vertical_domains); ?>
											<? foreach($vertical_domains as $row){ ?> 
												<li>
													<a href="http://<?=$row['domain_name']?>" target="_blank">
														<img src="<?=$row['logo']?>" alt="<?=$row['domain_name']?>">
													</a>
												</li>
												<? $row_cnt++; ?>
												<? if($row_cnt==6) break; ?>
												<? if($row_cnt%3==0){ ?>
														</ul>
													</div>
												<div class="span6">
													<ul class="unstyled u-vr2">
												<? }?> 
											<? } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="row-fluid" style="background: none repeat scroll 0 0 #fff;border: 1px solid #ddd;padding: 10px 0 10px 15px;border-radius:4px;">
                                    <div class="span6">
                                        <ul class="unstyled u-vr2 text-2">
											<? $row_cnt1 = 0; ?>
											<? shuffle($vertical_domains_nologo); ?>
											<? foreach($vertical_domains_nologo as $row1){ ?>
												<li>
                                                    <i class="icon-star-empty"></i>
													<a href="http://<?=$row1['domain_name']?>" target="_blank">
														<?=ucwords($row1['domain_name'])?>
													</a>
												</li>
												<? $row_cnt1++; ?>
												<? if($row_cnt1==12) break; ?>
												<? if($row_cnt1%6==0){ ?>
														</ul>
													</div>
												<div class="span6">
													<ul class="unstyled u-vr2 text-2">
												<? } ?>
											<? } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row-fluid text-center">
                    <div class="span12">
                        <a href="http://www.contrib.com/verticals/news/<?=$vertical_domains[0]['slug']?>" target="_blank" class="btn btn-primary">
                            <i class="icon-search"></i>
                            View more
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<? } ?>

<div class="container-fluid lead-reset-padd"  style="background: url(/img/bg-socialholdings.jpg) repeat;">
    <div class="row-fluid">
        <div class="wrap-ad" style="background: none repeat scroll 0 0 rgba(0, 0, 0, 0.8);">
            <div class="container overflow-ad">
                <div class="row-fluid">
                    <div class="content-ad">
                        <div class="section-heading-ttle text-left">
                            <a name="top"></a>
                            <h2 style="padding-left:0;"><span>About</span> <?=ucwords($info['domain'])?></h2>							
                        </div>
                        <div class="row-fluid">
                            <div class="span12">
                                <div>
                                    <div class="span4">
                                        <img class="ad-img" src="http://d2qcctj8epnr7y.cloudfront.net/images/marvinpogi/logo-ecorp2.png" style="margin: 30px 0 0 -50px;"/>
									</div><!--end span4-->
                                    <div class="span7">
                                        <div>
                                            <p class="p-desc stripe-text right text-left">
                                                <span class="p-intro"><?=ucwords($info['domain'])?></span>
                                                Platform is part of the Global Ventures Network.											
                                                <br>
                                                <br>
                                                Founded in 1996, Global Ventures is the worlds largest virtual Domain Development Incubator on the planet.
                                                <br>
                                                <br>
                                                We create and match great domain platforms with talented people, applications and resources to build successful, value driven, web-based businesses. Join the fastest growing Virtual Business Network and earn Equity and Cowork with other great people making a difference.
                                            </p>
                                            <br />
                                            <p class="p-desc stripe-text left text-left">
                                                <a href="http://globalventures.com" target="_blank" class="btn btn-primary btn-large">
                                                    Learn about this site
                                                </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--3rd section-->

<? include('footer_outer.php'); ?>