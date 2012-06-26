<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Snowberry
 * @subpackage Template
 * @since Snowberry 1.0
 */
?>

	</div><!-- #main -->

	<footer id="colophon" role="contentinfo">

			<?php
				/* A sidebar in the footer? Yep. You can can customize
				 * your footer with three columns of widgets.
				 */
				get_sidebar( 'footer' );
			?>

			<div id="site-generator">
				<?php do_action( 'snowberry_credits' ); ?>
                <?php _e( 'Powered by', 'snowberry' ); ?>  <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'snowberry' ) ); ?>">WordPress</a><br>
                <?php _e( 'Designed by', 'snowberry' ); ?> <a href="<?php echo esc_url( __( 'http://stfalcon.com/', 'snowberry' ) ); ?>" target="_blank">stfalcon.com</a>
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
