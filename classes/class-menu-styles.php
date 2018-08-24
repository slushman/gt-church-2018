<?php

/**
 * Functions for WordPress themes to simplify styling menus.
 * 
 * Adds a class to the menu item for the current page.
 * Adds a class to the menu item link for the current page.
 * Adds classes with the menu name and depth level to each menu item.
 * Adds classes with the menu name and depth level to each menu item link.
 * Adds a class with the menu name for parent menu items.
 * Adds a class with the menu order and depth level to each menu item.
 * Adds a class with the menu order and depth level to each menu item link.
 * Adds the menu item text as a class on the menu item.
 * 
 * Deactivated:
 * Adds the menu name as a class for the current page, current page ancestor,
 * and current page parent.
 */

namespace GTChurch2018\Classes;

class Menu_Styles {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks() {

		add_filter( 'nav_menu_css_class', 			array( $this, 'add_menu_item_classes' ), 10, 4 );
		add_filter( 'nav_menu_css_class', 			array( $this, 'add_current_class_to_menu_item' ), 10, 4 );
		add_filter( 'nav_menu_css_class', 			array( $this, 'add_menu_name_and_depth_classes_to_parent_menu_items' ), 10, 4 );
		add_filter( 'nav_menu_css_class',  			array( $this, 'add_menu_item_text_as_class' ), 10, 4 );

		add_filter( 'nav_menu_link_attributes', 	array( $this, 'add_menu_item_links_classes' ), 10, 4 );
		add_filter( 'nav_menu_link_attributes', 	array( $this, 'add_current_class_to_menu_item_links' ), 10, 4 );

		add_filter( 'nav_menu_submenu_css_class', 	array( $this, 'add_submenu_classes' ), 10, 3 );

		//add_filter( 'page_css_class', 			array( $this, 'add_menu_name_to_current_classes' ), 10, 5 );

	} // hooks()

	/**
	 * Adds the current-($menu_id or $menu->slug)-item class to the menu item for the current page.
	 *
	 * @exits 		If $args is empty.
	 * @hooked 		nav_menu_css_class 			10
	 * @param 		array 		$classes 		The current menu item classes.
	 * @param 		object 		$item 			The current menu item.
	 * @param 		array 		$args 			The wp_nav_menu args.
	 * @param 		int 		$depth 			The menu item depth.
	 * @return 		array 						The modified menu item classes.
	 */
	public function add_current_class_to_menu_item( $classes, $item, $args, $depth ) {

		if ( empty( $args ) ) { return $classes; }
		if ( ! $item->current ) { return $classes; }

		$name = empty($args->menu_id) ? $args->menu->slug : $args->menu_id;

		$classes[] = 'current-' . $name . '-item';

		return $classes;

	} // add_current_class_to_menu_item()

	/**
	 * Adds the current-($menu_id or $menu->slug)-item-link class to the menu item link
	 * for the current page.
	 *
	 * @hooked 		nav_menu_link_attributes 		10
	 * @param 		array 		$atts 				The current menu item link attributes.
	 * @param 		object 		$item 				The current menu item.
	 * @param 		object 		$args 				The wp_nav_menu args.
	 * @param 		int 		$depth 				The menu item depth.
	 * @return 		array 							The modified menu item link attributes.
	 */
	public function add_current_class_to_menu_item_links( $atts, $item, $args, $depth ) {

		if ( empty( $item ) ) { return $atts; }
		if ( empty( $args ) ) { return $classes; }
		if ( ! $item->current ) { return $atts; }

		$name = empty($args->menu_id) ? $args->menu->slug : $args->menu_id;

		$atts['class'] .= 'current-' . $name . '-item-link';

		if ( ! is_array( $item->classes ) ) { return $atts; }

		return $atts;

	} // add_current_class_to_menu_item_links()

	/**
	 * Adds classes with the menu name, depth level, and 
	 * first/last menu order to each menu item.
	 *
	 * @hooked 		nav_menu_css_class 			10
	 * @param 		array 		$classes 		The current menu item classes.
	 * @param 		object 		$item 			The current menu item.
	 * @param 		array 		$args 			The wp_nav_menu args.
	 * @param 		int 		$depth 			The menu item depth.
	 * @return 		array 						The modified menu item classes.
	 */
	public function add_menu_item_classes( $classes, $item, $args, $depth ) {

		if ( empty( $item ) ) { return $classes; }
		if ( ! isset( $atts['class'] ) ) { $atts['class'] = ''; }

		$name = empty($args->menu_id) ? $args->menu->slug : $args->menu_id;

		$classes[] = $name . '-item';
		$classes[] = $name . '-item-' . $depth;

		if ( 1 === $item->menu_order ) {

			$classes[] = $name . '-item-first';
			$classes[] = $name . '-item-' . $depth . '-first';

		}

		if ( $args->menu->count === $item->menu_order ) {

			$classes[] = $name . '-item-last';
			$classes[] = $name . '-item-' . $depth . '-last';

		}

		if ( ! is_array( $item->classes ) ) { return $atts; }

		if ( in_array( 'text-coin', $item->classes ) ) {

			$atts['class'] .= 'coin ';

		}

		return $classes;

	} // add_menu_item_classes()

