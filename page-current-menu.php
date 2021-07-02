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

	<main id="primary" class="current menu site-main">

	<?php 
	while ( have_posts() ) :
				the_post();
	?>

		<nav class="menu-filter">
			<a href="<?php echo get_permalink(47); ?>">Previous Weeks</a>
			<a class="selected" href="#">Current Week</a>
			<a href="<?php echo get_permalink(49); ?>">Next Week</a>
		</nav>

			<?php
			$currentWeek = date('o-W');
			// loop to get menu items ---------------------------------------------------------
			$terms = get_terms(
				array(
					'taxonomy' 	=> 'farm-type',
				)
			);
			if ( $terms && ! is_wp_error( $terms ) ) : ?>
				<section class='menu-container'>
				<?php
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
								'terms' 	=> $currentWeek
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
					if ( $query -> have_posts() ){ ?>
						<section class='<?php echo $term->slug; ?>-menu'>
						<h2><?php echo $term->name; ?> Menu</h2>
						
						<?php
						while ( $query -> have_posts() ) {
							$query -> the_post();
						?>
							<article class='menu-item'>	
								<?php the_post_thumbnail('medium');?>
								<a href="<?php the_permalink();?>"><?php the_title(); ?></a>
							</article>
						<?php
						} ?>
						
						</section>
						<?php
						wp_reset_postdata();
					}
				} ?>

				</section>
			<?php
			endif;

		// <!-- CTA -->
		if ( get_field( 'cta_link' ) ) { ?>
			<section class='button-container'>
				<div class='button'><a href=' <?php echo get_field( 'cta_link') ?> '>Try It Free</a></div>
			</section>
		<?php
		}else{ ?>
			<section class='button-container'>
			<div class='button'><a href='<?php echo get_permalink(53) ?>'>Try It Free</a></div>
			</section>
			
		<?php
		}
		endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
