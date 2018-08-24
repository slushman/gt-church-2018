<?php

/**
 * Adds the ability to include SVGs as icons inside menu items using CSS classes on the menu items.
 * 
 * USAGE
 * 
 * In the menu editor, edit the classes for the menu item and add "slushicons", the name and type of the 
 * icon to add, then the position for the menu item text.
 * 
 * text-right: adds the icon to the right of the menu item text.
 * text-left: adds the icon to the left of the menu item text.
 * text-hide: adds the icon and hides the menu item text in an accessible span.
 * 
 * The icon name should include what folder contains that icon:
 * dic- = Dashicon
 * fas- = FontAwesome
 * svg- = Theme
 * 
 * 
 * EXAMPLES
 * 
 * For a menu item to contain the FontAwesome icon for Twitter to the left of the menu text,
 * the classes for that menu item include:
 * slushicons text-left fas-twitter
 * 
 * The menu has no text and the Dashicon for Facebook:
 * slushicons text-hide dic-facebook
 * 
 * Menu item with a custom icon and the menu text on the right:
 * slushicons text-right svg-custom
 * 
 * 
 * REQUIREMENTS
 * Create a folder titled "svgs" in the root of the theme.
 * Inside this folder, add three more folders:
 * 		dashicons
 * 		fontawesome
 * 		theme
 * 
 * Upload all the Dashicon and Fontawesome SVGs into the appropriate folders.
 * The theme folder should contain SVGs for that particular site.
 */

namespace GTChurch2018\Classes;

class Slushicons {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Registers all the WordPress hooks and filters for this class.
	 */
	public function hooks(){

		add_filter( 'nav_menu_item_title', 			array( $this, 'add_icons_to_menu' ), 10, 4 );
		add_filter( 'gt_menu_item_icon_info', 	array( $this, 'get_icon_info' ), 10, 3 );
		add_filter( 'gt_menu_item_text_position', array( $this, 'get_text_position' ), 10, 3 );

	} // hooks()

	/**
	 * Adds an icon in the menu item title, either with or without the title text.
	 * 
	 * @exits 		If $args is empty or an array.
	 * @exits 		If 'slushicon' is not in the classes array.
	 * @hooked 		nav_menu_item_title 			10
	 * @param 		string 		$title 				The menu item title.
	 * @param 		object 		$item				The current menu item.
	 * @param 		array 		$args 				The wp_nav_menu args.
	 * @param 		int 		$depth 				The menu item depth.
	 * @return 		string 							The modified menu item title.
	 */
	public function add_icons_to_menu( $title, $item, $args, $depth ) {

		if ( empty( $args ) || is_array( $args ) ) { return $title; }
		if ( ! in_array( 'slushicon', $item->classes ) ) { return $title; }

		$icon_info 	= apply_filters( 'gt_menu_item_icon_info', '', $item, $args );
		$icon 		= $this->get_icon( $icon_info );
		$textpos 	= apply_filters( 'gt_menu_item_text_position', '', $item, $args );

		if ( empty( $icon ) && empty( $textpos ) ) { return $title; }

		$output = '';

		if ( 'right' === $textpos ) {

			$output .= $icon;

		}

		if ( 'hide' === $textpos ) {

			$output .= '<span class="screen-reader-text">' . esc_html( $title ) . '</span>';
			$output .= $icon;

		} else {

			$output .= '<span class="menu-label">' . esc_html( $title ) . '</span>';

		}

		if ( 'left' === $textpos ) {

			$output .= $icon;

		}

		return $output;

	} // add_icons_to_menu()

