<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package UW Theme
 */


if ( ! function_exists( 'uwmadison_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * Create your own uwmadison_entry_meta() function to override in a child theme.
 *
 */
function uwmadison_entry_meta() {
  // Hide category and tag text for pages.
  if ( 'post' === get_post_type() ) {
    // printf( '<span class="byline"><span class="author vcard">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n" href="%3$s">%4$s</a></span></span>',
    //   get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
    //   _x( 'Author', 'Used before post author name.', 'uw-theme' ),
    //   esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
    //   get_the_author()
    // );

    /* translators: used between list items, there is a space after the comma */
    $categories_list = get_the_category_list( esc_html__( ', ', 'uw-theme' ) );
    if ( $categories_list && uwmadison_categorized_blog() ) {
      printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'uw-theme' ) . '</span>', $categories_list ); // WPCS: XSS OK.
    }

    /* translators: used between list items, there is a space after the comma */
    $tags_list = get_the_tag_list( '', esc_html__( ', ', 'uw-theme' ) );
    if ( $tags_list ) {
      printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'uw-theme' ) . '</span>', $tags_list ); // WPCS: XSS OK.
    }
  }

  if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
    echo '<span class="comments-link">';
    comments_popup_link( esc_html__( 'Leave a comment', 'uw-theme' ), esc_html__( '1 Comment', 'uw-theme' ), esc_html__( '% Comments', 'uw-theme' ) );
    echo '</span>';
  }

  edit_post_link(
    sprintf(
      /* translators: %s: Name of current post */
      esc_html__( 'Edit %s', 'uw-theme' ),
      the_title( '<span class="screen-reader-text">"', '"</span>', false )
    ),
    '<span class="edit-link">',
    '</span>'
  );
}
endif;

if ( ! function_exists( 'uwmadison_posted_on' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own uwmadison_posted_on() function to override in a child theme.
 *
 */
function uwmadison_posted_on() {
 $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
  // if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
  //   $time_string = '<time class="updated" datetime="%3$s">%4$s</time>';
  // }

  $time_string = sprintf( $time_string,
    esc_attr( get_the_date( 'c' ) ),
    esc_html( get_the_date() ),
    esc_attr( get_the_modified_date( 'c' ) ),
    esc_html( get_the_modified_date() )
  );

  $posted_on = sprintf(
    esc_html_x( 'Posted on %s', 'post date', 'uw-theme' ),
    '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
  );

  $byline = sprintf(
    esc_html_x( 'by %s', 'post author', 'uw-theme' ),
    '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
  );

  // echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
  echo '<span class="posted-on">' . $posted_on . '</span>';

}
endif;



if ( ! function_exists( 'uwmadison_entry_taxonomies' ) ) :
/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own uwmadison_entry_taxonomies() function to override in a child theme.
 */
function uwmadison_entry_taxonomies() {
  $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'uw-theme' ) );
  if ( $categories_list && uwmadison_categorized_blog() ) {
    printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
      _x( 'Categories', 'Used before category names.', 'uw-theme' ),
      $categories_list
    );
  }

  $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'uw-theme' ) );
  if ( $tags_list ) {
    printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
      _x( 'Tags', 'Used before tag names.', 'uw-theme' ),
      $tags_list
    );
  }
}
endif;

/**
 * Determines whether blog/site has more than one category.
 *
 * Create your own uwmadison_categorized_blog() function to override in a child theme.
 *
 * @return bool True if there is more than one category, false otherwise.
 */
function uwmadison_categorized_blog() {
  if ( false === ( $all_the_cool_cats = get_transient( 'uwmadison_categories' ) ) ) {
    // Create an array of all the categories that are attached to posts.
    $all_the_cool_cats = get_categories( array(
      'fields'     => 'ids',
      // We only need to know if there is more than one category.
      'number'     => 2,
    ) );

    // Count the number of categories that are attached to the posts.
    $all_the_cool_cats = count( $all_the_cool_cats );

    set_transient( 'uwmadison_categories', $all_the_cool_cats );
  }

  if ( $all_the_cool_cats > 1 ) {
    // This blog has more than 1 category so uwmadison_categorized_blog should return true.
    return true;
  } else {
    // This blog has only 1 category so uwmadison_categorized_blog should return false.
    return false;
  }
}

/**
 * Flushes out the transients used in uwmadison_categorized_blog().
 *
 * @link https://css-tricks.com/the-deal-with-wordpress-transients/
 * @link https://codex.wordpress.org/Transients_API
 *
 */
function uwmadison_category_transient_flusher() {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }
  // Like, beat it. Dig?
  delete_transient( 'uwmadison_categories' );
}
add_action( 'edit_category', 'uwmadison_category_transient_flusher' );
add_action( 'save_post',     'uwmadison_category_transient_flusher' );


if ( ! function_exists( 'uwmadison_page_menu' ) ) :
  /**
   * wp_nav_menu() fallback function that renders menu based on published pages
   *
   * @return void
   **/
  function uwmadison_page_menu_fallback() {
    $pages = get_pages(array('parent' => 0));
    $out = '';

    if(!empty($pages)) {
      echo '<ul id="uw-main-nav">';
    }
    foreach ($pages as $page) {
      $subpages = get_pages(array('parent' => $page->ID, 'hierarchical' => false));
      $has_children = (!empty($subpages)) ? true : false;
      $li_dropdown_class = $has_children ? " uw-dropdown" : "";
      echo '<li id="menu-item-'.$page->ID.'" class="menu-item menu-item-'.$page->ID.$li_dropdown_class.'">';
      echo '<a href="'.get_permalink($page->ID).'">';
      echo esc_html( $page->post_title );
      if ($has_children) {
        echo get_svg('uw-symbol-caret-down', array('aria-hidden' => 'true'));
      }
      echo '</a>';
      if ($has_children) {
        echo '<ul aria-hidden="true" aria-labelled-by="menu-item-'.$page->ID.'" class="sub-menu uw-child-menu">';
          foreach ($subpages as $subpage) {
            echo '<li id="menu-item-'.$subpage->ID.'" class="menu-item menu-item-'.$page->ID.'">';
            echo '<a href="'.get_permalink($subpage->ID).'">';
            echo esc_html( $subpage->post_title );
            echo '</a>';
            echo '</li>';
          }
        echo '</ul>';
      }
      echo '</li>';
    }
    if(!empty($pages)) {
      echo '</ul>';
    }
  }
