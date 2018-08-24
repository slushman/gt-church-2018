<?php

/**
 * A class of functions related to file uploads.
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Uploads {

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

		add_filter( 'post_mime_types', 	array( $this, 'add_mime_types' ) );
		add_filter( 'upload_mimes', 	array( $this, 'custom_upload_mimes' ) );

	} // hooks()

	/**
	 * Adds PDF as a filter for the Media Library
	 *
	 * @hooked 		post_mime_types
	 * @param 		array 		$post_mime_types 		The current MIME types
	 * @return 		array 								The modified MIME types
	 */
	public function add_mime_types( $post_mime_types ) {

		$post_mime_types['application/pdf'] = array( esc_html__( 'PDFs', 'gt' ), esc_html__( 'Manage PDFs', 'gt' ), _n_noop( 'PDF <span class="count">(%s)</span>', 'PDFs <span class="count">(%s)</span>', 'gt' ) );
		$post_mime_types['text/x-vcard'] 	= array( esc_html__( 'vCards', 'gt' ), esc_html__( 'Manage vCards', 'gt' ), _n_noop( 'vCard <span class="count">(%s)</span>', 'vCards <span class="count">(%s)</span>', 'gt' ) );

		return $post_mime_types;

	} // add_mime_types()

	/**
	 * Adds support for additional MIME types to WordPress
	 *
	 * @hooked 		upload_mimes
	 * @param 		array 		$existing_mimes 			The existing MIME types
	 * @return 		array 									The modified MIME types
	 */
	public function custom_upload_mimes( $existing_mimes = array() ) {

		// add your extension to the array
		$existing_mimes['vcf'] = 'text/x-vcard';

		return $existing_mimes;

	} // custom_upload_mimes()

} // class