	/**
	 * Adds classes to menu item links.
	 *
	 * Adds the depth class to make styling easier.
	 * Adds the "coin" class if the menu item has the text-coin class.
	 *
	 * @hooked 		nav_menu_link_attributes 		10
	 * @param 		array 		$atts 				The current menu item link attributes.
	 * @param 		object 		$item 				The current menu item.
	 * @param 		object 		$args 				The wp_nav_menu args.
	 * @param 		int 		$depth 				The menu item depth.
	 * @return 		array 							The modified menu item link attributes.
	 */
	public function add_menu_item_links_classes( $atts, $item, $args, $depth ) {

		if ( empty( $item ) ) { return $atts; }
		if ( ! isset( $atts['class'] ) ) { $atts['class'] = ''; }

		$name = empty($args->menu_id) ? $args->menu->slug : $args->menu_id;

		$atts['class'] .= $name . '-item-link ';
		$atts['class'] .= $name . '-item-link-' . $depth . ' ';

		if ( 1 === $item->menu_order ) {

			$atts['class'] .= $name . '-item-link-first ';
			$atts['class'] .= $name . '-item-link-' . $depth . '-first ';

		}

		if ( $args->menu->count === $item->menu_order ) {

			$atts['class'] .= $name . '-item-link-last ';
			$atts['class'] .= $name . '-item-link-' . $depth . '-last ';

		}

		if ( ! is_array( $item->classes ) ) { return $atts; }

		if ( in_array( 'text-coin', $item->classes ) ) {

			$atts['class'] .= 'coin ';

		}

		return $atts;

	} // add_menu_item_links_classes()

	/**
	 * Adds the menu item text as a class to each menu item.
	 *
	 * @exits 		If $args is empty.
	 * @hooked 		nav_menu_css_class 			10
	 * @param 		array 		$classes 		The current menu item classes.
	 * @param 		object 		$item 			The current menu item.
	 * @param 		array 		$args 			The wp_nav_menu args.
	 * @param 		int 		$depth 			The menu item depth.
	 * @return 		array 						The modified menu item classes.
	 */
	public function add_menu_item_text_as_class( $classes, $item, $args, $depth ) {

		if ( empty( $item ) ) { return $classes; }

		$title = sanitize_title( $item->title );

		if ( empty( $classes ) || ! is_array( $classes ) ) {

			$classes[0] = $title;

		} elseif ( ! in_array( $title, $classes ) ) {

			$classes[] = $title;

		}

		return $classes;

	} // add_menu_item_text_as_class()

	/**
	 * Adds a class with the menu name to each menu item with children.
	 * 
	 * @exits 		If $classes does not include 'menu-item-has-children'.
	 * @hooked 		nav_menu_css_class 			10
	 * @param 		array 		$classes 		The current menu item classes.
	 * @param 		object 		$item 			The current menu item.
	 * @param 		array 		$args 			The wp_nav_menu args.
	 * @param 		int 		$depth 			The menu item depth.
	 * @return 		array 						The modified menu item classes.
	 */
	public function add_menu_name_and_depth_classes_to_parent_menu_items( $classes, $item, $args, $depth ) {

		if ( ! in_array( 'menu-item-has-children', $classes ) ) { return $classes; } 

		$name = empty($args->menu_id) ? $args->menu->slug : $args->menu_id;

		$classes[] = $name . '-item-has-children';
		$classes[] = $name . '-item-' . $depth . '-has-children';

		return $classes;

	} // add_menu_name_and_depth_classes_to_parent_menu_items()

	/**
	 * Adds the menu name as a class for the current page, current page ancestor,
	 * and current page parent.
	 *
	 * @param 		array 			$css_class 			An array of CSS classes to be applied
	 *                                 						to each list item.
	 * @param 		WP_Post 		$page 				Page data object.
	 * @param 		int 			$depth 				Depth of page, used for padding.
	 * @param 		array 			$args 				An array of arguments.
	 * @param 		int 			$current_page 		ID of the current page.
	 * @return 		array 			$css_class 			The modified CSS classes array.
	 */
	public function add_menu_name_to_current_classes( $css_class, $page, $depth, $args, $current_page ) {

		$name = empty($args->menu_id) ? $args->menu->slug : $args->menu_id;

		if ( ! empty( $current_page ) ) {

			$_current_page = get_post( $current_page );

			if ( $_current_page && in_array( $page->ID, $_current_page->ancestors ) ) {

				$css_class[] = $name . '-current_page_ancestor';

			}

			if ( $page->ID == $current_page ) {

				$css_class[] = $name . '-current_page_item';

			} elseif ( $_current_page && $page->ID == $_current_page->post_parent ) {

				$css_class[] = $name . '-current_page_parent';

			}

		} elseif ( $page->ID == get_option( 'page_for_posts' ) ) {

			$css_class[] = $name . '-current_page_parent';

		}

		return $css_class;

	} // add_menu_name_to_current_classes()

	/**
	 * Adds classes to the UL elements in each submenu.
	 */
	public function add_submenu_classes( $classes, $args, $depth ) {

		$real_depth = $depth + 1;
		$name = empty($args->menu_id) ? $args->menu->slug : $args->menu_id;

		$classes[] = $name . '-items';
		$classes[] = $name . '-items-' . $real_depth; 
		$classes[] = $name . '-items-closed';

		return $classes;

	} // add_submenu_classes()

} // class