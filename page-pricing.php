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
		// free trail notes
		if ( function_exists ( 'get_field' ) ) {
			if ( get_field( 'free_trial_notes' ) ) {
				echo "<section class='free-trial-note'>";
				echo get_field( 'free_trial_notes');
				echo "</section>";
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
				echo '<section class="product">';
				echo "<div class = 'product-grid'>";
				while ($query-> have_posts() ){
					echo "<article class='product-item'>";
					$query -> the_post();
					the_post_thumbnail('medium');
					echo "<h2>".get_the_title()."</h2>";
					// the_content();
					$excerpt = get_the_content();
					echo substr( $excerpt, 0, 260 );
					echo "</article>";
				}
				echo "</div>";
				wp_reset_postdata();
				echo '</section>';
			}
			// Why Choose
			if ( function_exists ( 'get_field' ) ) {
				get_template_part( 'template-parts/why', 'choose' );
			}

			// FAQ snippet
			if ( function_exists ( 'get_field' ) ) {
				echo "<section class = 'faq'>";
				if( have_rows('faq') ):
					while( have_rows('faq') ) : the_row();
						$faq_category_heading = get_sub_field('category_heading');
						echo "<div class = 'faq-category'>";
							echo "<h2>$faq_category_heading</h2>";
							while(have_rows('category')): the_row();
								echo "<article class = 'faq-qa'>";
								$faq_question = get_sub_field('question');
								$faq_answer = get_sub_field('answer');
								echo "<h3>$faq_question</h3>";
								echo $faq_answer;
								echo "</article>";
							endwhile;
							// echo "<p>$sub_value_text</p>";
						echo "</div>";
					endwhile;
				endif;
				echo "</section>";

				// CTA to FAQ page
				if ( get_field( 'cta_faq_link' ) ) {
					echo "<div class='button-container'>";
						echo "<div class='button'><a target='_blank' href='".get_field( 'cta_faq_link')."'>Read the FAQs</a></div>";
					echo "</div>";
				}else{
					echo "<div class='button-container'>";
					echo "<div class='button'><a target='_blank' href='".get_permalink(51)."'>Read the FAQs</a></div>";
					echo "</div>";
				}
			}


			// delivery area
			?>
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
