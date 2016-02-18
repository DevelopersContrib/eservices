<?php 
$db = new db("mysql:host=184.107.215.234;dbname=domaindi_managedomain", "fromeservices", "sul0dk0h4");

function gettotaleservices(){
	global $db;
	$sql = "SELECT cart_microtask.`task_id`,`cart_microtask`.`title`, cart_microtask.`slug`,`cart_order`.`date_ordered`,cart_order.`instruction`,cart_order.`is_close`, cart_order.`is_external`,cart_order.`external_domain`,
cart_order.`process_by` AS employer_id,domain.domain_name,cart_order_list.`price`,cart_category.`category_name`,
members.firstname, members.lastname,members.`email`,cart_items.`description`,cart_order.`order_id`,cart_items.`image`
FROM cart_microtask LEFT JOIN domain ON (cart_microtask.domain_id = domain.domain_id)
LEFT JOIN cart_order ON (cart_microtask.order_id = cart_order.order_id)
LEFT JOIN members ON (members.member_id = cart_order.process_by)
LEFT JOIN `cart_order_list` ON (`cart_order_list`.`id` = `cart_microtask`.`cart_order_list_id`)
INNER JOIN `cart_items` ON (`cart_items`.`item_id` = `cart_order_list`.`item_id`)
LEFT JOIN cart_category ON (cart_category.`category_id` = cart_items.`category_id`)
WHERE cart_order.is_purchased = 1
AND cart_microtask.parent_id <> -1	
AND cart_microtask.`contrib_user` IS NULL
AND cart_items.`publish` = 'public'";
     $results = $db->run($sql);
     return count ($results);
}

function geteservices($start,$limit){
	global $db;
	$sql = "SELECT cart_microtask.`task_id`,`cart_microtask`.`title`, cart_microtask.`slug`,`cart_order`.`date_ordered`,cart_order.`instruction`,cart_order.`is_close`, cart_order.`is_external`,cart_order.`external_domain`,
cart_order.`process_by` AS employer_id,domain.domain_name,cart_order_list.`price`,cart_category.`category_name`,
members.firstname, members.lastname,members.`email`,cart_items.`description`,cart_order.`order_id`,cart_items.`image`
FROM cart_microtask LEFT JOIN domain ON (cart_microtask.domain_id = domain.domain_id)
LEFT JOIN cart_order ON (cart_microtask.order_id = cart_order.order_id)
LEFT JOIN members ON (members.member_id = cart_order.process_by)
LEFT JOIN `cart_order_list` ON (`cart_order_list`.`id` = `cart_microtask`.`cart_order_list_id`)
INNER JOIN `cart_items` ON (`cart_items`.`item_id` = `cart_order_list`.`item_id`)
LEFT JOIN cart_category ON (cart_category.`category_id` = cart_items.`category_id`)
WHERE cart_order.is_purchased = 1
AND cart_microtask.parent_id <> -1	
AND cart_microtask.`contrib_user` IS NULL
AND cart_items.`publish` = 'public' ORDER BY cart_microtask.`task_id` DESC LIMIT $start,$limit";
	 $results = $db->run($sql);
	 return $results;
}

function getmodalvars($page,$id){
	global $db;
	$info = array();
	if ($page == 'category'){
		switch ($id){
			case 1:
				$info['image'] = "http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-writingjob-1.jpg";
				$info['title'] = "Writing Job";
			break;
			case 2:
				$info['image'] = "http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-signup-1.jpg";
				$info['title'] = "Sign up's";
			break;
			case 3:
				$info['image'] = "http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-marketing-1.jpg";
				$info['title'] = "Marketing";
			break;
			case 4:
				$info['image'] = "http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-SEOtask-1.jpg";
				$info['title'] = "SEO Task";
			break;				
		}
		$info['description'] = "";
		
	}else if ($page == 'eservice'){
		$info['image'] = "http://d2qcctj8epnr7y.cloudfront.net/images/2013/desc-eshares-writingjob-1.jpg";
		$info['title'] = "";
		$info['description'] = "";
		
		$sql = "SELECT cart_microtask.`title`, `cart_items`.`image`, `cart_items`.`description`
FROM `cart_microtask` inner JOIN `cart_order_list` ON (`cart_order_list`.`id` = `cart_microtask`.`cart_order_list_id`)
inner JOIN `cart_items` ON (cart_items.`item_id` = `cart_order_list`.`item_id`) WHERE `cart_microtask`.`task_id` = $id";
		 $results = $db->run($sql);
		 if (count($results) > 0){
		 	foreach ($results as $k=>$val){
		 		if ($val['image'] != ""){
		 			$info['image'] = $val['image'];
		 		}
		 		
		 		$info['title'] = $val['title'];
		 		$info['description'] = $val['description'];
		 	}
		 }
	     
	}
	
	return $info;
}


