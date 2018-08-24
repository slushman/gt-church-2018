<?php
/**
 * This file calls the init.php file, but only
 * if the child theme hasn't called it first.
 *
 * This method allows the child theme to load
 * the framework so it can use the framework
 * components immediately.
 *
 * @package  GTChurch2018
 * @author   slushman
 * @license  GPL-2.0+
 * @link     https://developer.wordpress.org/themes/basics/theme-functions/
 */

use \GTChurch2018\Classes as Classes;

/**
 * Set the constants used throughout.
 */
define( 'PARENT_THEME_SLUG', 'gt' );
define( 'PARENT_THEME_VERSION', '1.0.0' );

/**
 * Load Imagekit.
 */
require get_template_directory() . '/inc/imagekit.php';

/**
 * Load Themekit.
 */
require get_template_directory() . '/inc/toolkit.php';

/**
 * Load Imagekit.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Load Autoloader
 */
require get_template_directory() . '/classes/class-autoloader.php';


/**
 * Create an instance of each class and load the hooks function.
 */
$classes[] = new Classes\Theme_Setup();
$classes[] = new Classes\Enqueue();
$classes[] = new Classes\Utilities();
$classes[] = new Classes\Media();
$classes[] = new Classes\Uploads();
$classes[] = new Classes\Template_Column();
$classes[] = new Classes\Customizer();
$classes[] = new Classes\Slushicons();
$classes[] = new Classes\Menu_Utilities();
$classes[] = new Classes\Menu_Styles();
$classes[] = new Classes\Login();
$classes[] = new Classes\Admin();

$classes[] = new Classes\Automattic();
$classes[] = new Classes\Yoast();
$classes[] = new Classes\Soliloquy();

foreach ( $classes as $class ) {

	add_action( 'after_setup_theme', array( $class, 'hooks' ) );

}
