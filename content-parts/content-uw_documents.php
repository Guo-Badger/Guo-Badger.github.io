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

    <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

    <div class="entry-meta">
      <?php uwmadison_posted_on(); ?>
    </div>
  </header>

  <?php
  if(get_field('document_summary')) {
    $summary = get_field('document_summary');
    echo '<p>' . $summary . '</p>';
  }

  if(get_field('document_file')) {
    $file = get_field('document_file');
    echo 'File: <a href="' . $file['url'] . '">' . $file['filename'] . '</a>';
  }
  ?>

  <?php the_post_thumbnail(); ?>

  <div class="entry-content">
    <?php
      /* translators: %s: Name of current post */
      the_content( sprintf(
        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'uw-theme' ),
        get_the_title()
      ) );

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