<?php
$page = $_POST['current_page'];
$total_pages = intval($_POST['total_results']);
$limit = 10;
if ($page == 0) $page = 1;					//if no page var is given, default to 1.
$prev = $page - 1;							//previous page is page - 1
$next = $page + 1;							//next page is page + 1
$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
$lpm1 = $lastpage - 1;

	$pagination = '';
	if($lastpage > 1)
	{	
		
		//previous button
		if ($page > 1) 
			$pagination.= "<li><a href=\"javascript:loadPages($prev)\" aria-label=\"Previous\"><span aria-hidden=\"true\">«</span></a></li>";
		else
			$pagination.= '<li class="disabled"><a href="javascript:void(0)" aria-label="Previous"><span aria-hidden="true">«</span></a></li>';	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class=\"active\"><a href=\"javascript:void(0)\">$counter <span class=\"sr-only\">(current)</span></a></li>";
				else
					$pagination.= "<li><a href=\"javascript:loadPages($counter)\">$counter</a></li>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"javascript:void(0)\">$counter <span class=\"sr-only\">(current)</span></a></li>";
					else
						$pagination.= "<li><a href=\"javascript:loadPages($counter)\">$counter</a></li>";					
				}
				$pagination.= "<li><a href=\"javascript:void(0)\">...</a></li>";
				$pagination.= "<li><a href=\"javascript:loadPages($lpm1)\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"javascript:loadPages($lastpage)\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href=\"javascript:loadPages(1)\">1</a></li>";
				$pagination.= "<li><a href=\"javascript:loadPages(2)\">2</a></li>";
				$pagination.= "<li><a href=\"javascript:void(0)\">...</a></li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"javascript:void(0)\">$counter <span class=\"sr-only\">(current)</span></a></li>";
					else
						$pagination.= "<li><a href=\"javascript:loadPages($counter)\">$counter</a></li>";					
				}
				$pagination.= "<li><a href=\"javascript:void(0)\">...</a></li>";
				$pagination.= "<li><a href=\"javascript:loadPages($lpm1')\">$lpm1</a></li>";
				$pagination.= "<li><a href=\"javascript:loadPages($lastpage)\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<li><a href=\"javascript:loadPages(1)\">1</a></li>";
				$pagination.= "<li><a href=\"javascript:loadPages(2)\">2</a></li>";
				$pagination.= "<li><a href=\"javascript:void(0)\">...</a></li>";
				
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class=\"active\"><a href=\"javascript:void(0)\">$counter <span class=\"sr-only\">(current)</span></a></li>";
					else
						$pagination.= "<li><a href=\"javascript:loadPages($counter)\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<li><a href=\"javascript:loadPages($next)\">»</a></li>";
		else
			$pagination.= "<li><a aria-label=\"Next\" href=\"javascript:void(0)\"><span aria-hidden=\"true\">»</span></a></li>";
			
	}
	
	$pagination .= '';
?>

	
<?php echo $pagination?>

			
	  