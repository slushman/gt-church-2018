<?php

/**
 * Enqueues and manages all scripts and styles.
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Enqueue {

	/**
	 * Constructor
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_action( 'wp_enqueue_scripts', 					array( $this, 'enqueue_public' ) );
		add_action( 'wp_print_scripts', 					array( $this, 'print_scripts_header' ) );
		add_action( 'wp_print_footer_scripts', 				array( $this, 'print_scripts_footer' ) );

		add_filter( 'script_loader_tag', 					array( $this, 'async_scripts' ), 10, 2 );
		add_filter( 'style_loader_src', 					array( $this, 'remove_cssjs_ver' ), 10, 2 );
		add_filter( 'script_loader_src', 					array( $this, 'remove_cssjs_ver' ), 10, 2 );
	
	} // hooks()

	/**
	 * Sets the async attribute on all script tags.
	 *
	 * @hooked 		script_loader_tag
	 */
	public function async_scripts( $tag, $handle ) {

		if ( is_admin() ) { return $tag; }

		$check = strpos( $handle, 'gt-' );

		if ( ! $check || 0 < $check ) { return $tag; }

		return str_replace( ' src', ' async="async" src', $tag );

	} // async_scripts()

	/**
	 * Enqueue scripts and styles for the front end.
	 *
	 * @hooked 		wp_enqueue_scripts
	 */
	public function enqueue_public() {

		wp_scripts()->add_data( 'jquery', 'group', 1 );
		wp_scripts()->add_data( 'jquery-core', 'group', 1 );
		wp_scripts()->add_data( 'jquery-migrate', 'group', 1 );

		wp_enqueue_style( 'gt-style', get_stylesheet_uri() );

		//wp_enqueue_script( 'enquire', '//cdnjs.cloudflare.com/ajax/libs/enquire.js/2.1.2/enquire.min.js', array(), PARENT_THEME_VERSION, true );

		//wp_enqueue_script( 'gt-libs', get_theme_file_uri( '/assets/js/lib.min.js' ), array(), PARENT_THEME_VERSION, true );

		wp_enqueue_script( 'gt-public', get_theme_file_uri( '/assets/js/public.min.js' ), array( 'jquery' ), PARENT_THEME_VERSION, true );

		// wp_enqueue_style( 'gt-fonts', $this->fonts_url(), array(), null );

	} // enqueue_public()

	/**
	 * Properly encode a font URLs to enqueue a Google font
	 *
	 * @see 		enqueue_public()
	 * @return 		mixed 		A properly formatted, translated URL for a Google font
	 */
	public static function fonts_url() {

		$return 	= '';
		$families 	= '';
		$fonts[] 	= array( 'font' => 'Open Sans', 'weights' => '400,700', 'translate' => esc_html_x( 'on', 'Open Sans font: on or off', 'gt' ) );

		foreach ( $fonts as $font ) {

			if ( 'off' == $font['translate'] ) { continue; }

			$families[] = $font['font'] . ':' . $font['weights'];

		}

		if ( ! empty( $families ) ) {

			$query_args['family'] 	= urlencode( implode( '|', $families ) );
			$query_args['subset'] 	= urlencode( 'latin' );
			$return 				= add_query_arg( $query_args, '//fonts.googleapis.com/css' );

		}

		return $return;

	} // fonts_url()

	/**
	 * Prints scripts in the footer.
	 */
	public function print_scripts_footer() {

		//

	} // print_scripts_footer()

	/**
	 * Prints scripts in the header.
	 */
	public function print_scripts_header() {

		//

	} // print_scripts_header()

	/**
	 * Removes query strings from static resources
	 * to increase Pingdom and GTMatrix scores.
	 *
	 * Does not remove query strings from Google Font calls.
	 *
	 * @hooked		style_loader_src
	 * @hooked 		script_loader_src
	 * @param 		string 		$src 			The resource URL
	 * @return 		string 						The modifed resource URL
	 */
	public function remove_cssjs_ver( $src ) {

		if ( empty( $src ) ) { return; }
		if ( strpos( $src, 'https://fonts.googleapis.com' ) ) { return; }

		if ( strpos( $src, '?ver=' ) ) {

			$src = remove_query_arg( 'ver', $src );

		}

		return $src;

	} // remove_cssjs_ver()

} // class