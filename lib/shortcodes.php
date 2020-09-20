<?php

/**
 * Shortcode for including social links as set in Customizer
 *
 * @return String unordered list with social icons
 **/
function uwmadison_social_shortcode( $atts ) {
  // extend here with shortcode attrs if we want
  // $atts = shortcode_atts( array(
  //   'show_text_link' => 'false',
  // ), $atts, 'uwmadison_social' );
  $uwmadison_social = get_theme_mod( "uwmadison_social" );
  return uwmadison_social_links($uwmadison_social);
}
add_shortcode( 'uwmadison_social', 'uwmadison_social_shortcode' );


/**
 * Shortcode for including contact info as set in Customizer
 *
 * @return String markup for contact info
 **/
function uwmadison_contact_shortcode( $atts ) {
  // extend here with shortcode attrs if we want
  // $atts = shortcode_atts( array(
  //   'show_text_link' => 'false',
  // ), $atts, 'uwmadison_social' );
  return uwmadison_contact_info($include_social = false);
}
add_shortcode( 'uwmadison_contact', 'uwmadison_contact_shortcode' );


/**
 * Shortcode for including search form in content
 *
 * @return String markup for search form
 **/
function uwmadison_search_form_shortcode() {
	// filter markup to eliminate duplicate IDs
	add_filter( 'get_search_form', function( $form ) {
		return preg_replace('/id="([^"]+)"/i', 'id="$1-2"', $form);
	}, 10, 1 );
  return get_search_form(false);
}
add_shortcode( 'uw-search-input', 'uwmadison_search_form_shortcode' );



/**
 * Shortcode for including RSS Feed in content
 *
 *	Usage: [uw-rss-feed url="http://rss.example.com/feed.xml" title="Example Title" description="Example description." more-link="http://example.com" max-posts="10"]
 *
 * @return String markup for RSS Feed
 **/
function uw_rss_feed_cache_lifetime( $seconds ) {
	return 3 * HOUR_IN_SECONDS;
}
function uw_rss_feed( $atts ) {
    $url = ( !empty( $atts['url'] ) ) ? $atts['url']: "";
    $title = ( !empty( $atts['title'] ) ) ? $atts['title']: "";
    $description = ( !empty( $atts['description'] ) ) ? $atts['description']: "";
    $more_link = ( !empty( $atts['more-link'] ) ) ? $atts['more-link']: "";
    $max_posts = ( !empty( $atts['max-posts'] ) ) ? intval( $atts['max-posts'] ): 10; // default to 10
    if ( !empty( $url ) ) :
      ob_start();
			add_filter( 'wp_feed_cache_transient_lifetime' , 'uw_rss_feed_cache_lifetime' );
			$feed = fetch_feed($url);
			remove_filter( 'wp_feed_cache_transient_lifetime' , 'uw_rss_feed_cache_lifetime' );
      if(is_wp_error($feed)) : ?>
        <div class="uw-pe uw-pe-latest_posts uw-rss-feed">
          <p>Feed unavailable. Check back soon.</p>
        </div>
      <?php else :
  			$items = $feed->get_items(0, $max_posts);
          if ( count($items) > 0 ) : ?>
              <div class="uw-pe uw-pe-latest_posts uw-rss-feed">
                  <?php if ( !empty( $title ) ) : ?>
                      <h2 class="uw-mini-bar uw-content-box-header"><?php echo $title; ?></h2>
                  <?php endif; ?>
                  <?php if ( !empty( $description ) ) : ?>
                      <p><?php echo $description; ?></p>
                  <?php endif; ?>
                  <ul class="uw-posts-listing">
                      <?php
                      foreach ($items as $item) :
                      ?>
                          <li class="uw-post align-middle">
                              <div class="uw-post-text">
                                  <h3>
                                      <a href='<?php echo $item->get_permalink(); ?>'><?php echo $item->get_title(); ?></a>
                                  </h3>
                                  <?php if ( !empty( $item->get_date('F j, Y') ) ) :
                                      ?>
                                      <span class='uw-post-date'><?php echo " " . str_replace(' ','&nbsp;',$item->get_date('F j, Y')); ?></span>
                                  <?php endif ?>
                              </div>
                          </li>
                          <?php endforeach; ?>
                  </ul>
              </div>
              <?php
              if ( !empty( $more_link ) ) : ?>
                      <div class="uw-pe uw-pe-text_block">
                          <p>
                              <a class="uw-more-link" style="text-decoration: none;" href="<?php echo $more_link; ?>">More <?php echo get_svg('uw-symbol-more', array("aria-hidden" => "true")); ?></a>
                          </p>
                      </div>
                  <?php
              endif;
          endif;
        endif;
 			$output = ob_get_clean();
			/**
			*
			* Override this shortcode from a child theme using filter: uw_rss_feed_filter
			*
			* Example:
			*
			* function example_filter_function( $output, $atts ) {
			*   // your code here
			* }
			* add_filter( 'uw_rss_feed_filter', 'example_filter_function', 1, 2 );
			*
			*/
			$output = apply_filters( 'uw_rss_feed_filter', $output, $atts );
      return $output;
    endif;
    return false;
}
add_shortcode( 'uw-rss-feed', 'uw_rss_feed' );


/**
 *
 * Back to Top Button
 *
 * This shortcode adds a button that jumps a user back to the #main element
 *
 */
function uw_back_to_top_button_shortcode( $atts ) {
    return '<p class="uw-back-to-top"><a class="uw-more-link uw-back-to-top__link" href="#main">Back to top ' . get_svg('uw-symbol-caret-up', ['aria-hidden' => 'true', 'title' => 'Back to top']) . '</a></p>';
}
add_shortcode( 'back-to-top', 'uw_back_to_top_button_shortcode' );
