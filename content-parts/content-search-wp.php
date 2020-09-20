<?php if ( have_posts() ) : ?>

  <header class="page-header">
    <h1 class="page-title uw-mini-bar"><?php printf( __( 'Search Results for: %s', 'uw-theme' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
  </header><!-- .page-header -->

  <?php
  // Start the loop.
  while ( have_posts() ) : the_post();

    /**
     * Run the loop for the search to output the results.
     * To customize how a post type is displayed in the search results, include
     * a file named `content-search-POST_TYPE.php`.
     */
    if (locate_template( 'content-parts/content-search-' . get_post_type() . '.php' ) != '') {
      get_template_part( 'content-parts/content-search', get_post_type() );
    } else {
      get_template_part( 'content-parts/content', get_post_format() );
    }

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