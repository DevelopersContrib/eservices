<?php include 'header-pages.php'; ?>

<title>Fund <?=$domain?></title>
	<meta name="title" content="Fund <?=$domain?> " />
	<meta name="description" content="Contact <?=$domain?> today." />
	<style>
	.fund-container {
	background: rgb(250, 250, 250) none repeat scroll 0% 0%;
	padding: 10px;
	border: 1px solid rgb(222, 222, 222);
	}	

.rower {
 -moz-column-width: 18em;
 -webkit-column-width: 18em;
 -moz-column-gap: 1em;
 -webkit-column-gap:1em; 
  
}

.item {
 display: inline-block;
 padding:  .25rem;
 width:  100%; 
 margin-bottom: 15px;
}

.well {
 position:relative;
 display: block;
}
section {   
    padding-bottom: 10px;
}
.funded-l {
	float:left;
}
.funded-r {
	float:right;
}
/*ribbon*/
	.ribbon-wrapper-orange {
    height: 88px;
    overflow: hidden;
    z-index: 1;
    width: 85px;
    position: absolute;
    margin-left: 185px;
	margin-top: -17px;
    z-index: 1;
}

	.ribbon-orange {
		font: bold 15px Sans-Serif;
		color: #fff;
		text-align: center;
		-webkit-transform: rotate(45deg);
		-moz-transform:    rotate(45deg);
		-ms-transform:     rotate(45deg);
		-o-transform:      rotate(45deg);
		position: relative;
		padding: 7px 0;
		left: -5px;
		top: 15px;
		width: 120px;
		border: solid 1px #da7c0c;
		background: #f78d1d;
		background: -webkit-gradient(linear, left top, left bottom, from(#faa51a), to(#f47a20));
		background: -moz-linear-gradient(top,  #faa51a,  #f47a20);
		filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#faa51a', endColorstr='#f47a20');
		-webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.3);
		-moz-box-shadow:    0px 0px 3px rgba(0,0,0,0.3);
		box-shadow:         0px 0px 3px rgba(0,0,0,0.3);
	}
	.ribbon-orange a{
		color: #fff;
		display: block;
	}
	.ribbon-orange a:hover,.ribbon-orange a:focus{
		color: #fff;
		text-decoration: none;
		outline: none;
	}
	.ribbon-orange:before, .ribbon-orange:after {
		content: "";
		border-top:   3px solid #6e8900;   
		border-left:  3px solid transparent;
		border-right: 3px solid transparent;
		position:absolute;
		bottom: -3px;
	}

	.ribbon-orange:before {
		left: 0;
	}
	.ribbon-orange:after {
		right: 0;
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
                        <h1 class="black-text">Fund <?=$domain?></h1>
                        <!-- end page title -->
                    </div>
                    <div style="visibility: visible; animation-duration: 600ms; animation-name: fadeInUp;" class="col-md-4 col-sm-12 breadcrumb text-uppercase wow fadeInUp xs-display-none animated" data-wow-duration="600ms">
                        <!-- breadcrumb -->
                        <ul>
                            <li><a href="/">Home</a></li>
                            <li><a href="/fund">Fund</a></li>
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
                        <p class="title-large text-uppercase letter-spacing-1 black-text font-weight-600">Fund Our Services</p>
                    </div>
                </div>						
			</div>
		</section>

<div class="container"> 
	<div class="row rower">
	<?foreach($fund_campaigns as $funds):?>
							<?if($funds['post_title'] != 'Micro Markets'):?>
		<div class="item">		
		  <div class="well2"> 	
									<div class="fund-container">
										<div class="ribbon-wrapper-orange">
											<div class="ribbon-orange">Staff Pick</div>
										</div>									
										<?php if($funds['logo'] != ""):?>
										<img src="<?php echo $funds['logo']?>" class="img-responsive" />
										<?php endif;?>
										<a target="_blank" class="alink" href="<?php echo $funds['permalink']?>">
											<h3><?php echo $funds['post_title']?></h3>
										</a>
										<p class="fund-desc"><?php echo strip_tags($funds['post_content'])?></p>
										<div class="funded-l">
											<div class="fund-icon"><i class="fa fa-usd"></i></div>
											<div class="fund-details">
												<p>Funded</p>
												<p><b><?php echo number_format($funds['campaign_goal'],2)?></b></p>
											</div>
											<div style="clear:both"></div>
										</div>
										<div class="funded-r">
											<div class="fund-icon"><i class="fa fa-bar-chart"></i></div>
											<div class="fund-details">
												<p>Funded</p>
												<p><b>10%</b></p>
											</div>
											<div style="clear:both"></div>
										</div>
										<div style="clear:both"></div>
									</div>					 
		  </div>
		</div>
	<?endif;?>
	<?endforeach?>	
	</div>
</div>
		
<?php include_once 'footer.php';?>       

