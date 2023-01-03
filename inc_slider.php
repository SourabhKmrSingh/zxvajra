<section class="hero-section">
	<div class="hero-items owl-carousel">
		<?php
		$sliderResult = $db->view('sliderid,title,title_id,url,url_target,imgName,tagline,description,sale', 'rb_sliders', 'sliderid', "and status='active'", 'order_custom desc', '8');
		if($sliderResult['num_rows'] >= 1)
		{
			foreach($sliderResult['result'] as $sliderRow)
			{
				if($sliderRow['url'] != "http://www." and $sliderRow['url'] != "")
				{
					$slider_url = $sliderRow['url'];
					$slider_target = $sliderRow['url_target'];;
				}
				else
				{
					$slider_url = "";
					$slider_target = "";
				}
		?>
			<div class="single-hero-items set-bg" data-setbg="">
				<img src="<?php echo BASE_URL.IMG_MAIN_LOC.$validation->db_field_validate($sliderRow['imgName']); ?>" width="w-100" />
				<!--<div class="container">
					<div class="row">
						<div class="col-lg-5">
							<span><?php echo $validation->db_field_validate($sliderRow['tagline']); ?></span>
							<h1><?php echo $validation->db_field_validate($sliderRow['title']); ?></h1>
							<p><?php echo $validation->db_field_validate($sliderRow['description']); ?></p>
							<?php if($slider_url != "") { ?>
								<a href="<?php echo $slider_url; ?>" target="<?php echo $slider_target; ?>" class="primary-btn">Shop Now</a>
							<?php } ?>
						</div>
					</div>
					<?php if($sliderRow['sale'] != "0") { ?>
						<div class="off-card">
							<h2>Sale <span><?php echo $validation->db_field_validate($sliderRow['sale']); ?>%</span></h2>
						</div>
					<?php } ?>
				</div>-->
			</div>
		<?php
			}
		}
		?>
	</div>
</section>