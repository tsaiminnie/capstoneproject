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

	<main id="primary" class="site-main">

		<!-- add ACF -->
		<?php 
			if ( function_exists ( 'get_field' ) ) {

				// Banner
				echo "<section class = 'banner'>";
				if ( get_field( 'banner_image' ) ) {
					echo wp_get_attachment_image( get_field( 'banner_image' ), 'full', '', array( 'class' => '' ));
				}

				if ( get_field( 'banner_text_area' ) ) {
					echo "<p>".get_field( 'banner_text_area')."</p>";
				}

				if ( get_field( 'banner_link' ) ) {
					echo "<div class='button'><a href='".get_field( 'banner_link')."'>Try it Free</a></div>";
				}
				echo "</section>";

				// How It Works
				echo "<section class = 'how-it-works'>";
				if( have_rows('how_it_works') ):
					while( have_rows('how_it_works') ) : the_row();
						$sub_value_img = wp_get_attachment_image( get_sub_field('image'), 'full', '', array( 'class' => '' ));
						$sub_value_heading = get_sub_field('heading');
						$sub_value_text = get_sub_field('text_area');
						echo "<div class = 'how-it-work-item'>";
							echo $sub_value_img;
							echo "<h2>$sub_value_heading</h2>";
							echo "<p>$sub_value_text</p>";
						echo "</div>";
					endwhile;
				endif;
				echo "</section>";

				// Why Choose
				get_template_part( 'template-parts/why', 'choose' );
			} 
		?>

		<!-- Add menu-->
		<?php
		$terms = get_terms(
					array(
						'taxonomy' 	=> 'farm-week',
					)
				);
				if ( $terms && ! is_wp_error( $terms ) ) {
					// for each service term out put all the related service -------------------------
					foreach ( $terms as $term ) {
						// Add your WP_Query() code here
						// Use $term->slug in your tax_query
						// Use $term->name to organize the posts
						$args = array(
							'post_type' 		=> 'farm-dish',
							'posts_per_page' 	=> -1,
							'orderby'            => 'title',
							'order'              => 'ASC',
							'tax_query' 		=> array(
								array(
									'taxonomy' 	=> 'farm-week',
									'field' 	=> 'slug',
									'terms' 	=> "2021-25"
								)
							)
						);
						$query = new WP_Query( $args );
						// loop output all the service ----------------------------------------------
						if ( $query -> have_posts() ){
							echo "<section class='this-week-menu'>";
							echo "<h2>This Week's Menu</h2>";
							echo "<div class = 'menu-grid'>";
							while ( $query -> have_posts() ) {
								$query -> the_post();
								?>
								<article class='menu-item'>	
									<?php
										the_post_thumbnail('medium');
									?>
									<a href="<?php the_permalink();?>"><?php the_title(); ?></a>
								</article>
								<?php
							}
							echo "</div>";
							echo "</section>";
							wp_reset_postdata();
						}

					}
				}
		?>

		<!-- Add Testimonials -->
		<?php
			// Output a random testimonial 
			$args = array(
				'post_type'      => 'farm-testimonial',
				'orderby'        => 'rand',
				'posts_per_page' => 2,
				);

				$query = new WP_Query( $args );
				if ( $query -> have_posts() ){
					echo '<section class="testimonial"><h2>Testimonial</h2>';
					echo "<div class = 'testimonial-grid'>";
					while ($query-> have_posts() ){
						echo "<article class='testimonial-item'>";
						$query -> the_post();
						the_content();
						echo "</article>";
					}
					echo "</div>";
					wp_reset_postdata();
					echo '</section>';
				}
		?>

		<!-- Featured in news -->
		<?php
			// Output a random Social 
			$args = array(
				'post_type'      => 'farm-social',
				'orderby'        => 'rand',
				'posts_per_page' => 2,
				);

				$query = new WP_Query( $args );
				if ( $query -> have_posts() ){
					echo '<section class="social"><h2>Social</h2>';
					echo "<div class = 'social-grid'>";
					while ($query-> have_posts() ){
						$query -> the_post();
						echo "<article class='social-item'>";
						?>
						<a href="<?php the_permalink();?>"><?php
						the_post_thumbnail('medium');
						?></a>
						<?php
						echo "</article>";
					}
					echo "</div>";
					wp_reset_postdata();
					echo '</section>';
				}
		?>

		<!-- Add ACF map -->
		<section class="delivery">
			<h2>Delivery Area</h2>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d10417.699821447517!2d-123.01679330829566!3d49.24939081924198!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x54867721fd53fee5%3A0x355ab207647a109d!2sBritish%20Columbia%20Institute%20of%20Technology!5e0!3m2!1sen!2sca!4v1624907010490!5m2!1sen!2sca" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
		</section>

		<?php
		// while ( have_posts() ) :
		// 	the_post();

		// 	get_template_part( 'template-parts/content', 'page' );

		// 	// If comments are open or we have at least one comment, load up the comment template.
		// 	if ( comments_open() || get_comments_number() ) :
		// 		comments_template();
		// 	endif;

		// endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
