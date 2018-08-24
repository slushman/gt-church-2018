<?php

/**
 * Defines functionality for and related to the WordPress admin.
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Admin {

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

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin' ) );
	
	} // hooks()

	/**
	 * Enqueues scripts and styles for the login page
	 *
	 * @hooked 		login_enqueue_scripts
	 */
	public function enqueue_admin( $hook ) {

		wp_enqueue_style( 'gt-admin', get_theme_file_uri( '/admin.css' ) );

	} // enqueue_admin()

} // class