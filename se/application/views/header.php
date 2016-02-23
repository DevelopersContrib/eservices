<!DOCTYPE html>
<html>
<head>
<link rel="canonical" href="http://<?=$info['domain']?>/<?=basename($_SERVER['PHP_SELF'])?>/" />
<link rel="icon" type="image/icon" href="favicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="index, follow" />
<title><?=$info['title']?> - <?=$metatitle?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="title" content="<?=$info['title']?> " />
<meta name="description" content="<?=ucwords($info['domain'])?> - <?=$info['description']?>" />
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $base_url?>css/custom-lead.css"/>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $base_url?>css/bootstrap-responsive.css"/>
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $base_url?>js/jquery.counter-analog.css"  />
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $base_url?>js/jquery.counter-analog2.css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $base_url?>css/serviceforms/partner.css">
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $base_url?>css/serviceforms/staffing.css">
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $base_url?>css/serviceforms/offer.css">
<link rel="stylesheet" media="screen" type="text/css" href="<?php echo $base_url?>css/serviceforms/inquiry.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<style type="text/css">
<? if($attr['background_image'] != ""){ ?>
	#wrap-lead-bckgrnd{ background: url(<?=$attr['background_image']?>);color: #A0A0A0;
<? }else{ ?>
	#wrap-lead-bckgrnd{ background: url('http://rdbuploads.s3.amazonaws.com/backgrounds/abstract-desktop-desktop-02.jpg') no-repeat; }
<? } ?>
</style>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?=$info['account_ga'] ?>', '<?=$info['domain'] ?>');
  ga('send', 'pageview');

</script>
<!-- Piwik -->
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//www.stats.numberchallenge.com/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', <?=$info['piwik_id'] ?>]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//www.stats.numberchallenge.com/piwik.php?idsite=<?=$info['piwik_id'] ?>" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->

</head>
<body>
<? if($forsale=='1' || $forsaledefault = '1'){ ?>
<div class="row-fluid">
   <div class="navbar-inner">	
		<h5 class="text-center"> This domain belongs to the Global Ventures network. We have interesting opportunities for work, sponsors and partnerships. <a id="_contactus" data-toggle="modal" data-target="#form-container">Inquire now</a>.</h5>
	</div>
</div>
<? } ?>

	