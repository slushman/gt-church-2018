<?php

/**
 * A class of helpful menu-related functions
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Menu_Utilities {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		//add_filter( 'wp_nav_menu_items', 					array( $this, 'add_search_to_menu' ), 10, 2 );
		add_filter( 'wp_nav_menu_container_allowedtags', 	array( $this, 'allow_section_tags_as_containers' ), 10, 1 );
		add_filter( 'nav_menu_item_title', 					array( $this, 'submenu_toggle' ), 10, 4 );

	} // hooks()

	/**
	 * Adds a search form to the menu.
	 *
	 * @exits 		If not on the correct menu.
	 * @hooked 		wp_nav_menu_items 			10
	 * @param 		array 		$items 			The current menu items.
	 * @param 		array 		$args 			The menu args.
	 * @return 		array 						The menu items plus a search form.
	 */
	public function add_search_to_menu( $items, $args ) {

		if ( '' !== $args->theme_location ) { return $items; }

		return $items . get_search_form();

	} // add_search_to_menu()

	/**
	 * Adds more allowed tags for WP menu containers.
	 *
	 * @hooked 		wp_nav_menu_container_allowedtags
	 * @param 		array 			$tags 			The current allowed tags
	 * @return 		array 							The modified allowed tags
	 */
	public function allow_section_tags_as_containers( $tags ) {

		$tags[] = 'section';

		return $tags;

	} // allow_section_tags_as_containers()

	/**
	 * Adds the "+" menu-1-submenu-toggle trigger for mobile menus and the down caret for laptop menus.
	 *
	 * @exits 		If $args is empty or an array.
	 * @exits 		If not on the primary menu.
	 * @exits 		If 'menu-item-has-children' is not in the $classes array.
	 * @hooked 		nav_menu_item_title 			10
	 * @param 		string 		$title 				The menu item title.
	 * @param 		object 		$item				The current menu item.
	 * @param 		array 		$args 				The wp_nav_menu args.
	 * @param 		int 		$depth 				The menu item depth.
	 * @return 		string 							The modified menu item title.
	 */
	public function submenu_toggle( $title, $item, $args, $depth ) {

		if ( empty( $args ) || is_array( $args ) ) { return $title; }
		if ( 'menu-1' !== $args->theme_location ) { return $title; }
		if ( ! in_array( 'menu-item-has-children', $item->classes ) ) { return $title; }

		$output = '';
		$output .= $title;

		if ( 0 === $depth ) {

			$output .= '<span class="menu-1-submenu-icon triangle-down"></span>';

		} else {

			$output .= '<span class="menu-1-submenu-icon triangle-right"></span>';

		}

		$output .= '<button class="menu-1-submenu-toggle">+</button>';

		return $output;

	} // submenu_toggle()

} // class
