<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package UW Theme
 */


if( get_theme_mod('uwmadison_404_page_id') ) : 

	// custom 404 page
	uw_custom_404();

else: 
	
 	// default 404 page
	get_header(); ?>

		<div id="primary" class="content-area row">
			<main id="main" class="site-main">

				<section class="error-404 not-found">
					<header class="page-header">
						<h1 class="page-title uw-mini-bar"><?php _e( 'Page not found', 'uw-theme' ); ?></h1>
					</header>

					<div class="page-content uw-pe">
						<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'uw-theme' ); ?></p>

						<?php echo do_shortcode('[uw-search-input]'); ?>
					</div>
				</section>

			</main>

			<?php get_sidebar( 'content-bottom' ); ?>

		</div>

	<?php get_sidebar(); ?>
	<?php get_footer(); ?>

<?php endif; ?>