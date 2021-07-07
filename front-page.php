<?php
/**
 * The template for displaying the Front Page
 *
 * This is the template that displays the Front Page by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Farm_to_Plate
 */

get_header();
?>

	<main id="primary" class="home-page site-main">
		<?php 
		while ( have_posts() ) :
		the_post();
		// <!-- add ACF -->
		
			if ( function_exists ( 'get_field' ) ) {
				// Banner
				?>
				<section class = 'banner'>
				<?php
				if ( get_field( 'banner_image' ) ) {
					?><div class = "img-container">
						<?php echo wp_get_attachment_image( get_field( 'banner_image' ), 'full', '', array( 'class' => '' )); ?>
					  </div>
					  <?php
				}

				if ( get_field( 'banner_text_area' ) ) {
					?>
					<h1> <?php echo get_field( 'banner_text_area'); ?> </h1>
					<?php
				}

				if ( get_field( 'banner_link' ) ) {
					?>
					<div class='button'><a href='<?php echo get_field( 'banner_link') ?>'>Try It Free</a></div>
					<?php
				}
				?>
				</section>

				<!-- // How It Works -->

				<section class = 'how-it-works'>
				<?php
				if( have_rows('how_it_works') ):
					?>
					<h2>How It Works</h2>
					<?php
					while( have_rows('how_it_works') ) : the_row();
						$sub_value_img = wp_get_attachment_image( get_sub_field('image'), 'full', '', array( 'class' => '' ));
						$sub_value_heading = get_sub_field('heading');
						$sub_value_text = get_sub_field('text_area');
						?>
						<article class = 'how-it-work-item'>
						<?php
							echo $sub_value_img;
							echo "<h2>$sub_value_heading</h2>";
							echo "<p>$sub_value_text</p>";
						?>
						</article>
						<?php
					endwhile;
				endif;
				?>
				</section>
				<?php

				// Why Choose
				get_template_part( 'template-parts/why', 'choose' );
			} 
		?>

		<!-- Add menu-->
		<?php
		
		// calc date (php date)
		// https://www.php.net/manual/en/function.date.php
		// https://www.php.net/manual/en/datetime.format.php
		$currentWeek = date('o-W');
		$terms = get_terms(
					array(
						'taxonomy' 	=> 'farm-week',
					)
				);
				if ( $terms && ! is_wp_error( $terms ) ) {
						// Add your WP_Query() code here
						// Use $term->slug in your tax_query
						// Use $term->name to organize the posts
						$args = array(
							'post_type' 		=> 'farm-dish',
							'posts_per_page' 	=> 8,
							'orderby'            => 'title',
							'order'              => 'ASC',
							'tax_query' 		=> array(
								array(
									'taxonomy' 	=> 'farm-week',
									'field' 	=> 'slug',
									'terms' 	=> $currentWeek
								)
							)
						);
						$query = new WP_Query( $args );
						// loop output all the menu ----------------------------------------------
						if ( $query -> have_posts() ){
							?>
							<section class='this-week-menu'>
							<h2>This Week's Menu</h2>
							<?php
							while ( $query -> have_posts() ) {
								$query -> the_post();
								?>
								<article class='menu-item'>	
								<a href="<?php the_permalink();?>">
									<?php
										the_post_thumbnail('menu-home');
									?>
									<h3><?php the_title(); ?></h3>
								</a>
								</article>
								<?php
							}
							?>
							</section>
							<?php
							wp_reset_postdata();
						}

				}
		// <!-- CTA -->
		if ( get_field( 'cta_link' ) ) {
			?>
			<section class='button-container'>
				<div class='button'><a href=' <?php echo get_field( 'cta_link') ?> '>Try It Free</a></div>
			</section>
		<?php
		}else{
			?>
			<section class='button-container'>
			<div class='button'><a href='<?php echo get_permalink(53) ?>'>Try It Free</a></div>
			</section>
		<?php
		}
		// <!-- Add Testimonials -->
			// Output a random testimonial 
			$args = array(
				'post_type'      => 'farm-testimonial',
				'orderby'        => 'rand',
				'posts_per_page' => 2,
				);

				$query = new WP_Query( $args );
				if ( $query -> have_posts() ){
					?>
					<section class="testimonial"><h2>What Our Customers Say</h2>
					<?php
					while ($query-> have_posts() ){
						?>
						<article class='testimonial-item'>
						<?php
						$query -> the_post();
						the_content();
						?>
						</article>
						<?php
					}
					wp_reset_postdata();
					?>
					</section>
					<?php
				}
		?>

		<!-- Featured in news -->
		<?php
			// Output a random Social 
			$args = array(
				'post_type'      => 'farm-social',
				'orderby'        => 'rand',
				'posts_per_page' => 4,
				);

				$query = new WP_Query( $args );
				if ( $query -> have_posts() ){
					?>
					<section class="social"><h2>As Featured in</h2>
					<?php
					while ($query-> have_posts() ){
						$query -> the_post();
						?>
						<article class='social-item'>
						<a href="<?php the_permalink();?>">
						<?php
						the_post_thumbnail('medium');
						?></a>
						</article>
						<?php
					}
					wp_reset_postdata();
					?>
					</section>
					<?php
				}
		?>

		<!-- Add ACF map -->
		<section class="delivery">
			<h2>We Deliver to Greater Vancouver</h2>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10417.699821447517!2d-123.01679330829566!3d49.24939081924198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54867721fd53fee5%3A0x355ab207647a109d!2sBritish%20Columbia%20Institute%20of%20Technology!5e0!3m2!1sen!2sca!4v1624907010490!5m2!1sen!2sca" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
		</section>

		<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
