<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Snowberry
 * @subpackage Template
 * @since Snowberry 1.0
 */

get_header(); ?>

		<div id="primary">
			<div id="content" role="main">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'single' ); ?>
					<nav id="nav-single">
						<h3 class="assistive-text"><?php _e( 'Post navigation', 'snowberry' ); ?></h3>
						<span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'snowberry' ) ); ?></span>
						<span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'snowberry' ) ); ?></span>
					</nav>
					<?php comments_template( '', true ); ?>
				<?php endwhile; // end of the loop. ?>
			</div><!-- #content -->
		</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>