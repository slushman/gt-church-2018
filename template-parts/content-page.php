<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GTChurch2018
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header content-page"><?php
	
		the_title( '<h1 class="entry-title">', '</h1>' ); 
		
	?></header><!-- .page-header -->
	<div class="page-content"><?php

		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gt' ),
			'after'  => '</div>',
		) );

	?></div><!-- .page-content --><?php 
	
	if ( get_edit_post_link() ) : 
	
		?><footer class="entry-footer"><?php

			gt_entry_edit_link();

		?></footer><!-- .entry-footer --><?php 

	endif; 
	
?></article><!-- #post-<?php the_ID(); ?> -->
