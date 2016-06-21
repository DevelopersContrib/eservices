<?php include 'includes/class.db.php';?>
<?php include 'includes/functions.php'?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <!--<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">-->
     <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Eservices Landing Page</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- <link rel="icon" type="/image/png" href="favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="/image/png" href="favicon-16x16.png" sizes="16x16" /> -->
    <link rel="stylesheet" href="/css/normalize.min.css">
    <!-- <link rel="stylesheet" href="css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" /   >
    <link rel="stylesheet" href="/css/jquery.fancybox.css">
    <link rel="stylesheet" href="/css/flexslider.css">
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/queries.css">
    <link rel="stylesheet" href="/css/etline-font.css">
    <link rel="stylesheet" href="/bower_components/animate.css/animate.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    
     <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-41926954-37']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//www.stats.numberchallenge.com/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 95]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//www.stats.numberchallenge.com/piwik.php?idsite=95" style="border:0;" alt="" /></p></noscript>
    
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

    <style>
        html, body{
            overflow-x:visible;
        }
        .brdr{
            border :1px solid;
        }
        .fnt-nunito{
            font-family: "Nunito", sans-serif;
        }
        .fnt-300{
            font-weight: 300;
        }
        .fnt-400{
            font-weight: 400;
        }
        .fnt-600{
            font-weight: 600;
        }
        .fnt-bold{
            font-weight: bold;
        }
        .text-black{
            color: #000;
        }
        .wrap-findServicesForm{
            width: 80%;
            margin:auto;
            position: relative;
            padding-left: 15px;
            padding-right: 15px;
        }
        .wrap-findServicesForm:before,.wrap-findServicesForm:after{
            display: table;
            content: "";
        }
        .wrap-findServicesForm:after{
            clear: both;
        }
        p.intro.p-cust-intro{
            margin-bottom: 25px;
        }
        .wrap-findServicesForm .btn{
            border-radius: 4px;
            border:0;
        }
        .wrap-findServicesForm .btn-lg{
            font-size: 18px;
        }
        .hero.hero-main{
            background-image: url('http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-lander-3.jpg');
        }
        section.intro.featuresMidBlck-main{
            background-color: #f7f7f7;
            border-bottom: 1px solid #e1e1e1;
            border-top: 1px solid #e1e1e1;
            z-index: 2;
            padding-bottom: 50px;
            position: relative;
        }
        .featuresMidBlck{
            margin-top: -50px;
            border:1px solid #ccc;
            background-color: #f0f0f0;
            border-radius: 10px;
            color: #000;
            padding-bottom: 25px;
        }
        p.intro.p-cust-intro, .sub-small,.hero-content .ttle{
            text-shadow: 0 2px 1px #000;
        }
        .sub-small{
            color: #aaa;
        }
        .wrap-features-title .ttle{
            margin-bottom: 0;
        }
        .wrap-features-title-2 .ttle{
            margin-top: 0;
        }
        .wrap-features-title .sub-ttle{
            color: #000;
            padding-bottom: 10px;
        }

        /* Grid Features */
        .wrap-item-grid{
            background-color: #fff;
            border-radius: 4px;
            border:1px solid #ccc;
            padding: 5px;
            display: block;
            margin-bottom: 25px;
        }
        .wrap-item-header {
            height: 58px;
            overflow: hidden;
        }
        .wrap-item-title{
            font-weight: bold;
            font-size: 17px;
            line-height: 28px;
            margin-top: 5px;
            word-wrap: break-word;
            display: block;
            color: #000;
        }
        .wrap-item-meta{
            color: #999;
            display: block;
            margin-bottom: 10px;
        }
        .wrap-item-img img {
            border: 1px solid #e9e9e9;
        }
        a.wrap-item-grid:hover .wrap-item-title{
            color:#ff5274;
        }
        .brdrBtm-trending{
            border-bottom: 1px solid #c9c9c9;
            padding-bottom: 20px;
            margin-bottom: 30px
        }
        /* Hovering Feature */

        .wrap-item-grid.wig-2{
            height:330px;
            position: relative;
        }
        .wrap-item-grid.wig-2:before,.wrap-item-grid.wig-2:after,
        .wrap-item-user-main:before,.wrap-item-user-main:after,
        .wrap-feature-footer:before,.wrap-feature-footer:after{
            display: table;
            content: "";
        }
        .wrap-item-grid.wig-2:after,
        .wrap-item-user-main:after,
        .wrap-feature-footer:after{
            clear: both;
        }
        /* User Name Hovering */
        .wrap-item-user-main{
            color: #000;
            font-size: 12px;
            padding: 7px 5px;
            width: 100%;
        }
        .wrap-item-grid.wig-2 .wrap-item-user-main{
            height: 0;
            left: 0;
            line-height: 34px;
            overflow: hidden;
            padding: 0 12px;
            position: absolute;
            top: 0;
            transform: translate3d(0px, 0px, 0px);
            transition: all 0.15s ease-in-out 0s;
        }
        .wrap-item-grid.wig-2:hover .wrap-item-user-main{
            height: 35px;
        }
        .wrap-item-user-main .by, .wism-num{
            color: #b2b2b2;
            display: inline-block;
        }
        .wism-num .fa-star,.fa-yellow{
            color: #e5e500;
        }
        .wism-un{
            color: #000;
        }
        .wisg-meta-info{
            text-transform: capitalize;
        }
        .wism-num{
            float: right;
        }
        /* Hovering Link Image and Description */
        .wism-a-link{
            display: block;
            position: relative;
            text-decoration: none !important;
            transform: translate3d(0px, 0px, 0px);
            transition: all 0.15s ease-in-out 0s;
        }

        .wrap-item-grid.wig-2:hover .wism-a-link{
            margin-top: 30px;
        }
        /* Hovering Link Desc */

        .wism-al-desc h3{
            color: #303030;
            display: block;
            font-size: 15px;
            font-weight: 400;
            height: 40px;
            line-height: 20px;
            margin: 5px 12px 9px;
            overflow: hidden;
            transition: all 0.15s ease-in-out 0s;
            word-wrap: break-word;
        }
        .wism-al-desc h2{
            font-weight: bold;
            font-size: 17px;
            line-height: 20px;
            height: 40px;
            overflow: hidden;
            margin: 5px 12px 9px;
        }
        .wrap-item-grid.wig-2:hover .wism-al-desc h3{
            color: #ff5274;
            text-decoration: underline;
        }
        /* Hovering Footer */
        .wrap-feature-footer{
            height: 22px;
            overflow: hidden;
            padding: 0 12px;
            transition: all 0.15s ease-in-out 0s;
        }
        .wrap-item-grid.wig-2:hover .wrap-feature-footer{
            height: 0;
        }
        .wff-left{
            font-size: 12px;
            display: inline-block;
        }
        .wff-meta-num{
            font-size: 17px;
            font-weight: bold;
        }
        /* Register Here */
        .link-regHere{
            background-color: #fceac5;
            border: 1px solid #ffdfbf;
            padding:15px;
            display: block;
            margin:auto;
            margin-top: 25px;
        }
        .link-regHere .btn{
            font-size: 18px;
        }
        .link-regHere h3{
            margin-bottom: 0;
            margin-top: 0;
            font-size: 20px;
            font-weight: bold;
        }
        .link-regHere p{
            padding-bottom: 0;
        }

        .ellipsis{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        /* Sub Navigation */

        .wrap-sub-navigation{
        }
        ul.cust-sub-nav{
            display: table;
            position: relative;
            top: 150px;
            width: 100%;
            z-index: 998;
        }
        ul.cust-sub-nav li{
            display: table-cell;
            width: 16.666666667%;
            text-align: center;
            border-right: 1px dotted rgba(255, 255, 255, 0.1);
        }
        ul.cust-sub-nav li:last-child{
            border-right: none;
        }
        ul.cust-sub-nav a{
            color: rgba(255, 255, 255, 0.5);
            padding-right: 15px;
            padding-left: 15px;
            display: block;
            font-size: 12px;
        }
        ul.cust-sub-nav a:hover{
            color: rgba(255, 255, 255, 1);
        }
        /* Dark Footer */
        .footer-cust p{
            color: #fff;
        }
        .footer-dark-1,.footer-dark-2{
            line-height: 20px;
        }
        .footer-dark-1 .text-g1,.footer-dark-2 .text-g1{
            color: #ccc;
        }
        .footer-dark-1 .f-a-links a,.footer-dark-2 .f-a-links a{
            color: #ccc;
        }
        .footer-dark-1 .f-a-links a:hover, .footer-dark-2 .f-a-links a:hover{
            color: #e1e1e1;
            text-decoration: none;
        }
        .footer-dark-1{
            color: #fff;
            padding: 25px 0 10px;
            background-color: #333;
        }
        .footer-dark-1 h3{
            margin-top: 0;
        }
        .fnt-bold{
            font-weight: bold;
        }
        .footer-dark-2{
            color: #fff;
            padding: 25px 0;
            background-color: #222;
        }
        .footer-dark-2 ul.list-inline{
            margin-bottom: 0;
        }
        .socials-ul li{
            padding-right: 0;
            padding-left: 0;
        }
        /* Black B */
        .footer-dark-1.footer-dark-b-1{
            background-color: #020202;
        }
        .footer-dark-2.footer-dark-b-2{
            background-color: #0e0e0e;
        }


        /* For Social Media Style Brand Details */
        /* Wrapper */
        .icon-button {
            border-radius: 0.6rem;
            cursor: pointer;
            display: inline-block;
            font-size: 2.0rem;
            height: 3rem;
            line-height: 3rem;
            position: relative;
            text-align: center;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            width: 3rem;
        }

        /* Circle */
        .icon-button span {
            border-radius: 0;
            display: block;
            height: 0;
            left: 50%;
            margin: 0;
            position: absolute;
            top: 50%;
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -o-transition: all 0.3s;
            transition: all 0.3s;
            width: 0;
        }
        .icon-button span {
            width: 3rem;
            height: 3rem;
            border-radius: 0.6rem;
            margin: -1.5rem;
        }
        .twitter span {
            background-color: #4099ff;
        }
        .facebook span {
            background-color: #3B5998;
        }
        .google-plus span {
            background-color: #dd4b39;
        }
        .youtube span {
            background-color: #bb0000;
        }
        .pinterest span {
            background-color: #cb2027;
        }
        .angellist span {
            background-color: #000;
        }
        .github span {
            background-color: #000;
        }
        .linkedin span {
            background-color: #007bb6 ;
        }
        .tumblr span {
            background-color: #36465d ;
        }
        .foursquare span {
            background-color: #0072b1 ;
        }

        /* Icons */
        .icon-button i {
            background: none;
            color: white;
            height: 3rem;
            left: 0;
            line-height: 3rem;
            position: absolute;
            top: 0;
            width: 3rem;
            z-index: 10;
        }
        /* For Image iCons */
        .social-img-icon-a{
            border-radius: 0.6rem;
            display: block;
            height: 30px;
            overflow: hidden;
            width: 30px;
        }
        .social-img-icon-a img{
            height: 30px;
        }
        /* Landscape phones and down */
        @media (max-width: 480px) {
            .featuresMidBlck{
                border-radius: 0;
                margin-top: 0;
            }
            .input-f-xs{
                display: block;
            }
            .input-f-xs.input-group .form-control {
                border-radius: 8px;
                float: none;
                margin-bottom: 15px;
                float: none;
            }
            .input-f-xs .btn {
                border-radius: 8px !important;
                width: 100%;
            }
            .link-regHere .col-xs-12{
                margin-bottom: 15px;
            }
            .link-regHere .btn{
                display: block;
            }
            .link-regHere{
                text-align: center;
            }
        }
        /* Portrait tablet to landscape and desktop */
        @media (min-width: 768px) and (max-width: 979px) {
            .featuresMidBlck{
                border-radius: 0;
                margin-top: 0;
                border:none;
            }
        }
        .num-obj{
            border: 5px solid #2ecc71;
            border-radius: 50%;
            box-shadow: 0 0 1px #27ae60;
            color: #27ae60;
            font-size: 17px;
            line-height: 35px;
            margin: 5px;
            text-align: center;
            width: 45px;
        }
        .mb-header-cust{
            color: #27ae60;
            font-size: 26px;
            line-height: 50px;
        }
        .btn.btn-danger{
            border-color: #d43f3a;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function(){
            //$('#myModal').modal('show');
        });
    </script>
</head>
<body id="top">