<?php

/**
 * A class of functions related to excerpts.
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Excerpts {

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

		add_filter( 'excerpt_length', 	array( $this, 'excerpt_length' ) );
		add_filter( 'excerpt_more', 	array( $this, 'excerpt_read_more' ) );

	} // hooks()

	/**
	 * Limits excerpt length
	 *
	 * @hooked 		excerpt_length
	 * @param 		int 		$length 			The current word length of the excerpt
	 * @return 		int 							The word length of the excerpt
	 */
	public function excerpt_length( $length ) {

		if ( is_home() || is_front_page() ) {

			return 30;

		}

		return $length;

	} // excerpt_length()

	/**
	 * Customizes the "Read More" text for excerpts
	 *
	 * @hooked 		excerpt_more
	 * @global   				$post 		The post object
	 * @param 		mixed 		$more 		The current "read more"
	 * @return 		mixed 					The modifed "read more"
	 */
	public function excerpt_read_more( $more ) {

		global $post;

		$return = sprintf( '... <a class="moretag read-more" href="%s">', esc_url( get_permalink( $post->ID ) ) );
		$return .= esc_html__( 'Read more', 'gt' );
		$return .= '<span class="screen-reader-text">';
		$return .= sprintf( esc_html__( ' about %s', 'gt' ), $post->post_title );
		$return .= '</span></a>';

		return $return;

	} // excerpt_read_more()

} // class