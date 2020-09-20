<?php
/**
 * The template to display search results.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package UW Theme
 */

get_header();

if ( site_uses_breadcrumbs() ) { custom_breadcrumbs(); }  ?>

<div id="page" class="content">
	<main id="main" class="site-main">

		<?php
			if ( site_uses_google_search() ) {
				get_template_part( 'content-parts/content', 'search-gcse' );
			} else {
				get_template_part( 'content-parts/content', 'search-wp' );
			}
		?>

	</main>

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>
