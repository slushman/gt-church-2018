<?php

/**
 * Template part for displaying the social menu.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GTChurch2018
 */

if ( ! has_nav_menu( 'menu-3' ) ) { return; }

$menu_args['theme_location']	= 'social';
$menu_args['container'] 		= false;
$menu_args['menu_id']         	= 'social-menu';
$menu_args['menu_class']      	= 'social-menu-items social-menu-items-0';
$menu_args['depth']           	= 1;

wp_nav_menu( $menu_args );
