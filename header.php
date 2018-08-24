<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GTChurch2018
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11"><?php 
	
	wp_head(); 
	
?></head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php 
	
		esc_html_e( 'Skip to content', 'gt' ); 
		
	?></a><?php

	$tag_id = get_theme_mod( 'tag_manager_id' );

		if ( ! empty( $tag_id ) ) :

			?><!-- Google Tag Manager -->
			<noscript><iframe src="//www.googletagmanager.com/ns.html?id=<?php echo esc_html( $tag_id ); ?>"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','<?php echo esc_html( $tag_id ); ?>');</script>
			<!-- Google Tag Manager --><?php

		endif;

	?><header id="masthead" class="site-header">
		<div class="site-branding"><?php

			$logo = get_custom_logo();

			if ( is_front_page() || is_home() && ! empty( $logo ) ) :

				?><h1 class="site-title"><?php echo $logo; ?></h1><?php

			elseif ( ! is_front_page() && ! is_home() && ! empty( $logo ) ) :

				?><p class="site-title"><?php echo $logo; ?></p><?php

			elseif ( is_front_page() || is_home() ) :

				?><h1 class="site-title">
					<a class="site-title-link" href="<?php

						echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' );

					?></a>
				</h1><?php

			else :

				?><p class="site-title">
					<a class="site-title-link" href="<?php

						echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' );

					?></a>
				</p><?php

			endif;

		?></div><!-- .site-branding -->
		<nav id="site-navigation" class="nav-1">
			<button class="menu-1-toggle" aria-controls="menu-1" aria-expanded="false"><?php esc_html_e( 'Menu', 'gt' ); ?></button><?php

				$menu_args['menu_id'] 			= 'menu-1';
				$menu_args['container'] 		= false;
				$menu_args['container_class'] 	= 'menu-1-wrap';
				$menu_args['items_wrap'] 		= '<ul id="%1$s" class="%2$s"><button class="close-tablet-menu-btn"><span class="close-btn-text">Close Menu</span></button>%3$s</ul>';
				$menu_args['menu_class']      	= 'menu-1-items menu-1-items-0';
				$menu_args['theme_location'] 	= 'menu-1';

				wp_nav_menu( $menu_args );

		?></nav><!-- #site-navigation --><?php

		get_template_part( 'template-parts/button', 'cta' );

	?></header><!-- #masthead -->