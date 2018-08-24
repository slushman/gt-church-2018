<?php
/**
 * Template part for displaying post excerpts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package GTChurch2018
 */

 ?><article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header justcontent"><?php

		 the_title( '<h1 class="entry-title">', '</h1>' );

	 ?></header><!-- .entry-header -->
	<div class="entry-content"><?php

		 the_excerpt();

	?></div><!-- .entry-content -->
	<footer class="entry-footer"><?php

		gt_entry_categories_links();
		gt_entry_tags_links();
		gt_entry_comments_links();
		gt_entry_edit_link();

	?></footer><!-- .entry-footer -->
</article><!-- #post-<?php the_ID(); ?> -->
