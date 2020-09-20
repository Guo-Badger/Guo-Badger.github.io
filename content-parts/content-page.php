<?php
/**
 * The template partial that displays content on page.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package UW Theme
 */
if (!function_exists('output_page_elements')) {
  function output_page_elements() {
    switch (get_row_layout()) {
      case 'text_block':
        get_template_part('content-parts/page-elements/text', 'block');
        break;
      case 'image':
        get_template_part('content-parts/page-elements/image', 'content');
        break;
      case 'image_carousel':
        get_template_part('content-parts/page-elements/image', 'carousel');
        break;
      case 'image_gallery':
        get_template_part('content-parts/page-elements/image', 'gallery');
        break;
      case 'faculty_list_options':
        get_template_part('content-parts/page-elements/faculty', 'list');
        break;
      case 'accordion_panel':
        get_template_part('content-parts/page-elements/accordion', 'panel');
        break;
      case 'tabbed_content':
        get_template_part('content-parts/page-elements/tabbed', 'content');
        break;
      case 'embed_content':
        get_template_part('content-parts/page-elements/embed', 'content');
        break;
      case 'group_of_links':
        get_template_part('content-parts/page-elements/content', 'links');
        break;
      case 'latest_posts': // 'latest_posts' is a legacy ACF field value still used here
        get_template_part('content-parts/page-elements/posts', 'listing');
        break;
      case 'featured_content':
        get_template_part('content-parts/page-elements/featured', 'content');
        break;
      case 'stylized_quote':
        get_template_part('content-parts/page-elements/stylized', 'quote');
        break;
      case 'alternating_content_boxes':
        get_template_part('content-parts/page-elements/alternating', 'boxes');
        break;
      case 'todaywiscedu_events':
        get_template_part('content-parts/page-elements/today', 'events');
        break;
      case 'documents_listing':
        get_template_part('content-parts/page-elements/documents', 'list');
        break;
      case 'page_element_action_hook':
        $action_hook_slug = get_sub_field('action_hook_slug');
        $action_hook_slug = preg_replace('/[^A-Za-z-]+/', '_', $action_hook_slug);
        if (!empty($action_hook_slug))
          do_action($action_hook_slug);
        break;
      default:
        // Allow child themes to register their own page builder elements
        if (has_action(get_row_layout())) {
          do_action(get_row_layout());
        } else {
          echo 'Page element not found';
        }
    }
  }
}

/**
 * Extract unique acf_fc_layout values within a layout row for use as a CSS
 * class list.
 *
 * @param array $row An ACF layout row array.
 * @return string Space-delimited string of acf_fc_layout values.
 */
