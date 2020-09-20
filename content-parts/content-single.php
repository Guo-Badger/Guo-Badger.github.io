<?php
/**
 * A sample template partial to create any additional reusable elements/components.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package UW Theme
 */


$news_url = get_field('news_url');

if ($news_url) :
	$url = rtrim($news_url, '/');
  $rss = new DOMDocument();
  if( @$rss->load($url . '/feed/?withoutcomments=1') ) :
  	foreach ($rss->getElementsByTagName('item') as $node) {
	    $title = $node->getElementsByTagName('title')->item(0)->nodeValue;
	    $link = $node->getElementsByTagName('link')->item(0)->nodeValue;
	    $description = $node->getElementsByTagName('description')->item(0)->nodeValue;
	  }
	else :
		$description = "";
		$link = $news_url;
	endif;
endif;

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if('uw_staff' != get_post_type()) : ?>
		<?php if($news_url && $title): ?>
      <header>
        <h1 class="page-title uw-mini-bar"><?php echo $title; ?></h1>
        <div><?php get_template_part('templates/entry-meta'); ?></div>
      </header>
		<?php else: ?>

			<header class="entry-header">
				<?php the_title( '<h1 class="page-title uw-mini-bar">', '</h1>' ); ?>
				<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php uwmadison_posted_on(); ?>
				</div><!-- .entry-meta -->
				<?php endif; ?>
			</header>
		<?php endif; ?>
	<?php endif; ?>


	<div class="entry-content">
		<?php
			$post_type = get_post_type();

			if (locate_template('content-parts/page-elements/single-' . $post_type . '.php') != '') {
				get_template_part('content-parts/page-elements/single', $post_type);
			} else {

        the_post_thumbnail();

        if($news_url) : ?>
        		<?php
        			if($description) :
        				echo '<p>' . $description . '</p>';
        			else :
        				the_content();
        			endif;
        		?>
        		Read the full article at:
        		<a href="<?php echo $link; ?>" target="_blank">
        			<?php echo $news_url; ?>
        		</a>
      	<?php else:
					the_content();
				endif;
			}

			wp_link_pages( array(
				'before'      => '<div class="pagination-container"><div class="pagination pagination-post-pages" role="navigation" aria-label="Pagination"><span class="page-links-title">' . __( 'Pages:', 'uw-theme' ) . '</span>',
				'after'       => '</div></div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="show-for-sr">' . __( 'Page', 'uw-theme' ) . ' </span>%',
				'separator'   => '',
			) );

			if ( '' !== get_the_author_meta( 'description' ) ) {
				get_template_part( 'content-parts/biography' );
			}
		?>
	</div>

	<footer class="entry-footer">
		<?php uwmadison_entry_meta(); ?>
	</footer>
</article>