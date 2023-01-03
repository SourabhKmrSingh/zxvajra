<?php
$rightcategoryResult = $db->view("*", "rb_categories", "categoryid", "and status='active'", "order_custom desc", "15");
if($rightcategoryResult['num_rows'] >= 1)
{
?>
	<div class="filter-widget">
		<h4 class="fw-title">Our Categories</h4>
		<ul class="filter-catagories">
			<?php
			foreach($rightcategoryResult['result'] as $rightcategoryRow)
			{
				if($rightcategoryRow['url'] == "#")
				{
					$rightcategory_url = "#";
					$rightcategory_url_target = "";
				}
				else if($rightcategoryRow['url'] != "http://www." and $rightcategoryRow['url'] != "https://www." and $rightcategoryRow['url'] != "")
				{
					if(substr($rightcategoryRow['url'], 0, 7) == 'http://' || substr($rightcategoryRow['url'], 0, 8) == 'https://')
					{
						$rightcategory_url = $validation->db_field_validate($rightcategoryRow['url']);
						$rightcategory_url_target = $validation->db_field_validate($rightcategoryRow['url_target']);
					}
					else
					{
						$rightcategory_url = BASE_URL."".$validation->db_field_validate($rightcategoryRow['url']);
						$rightcategory_url_target = $validation->db_field_validate($rightcategoryRow['url_target']);
					}
				}
				else
				{
					$rightcategory_url = BASE_URL.'products/?cat='.$validation->db_field_validate($rightcategoryRow['title_id'])."";
					$rightcategory_url_target = "";
				}
			?>
				<li><a href="<?php echo $rightcategory_url; ?>" target="<?php echo $rightcategory_url_target; ?>"><?php echo $validation->db_field_validate($rightcategoryRow['title']); ?></a></li>
			<?php
			}
			?>
		</ul>
	</div>
<?php
}
?>

<div class="filter-widget">
	<h4 class="fw-title">Sort by:</h4>
	<div class="fw-brand-check">
		<div class="bc-item">
			<label for="bc-calvin">
				<a href="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=title&order=asc'.$url_parameters_order; ?>" class="anchor-tag fs-black">
					A-Z
					<input type="checkbox" id="bc-calvin" <?php if($orderby == "title" and $order == "asc") echo "checked"; ?>>
					<span class="checkmark"></span>
				</a>
			</label>
		</div>
		<div class="bc-item">
			<label for="bc-calvin">
				<a href="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=title&order=desc'.$url_parameters_order; ?>" class="anchor-tag fs-black">
					Z-A
					<input type="checkbox" id="bc-calvin" <?php if($orderby == "title" and $order == "desc") echo "checked"; ?>>
					<span class="checkmark"></span>
				</a>
			</label>
		</div>
		<div class="bc-item">
			<label for="bc-calvin">
				<a href="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=price&order=asc'.$url_parameters_order; ?>" class="anchor-tag fs-black">
					Price - Low to High
					<input type="checkbox" id="bc-calvin" <?php if($orderby == "price" and $order == "asc") echo "checked"; ?>>
					<span class="checkmark"></span>
				</a>
			</label>
		</div>
		<div class="bc-item">
			<label for="bc-calvin">
				<a href="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=price&order=desc'.$url_parameters_order; ?>" class="anchor-tag fs-black">
					Price - High to Low
					<input type="checkbox" id="bc-calvin" <?php if($orderby == "price" and $order == "desc") echo "checked"; ?>>
					<span class="checkmark"></span>
				</a>
			</label>
		</div>
		<div class="bc-item">
			<label for="bc-calvin">
				<a href="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=createdate&order=desc'.$url_parameters_order; ?>" class="anchor-tag fs-black">
					Newest First
					<input type="checkbox" id="bc-calvin" <?php if($orderby == "createdate" and $order == "desc") echo "checked"; ?>>
					<span class="checkmark"></span>
				</a>
			</label>
		</div>
		<div class="bc-item">
			<label for="bc-calvin">
				<a href="<?php echo BASE_URL.''.$page_name.''.SUFFIX.'?orderby=views&order=desc'.$url_parameters_order; ?>" class="anchor-tag fs-black">
					Popularity
					<input type="checkbox" id="bc-calvin" <?php if($orderby == "views" and $order == "desc") echo "checked"; ?>>
					<span class="checkmark"></span>
				</a>
			</label>
		</div>
	</div>
</div>

<div class="filter-widget mb-0">
	<h4 class="fw-title">Price</h4>
	
	<div class="filter_con filter-widget">
		<div class="filter-range-wrap">
			<div class="drag_value">
				<div class="min_value"><span class="">₹</span> <span class="min_value_class"><?php if($min != "") echo number_format($min); else echo "0"; ?></span></div>
				<div class="max_value"><span class="">₹</span> <span class="max_value_class"><?php if($max != "") echo number_format($max); else echo number_format($max_price); ?></span></div>
			</div>
			<div class="dragable">
				<div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content" data-min="0" data-max="<?php echo $max_price; ?>">
					<div class="ui-slider-range ui-corner-all ui-widget-header"></div>
					<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
					<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="filter-widget">
	<?php if($orderby != "" || $order != "" || $min != "" || $max != "") { ?>
		<a href="<?php echo BASE_URL.''.$page_name.''.SUFFIX; ?>" class="filter-btn">Clear Filters</a>
	<?php } ?>
</div>