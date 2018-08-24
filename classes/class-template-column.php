<?php

/**
 * Adds a page template column to the Pages admin.
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Template_Column {

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

		add_action( 'manage_page_posts_custom_column', 	array( $this, 'page_template_column_content' ), 10, 2 );
		add_filter( 'manage_page_posts_columns', 		array( $this, 'page_template_column_head' ), 10 );

	} // hooks()

	/**
	 * The content for each column cell
	 *
	 * @hooked		manage_page_posts_custom_column
	 * @param 		string 		$column_name 		The name of the column
	 * @param 		int 		$post_ID 			The post ID
	 * @return 		mixed 							The cell content
	 */
	public function page_template_column_content( $column_name, $post_ID ) {

		if ( 'page_template' !== $column_name ) { return; }

		$slug 		= get_page_template_slug( $post_ID );
		$templates 	= get_page_templates();
		$name 		= array_search( $slug, $templates );

		if ( ! empty( $name ) ) {

			echo '<span class="name-template">' . $name . '</span>';

		} else {

			echo '<span class="name-template">' . esc_html( 'Default', 'gt' ) . '</span>';

		}

	} // page_template_column_content()

	/**
	 * Adds the page template column to the columns on the page listings
	 *
	 * @hooked 		manage_page_posts_columns
	 * @param 		array 		$defaults 			The current column names
	 * @return 		array           				The modified column names
	 */
	public function page_template_column_head( $defaults ) {

		$defaults['page_template'] = esc_html( 'Page Template', 'gt' );

		return $defaults;

	} // page_template_column_head()

} // class