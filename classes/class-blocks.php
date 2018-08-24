<?php

/**
 * A class of functions related to blocks.
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Blocks {

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

		add_filter( 'init', array( $this, 'register_block_templates' ) );

	} // hooks()

	/**
	 * Adds the video ID as the ID attribute on the iframe
	 *
	 * @hooked 		init
	 */
	public function register_block_templates() {

		$page = get_post_type_object( 'page' );

		if ( 'services' ) { // check page template

			$page->template = array(
				array( 'core/paragraph', array(
						'placeholder' => 'Add service description here...'
				) ),
				array( 'core/gallery', array(
						'placeholder' => 'Add service images here...'
				) ),
				array( 'core/heading', array(
						'h2' => 'Case Studies'
				) ),
			);

		}

	} // register_block_templates()

} // class