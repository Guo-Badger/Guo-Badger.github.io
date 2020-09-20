<?php
/**
 * The template to display a single post.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package UW Theme
 */

get_header();

if ( site_uses_breadcrumbs() ) { custom_breadcrumbs(); } ?>

<div id="page" class="content">
	<main id="main" class="site-main">
		<?php

		// Start the loop.
		while ( have_posts() ) : the_post();
			get_template_part( 'content-parts/content', 'single' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'uw-theme' ),
				) );
			} elseif ( is_singular( 'post' ) ) {
				// Previous/next post navigation.
				the_post_navigation( array(
					'next_text' => '<span class="show-for-sr">' . __( 'Next post:', 'uw-theme' ) . '</span> ' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="show-for-sr">' . __( 'Previous post:', 'uw-theme' ) . '</span> ' .
						'<span class="post-title">%title</span>',
				) );
			}

			// End of the loop.
		endwhile;
		?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
