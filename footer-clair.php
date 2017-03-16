<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mcen_s
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer clair" role="contentinfo">
		<div class="footer-widgets container">
			<?php 
				if (is_active_sidebar('pied-de-page')) {
					dynamic_sidebar('pied-de-page');
				}
			?>
		</div>
		<!--
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'mcen_s' ) ); ?>"><?php printf( esc_html__( 'Proudly powered by %s', 'mcen_s' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( esc_html__( 'Theme: %1$s by %2$s.', 'mcen_s' ), 'mcen_s', '<a href="https://automattic.com/" rel="designer">Underscores.me</a>' ); ?>
		</div> .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
