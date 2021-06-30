<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Farm_to_Plate
 */

?>

	<footer id="colophon" class="site-footer">
		<!-- <div class="site-info"> -->
			<!-- logo -->
			<?php
			if ( get_field( 'inverse_logo',2 ) ) {
				echo "<div class='footer-logo'>";
				echo wp_get_attachment_image( get_field( 'inverse_logo',2 ), 'full', '', array( 'class' => '' ));
				echo "</div>";
			}
			?>
			
			<nav id="footer-navigation" class="footer-navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'footer') ); ?>
			</nav>
		<!-- </div> -->

		<nav id="social-navigation" class="social-navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'social' ) ); ?>
		</nav>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
