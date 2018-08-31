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

	?><footer class="site-footer" id="colophon">
		<div class="site-credits">
			<div class="copyright">&copy; <?php echo date( 'Y' ); ?> <a href="<?php echo esc_url( get_admin_url() ); ?>"><?php echo get_bloginfo( 'name' ); ?></a></div>
		</div><!-- .site-credits -->
		<div class="site-info">
			<address><?php echo get_theme_mod( 'company_address' ); ?></address><?php

			get_template_part( 'template-parts/menu', 'social' );

		?></div><!-- .site-info -->
	</footer><!-- .site-footer --><?php 

	wp_footer(); 

	?></body>
</html>
