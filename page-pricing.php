<?php
/**
 * The template for displaying the Pricing page
 *
 * This is the template that displays the Pricing page default.
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

	<main id="primary" class="pricing site-main">
		<?php
		while ( have_posts() ) :
			the_post();

			// free trial notes
			if ( function_exists ( 'get_field' ) ) {
				if ( get_field( 'free_trial_notes' ) ) {
					?>
					<section class='free-trial-note'>
					<?php
					echo get_field( 'free_trial_notes');
					?>
					</section>
					<?php
				}
			}
			// meal kit
			$args = array(
				'post_type'      => 'product',
				'orderby'        => 'name',
				'order'			=> 'ASC',
				'posts_per_page' => 2,
				);

				$query = new WP_Query( $args );
				if ( $query -> have_posts() ){
					?>
					<section class="product">
						<?php
						while ($query-> have_posts() ){
							$query -> the_post();
							?>
							<article class='product-item'>
							<a href="<?php the_permalink();?>">
								<?php
								the_post_thumbnail('menu-home');
								echo "<h3>".get_the_title()."</h3>";
								// the_content();
								$excerpt = get_the_content();?>
								<p><?php echo substr( $excerpt, 0, 100 );?></p>
								
								<div class="button">
									<p>Select</p>
								</div>
							</a>
							</article>
							<?php


						}
						?>
						
						<?php
						wp_reset_postdata();
						?>
						</section>
						<?php
					}
				// Why Choose
				if ( function_exists ( 'get_field' ) ) {
					get_template_part( 'template-parts/why', 'choose' );
				}

				// FAQ snippet
				if ( function_exists ( 'get_field' ) ) {
					?>
					<section class = 'faq'>
					<h2>Common Questions</h2>
					<?php
					if( have_rows('faq') ):
						while( have_rows('faq') ) : the_row();
							$faq_category_heading = get_sub_field('category_heading');
							?>
							<div class = 'faq-category'>
								<h3><?php echo $faq_category_heading?></h3>
								<hr>
								<?php
								while(have_rows('category')): the_row();
									?>
									<article class = 'faq-qa'>
									<?php
									$faq_question = get_sub_field('question');
									$faq_answer = get_sub_field('answer');
									echo "<h4>$faq_question</h4>";
									echo $faq_answer;
									?>
									</article>
									<?php
								endwhile;
							?>
							</div>
							<?php
						endwhile;
					endif;
					?>
					</section>
					<?php

					// CTA to FAQ page
					if ( get_field( 'cta_faq_link' ) ) {
						?>
						<section class='button-container'>
							<div class='button'><a target='_blank' href=' <?php echo get_field( 'cta_faq_link') ?>'>Check out our FAQs</a></div>
						</section>
						<?php
					}else{
						?>
						<section class='button-container'>
							<div class='button'><a target='_blank' href=' <?php echo get_permalink(51) ?>'>Read the FAQs</a></div>
						</section>
						<?php
					}
				}


				// delivery area
				?>
				<section class="delivery">
				<h2>We Deliver to Greater Vancouver</h2>
				<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10417.699821447517!2d-123.01679330829566!3d49.24939081924198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54867721fd53fee5%3A0x355ab207647a109d!2sBritish%20Columbia%20Institute%20of%20Technology!5e0!3m2!1sen!2sca!4v1624907010490!5m2!1sen!2sca" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
				</section>

		<?php
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
