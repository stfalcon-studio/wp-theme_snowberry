<?php
/**
 * Snowberry Theme Options
 *
 * @package Snowberry
 * @subpackage Template
 * @since Snowberry 1.0
 */

/**
 * Properly enqueue styles and scripts for our theme options page.
 *
 * This function is attached to the admin_enqueue_scripts action hook.
 *
 * @since Snowberry 1.0
 *
 */
function snowberry_admin_enqueue_scripts( $hook_suffix ) {
	wp_enqueue_style( 'snowberry-theme-options', get_template_directory_uri() . '/inc/theme-options.css', false, '2011-04-28' );
	wp_enqueue_script( 'snowberry-theme-options', get_template_directory_uri() . '/inc/theme-options.js', array( 'farbtastic' ), '2011-06-10' );
	wp_enqueue_style( 'farbtastic' );
}
add_action( 'admin_print_styles-appearance_page_theme_options', 'snowberry_admin_enqueue_scripts' );

/**
 * Register the form setting for our snowberry_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, snowberry_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are complete, properly
 * formatted, and safe.
 *
 * We also use this function to add our theme option if it doesn't already exist.
 *
 * @since Snowberry 1.0
 */
function snowberry_theme_options_init() {

	// If we have no options in the database, let's add them now.
	if ( false === snowberry_get_theme_options() )
		add_option( 'snowberry_theme_options', snowberry_get_default_theme_options() );

	register_setting(
		'snowberry_options',       // Options group, see settings_fields() call in theme_options_render_page()
		'snowberry_theme_options', // Database option, see snowberry_get_theme_options()
		'snowberry_theme_options_validate' // The sanitization callback, see snowberry_theme_options_validate()
	);
}
add_action( 'admin_init', 'snowberry_theme_options_init' );

/**
 * Change the capability required to save the 'snowberry_options' options group.
 *
 * @see snowberry_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see snowberry_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * By default, the options groups for all registered settings require the manage_options capability.
 * This filter is required to change our theme options page to edit_theme_options instead.
 * By default, only administrators have either of these capabilities, but the desire here is
 * to allow for finer-grained control for roles and users.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function snowberry_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_snowberry_options', 'snowberry_option_page_capability' );
/**
 * Add our theme options page to the admin menu, including some help documentation.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since Snowberry 1.0
 */
function snowberry_theme_options_add_page() {

    global $theme_page;

	$theme_page = add_theme_page(
		__( 'Theme Options', 'snowberry' ),   // Name of page
		__( 'Theme Options', 'snowberry' ),   // Label in menu
		'edit_theme_options',                 // Capability required
		'theme_options',                      // Menu slug, used to uniquely identify the page
		'snowberry_theme_options_render_page' // Function that renders the options page
	);

    // Adds snowberry_theme_add_help_tab when snowberry_theme_options_add_page loads
    if ( $theme_page )
        add_action('load-' . $theme_page, 'snowberry_theme_add_help_tab');
}
add_action( 'admin_menu', 'snowberry_theme_options_add_page' );

/**
 * Add help contextual information for the themes options page
 *
 * @since Snowberry 1.1.1
 */
function snowberry_theme_add_help_tab() {
    get_current_screen()->add_help_tab(array(
       'id'      => 'snowberry_theme_options_help',
       'title'   => __( 'Special Instructions', 'snowberry' ),
       'content' =>
            '<p>' . __( 'Some themes provide customization options that are grouped together on a Theme Options screen. If you change themes, options may change or disappear, as they are theme-specific. Your current theme, Snowberry, provides the following Theme Options:', 'snowberry' ) . '</p>' .
			'<ol>' .
				'<li>' . __( '<strong>Link Color</strong>: You can choose the color used for text links on your site. You can enter the HTML color or hex code, or you can choose visually by clicking the "Select a Color" button to pick from a color wheel.', 'snowberry' ) . '</li>' .
				'<li>' . __( '<strong>Default Layout</strong>: You can choose if you want your site&#8217;s default layout to have a sidebar on the left, the right, or not at all.', 'snowberry' ) . '</li>' .
			'</ol>' .
			'<p>' . __( 'Remember to click "Save Changes" to save any changes you have made to the theme options.', 'snowberry' ) . '</p>' .
			'<p><strong>' . __( 'For more information:', 'snowberry' ) . '</strong></p>' .
			'<p>' . __( '<a href="http://codex.wordpress.org/Appearance_Theme_Options_Screen" target="_blank">Documentation on Theme Options</a>', 'snowberry' ) . '</p>' .
			'<p>' . __( '<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>', 'snowberry' ) . '</p>'
    ));
}

/**
 * Returns an array of layout options registered for Snowberry.
 *
 * @since Snowberry 1.0
 */