if (!function_exists('elements_as_classes')) {
  function elements_as_classes($row) {
    $elements = array();
    if (function_exists('array_column')) {
      foreach ($row as $key => $value) {
        if ("array" == gettype($value)) {
          $elements = array_merge($elements, array_unique(array_column($value, 'acf_fc_layout')));
        }
      }
    }
    if (!empty($elements)) {
      return " " . implode(" ", array_map(function ($text) {
          return "has_" . $text;
        }, array_unique($elements)));
    }
  }
}
global $pe_heading_level;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <?php if(!is_front_page()): ?>
  <header class="entry-header">
    <?php the_title( '<h1 class="page-title uw-mini-bar">', '</h1>' ); ?>
  </header>
  <?php endif; ?>

  <div class="entry-content">
    <?php
    if ( have_rows('primary_content_area')) :
      while ( have_rows('primary_content_area') ) : the_row();

        $row_headline = get_sub_field('row_headline');
        $background = get_sub_field('background_choice');
        $background_image = null;
        // Set background based on user choice.
        if ($background == 'Badger Red') {
          $bg_color = 'primary-background row-dark-background';
        } else if ($background == 'White') {
          $bg_color = 'white-background';
        } else if ($background == 'Dark Red') {
          $bg_color = 'secondary-background row-dark-background';
        } else if ($background == 'Light Gray') {
          $bg_color = 'lightest-gray-background';
        } else if ($background == 'Dark Gray') {
          $bg_color = 'dark-gray-background row-dark-background';
        } else if ($background == 'Blue-Gray') {
          $bg_color = 'blue-gray-background';
        } else if ($background == 'Upload Image') {
          $background_image = get_sub_field('background_image');
          $bg_color = 'has_background-image';
        } else {
          $bg_color = 'default-background';
        }
        $row_custom_id = get_sub_field('row_custom_id');
        $row_custom_class = get_sub_field('row_custom_class');

        echo '<div ';
        if ($row_custom_id) {
          echo 'id="' . $row_custom_id . '" ';
        }
        echo 'class="uw-outer-row row-' . get_row_index() . elements_as_classes(get_row()) . ' ' . $bg_color;
        if ($row_custom_class) {
          echo ' ' . $row_custom_class;
        }
        echo '"';
        if ($background_image) {
          $row_styles = [
            'background-image: url(' . $background_image['url'] . ')',
            'background-repeat: no-repeat',
            'background-size: cover'
          ];

          $row_classes = explode(' ', elements_as_classes(get_row()));
          if (
            in_array('has_accordion_panel', $row_classes)
            || in_array('has_tabbed_content', $row_classes)
          ) {
            $row_styles[] = 'background-position: 50% 0';
          }

          echo ' style="' . join('; ', $row_styles) . ';"';
        }
        echo '>';

        echo '<div class="uw-inner-row">';
          if ($row_headline) {
            echo '<div class="uw-column uw-row-header"><h2>' . $row_headline . '</h2></div>';
            $pe_heading_level = 'h3';
          }
          else {
            $pe_heading_level = 'h2';
          }

        // One Column Content Layout
        if ( get_row_layout() == 'one_column_content_layout' ) :
            echo '<div class="uw-column one-column">';
              while ( have_rows('one_column_page_elements') ) : the_row();
                echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
                  output_page_elements();
                echo '</div>';
              endwhile;
            echo '</div>';

        // Two Column Content Layout
        elseif ( get_row_layout() == 'two_column_content_layout' ) :
          // Left Column (can be wide, narrow, or equal)
          if(get_sub_field('column_display') == "Left 60%  Right 40%") :
            echo '<div class="uw-column wide-column">';
          elseif (get_sub_field('column_display') == "Left 40%  Right 60%") :
            echo '<div class="uw-column narrow-column">';
          else:
            echo '<div class="uw-column equal-column">';
          endif;
            while ( have_rows('first_column_page_elements') ) : the_row();
              echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
                output_page_elements();
              echo '</div>';
            endwhile;
          echo '</div>';

          // Right Column (can be wide, narrow, or equal)
          if (get_sub_field('column_display') == "Left 60%  Right 40%") :
            echo '<div class="uw-column narrow-column">';
          elseif (get_sub_field('column_display') == "Left 40%  Right 60%") :
            echo '<div class="uw-column wide-column">';
          else:
            echo '<div class="uw-column equal-column">';
          endif;
          while ( have_rows('second_column_page_elements') ) : the_row();
            echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
              output_page_elements();
            echo '</div>';
          endwhile;
          echo '</div>';

        // Three Column Content Layout
        elseif ( get_row_layout() == 'three_column_content_layout' ) :
          echo '<div class="uw-column three-column">';
          while ( have_rows('first_column_page_elements') ) : the_row();
            echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
              output_page_elements();
            echo '</div>';
          endwhile;
          echo '</div><div class="uw-column three-column">';
          while ( have_rows('second_column_page_elements') ) : the_row();
            echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
              output_page_elements();
            echo '</div>';
          endwhile;
          echo '</div><div class="uw-column three-column">';
          while ( have_rows('third_column_page_elements') ) : the_row();
            echo '<div class="uw-pe uw-pe-' . get_row_layout() . '">';
              output_page_elements();
            echo '</div>';
          endwhile;
          echo '</div>';
        endif;

        echo '</div></div>'; // end of uw-row-full and uw-inner-row

      endwhile;
    else :
      echo '<div class="uw-outer-row"><div class="uw-inner-row"><div class="uw-column"><div class="uw-pe uw-pe-text-block">';
        the_content();
      echo '</div></div></div></div>';
    endif;

    wp_link_pages( array(
      'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'uw-theme' ) . '</span>',
      'after'       => '</div>',
      'link_before' => '<span>',
      'link_after'  => '</span>',
      'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'uw-theme' ) . ' </span>%',
      'separator'   => '<span class="screen-reader-text">, </span>',
    ) );
    ?>
  </div>

</article>
