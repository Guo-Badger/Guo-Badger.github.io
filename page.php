<?php
/**
 * The standard Page template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package UW Theme
 */

get_header();

// Include the page content template.
get_template_part( 'content-parts/content', 'hero' );

if ( site_uses_breadcrumbs() ) { custom_breadcrumbs(); } ?>

<div id="page" class="content page-builder">

	<main id="main" class="site-main">
		<?php

		// Start the loop.

			if ( ! post_password_required() ) {
				while ( have_posts() ) : the_post();
					// Include the page content template.
					get_template_part( 'content-parts/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
				// End of the loop.
			} else { ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title( '<h1 class="page-title uw-mini-bar">', '</h1>' ); ?>
					</header>
					<div class="entry-content">
						<div class="uw-outer-row">
							<div class="uw-inner-row">
								<div class="uw-column one-column">
									<?php echo get_the_password_form(); ?>
								</div>
							</div>
						</div>
					</div>
				</article><?php
			}
		?>

	</main>

</div>

<?php get_template_part( 'content-parts/content', 'lower' ); ?>

<?php get_footer(); ?>
