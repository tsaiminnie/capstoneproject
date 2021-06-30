<?php
/**
 * The template for displaying the Next Menu page
 *
 * This is the template that displays the Next Menu page by default.
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

<main id="primary" class="next menu site-main">

		<nav class="menu-filter">
			<a href="<?php echo get_permalink(47); ?>">Previous Weeks</a>
			<a href="<?php echo get_permalink(42); ?>">Current Week</a>
			<a class="selected" href="#">Next Week</a>
		</nav>


		<?php

		// check if the currnt week is less than total week of the year
		$currentWeek = date('W');
		$currentYear = date('Y');
		if ($currentWeek < date("W", mktime(0,0,0,12,31,$currentYear))) {
			$nextWeek = $currentWeek + 1 . "<br>";
			$formattedNextWeek = $currentYear ."-" . $nextWeek;
		} 
		elseif ($nextWeek >= mktime(0,0,0,12,31,$currentYear)) {
			$nextWeek = 1;
			$nextYear = $currentYear + 1;
			$formattedNextWeek = $nextYear ."-" . $nextWeek;
		}

		// loop to get menu items ---------------------------------------------------------
		$terms = get_terms(
			array(
				'taxonomy' 	=> 'farm-type',
			)
		);
		if ( $terms && ! is_wp_error( $terms ) ) :
			// for each service term out put all the related service -------------------------
			echo "<section class='menu-container'>";
			foreach ( $terms as $term ) {
				$args = array(
					'post_type' 		=> 'farm-dish',
					'posts_per_page' 	=> -1,
					// 'orderby'            => 'title',
					// 'order'              => 'ASC',
					'tax_query' 		=> array(
						'relation' => 'AND',
						array(
							'taxonomy' 	=> 'farm-week',
							'field' 	=> 'slug',
							'terms' 	=> $formattedNextWeek
						),
						array(
							'taxonomy' 	=> 'farm-type',
							'field' 	=> 'slug',
							'terms' 	=> $term->slug
						)

					)
				);

				$query = new WP_Query( $args );
				// loop output all the menu ----------------------------------------------
				if ( $query -> have_posts() ){
					echo "<div class='$term->slug-menu'>";
					echo "<h2>$term->name Menu</h2>";
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
			echo "</section>";
		endif;

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
