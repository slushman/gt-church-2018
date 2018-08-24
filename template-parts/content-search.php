<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GTChurch2018
 */

?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header content-search"><?php 
	
		the_title( 
			sprintf( 
				'<h2 class="entry-title"><a lass="archive-entry-link" href="%s" rel="bookmark">', 
				esc_url( get_permalink() ) 
			), 
			'</a></h2>' 
		); 
		
		if ( 'post' === get_post_type() ) : 
		
			?><div class="entry-meta"><?php

				gt_posted_on();
				gt_posted_by();
			
			?></div><!-- .entry-meta --><?php 
			
		endif; 
		
	?></header><!-- .entry-header -->
	<div class="entry-summary"><?php 
	
		the_excerpt(); 
		
	?></div><!-- .entry-summary -->

	<footer class="entry-footer"><?php 
	
		gt_entry_footer(); 
	
	?></footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->