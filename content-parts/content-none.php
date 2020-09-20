<?php
/**
 * The template partial that displays when no posts are found.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package UW Theme
 */
?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title uw-mini-bar"><?php _e( 'Nothing Found', 'uw-theme' ); ?></h1>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'uw-theme' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'uw-theme' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'uw-theme' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</section>