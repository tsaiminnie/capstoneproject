<?php
/**
 * The template for displaying the current Menu Page
 *
 * This is the template that displays the current Menu Page by default.
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

	<main id="primary" class="archive-menu site-main">
            <h1>Archive Menu</h1>
				<?php
				$currentWeek = date('oW');
				// loop to get menu items ---------------------------------------------------------
				$terms = get_terms(
					array(
						'taxonomy' 	=> 'farm-week',
                        'orderby'   =>  'name',
                        'order'     =>  'DESC',
					)
				);
				if ( $terms && ! is_wp_error( $terms ) ) :
					// for each service term out put all the related service -------------------------
					echo "<section class='menu-container'>";
					foreach ( $terms as $term ) {
                        $week = str_replace('-', '', $term->name);
                        if($week >= $currentWeek){
                            continue;
                        }
						$args = array(
							'post_type' 		=> 'farm-dish',
							'posts_per_page' 	=> -1,
							// 'orderby'            => 'title',
							// 'order'              => 'DESC',
							'tax_query' 		=> array(
								array(
									'taxonomy' 	=> 'farm-week',
									'field' 	=> 'slug',
									'terms' 	=> $term->slug
								)

							)
						);

						$query = new WP_Query( $args );
						// loop output all the menu ----------------------------------------------
						if ( $query -> have_posts() ){
							echo "<div class='$term->slug-list'>";
							echo "<h2>$term->name's Menu</h2>";
							echo "<div class = 'menu-list'>";
							while ( $query -> have_posts() ) {
								$query -> the_post();
								?>
								<article class='menu-item'>	
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
