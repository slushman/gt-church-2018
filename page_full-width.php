<?php
/**
 * Template Name: Full Width
 *
 * Description: Page template with no sidebar.
 *
 * @package GTChurch2018
 */

get_header();

?><main id="main"><?php

	while ( have_posts() ) : the_post();

		get_template_part( 'template-parts/content', 'page' );

	endwhile; // End of the loop.

?></main><!-- #main --><?php

get_footer();
