<?php 
include 'includes/class.db.php';
include 'includes/functions.php';
$current_page = $_POST['current_page'];
$limit = 8;
if($current_page) 
		 $start = ($current_page - 1) * $limit; 			//first item to display on this page
	    else
		 $start = 0;
		
$results = geteservices($start,$limit);


if (count($results) > 0):?>
	                <?php foreach ($results as $k=>$val):?>
		                <div class="col-md-3 col-sm-4 col-xs-12">
		                    <div class="wrap-item-grid wig-2" href="">
		                        <div class="wrap-item-user-main">
		                            <div class="wism-num">
		                                <span class="label label-danger">
		                                    <i class="fa fa-star fa-yellow"></i>
		                                    FEATURED
		                                </span>
		                            </div>
		                            <div class="wisg-meta-info ellipsis">
		                                <span class="by">by</span>
		                                <!-- First Name Only -->
		                                <a href="" class="wism-un" title="mary catherine sicuya"><?php echo $val['firstname'].' '.$val['lastname']?></a>
		                            </div>
		                        </div>
		                        <a href="javascript:popeservice(<?php echo $val['task_id']?>)" class="wism-a-link">
		                            <div class="wrap-item-img">
		                                <?php if ($val['image'] == ""):?>
		                                <img class="img-responsive" src="http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-writingjob-1.jpg" alt="<?php echo $val['description']?>">
		                                <?php else:?>
		                                <img class="img-responsive" src="<?php echo $val['image']?>" alt="<?php echo $val['description']?>">
		                                <?php endif?>
		                            </div>
		                            <div class="wism-al-desc">
		                                <h2><?php echo stripcslashes($val['title'])?></h2>
		                                <h3><?php echo $val['description']?></h3>
		                            </div>
		                        </a>
		                        <div class="wrap-feature-footer">
		                            <div class="wff-left">
		                                <span class="label label-danger">
		                                    <i class="fa fa-star fa-yellow"></i>
		                                    <span class="text-capitalize"><?php echo $val['category_name']?></span>
		                                </span>
		                            </div>
		                            <span class="pull-right wff-meta-num text-danger">
		                                $<?php echo $val['price']?>
		                            </span>
		                        </div>
		                    </div>
		                </div>
	                <?php endforeach;?>
                <?php endif?>
<script>
function popeservice(id){
	jQuery.post('/emodal.php',{'page':'eservice','id':id},
	function(data_html){
		jQuery('.modal-content').html(data_html);
		$('#myModal').modal('show');
	});
}

</script>