	/**
	 * Returns the proper name for certain requested svgs.
	 *
	 * @param 		string 		$svg 		Name of the svg.
	 * @return 		string 					The correct name of the SVG.
	 */
	public function change_default_svgs( $svg ) {

		if ( empty( $svg ) ) { return $svg; }

		$shorts['caret-down'] 			= 'arrow-down-alt2';
		$shorts['caret-left'] 			= 'arrow-left-alt2';
		$shorts['caret-right'] 			= 'arrow-right-alt2';
		$shorts['caret-up'] 			= 'arrow-up-alt2';
		$shorts['email'] 				= 'email-alt';
		$shorts['facebook'] 			= 'facebook-alt';
		$shorts['facebook-square'] 		= 'facebook';
		$shorts['gallery'] 				= 'format-gallery';
		$shorts['hamburger'] 			= 'menu';
		$shorts['map'] 					= 'location-alt';
		$shorts['menu'] 				= 'menu-alt';

		if ( array_key_exists( $svg, $shorts ) ) {

			return $shorts[$svg];

		}

		return $svg;

	} // change_default_svgs()

	/**
	 * Returns an array of info about the icon.
	 *
	 * @exits 		If $classes is empty.
	 * @hooked 		gt_menu_item_icon_info 		10
	 * @param 		string 		$icon 					The current icon name.
	 * @param 		object 		$item					The menu item object.
	 * @param 		array 		$args 					The menu arguments.
	 * @return 		array 								The type and name of the icon.
	 */
	public function get_icon_info( $icon, $item, $args  ) {

		if ( empty( $item->classes ) ) { return; }

		$return = array();
		$checks = array( 'dic-', 'fas-', 'svg-' );

		foreach ( $item->classes as $class ) {

			if ( stripos( $class, $checks[0] ) !== FALSE ) {

				$return['name'] = str_replace( $checks[0], '', $class );
				$return['type'] = 'dashicons';
				break;

			}

			if ( stripos( $class, $checks[1] ) !== FALSE ) {

				$return['name'] = str_replace( $checks[1], '', $class );
				$return['type'] = 'fontawesome';
				break;

			}

			if ( stripos( $class, $checks[2] ) !== FALSE ) {

				$return['name'] = str_replace( $checks[2], '', $class );
				$return['type'] = 'svg';
				break;

			}

		} // foreach

		return $return;

	} // get_icon_info()

	/**
	 * Returns the text position from the menu item class.
	 *
	 * @exits 		If $classes is empty.
	 * @hooked 		gt_menu_item_text_position 		10
	 * @param 		string 		$position 					The current text position.
	 * @param 		object 		$item						The menu item object.
	 * @param 		array 		$args 						The menu arguments.
	 * @return 		string 									The text position.
	 */
	public function get_text_position( $position, $item, $args ) {

		if ( empty( $item->classes ) ) { return; }

		if ( in_array( 'text-hide', $item->classes ) ) { return 'hide'; }
		if ( in_array( 'text-left', $item->classes ) ) { return 'left'; }
		if ( in_array( 'text-right', $item->classes ) ) { return 'right'; }
		if ( in_array( 'text-coin', $item->classes ) ) { return 'coin'; }
		if ( in_array( 'text-above', $item->classes ) ) { return 'above'; }
		if ( in_array( 'text-below', $item->classes ) ) { return 'below'; }

		return;

	} // get_text_position()

	/**
	 * Returns the code for the icon.
	 *
	 * @exits 		If $icon_info is empty
	 * @exits 		if $icon_info is not an array.
	 * @param 		array 		$icon_info 			The icon info array.
	 * @return 		mixed 							The icon markup.
	 */
	private function get_icon( $icon_info ) {

		if ( empty( $icon_info ) || ! is_array( $icon_info ) ) { return; }

		$return = '';

		if ( 'dashicons' === $icon_info['type'] ) {

			$return = '<span class="dashicons dashicons-' . $icon_info['name'] . '"></span>';

		}

		if ( 'fontawesome' === $icon_info['type'] ) {

			$return = '<span class="fa fa-' . $icon_info['name'] . '"></span>';

		}

		if ( 'svg' === $icon_info['type'] ) {

			$check = gt_get_svg( $icon_info['name'] );

			//wp_die(print_r($check));

			if ( ! is_null( $check ) ) {

				$return = $check;

			}

		}

		return $return;

	} // get_icon()

} // class