<?php

/**
 * GTChurch2018 Brothers Customizer
 *
 * Contains methods for customizing the theme customization screen.
 *
 * @link 			https://developer.wordpress.org/themes/customize-api/
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Customizer {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'customize_register', 					array( $this, 'register_panels' ) );
		add_action( 'customize_register', 					array( $this, 'register_sections' ) );
		add_action( 'customize_register', 					array( $this, 'register_fields_default' ) );
		add_action( 'customize_register', 					array( $this, 'register_fields_images' ) );
		add_action( 'customize_register', 					array( $this, 'register_fields_menus' ) );
		add_action( 'customize_register', 					array( $this, 'register_fields_siteid' ) );
		add_action( 'wp_head', 								array( $this, 'header_output' ) );
		//add_action( 'customize_register', 					array( $this, 'load_customize_controls' ), 0 );
		add_action( 'customize_preview_init', 				array( $this, 'enqueue_customizer_scripts' ) );
		add_action( 'customize_controls_enqueue_scripts', 	array( $this, 'enqueue_customizer_controls' ) );
		add_action( 'customize_controls_print_styles', 		array( $this, 'enqueue_customizer_styles' ) );

	} // hooks()

	/**
	 * Used by customizer controls, mostly for active callbacks.
	 *
	 * @hooked		customize_controls_enqueue_scripts
	 * @access 		public
	 * @see 		add_action( 'customize_preview_init', $func )
	 * @since 		1.0.0
	 */
	public function enqueue_customizer_controls() {

		wp_enqueue_script( 'gt-customizer-controls', get_theme_file_uri( '/assets/js/customizer-controls.min.js' ), array( 'jquery', 'customize-controls' ), PARENT_THEME_VERSION, true );

	} // enqueue_customizer_controls()

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @hooked 		customize_preview_init
	 */
	public function enqueue_customizer_scripts() {

		wp_enqueue_script( 'gt-customizer', get_theme_file_uri( '/assets/js/customizer.min.js' ), array( 'jquery', 'customize-preview' ), PARENT_THEME_VERSION, true );

	} // enqueue_customizer_scripts()

	/**
	 * Loads custopmizer.css file for Customizer Previewer styling.
	 *
	 * @hooked 		customize_controls_print_styles
	 */
	public function enqueue_customizer_styles() {

		wp_enqueue_style( 'gt-customizer-style', get_theme_file_uri( 'customizer.css' ), 10, 2 );

	} // enqueue_customizer_styles()

	/**
	 * Registers custom panels for the Customizer
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_panels( $wp_customize ) {

		// Register panels here

	} // register_panels()

	/**
	 * Registers custom sections for the Customizer
	 *
	 * Existing sections:
	 *
	 * Slug 				Priority 		Title
	 *
	 * title_tagline 		20 				Site Identity
	 * colors 				40				Colors
	 * header_image 		60				Header Image
	 * background_image 	80				Background Image
	 * nav_menus			100 			Navigation
	 * widgets 				110 			Widgets
	 * static_front_page 	120 			Static Front Page
	 * default 				160 			all others
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_sections( $wp_customize ) {

		// Tablet Menu Section
		$wp_customize->add_section( 'tablet_menu',
			array(
				'active_callback' 	=> '',
				'capability'  		=> 'edit_theme_options',
				'description'  		=> esc_html__( '', 'gt' ),
				'panel' 			=> 'nav_menus',
				'priority'  		=> 10,
				'theme_supports'  	=> '',
				'title'  			=> esc_html__( 'Tablet Menu Style', 'gt' ),
			)
		);

		// Images Section
		$wp_customize->add_section( 'images',
			array(
				'active_callback' 	=> '',
				'capability'  		=> 'edit_theme_options',
				'description'  		=> esc_html__( '', 'gt' ),
				'panel' 			=> '',
				'priority'  		=> 10,
				'theme_supports'  	=> '',
				'title'  			=> esc_html__( 'Images', 'gt' ),
			)
		);

	} // register_sections()

	/**
	 * Enables live preview JS and selective refresh for default fields.
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_fields_default( $wp_customize ) {

		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport 	= 'postMessage';
		$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

		if ( ! isset( $wp_customize->selective_refresh ) ) { return; }

		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '.site-title a',
			'render_callback' => [ $this, 'refresh_partial_blogname' ],
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '.site-description',
			'render_callback' => [ $this, 'refresh_partial_blogdescription' ],
		) );

	} // register_fields_default()

	/**
	 * Registers controls/fields for the Images section in the Customizer
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * Note: To use active_callbacks, don't add these to the selecting control, it apepars these conflict:
	 * 		'transport' => 'postMessage'
	 * 		$wp_customize->get_setting( 'field_name' )->transport = 'postMessage';
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_fields_images( $wp_customize ) {

		// Default Featured Image Field
		$wp_customize->add_setting(
			'default_featured_image' ,
			array(
				'capability' 			=> 'edit_theme_options',
				'default'  				=> '',
				'sanitize_callback' 	=> 'esc_url_raw',
				'transport' 			=> 'postMessage',
				'type' 					=> 'theme_mod'
			)
		);
		$wp_customize->add_control(
			new \WP_Customize_Media_Control(
				$wp_customize,
				'default_featured_image',
				array(
					'active_callback' 	=> '',
					'description' 		=> esc_html__( '', 'gt' ),
					'label' 			=> esc_html__( 'Default Featured Image', 'gt' ),
					'priority' 			=> 10,
					'section' 			=> 'images',
					'settings' 			=> 'default_featured_image'
				)
			)
		);

	} // register_fields_images()

	/**
	 * Registers controls/fields for the menus section in the Customizer.
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * Note: To use active_callbacks, don't add these to the selecting control, it apepars these conflict:
	 * 		'transport' => 'postMessage'
	 * 		$wp_customize->get_setting( 'field_name' )->transport = 'postMessage';
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_fields_menus( $wp_customize ) {

		// Tablet Menu Field
		$wp_customize->add_setting(
			'tablet_menu',
			array(
				'capability' 		=> 'edit_theme_options',
				'default'  			=> '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'type' 				=> 'theme_mod'
			)
		);
		$wp_customize->add_control(
			'tablet_menu',
			array(
				'active_callback' 	=> '',
				'choices' 			=> array(
					'tablet-slide-ontop-from-left' 		=> esc_html__( 'Slide On Top from Left', 'gt' ),
					'tablet-slide-ontop-from-right' 	=> esc_html__( 'Slide On Top from Right', 'gt' ),
					'tablet-slide-ontop-from-top' 		=> esc_html__( 'Slide On Top from Top', 'gt' ),
					'tablet-slide-ontop-from-bottom' 	=> esc_html__( 'Slide On Top from Bottom', 'gt' ),
					'tablet-push-from-left' 			=> esc_html__( 'Push In from Left', 'gt' ),
					'tablet-push-from-right' 			=> esc_html__( 'Push In from Right', 'gt' ),
				),
				'description' 		=> esc_html__( 'Select how the tablet menu appears.', 'gt' ),
				'label'  			=> esc_html__( 'Tablet Menu', 'gt' ),
				'priority' 			=> 10,
				'section'  			=> 'tablet_menu',
				'settings' 			=> 'tablet_menu',
				'type' 				=> 'select'
			)
		);
		$wp_customize->get_setting( 'tablet_menu' )->transport = 'postMessage';

	} // register_fields_menus()

	/**
	 * Registers controls/fields for the Site ID section in Customizer.
	 *
	 * Note: To enable instant preview, we have to actually write a bit of custom
	 * javascript. See live_preview() for more.
	 *
	 * Note: To use active_callbacks, don't add these to the selecting control, it apepars these conflict:
	 * 		'transport' => 'postMessage'
	 * 		$wp_customize->get_setting( 'field_name' )->transport = 'postMessage';
	 *
	 * @hooked 		customize_register
	 * @see			add_action( 'customize_register', $func )
	 * @link 		http://ottopress.com/2012/how-to-leverage-the-theme-customizer-in-your-own-themes/
	 * @since 		1.0.0
	 * @param 		WP_Customize_Manager 		$wp_customize 		Theme Customizer object.
	 */
	public function register_fields_siteid( $wp_customize ) {

		// Google Tag Manager ID Field
		$wp_customize->add_setting(
			'tag_manager_id',
			array(
				'capability' 		=> 'edit_theme_options',
				'default'  			=> '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'type' 				=> 'theme_mod'
			)
		);
		$wp_customize->add_control(
			'tag_manager_id',
			array(
				'active_callback' 	=> '',
				'description' 		=> esc_html__( 'Enter the Google Tag Manager container ID.', 'gt' ),
				'label'  			=> esc_html__( 'Google Tag Manager ID', 'gt' ),
				'priority' 			=> 10,
				'section'  			=> 'title_tagline',
				'settings' 			=> 'tag_manager_id',
				'type' 				=> 'text'
			)
		);
		$wp_customize->get_setting( 'tag_manager_id' )->transport = 'postMessage';

		// Company Address Field
		$wp_customize->add_setting(
			'company_address',
			array(
				'capability' 		=> 'edit_theme_options',
				'default'  			=> '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'type' 				=> 'theme_mod'
			)
		);
		$wp_customize->add_control(
			'company_address',
			array(
				'active_callback' 	=> '',
				'description' 		=> esc_html__( '', 'gt' ),
				'label'  			=> esc_html__( 'Company Address', 'gt' ),
				'priority' 			=> 10,
				'section'  			=> 'title_tagline',
				'settings' 			=> 'company_address',
				'type' 				=> 'text'
			)
		);
		$wp_customize->get_setting( 'company_address' )->transport = 'postMessage';

		// Company Phone Number Field
		$wp_customize->add_setting(
			'company_phone',
			array(
				'capability' 		=> 'edit_theme_options',
				'default'  			=> '',
				'sanitize_callback' => 'sanitize_text_field',
				'transport' 		=> 'postMessage',
				'type' 				=> 'theme_mod'
			)
		);
		$wp_customize->add_control(
			'company_phone',
			array(
				'active_callback' 	=> '',
				'description' 		=> esc_html__( '', 'gt' ),
				'label'  			=> esc_html__( 'Company Phone Number', 'gt' ),
				'priority' 			=> 10,
				'section'  			=> 'title_tagline',
				'settings' 			=> 'company_phone',
				'type' 				=> 'text'
			)
		);
		$wp_customize->get_setting( 'company_phone' )->transport = 'postMessage';

	} // register_fields_siteid()

	/**
	 * This will generate a line of CSS for use in header output. If the setting
	 * ($mod_name) has no defined value, the CSS will not be output.
	 *
	 * @access 		public
	 * @since 		1.0.0
	 * @see 		header_output()
	 * @param 		string 		$selector 		CSS selector
	 * @param 		string 		$style 			The name of the CSS *property* to modify
	 * @param 		string 		$mod_name 		The name of the 'theme_mod' option to fetch
	 * @param 		string 		$prefix 		Optional. Anything that needs to be output before the CSS property
	 * @param 		string 		$postfix 		Optional. Anything that needs to be output after the CSS property
	 * @param 		bool 		$echo 			Optional. Whether to print directly to the page (default: true).
	 * @return 		string 						Returns a single line of CSS with selectors and a property.
	 */
	public function generate_css( $selector, $style, $mod_name, $prefix = '', $postfix = '', $echo = true ) {

		$return = '';
		$mod 	= get_theme_mod( $mod_name );

		if ( empty( $mod ) ) { return; }

		$return = sprintf( '%s { %s:%s; }',
			$selector,
			$style,
			$prefix . $mod . $postfix
		);

		if ( $echo ) {

			echo $return;
			return;

		}

		return $return;

	} // generate_css()

	/**
	 * This will output the custom WordPress settings to the live theme's WP head.
	 *
	 * @hooked 		wp_head
	 * @access 		public
	 * @see 		add_action( 'wp_head', $func )
	 * @since 		1.0.0
	 */
	public function header_output() {

		?><!-- Customizer CSS -->
		<style type="text/css"><?php

			// pattern:
			// $this->generate_css( 'selector', 'style', 'mod_name', 'prefix', 'postfix', true );
			//
			// background-image example:
			// $this->generate_css( '.class', 'background-image', 'background_image_example', 'url(', ')' );

		?></style><!-- Customizer CSS --><?php

		/**
		 * Hides all but the first Soliloquy slide while using Customizer previewer.
		 */
		if ( is_customize_preview() ) {

			?><style type="text/css">

				li.soliloquy-item:not(:first-child) {
					display: none !important;
				}

			</style><!-- Customizer CSS --><?php

		}

	} // header_output()

	/**
	 * Returns TRUE based on which link type is selected, otherwise FALSE
	 *
	 * @param 	object 		$control 			The control object
	 * @return 	bool 							TRUE if conditions are met, otherwise FALSE
	 */
	public function states_of_country_callback( $control ) {

		$country_setting = $control->manager->get_setting('country')->value();

		if ( 'us_state' === $control->id && 'US' === $country_setting ) { return true; }
		if ( 'canada_state' === $control->id && 'CA' === $country_setting ) { return true; }
		if ( 'australia_state' === $control->id && 'AU' === $country_setting ) { return true; }
		if ( 'default_state' === $control->id && ! $this->custom_countries( $country_setting ) ) { return true; }

		return false;

	} // states_of_country_callback()

	/**
	 * Returns true if a country has a custom select menu
	 *
	 * @param 		string 		$country 			The country code to check
	 * @return 		bool 							TRUE if the code is in the array, FALSE otherwise
	 */
	public function custom_countries( $country ) {

		$countries = array( 'US', 'CA', 'AU' );

		return in_array( $country, $countries );

	} // custom_countries()

	/**
	 * Loads files for Custom Controls.
	 *
	 * @hooked
	 */
	public function load_customize_controls() {

		$files[] = 'control-editor.php';
		$files[] = 'control-layout-picker.php';
		$files[] = 'control-multiple-checkboxes.php';
		$files[] = 'control-select-category.php';
		$files[] = 'control-select-menu.php';
		$files[] = 'control-select-post.php';
		$files[] = 'control-select-post-type.php';
		//$files[] = 'control-select-recent-post.php';
		$files[] = 'control-select-tag.php';
		$files[] = 'control-select-taxonomy.php';
		$files[] = 'control-select-user.php';

		foreach ( $files as $file ) {

			require_once( trailingslashit( get_template_directory() ) . 'classes/customizer/' . $file );

		}

	} // load_customize_controls()

	/**
	 * Render the site title for the selective refresh partial.
	 *
	 * @since 		1.0.4
	 */
	public function refresh_partial_blogname() {

		bloginfo( 'name' );

	} // refresh_partial_blogname()

	/**
	 * Render the site description for the selective refresh partial.
	 *
	 * @since 		1.0.4
	 */
	public function refresh_partial_blogdescription() {

		bloginfo( 'description' );

	} // refresh_partial_blogdescription()

} // class
