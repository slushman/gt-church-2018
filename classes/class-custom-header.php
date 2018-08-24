<?php

/**
 * Defines functions related to the custom header.
 * 
 * You can add an optional custom header image to header.php like so ...
 *
 *	<?php the_header_image_tag(); ?>
 *
 * @link  			https://developer.wordpress.org/themes/functionality/custom-headers/
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Custom_Header {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );

	} // hooks()

	/**
	 * Set up the WordPress core custom header feature.
	 *
	 * @hooked 		after_setup_theme
	 * @uses 		header_style()
	 * @since 		1.0.0
	 */
	public function theme_support() {

		$headerOpts['default-image']          = '';
		$headerOpts['default-text-color']     = '000000';
		$headerOpts['width']                  = 1000;
		$headerOpts['height']                 = 250;
		$headerOpts['flex-height']            = true;
		$headerOpts['wp-head-callback']       = array( $this, 'header_style' );

		/**
		 * The gt_church_2018_custom_header_args filter.
		 * 
		 * @param 		array 		$headerOpts 		The header options.
		 */
		$headerOpts = apply_filters( 'gt_church_2018_custom_header_args', $headerOpts );

		add_theme_support( 'custom-header', $headerOpts );

	} // theme_support()

	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @exits 		If no theme support for custom header or default text color.
	 * @see header_setup().
	 */
	public function header_style() {

		$header_text_color = get_header_textcolor();

		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) { return; }

		// If we get this far, we have custom styles. Let's do this.
		?><style type="text/css"><?php

		// Has the text been hidden?
		if ( ! display_header_text() ) :
			?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php
		// If the user has set a custom color for the text use that.
		else :
			?>
			.site-title a,
			.site-description {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; 
		
		?></style><?php

	} // header_style()

} // class