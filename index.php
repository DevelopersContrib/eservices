 <?php include 'header.php';?>
    <!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
  
   <?php include 'header-menu.php';?> 
    
    <section class="intro featuresMidBlck-main">
        <div class="container featuresMidBlck">
            <div class="row ">
                <div class="col-md-12">
                    <div class="text-center wrap-features-title">
                        <h2 class="fnt-bold fnt-nunito ttle">Trending Collections</h2>
                        <p class="sub-ttle">Choose from our most popular services</p>
                    </div>
                </div>
            </div>
            <div class="row brdrBtm-trending ">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a class="wrap-item-grid" href="javascript:popcategory(1)">
                        <div class="wrap-item-header">
                            <div class="wrap-item-title text-uppercase fnt-400 fnt-nunito">
                                Writing Job
                            </div>
                            <span class="wrap-item-meta">
                               
                            </span>
                        </div>
                        <div class="wrap-item-img">
                            <img class="img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-writingjob-1.jpg" alt="writing job">
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a class="wrap-item-grid" href="javascript:popcategory(2)">
                        <div class="wrap-item-header">
                            <div class="wrap-item-title text-uppercase fnt-400 fnt-nunito">
                                Sign up's
                            </div>
                            <span class="wrap-item-meta">
                                
                            </span>
                        </div>
                        <div class="wrap-item-img">
                            <img class="img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-signup-1.jpg" alt="writing job">
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a class="wrap-item-grid" href="javascript:popcategory(3)">
                        <div class="wrap-item-header">
                            <div class="wrap-item-title text-uppercase fnt-400 fnt-nunito">
                                marketing
                            </div>
                            <span class="wrap-item-meta">
                                
                            </span>
                        </div>
                        <div class="wrap-item-img">
                            <img class="img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-marketing-1.jpg" alt="writing job">
                        </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a class="wrap-item-grid" href="javascript:popcategory(4)">
                        <div class="wrap-item-header">
                            <div class="wrap-item-title text-uppercase fnt-400 fnt-nunito">
                                SEO Task
                            </div>
                            <span class="wrap-item-meta">
                                
                            </span>
                        </div>
                        <div class="wrap-item-img">
                            <img class="img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-SEOtask-1.jpg" alt="writing job">
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center wrap-features-title wrap-features-title-2">
                        <h2 class="fnt-bold fnt-nunito ttle">Featured eServices</h2>
                        <p class="sub-ttle">Noteworthy Services</p>
                    </div>
                </div>
            </div>
            <div class="row" id="eservice-list">
                
               
            </div>
             <nav class="text-center">
                <ul class="pagination">
                    
                </ul>
            </nav>
        </div>
    </section>
   <input type="hidden" name="total_results" id="total_results" value="<?echo gettotaleservices()?>" />   

<script>

jQuery(document).ready(function() {
	var total_results = jQuery('#total_results').val();
	var current_page = 1;
	loadPages(current_page);
});

function loadPages(current_page){
	var total_results = jQuery('#total_results').val();
	getPagination(current_page,total_results);
	jQuery.post('/loadeservices.php',{current_page:current_page},function(data_html){
		jQuery('#eservice-list').html(data_html);
	});
}

function getPagination(current_page,total_results){
	jQuery.post('/loadpagination.php',{current_page:current_page,total_results:total_results},function(data_html){
		jQuery('.pagination').html(data_html);
	});
}


function popcategory(id){
	jQuery.post('/emodal.php',{'page':'category','id':id},
	function(data_html){
		jQuery('.modal-content').html(data_html);
		$('#myModal').modal('show');
	});
}


</script> 
   <?php include 'footer-home.php';?>