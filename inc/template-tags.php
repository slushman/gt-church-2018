<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package GTChurch2018
 */

if ( ! function_exists( 'gt_posted_on' ) ) :

	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function gt_posted_on() {

		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'gt' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	} // gt_posted_on()

endif;

if ( ! function_exists( 'gt_posted_by' ) ) :

	/**
	 * Prints HTML with meta information for the current author.
	 */
	function gt_posted_by() {

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'gt' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	} // gt_posted_by()

endif;

if ( ! function_exists( 'gt_entry_footer' ) ) :

	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function gt_entry_footer() {

		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'gt' ) );

			if ( $categories_list ) {

				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'gt' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'gt' ) );
			
			if ( $tags_list ) {
			
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'gt' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			
			}
		
		}

		gt_entry_edit_link();

	} // gt_entry_footer()

endif;

if ( ! function_exists( 'gt_post_thumbnail' ) ) :

	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function gt_post_thumbnail() {

		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) { return; }

		if ( is_singular() ) :
			
			?><div class="post-thumbnail"><?php 
			
				the_post_thumbnail();
			
			?></div><!-- .post-thumbnail --><?php 
			
		else : 
			
			?><a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1"><?php

				the_post_thumbnail( 'post-thumbnail', array(
					'alt' => the_title_attribute( array(
						'echo' => false,
					) ),
				) );
				
			?></a><?php

		endif; // End is_singular().

	} // gt_post_thumbnail()

endif;



if ( ! function_exists( 'gt_entry_edit_link' ) ) :

	/**
	 * Displays the entry edit link.
	 *
	 * @return 		mixed 		Entry comments markup.
	 */
	function gt_entry_edit_link() {

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'gt' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	
	} // gt_entry_edit_link()

endif;