endif;


if ( ! function_exists( 'uwmadison_footer_contact' ) ) :
  /**
   * Prints contact info and social media links based on theme options
   * set via the Customizer.
   *
   **/
  function uwmadison_footer_contact() {
    $uwmadison_address = get_theme_mod( "uwmadison_address" );
    $uwmadison_email = get_theme_mod( "uwmadison_email" );
    $uwmadison_phone = get_theme_mod( "uwmadison_phone" );
    $uwmadison_social = get_theme_mod( "uwmadison_social" );

    // return if none of the footer options have been set
    if (
        empty($uwmadison_address) &&
        empty($uwmadison_email) &&
        empty($uwmadison_phone) &&
        no_social_links($uwmadison_social)
      ) {
      return false;
    } else {
      $output = '
      <div class="uw-footer-contact">
        <h3 class="uw-footer-header">Contact Us</h3>';
      $output .= uwmadison_contact_info();
      $output .= '</div>';
    }

    /**
     * Filter the footer contact info output markup
     *
     * @param string $output Markup generated be default
     * @param Array void The email, phone and social links theme options
     * as set in the Customizer.
     */
    $output = apply_filters( 'uwmadison_footer_contacts', $output, array('email' => $uwmadison_email, 'phone' => $uwmadison_phone, 'social' => $uwmadison_social) );
    return $output;
  }
endif;

if ( ! function_exists( 'uwmadison_footer_privacy' ) ) :
  /**
   * Prints privacy statement link in the footer
   *
   **/
  function uwmadison_footer_privacy() {

    $uwmadison_privacy_link = apply_filters('uwmadison_privacy_link', UW_PRIVACY_STATEMENT_URL);

    $output = '<a href="'.$uwmadison_privacy_link.'">Privacy Notice</a>';
    return $output;
  }
endif;

/**
 * Render contact info ad set in customizer
 *
 * @return String markup for contact info
 **/
function uwmadison_contact_info($include_social = true) {
    $uwmadison_address = get_theme_mod( "uwmadison_address" );
    $uwmadison_map_url = get_theme_mod( "uwmadison_map_url" );
    $uwmadison_email = get_theme_mod( "uwmadison_email" );
    $uwmadison_phone = get_theme_mod( "uwmadison_phone" );


    $output = '';

    $output .= '<ul class="uw-contact-list">';
      if ( !empty($uwmadison_address) ) {
        $output .= "<li class=\"uw-contact-item uw-contact-address\">" . nl2br($uwmadison_address) . "</li>\n";

        // append map link if set
        if ( !empty($uwmadison_map_url) ) {
          $output .= "<li class=\"uw-contact-item uw-contact-map-link\"> <a href=\"$uwmadison_map_url\">Map" . get_svg('uw-symbol-map-marker') . "</a></li>\n";
        }
      }
      if ( !empty($uwmadison_email) )
        $output .= "<li class=\"uw-contact-item\">Email: <a href=\"mailto:$uwmadison_email\">$uwmadison_email</a></li>\n";
      if ( !empty($uwmadison_phone) )
        $output .= "<li class=\"uw-contact-item\">Phone: <a href=\"tel:$uwmadison_phone\">$uwmadison_phone</a></li>\n";
      if ( $include_social ) {
        $output .= '<li>';
        $output .= uwmadison_social_links();
        $output .= '</li>';
      }
      $output .= '</ul>';
      return $output;
}

/**
 * Render social links set in customizer
 *
 * @return String markup for social links
 **/
function uwmadison_social_links() {
  $uwmadison_social = get_theme_mod( "uwmadison_social" );

  if ( empty($uwmadison_social) )
    return;

  $output = '<ul class="uw-social-icons">';

  foreach ($uwmadison_social as $key => $value) {
    if ( !empty($value) ) {
      $output .= "<li id=\"uw-icon-$key\" class=\"uw-social-icon\"><a aria-label=\"$key\" href=\"$value\">" . get_svg('uw-symbol-' . $key, array("aria-hidden" => "true")) . "</a></li>";
    }
  }

  $output .= '</ul>';

  return $output;

}

/**
 * Helper function to test if we have meaningful data in the social links customizer options
 *
 * @param Array $uwmadison_social social links array returned form theme options
 * @return boolean
 **/
function no_social_links($uwmadison_social) {
  if ( empty($uwmadison_social) ) {
    return true;
  } else {
    foreach ($uwmadison_social as $key => $value) {
      if ( !empty($value)) {
        return false;
      }
    }
    return true;
  }
}

/**
* Helper function to prevent svg from being orphaned at end of link when
* window size changes
*/
function uw_prevent_link_orphan($link) {
  $link_parts = explode(' <svg', $link);
  if(count($link_parts) > 1) {
    $link_parts[0] = trim(preg_replace('/(\s+[\w\)\!\?]+)$/', '<span class="uw-nowrap">$1', ' '.$link_parts[0]));
    $link = implode('<svg', $link_parts).'</span>';
  }
  return $link;
}
