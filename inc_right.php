<div class="blog-sidebar box">
	<?php
	$rightcategoryResult = $db->view("*", "rb_categories", "categoryid", "and status='active'", "order_custom desc", "15");
	if($rightcategoryResult['num_rows'] >= 1)
	{
	?>
		<div class="blog-catagory">
			<h4>Our Categories</h4>
			<ul>
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
	
	<?php
	$rightproductResult = $db->view("*", "rb_products", "productid", "and status='active'", "order_custom desc", "7");
	if($rightproductResult['num_rows'] >= 1)
	{
	?>
		<div class="recent-post">
			<h4>Our Products</h4>
			<div class="recent-blog">
				<?php
				foreach($rightproductResult['result'] as $rightproductRow)
				{
					if($rightproductRow['url'] == "#")
					{
						$rightproduct_url = "#";
						$rightproduct_url_target = "";
					}
					else if($rightproductRow['url'] != "http://www." and $rightproductRow['url'] != "https://www." and $rightproductRow['url'] != "")
					{
						if(substr($rightproductRow['url'], 0, 7) == 'http://' || substr($rightproductRow['url'], 0, 8) == 'https://')
						{
							$rightproduct_url = $validation->db_field_validate($rightproductRow['url']);
							$rightproduct_url_target = $validation->db_field_validate($rightproductRow['url_target']);
						}
						else
						{
							$rightproduct_url = BASE_URL."".$validation->db_field_validate($rightproductRow['url']);
							$rightproduct_url_target = $validation->db_field_validate($rightproductRow['url_target']);
						}
					}
					else
					{
						$rightproduct_url = BASE_URL.'products/'.$validation->db_field_validate($rightproductRow['title_id'])."/";
						$rightproduct_url_target = $validation->db_field_validate($rightproductRow['url_target']);
					}
					
					$product_img = explode(" | ", $rightproductRow['imgName']);
				?>
					<a href="<?php echo $rightproduct_url; ?>" target="<?php echo $rightproduct_url_target; ?>" class="rb-item">
						<div class="rb-pic">
							<?php if($product_img[0] != "" and file_exists(IMG_THUMB_LOC.$product_img[0])) { ?>
								<img src="<?php echo BASE_URL.IMG_THUMB_LOC.$product_img[0]; ?>" alt="<?php echo $validation->db_field_validate($rightproductRow['title']); ?>" title="<?php echo $validation->db_field_validate($rightproductRow['title']); ?>" class="h-auto" />
							<?php } else { ?>
								<img src="<?php echo BASE_URL; ?>images/noimage.jpg" title="<?php echo $validation->db_field_validate($rightproductRow['title']); ?>" class="h-auto" />
							<?php } ?>
						</div>
						<div class="rb-text">
							<h6><?php echo $validation->db_field_validate($rightproductRow['title']); ?></h6>
							<p><?php if($rightproductRow['currency_code'] == 'INR') echo '<i class="fa fa-inr" style="font-size:17.5px;" aria-hidden="true"></i>'; else $validation->db_field_validate($rightproductRow['currency_code']); ?> <?php echo $validation->db_field_validate($validation->price_format($rightproductRow['price'])); ?></p>
						</div>
					</a>
				<?php
				}
				?>
			</div>
		</div>
	<?php
	}
	?>
	
	<?php
	$rightsectionResult = $db->view("*", "rb_dynamic_records", "recordid", "and status='active'", "order_custom desc", "7");
	if($rightsectionResult['num_rows'] >= 1)
	{
	?>
		<div class="recent-post">
			<h4>Recent Post</h4>
			<div class="recent-blog">
				<?php
				foreach($rightsectionResult['result'] as $rightsectionRow)
				{
					$rightpageid = $rightsectionRow['pageid'];
					$rightpageResult = $db->view("title,title_id", "rb_dynamic_pages", "pageid", "and pageid='{$rightpageid}'");
					$rightpageRow = $rightpageResult['result'][0];
					
					if($rightsectionRow['url'] == "#")
					{
						$rightsection_url = "#";
						$rightsection_url_target = "";
					}
					else if($rightsectionRow['url'] != "http://www." and $rightsectionRow['url'] != "https://www." and $rightsectionRow['url'] != "")
					{
						if(substr($rightsectionRow['url'], 0, 7) == 'http://' || substr($rightsectionRow['url'], 0, 8) == 'https://')
						{
							$rightsection_url = $validation->db_field_validate($rightsectionRow['url']);
							$rightsection_url_target = $validation->db_field_validate($rightsectionRow['url_target']);
						}
						else
						{
							$rightsection_url = BASE_URL."".$validation->db_field_validate($rightsectionRow['url']);
							$rightsection_url_target = $validation->db_field_validate($rightsectionRow['url_target']);
						}
					}
					else
					{
						$rightsection_url = BASE_URL.'section/'.$rightpageRow['title_id'].'/'.$validation->db_field_validate($rightsectionRow['title_id'])."/";
						$rightsection_url_target = $validation->db_field_validate($rightsectionRow['url_target']);
					}
					
					$section_img = explode(" | ", $rightsectionRow['imgName']);
				?>
					<a href="<?php echo $rightsection_url; ?>" target="<?php echo $rightsection_url_target; ?>" class="rb-item">
						<div class="rb-pic">
							<?php if($section_img[0] != "" and file_exists(IMG_THUMB_LOC.$section_img[0])) { ?>
								<img src="<?php echo BASE_URL.IMG_THUMB_LOC.$section_img[0]; ?>" alt="<?php echo $validation->db_field_validate($rightsectionRow['title']); ?>" title="<?php echo $validation->db_field_validate($rightsectionRow['title']); ?>" class="h-auto" />
							<?php } else { ?>
								<img src="<?php echo BASE_URL; ?>images/noimage.jpg" title="<?php echo $validation->db_field_validate($rightsectionRow['title']); ?>" class="h-auto" />
							<?php } ?>
						</div>
						<div class="rb-text">
							<h6><?php echo $validation->db_field_validate($rightsectionRow['title']); ?></h6>
							<p><?php echo $validation->db_field_validate($rightpageRow['title']); ?> <span>- <?php echo $validation->date_format_custom($rightsectionRow['createdate']); ?></span></p>
						</div>
					</a>
				<?php
				}
				?>
			</div>
		</div>
	<?php
	}
	?>
</div>