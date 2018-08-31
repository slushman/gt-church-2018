<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GTChurch2018
 */

$mods = get_theme_mods();

	?><footer class="site-footer" id="colophon">
		<div class="copyright">&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( get_admin_url() ); ?>"><?php echo get_bloginfo( 'name' ); ?></a></div>
		<address class="footer-address"><?php echo esc_html( $mods['company_address'] ); ?></address>
		<address class="footer-address">
			<a href="tel:<?php echo esc_attr( gt_format_phone_number( $mods['company_phone'] ) ); ?>"><?php 
			
				echo esc_html( $mods['company_phone'] ); 
				
			?></a>
		</address><?php

		get_template_part( 'template-parts/menu', 'social' );

	?></footer><!-- .site-footer --><?php 

	wp_footer(); 

	?></body>
</html>
