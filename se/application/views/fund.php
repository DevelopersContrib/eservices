<? include('header.php'); ?>
<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
<link href="http://fonts.googleapis.com/css?family=Lato:300,400" type="text/css" rel="stylesheet" />
<style type="text/css">
	.fund-backgrnd{
		background: url('<?echo $base_url?>img/bg-socialholdings.jpg') repeat;
	}
	.sub-fund-container{
		background: none repeat scroll 0 0 rgba(0, 0, 0, 0.8);
		padding: 50px 0;
	}
	.fnt-sans{
		font-family: 'Open Sans', sans-serif;
	}
	.fnt-lato{
		font-family: 'Lato', Arial, sans-serif;
	}
	.fnt-size1-lato{
		font-size: 15px;
		letter-spacing: 1px;
		margin: 0;
	}
	.fnt-300{
		font-weight: 300 !important;
	}
	.fnt-400{
		font-weight: 400 !important;
	}
	.wrap-ifund-container{
		background: none repeat scroll 0 0 #fff;
		box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
		font-family: "Lato",sans-serif;
		padding: 5px 15px;
		margin-bottom: 25px;
	}
	/*ribbon*/
	.ribbon-wrapper-orange {
		height: 88px;
		overflow: hidden;
		position: absolute;
		right: -3px;
		top: -7px;
		width: 85px;
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
	.fund-ttle-a,.fund-ttle-a:hover,.fund-ttle-a:focus{
		color: #515151;
		outline: none;
	}
	.digits{
		color: #565656;
		font-size: 10px;
		margin: 20px 0 5px;
		overflow: hidden;
	}
	.bar {
		background: none repeat scroll 0 0 #c5c5c5;
		height: 8px;
		margin: 0 0 5px;
	}
	.bar span{
		background: none repeat scroll 0 0 #04937f;
		height: 8px;
		float: left;
	}
	.digits ul {
		list-style: outside none none !important;
		margin: 0;
	}
	.digits li {
		float: left;
		margin: 0 !important;
		text-transform: uppercase;
		width: 33%;
	}
	.digits strong {
		color: #282828;
		display: block;
		font-size: 11px;
		font-weight: 700;
		margin: 0 0 -4px;
	}
	.brdr-lead{
		color: #fff;
	}
	.brdr-lead:before,.brdr-lead:after{
		border-color: #fff;
	}
	.lead-ttle-top{
		margin-top: 0;
		margin-bottom: 40px;
	}
</style>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/masonry/3.1.5/masonry.pkgd.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('#wrapper-container').masonry({
			columnWidth: '.span3',
			transitionDuration: '0.4s',
			itemSelector : '.item'
		});
	});
</script>
<div class="container-fluid fund-backgrnd lead-reset-padd">
	<div class="sub-fund-container">
		<div class="container">
			<div class="row-fluid text-center lead-ttle-top">
                <h1 class="brdr-lead">
                    Fund Our Ventures
                </h1>
            </div>
			<div class="row" id="wrapper-container">
				<?php 
				if(sizeof($fundcampaigns)>0){
					foreach($fundcampaigns as $item){
				?>
				<div class="span3 item">
					<div class="wrap-ifund-container">
						<div class="ribbon-wrapper-orange">
							<div class="ribbon-orange">
								<a href="<?=$item['permalink']?>">Staff Pick</a>
							</div> 
						</div>
						<a rel="bookmark" title="<?=$item['post_title']?>" href="<?=$item['permalink']?>">
							<img  alt="Cook board" class="attachment-campaign wp-post-image" src="<?=$item['logo']?>">
						</a>
						<h3 class="fnt-size1-lato fnt-lato">
							<a href="<?=$item['permalink']?>" class="fund-ttle-a"><?=$item['post_title']?></a>
						</h3>
						<p><?=$item['post_content']?></p>
						<div class="digits">
							<div class="bar">
								<span style="width: 10%"></span>
							</div>
							<ul>
								<li><strong>10%</strong> Funded</li>
								<li><strong>$10,000.00</strong> Funded</li>
							</ul>
						</div>
					</div>
				</div>
				<?php }
				}?>
			</div>
		</div>
	</div>
</div><!--3rd section-->
<? include('footer_outer.php'); ?>