function snowberry_layouts() {
	$layout_options = array(
		'content-sidebar' => array(
			'value' => 'content-sidebar',
			'label' => __( 'Content on left', 'snowberry' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/content-sidebar.png',
		),
		'sidebar-content' => array(
			'value' => 'sidebar-content',
			'label' => __( 'Content on right', 'snowberry' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/sidebar-content.png',
		),
		'content' => array(
			'value' => 'content',
			'label' => __( 'One-column, no sidebar', 'snowberry' ),
			'thumbnail' => get_template_directory_uri() . '/inc/images/content.png',
		),
	);

	return apply_filters( 'snowberry_layouts', $layout_options );
}

/**
 * Returns the default options for Snowberry.
 *
 * @since Snowberry 1.0
 */
function snowberry_get_default_theme_options() {
	$default_theme_options = array(
		'link_color'   => '#1b8be0',
		'theme_layout' => 'content-sidebar',
	);

	if ( is_rtl() )
 		$default_theme_options['theme_layout'] = 'sidebar-content';

	return apply_filters( 'snowberry_default_theme_options', $default_theme_options );
}

/**
 * Returns the options array for Snowberry.
 *
 * @since Snowberry 1.0
 */
function snowberry_get_theme_options() {
	return get_option( 'snowberry_theme_options', snowberry_get_default_theme_options() );
}

/**
 * Returns the options array for Snowberry.
 *
 * @since Snowberry 1.2
 */
function snowberry_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2><?php printf( __( '%s Theme Options', 'snowberry' ), wp_get_theme() ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
			<?php
				settings_fields( 'snowberry_options' );
				$options = snowberry_get_theme_options();
			?>

			<table class="form-table">

				<tr valign="top"><th scope="row"><?php _e( 'Link Color', 'snowberry' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Link Color', 'snowberry' ); ?></span></legend>
							<input type="text" name="snowberry_theme_options[link_color]" id="link-color" value="<?php echo esc_attr( $options['link_color'] ); ?>" />
							<a href="#" class="pickcolor hide-if-no-js" id="link-color-example"></a>
							<input type="button" class="pickcolor button hide-if-no-js" value="<?php esc_attr_e( 'Select a Color', 'snowberry' ); ?>" />
							<div id="colorPickerDiv"></div>
							<br />
							<span><?php printf( __( 'Default color: %s', 'snowberry' ), '<span id="default-color">#1b8be0</span>' ); ?></span>
						</fieldset>
					</td>
				</tr>

				<tr valign="top" class="image-radio-option theme-layout"><th scope="row"><?php _e( 'Default Layout', 'snowberry' ); ?></th>
					<td>
						<fieldset><legend class="screen-reader-text"><span><?php _e( 'Color Scheme', 'snowberry' ); ?></span></legend>
						<?php
							foreach ( snowberry_layouts() as $layout ) {
								?>
								<div class="layout">
								<label class="description">
									<input type="radio" name="snowberry_theme_options[theme_layout]" value="<?php echo esc_attr( $layout['value'] ); ?>" <?php checked( $options['theme_layout'], $layout['value'] ); ?> />
									<span>
										<img src="<?php echo esc_url( $layout['thumbnail'] ); ?>" width="136" height="122" alt="" />
										<?php echo $layout['label']; ?>
									</span>
								</label>
								</div>
								<?php
							}
						?>
						</fieldset>
					</td>
				</tr>
			</table>

			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see snowberry_theme_options_init()
 * @todo set up Reset Options action
 *
 * @since Snowberry 1.0
 */
function snowberry_theme_options_validate( $input ) {
	$output = $defaults = snowberry_get_default_theme_options();

	// Link color must be 3 or 6 hexadecimal characters
	if ( isset( $input['link_color'] ) && preg_match( '/^#?([a-f0-9]{3}){1,2}$/i', $input['link_color'] ) )
		$output['link_color'] = '#' . strtolower( ltrim( $input['link_color'], '#' ) );

	// Theme layout must be in our array of theme layout options
	if ( isset( $input['theme_layout'] ) && array_key_exists( $input['theme_layout'], snowberry_layouts() ) )
		$output['theme_layout'] = $input['theme_layout'];

	return apply_filters( 'snowberry_theme_options_validate', $output, $input, $defaults );
}

/**
 * Add a style block to the theme for the current link color.
 *
 * This function is attached to the wp_head action hook.
 *
 * @since Snowberry 1.0
 */
function snowberry_print_link_color_style() {
	$options = snowberry_get_theme_options();
	$link_color = $options['link_color'];

	$default_options = snowberry_get_default_theme_options();

	// Don't do anything if the current link color is the default.
	if ( $default_options['link_color'] == $link_color )
		return;
?>
	<style>
		/* Link color */
		a,
		#site-title a:focus,
		#site-title a:hover,
		#site-title a:active,
		.entry-title a:hover,
		.entry-title a:focus,
		.entry-title a:active,
		.widget_snowberry_ephemera .comments-link a:hover,
		section.recent-posts .other-recent-posts a[rel="bookmark"]:hover,
		section.recent-posts .other-recent-posts .comments-link a:hover,
		.format-image footer.entry-meta a:hover,
		#site-generator a:hover {
			color: <?php echo $link_color; ?>;
		}
		section.recent-posts .other-recent-posts .comments-link a:hover {
			border-color: <?php echo $link_color; ?>;
		}
		article.feature-image.small .entry-summary p a:hover,
		.entry-header .comments-link a:hover,
		.entry-header .comments-link a:focus,
		.entry-header .comments-link a:active,
		.feature-slider a.active {
			background-color: <?php echo $link_color; ?>;
		}
	</style>
<?php
}
add_action( 'wp_head', 'snowberry_print_link_color_style' );

/**
 * Adds Snowberry layout classes to the array of body classes.
 *
 * @since Snowberry 1.0
 */
function snowberry_layout_classes( $existing_classes ) {
	$options = snowberry_get_theme_options();
	$current_layout = $options['theme_layout'];

	if ( in_array( $current_layout, array( 'content-sidebar', 'sidebar-content' ) ) )
		$classes = array( 'two-column' );
	else
		$classes = array( 'one-column' );

	if ( 'content-sidebar' == $current_layout )
		$classes[] = 'right-sidebar';
	elseif ( 'sidebar-content' == $current_layout )
		$classes[] = 'left-sidebar';
	else
		$classes[] = $current_layout;

	$classes = apply_filters( 'snowberry_layout_classes', $classes, $current_layout );

	return array_merge( $existing_classes, $classes );
}
add_filter( 'body_class', 'snowberry_layout_classes' );