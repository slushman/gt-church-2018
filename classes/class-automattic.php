<?php

/**
 * A class of functions related to media and embeds.
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Automattic {

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

		if ( ! defined( 'JETPACK_VERSION' ) ) { return; }

		add_action( 'after_setup_theme', array( $this, 'jetpack_setup' ) );
		add_action( 'after_setup_theme', array( $this, 'wpcom_setup' ) );

	} // hooks()

	/**
	 * Custom render function for Infinite Scroll.
	 */
	public function infinite_scroll_render() {

		while ( have_posts() ) {

			the_post();

			if ( is_search() ) {

				get_template_part( 'template-parts/content', 'search' );

			} else {

				get_template_part( 'template-parts/content', get_post_type() );

			}

		}

	} // infinite_scroll_render()

	/**
	 * Jetpack setup function.
	 *
	 * @see: https://jetpack.com/support/infinite-scroll/
	 * @see: https://jetpack.com/support/responsive-videos/
	 * @see: https://jetpack.com/support/content-options/
	 * @hooked 		after_setup_theme
	 */
	function jetpack_setup() {

		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => [ $this, 'infinite_scroll_render' ],
			'footer'    => 'page',
		) );

		add_theme_support( 'jetpack-responsive-videos' );

		// Add theme support for Content Options.
		add_theme_support( 'jetpack-content-options', array(
			'post-details' => array(
				'stylesheet' 	=> 'gt-style',
				'date'			=> '.posted-on',
				'categories'	=> '.cat-links',
				'tags'			=> '.tags-links',
				'author'		=> '.byline',
				'comment'		=> '.comments-link',
			),
			'featured-images' => array(
				'archive' 	=> true,
				'post' 		=> true,
				'page' 		=> true,
			),
		) );

	} // jetpack_setup()

} // class