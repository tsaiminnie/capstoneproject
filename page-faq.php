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
		<?php 
		while ( have_posts() ) :
		the_post();
		?>
		<h1><?php the_title(); ?></h1>

		<?php
		// FAQ snippet
		if ( function_exists ( 'get_field' ) ) {
			?>
			<section class = 'faq'>
			<?php
			if( have_rows('faq') ):
				while( have_rows('faq') ) : the_row();
					$faq_category_heading = get_sub_field('category_heading');
					?>
					<div class = 'faq-category'>
					<?php
						echo "<h2>$faq_category_heading</h2>";
						while(have_rows('category')): the_row();
							?>
							<article class = 'faq-qa'>
							<?php
							$faq_question = get_sub_field('question');
							$faq_answer = get_sub_field('answer');
							echo "<h3>$faq_question</h3>";
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
		}

		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
get_footer();
