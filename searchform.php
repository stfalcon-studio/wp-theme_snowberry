<?php
/**
 * The template for displaying search forms in Snowberry
 *
 * @package WordPress
 * @subpackage Snowberry
 * @since Snowberry 1.0
 */
?>
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s" class="assistive-text"><?php _e( 'Search', 'snowberry' ); ?></label>
		<input type="text" class="field" name="s" id="s"  />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'snowberry' ); ?>" />
	</form>
