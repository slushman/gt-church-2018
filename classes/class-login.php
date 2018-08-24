<?php

/**
 * Defines functionality for and related to the login page.
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Login {

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

		add_action( 'login_enqueue_scripts', array( $this, 'enqueue_login' ) );
	
	} // hooks()

	/**
	 * Enqueues scripts and styles for the login page
	 *
	 * @hooked 		login_enqueue_scripts
	 */
	public function enqueue_login() {

		wp_enqueue_style( 'gt-login', get_theme_file_uri( 'login.css' ), 10, 1 );

	} // enqueue_login()

} // class