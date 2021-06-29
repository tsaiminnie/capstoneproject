<?php
/**
 * The template for displaying a single dish
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Farm_to_Plate
 */

get_header();
?>

	<main id="primary" class="single-dish site-main">

		<section class='banner'>
			<div class='inner-banner'>
				<?php
						the_title( '<h1 class="dish-title">', '</h1>' );
						the_post_thumbnail('large');
						$terms = get_the_terms( $post->ID, 'farm-type' );
						foreach($terms as $term){
							echo "<p>".$term->name."</p>";
						}
						// farm_to_plate_post_thumbnail();
						?>
			</div>
			<?php
			if ( function_exists ( 'get_field' ) ) {
			?>
				<div class='dish-info-icon'>
					<!-- from ACF -->
					<?php
						if ( get_field( 'flavour_notes' ) ) {
							echo "<div class = 'flavour_notes'>";
							// add icon for this flavour notes <-------------------
							// if(the_field('flavour_notes') === "mild"){
							// 	// show a icon
							// }else if(the_field('flavour_notes') === "medium"){
							// 	// show a icon
							// }else if(the_field('flavour_notes') === "hot"){
							// 	// show a icon
							// }else{
							// 	// dont show icon
							// }
							?>
								<p>flavour notes: <?php the_field('flavour_notes'); ?></p>
							<?php
							echo "</div>";
						}

						if ( get_field( 'time' ) ) {
							echo "<div class = 'time'>";
							// add icon for this flavour notes <-------------------
							// if(the_field('time') === "15 min"){
							// 	// show a icon
							// }else if(the_field('time') === "30 min"){
							// 	// show a icon
							// }else if(the_field('time') === "1 hr"){
							// 	// show a icon
							// }else{
							// 	// dont show icon
							// }
							?>
								<p>time: <?php the_field('time'); ?></p>
							<?php
							echo "</div>";
						}

						if ( get_field( 'difficulty' ) ) {
							echo "<div class = 'difficulty'>";
							// add icon for this flavour notes <-------------------
							// if(the_field('difficulty') === "beginner"){
							// 	// show a icon
							// }else if(the_field('difficulty') === "intermediate"){
							// 	// show a icon
							// }else if(the_field('difficulty') === "expert"){
							// 	// show a icon
							// }else{
							// 	// dont show icon
							// }
							?>
								<p>difficulty: <?php the_field('difficulty'); ?></p>
							<?php
							echo "</div>";
						}
					?>
				</div>
			<?php
			}
			?>
		</section>

		<?php
		if ( function_exists ( 'get_field' ) ) {
		?>
			<section class="ingredients">
				<h2>Ingredients</h2>
				<?php
				if( have_rows('what_we_deliver') ):
				?>
					<div class="deliver">
						<h3>What We Deliver</h3>
						<?php
							while( have_rows('what_we_deliver') ) : the_row();
								$sub_value_img = wp_get_attachment_image( get_sub_field('ingredient_image'), 'full', '', array( 'class' => '' ));
								$sub_value_text = get_sub_field('ingredient_name');
								echo "<div class = 'deliver-item'>";
									echo $sub_value_img;
									echo "<p>$sub_value_text</p>";
								echo "</div>";
							endwhile;
						?>
					</div>
				<?php
				endif;
				if( have_rows('what_you_need') ):
				?>
					<div class="need">
						<h3>What You Need</h3>
						<?php
							while( have_rows('what_you_need') ) : the_row();
								$sub_value_text = get_sub_field('ingredients_and_tools');
								echo "<div class = 'need-item'>";
									echo "<p>$sub_value_text</p>";
								echo "</div>";
							endwhile;
						?>
					</div>
				<?php
				endif;
				?>

				<div class="nutrition">
					<h3>Nutrition</h3>
					<?php
					if ( get_field( 'calories' ) ) {
						$field = get_field_object('calories');
						?>
						<div class="<?php echo $field['name']; ?> nutrition-item">
							<h4><?php echo $field['label']; ?></h4> 
							<h4><?php echo $field['value']; ?></h4>
							</div>	
					<?php
					}
					?>

					<?php
					if ( get_field( 'total_fat' ) ) {
						$field = get_field_object('total_fat');
						?>
						<div class="<?php echo $field['name']; ?> nutrition-item">
							<p><?php echo $field['label']; ?></p> 
							<p><?php echo $field['value']; ?></p>
							</div>	
					<?php
					}
					?>

					<?php
					if ( get_field( 'protein' ) ) {
						$field = get_field_object('protein');
						?>
						<div class="<?php echo $field['name']; ?> nutrition-item">
							<p><?php echo $field['label']; ?></p> 
							<p><?php echo $field['value']; ?></p>
							</div>	
					<?php
					}
					?>

					<?php
					if ( get_field( 'carbohydrate' ) ) {
						$field = get_field_object('carbohydrate');
						?>
						<div class="<?php echo $field['name']; ?> nutrition-item">
							<p><?php echo $field['label']; ?></p> 
							<p><?php echo $field['value']; ?></p>
							</div>	
					<?php
					}
					?>

					<?php
					if ( get_field( 'sodium' ) ) {
						$field = get_field_object('sodium');
						?>
						<div class="<?php echo $field['name']; ?> nutrition-item">
							<p><?php echo $field['label']; ?></p> 
							<p><?php echo $field['value']; ?></p>
							</div>	
					<?php
					}
					?>

					<?php
					if( have_rows('nutrients') ):
						$field = get_field_object('nutrients');		
					?>
						<div class="<?php echo $field['name']; ?>">
							<h4><?php echo $field['label']; ?></h4>
							<?php
								while( have_rows('nutrients') ) : the_row();
									$sub_value_label = get_sub_field('label');
									$sub_value_value = get_sub_field('value');
									$sub_value_name = get_sub_field('name');
									
									?>
									<div class="nutrients-item">
									<?php
										echo "<p>$sub_value_label</p>";
										echo "<p>$sub_value_value</p>";
									echo "</div>";
								endwhile;
							?>
						</div>
					<?php
					endif;
					?>

				</div>

				<div class="allergen">
				<?php
					if ( get_field( 'allergen' ) ) {
						?>
						<h3>Allergen Info</h3>
						<p>time: <?php the_field('allergen'); ?></p>
					<?php	
					}
					?>
				</div>
			</section>
		<?php
		}
		?>

		<?php
		if ( function_exists ( 'get_field' ) ) {
		?>
				<?php
				if( have_rows('cooking_directions') ):
				?>
					<section class="cooking-directions">
						<h2>Cooking Directions</h2>
						<?php
							while( have_rows('cooking_directions') ) : the_row();
								$sub_value_img = wp_get_attachment_image( get_sub_field('image'), 'medium', '', array( 'class' => '' ));
								$sub_value_step = get_sub_field('step');
								$sub_value_text_area = get_sub_field('text_area');
								echo "<div class = 'cooking-steps'>";
									echo $sub_value_img;
									echo "<h3>$sub_value_step</h3>";
									echo "$sub_value_text_area";
								echo "</div>";
							endwhile;
						?>
					</section>
				<?php
				endif;
				?>
		<?php
		}
		
		// <!-- CTA -->
		if ( get_field( 'cta_link' ) ) {
			echo "<div class='button-container'>";
				echo "<div class='button'><a href='".get_field( 'cta_link')."'>Try it Free</a></div>";
			echo "</div>";
		}

		// while ( have_posts() ) :
		// 	the_post();

		// 	get_template_part( 'template-parts/content', get_post_type() );

			// the_post_navigation(
			// 	array(
			// 		'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous:', 'farm-to-plate' ) . '</span> <span class="nav-title">%title</span>',
			// 		'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next:', 'farm-to-plate' ) . '</span> <span class="nav-title">%title</span>',
			// 	)
			// );

			// // If comments are open or we have at least one comment, load up the comment template.
			// if ( comments_open() || get_comments_number() ) :
			// 	comments_template();
			// endif;

		// endwhile; // End of the loop.
		?>

	</main><!-- #main -->

<?php
// get_sidebar();
get_footer();
