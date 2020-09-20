<?php
/**
 * The template partial that displays posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package UW Theme
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( sprintf( '<h2 class="entry-title uw-mini-bar"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php if (get_post_type() == "post") : ?>
			<div class="entry-meta">
				<?php uwmadison_posted_on(); ?>
			</div>
		<?php endif; ?>
	</header>

	<div class="entry-content">
		<?php
			the_excerpt();

			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'uw-theme' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'uw-theme' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );
		?>
	</div>

	<footer class="entry-footer">
		<?php uwmadison_entry_meta(); ?>
	</footer>
</article>