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
		<div class="site-info">
			<!-- logo -->
			<nav id="footer-navigation" class="footer-navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'footer') ); ?>
			</nav>
		</div><!-- .site-info -->

		<div class="social">
			<!-- social -->
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
