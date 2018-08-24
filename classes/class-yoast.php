<?php

/**
 * A class of functions related to the Yoast SEO plugin.
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Yoast {

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

		add_filter( 'wpseo_metabox_prio', array( $this, 'prioritize_yoast_metabox_low' ), 10 );

	} // hooks()

	/**
	 * Sets the priority of the Yoast SEO metabox to low.
	 * 
	 * @hooked 		wpseo_metabox_prio
	 * @since 		1.0.0
	 * @param 		string 		$priority 		The current priority
	 * @return 		string 						The modified priority
	 */
	public function prioritize_yoast_metabox_low( $priority ) {

		$priority = 'low';

		return $priority;

	} // prioritize_yoast_metabox_low()

} // class