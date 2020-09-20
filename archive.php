<?php
/**
 * The template for displaying an archive of all posts.
 * To create an archive specific to a category, create category.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package UW Theme
 */

get_header();

if ( site_uses_breadcrumbs() ) { custom_breadcrumbs(); } ?>

<div id="page" class="content">
	<main id="main" class="site-main" role="main">

	<?php if ( have_posts() ) :
	         $post_type = get_post_type();  ?>

		<header class="page-header">
			<?php
			the_archive_title( '<h1 class="page-title uw-mini-bar">', '</h1>' );
			the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header>

		<?php
		// Start the Loop.
		while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
		     get_template_part( 'content-parts/content', $post_type );

		// End the loop.
		endwhile;

		// Previous/next page navigation.
		the_posts_pagination( array(
			'prev_text'          => __( 'Previous page', 'uw-theme' ),
			'next_text'          => __( 'Next page', 'uw-theme' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'uw-theme' ) . ' </span>',
		) );

	// If no content, include the "No posts found" template.
	else :
		get_template_part( 'content-parts/content', 'none' );

	endif;
	?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
