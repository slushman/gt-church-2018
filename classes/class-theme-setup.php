<?php

/**
 * Methods for setting up the GTChurch2018 theme.
 *
 * @since 			1.0.0
 * @package 		GTChurch2018
 * @subpackage 		GTChurch2018\Classes
 */

namespace GTChurch2018\Classes;

class Theme_Setup {

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

		add_action( 'init', 		array( $this, 'text_domain' ) );
		add_action( 'init', 		array( $this, 'theme_supports' ) );
		add_action( 'init', 		array( $this, 'register_menus' ) );
		add_action( 'init', 		array( $this, 'content_width' ), 0 );
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );	
		add_action( 'init', 		array( $this, 'disable_emojis' ) );

	} // hooks()

	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @hooked 		after_setup_theme
	 * @global 		int 		$content_width
	 */
	public function content_width() {

		$GLOBALS['content_width'] = apply_filters( 'gt_content_width', 640 );

	} // content_width()

	/**
	 * Removes WordPress emoji support everywhere
	 *
	 * @hooked 		init
	 */
	public function disable_emojis() {

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	} // disable_emojis()

	/**
	 * Registers Menus
	 *
	 * @hooked 		after_setup_theme
	 */
	public function register_menus() {

		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'gt' ),
			'menu-2' => esc_html__( 'Footer', 'gt' ),
			'menu-3' => esc_html__( 'Social', 'gt' ),
		) );

	} // register_menus()

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /assets/languages/ directory.
	 *
	 * @hooked 		after_setup_theme
	 */
	public function text_domain() {

		load_theme_textdomain( 'gt', get_template_directory() . '/languages' );

	} // text_domain()

	/**
	 * Setup theme support options.
	 * 
	 * Adds:
	 * 		Support for wide/full alignment image blocks in Gutenberg
	 * 		Posts and comments RSS feed links to head.
	 * 		Custom logo in Customizer.
	 * 		Selective refresh for widgets in the Customizer.
	 * 		Custom block color palettes.
	 * 		HTML5 markup for supported elements:
	 * 			Search form
	 * 			Comment form
	 * 			Comment list
	 * 			Gallery
	 * 			Caption
	 * 		Let WordPress manage the document title.
	 * 		Post thumbnails on posts and pages.
	 *
	 * @hooked 		after_setup_theme
	 */
	public function theme_supports() {

		add_theme_support( 'align-wide' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'editor-color-palette', array(
			array(
				'name' => __( 'strong magenta', 'gt' ),
				'slug' => 'strong-magenta',
				'color' => '#a156b4',
			),
			array(
				'name' => __( 'light grayish magenta', 'gt' ),
				'slug' => 'light-grayish-magenta',
				'color' => '#d0a5db',
			),
			array(
				'name' => __( 'very light gray', 'gt' ),
				'slug' => 'very-light-gray',
				'color' => '#eee',
			),
			array(
				'name' => __( 'very dark gray', 'gt' ),
				'slug' => 'very-dark-gray',
				'color' => '#444',
			),
		) );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );

	} // theme_supports()

	/**
	 * Register widget areas.
	 *
	 * @hooked 		widgets_init
	 * @link 		https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
	 */
	public function widgets_init() {

		register_sidebar( array(
			'name'          => esc_html__( 'Sidebar', 'gt' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'gt' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

	} // widgets_init()

} // class