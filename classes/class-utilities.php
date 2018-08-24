<?php

/**
 * A class of helpful theme functions
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Utilities {

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

		//add_action( 'wp_head', array( $this, 'background_images' ) );

		add_filter( 'body_class', array( $this, 'page_body_classes' ) );		

	} // hooks()

	/**
	 * Adds classes to the body tag.
	 *
	 * @hooked		body_class
	 * @global 		$post						The $post object
	 * @param 		array 		$classes 		Classes for the body element.
	 * @return 		array 						The modified body class array
	 */
	public function page_body_classes( $classes ) {

		global $post;

		if ( empty( $post->post_content ) ) {

			$classes[] = 'content-none';

		} else {

			$classes[] = $post->post_name;

		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {

			$classes[] = 'hfeed';

		}

		$tablet_menu = get_theme_mod( 'tablet_menu' );

		if ( ! empty( $tablet_menu ) ) {

			if ( FALSE !== strpos( $tablet_menu, '-slide-' ) ) {

				$classes[] = 'tablet-slide';

				if ( FALSE !== strpos( $tablet_menu, '-left' ) || FALSE !== strpos( $tablet_menu, '-right' ) ) {

					$classes[] = 'tablet-slide-sides';

				} elseif ( FALSE !== strpos( $tablet_menu, '-bottom' ) || FALSE !== strpos( $tablet_menu, '-top' ) ) {

					$classes[] = 'tablet-slide-topbot';

				}

			} elseif ( FALSE !== strpos( $tablet_menu, '-push' ) ) {

				$classes[] = 'tablet-push';

			}

			$classes[] = $tablet_menu;

		}

		if ( is_page() ) {

			if ( is_page_template( 'templates/page_content-sidebar.php' ) ) {

				$classes[] = 'content-sidebar';

			}

			if ( is_page_template( 'templates/page_sidebar-content.php' ) ) {

				$classes[] = 'sidebar-content';

			}

			if ( is_page_template( 'templates/page_full-width.php' ) ) {

				$classes[] = 'full-width';

			}

		}

		return $classes;

	} // page_body_classes()

} // class