<?php

$db->unique_visitors('rb_views', '', 'viewid', '', $user_ip, $regid);

$totalvisitorsResult = $db->view("viewid", "rb_views", "viewid", "and status='active'");

$totalvisitorsCount = $totalvisitorsResult['num_rows'];


?>

<footer class="footer-section">

	<div class="container">

		<div class="row">

			<div class="col-lg-3">

				<div class="footer-left">

					<div class="footer-logo">

						<?php if($configRow['logo'] != "") { ?>

							<!--<a href="<?php echo BASE_URL; ?>">

								<img src="<?php echo BASE_URL.IMG_MAIN_LOC.$validation->db_field_validate($configRow['logo']); ?>" alt="<?php echo $validation->db_field_validate($configRow['meta_title']); ?>" />

							</a>

							<br />-->

						<?php } ?>

						<h4 class="font-weight-bold fc-white">ZX VAJRA</h3>

					</div>

					<ul>

						<!--<li>Address: 1st Floor, 32/43, street no. 9, bhikam singh colony, vishwas nagar, Delhi - 110032</li>-->

						<li>Phone: +91-9711122119</li>

						<li>Email: info@zxvajrar.com</li>
                                                    
					</ul>

					<div class="footer-social">

						<a href="<?php echo BASE_URL; ?>"><i class="fa fa-facebook"></i></a>

						<a href="<?php echo BASE_URL; ?>"><i class="fa fa-instagram"></i></a>

						<a href="<?php echo BASE_URL; ?>"><i class="fa fa-twitter"></i></a>

						<a href="<?php echo BASE_URL; ?>"><i class="fa fa-pinterest"></i></a>

						<a href="<?php echo BASE_URL; ?>"><i class="fa fa-youtube"></i></a>

						<br /><br />

						<div class="copyright-text fc-white">

						Visitors: &nbsp;<span class="visitors"><?php echo sprintf("%06d", $totalvisitorsCount); ?></span>

						</div>

					</div>

				</div>

			</div>

			<div class="col-lg-2 offset-lg-1">

				<div class="footer-widget">

					<h5>Quick Links</h5>

					<ul>

						<li><a href="<?php echo BASE_URL; ?>page/about-us/">About Us</a></li>

						<li><a href="<?php echo BASE_URL; ?>products<?php echo SUFFIX; ?>">Our Products</a></li>

						<li><a href="<?php echo BASE_URL; ?>contact<?php echo SUFFIX; ?>">Contact</a></li>

						<li><a href="<?php echo BASE_URL; ?>contact<?php echo SUFFIX; ?>?q=collaborate">Want to Collaborate ?</a></li>

						<li><a href="<?php echo BASE_URL; ?>section/blog/">Blog</a></li>

						<li><a href="<?php echo BASE_URL; ?>faq<?php echo SUFFIX; ?>">FAQs</a></li>

						<li><a href="<?php echo BASE_URL; ?>page/privacy-policy/">Privacy Policy</a></li>

						<li><a href="<?php echo BASE_URL; ?>page/terms-and-conditions/">Terms & Conditions</a></li>

						<li><a href="<?php echo BASE_URL; ?>page/payment-policy/">Payment Policy</a></li>

					</ul>

				</div>

			</div>

			<div class="col-lg-2">

				<div class="footer-widget">

					<h5>My Account</h5>

					<ul>

						<li><a href="<?php echo BASE_URL; ?>register<?php echo SUFFIX; ?>">Register</a></li>

						<li><a href="<?php echo BASE_URL; ?>login<?php echo SUFFIX; ?>">Login</a></li>

						<li><a href="<?php echo BASE_URL; ?>home<?php echo SUFFIX; ?>">User's Home</a></li>

						<li><a href="<?php echo BASE_URL; ?>cart<?php echo SUFFIX; ?>">Shopping Cart</a></li>

						<li><a href="<?php echo BASE_URL; ?>coupons<?php echo SUFFIX; ?>">My Coupons</a></li>

					</ul>

				</div>

			</div>

			<div class="col-lg-4">

				<div class="newslatter-item">

					<h5>Join Our Newsletter Now</h5>

					<p>Get E-mail updates about our latest shop and special offers.</p>

					<form action="<?php echo BASE_URL; ?>newsletter_inter.php" method="post" class="subscribe-form">

						<input type="hidden" name="redirect_url" value="<?php echo $full_url; ?>" />

						<input type="text" name="email" placeholder="Enter Your Email" required />

						<button type="submit">Subscribe</button>

					</form>

				</div>

			</div>

		</div>

	</div>

	<div class="copyright-reserved">

		<div class="container">

			<div class="row">

				<div class="col-lg-12">

					<div class="copyright-text">

						Copyright &copy;2020 All rights reserved &nbsp;&nbsp; Design and Developed by <a href="https://www.techquenchsolution.com/" class='text-info'>Techquench Solution</a>

					</div>

					<div class="payment-pic">

						<img src="<?php echo BASE_URL; ?>images/payment-method.png" alt="" />

					</div>

				</div>

			</div>

		</div>

	</div>

</footer>