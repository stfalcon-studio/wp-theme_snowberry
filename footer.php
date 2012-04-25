<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package WordPress
 * @subpackage Snowberry
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
				Powered by <a href="http://wordpress.org" style="text-decoration: underline;">WordPress</a><br>
                <div class="made-by">Designed by
                    <a href="http://stfalcon.com/" target="_blank">
                        <img src="<?php echo get_template_directory_uri() . '/images/stf-logo.png'; ?>" alt=""/>stfalcon.com
                    </a>
                </div>
			</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
