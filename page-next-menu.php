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

<main id="primary" class="next menu-page site-main">

<?php 
	while ( have_posts() ) :
		the_post();
?>

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
	else if ($nextWeek >= mktime(0,0,0,12,31,$currentYear)) {
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
			if ( $query -> have_posts() ){ ?>
				<section class='<?php echo $term->slug; ?>-menu'>
					<h2><?php echo $term->name; ?> Menu</h2>
					
					<?php
					while ( $query -> have_posts() ) {
						$query -> the_post();
						?>
						<article class='menu-item'>	
							<a href="<?php the_permalink();?>">
							<?php the_post_thumbnail('large', array('class' => 'dish-image'));?>
							<h3><?php the_title(); ?></h3>
							<!-- acf -->
							<?php
							if ( function_exists ( 'get_field' ) ) {
								?>
								<div class="dish-info-container">
								<?php
								if ( get_field( 'flavour_notes' ) ) {
									?>
									<figure class = 'flavour_notes'>
										<?php
										if(get_field('flavour_notes') === "mild"){
											?>
											<img src="<?php echo get_template_directory_uri(); ?>/img/mild.png" alt="mild flavour">
											<?php
											
										}else if(get_field('flavour_notes') === "medium"){
											?>
											<img src="<?php echo get_template_directory_uri(); ?>/img/medium.png" alt="medium spicy flavour">
											<?php
										}else if(get_field('flavour_notes') === "hot"){
											?>
											<img src="<?php echo get_template_directory_uri(); ?>/img/spicy.png" alt="spicy flavour">
											<?php
										}
										?>
									</figure>
									<?php
								}
								if ( get_field( 'time' ) ) {
									?>
									<figure class = 'time'>
										<?php
										if(get_field('time') === "15 min"){
											?>
											<img src="<?php echo get_template_directory_uri(); ?>/img/15min.png" alt="15 min to cook">
											<?php
										}else if(get_field('time') === "30 min"){
											?>
											<img src="<?php echo get_template_directory_uri(); ?>/img/30min.png" alt="30 min to cook">
											<?php
										}else if(get_field('time') === "1 hr"){
											?>
											<img src="<?php echo get_template_directory_uri(); ?>/img/1hr.png" alt="1 hour to cook">
											<?php
										}
										?>
									</figure>
									<?php
								}
								?>
								</div>
								<?php
							}
							?>
							<!-- end acf -->
							</a>
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
		<section class='cta-button-container'>
			<?php
			$image = get_field( 'cta_image','option');
			if ( get_field( 'cta_image','option')) {
				?>
				<div class="cta-image-container">
				<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
				</div>
				<?php
			}
			?>
			<div class='button'><a href=' <?php echo get_field( 'cta_link') ?> '>Try It Free</a></div>
		</section>
	<?php
	}else{ ?>
		<section class='cta-button-container'>
		<?php
			$image = get_field( 'cta_image','option');
			if ( get_field( 'cta_image','option')) {
				?>
				<div class="cta-image-container">
				<img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
				</div>
				<?php
			}
			?>
		<div class='button'><a href='<?php echo get_permalink(53) ?>'>Try It Free</a></div>
		</section>
	<?php
	}
	// end CTA -------

	endwhile; // End of the loop.
	?>

</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
