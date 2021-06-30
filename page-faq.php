<?php
/**
 * The template for displaying the FAQ page
 *
 * This is the template that displays the FAQ page by default.
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

	<main id="primary" class="faq site-main">
		<h1>FAQs</h1>
	<?php
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


			// <!-- CTA -->
			if ( get_field( 'cta_link' ) ) {
				echo "<div class='button-container'>";
					echo "<div class='button'><a href='".get_field( 'cta_link')."'>Try it Free</a></div>";
				echo "</div>";
			}else{
				echo "<div class='button-container'>";
				echo "<div class='button'><a href='".get_permalink(53)."'>Try it Free</a></div>";
				echo "</div>";
			}
		}

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
