<?php

class UW_Breadcrumb {
  private $level = 0;

  /**
   * Get the integer level of the current or previous breadcrumb item.
   *
   * @return int
   */
  public function current_level() {
    return $this->level;
  }

  /**
   * Get the next level for the breadcrumb item being built, specifically for the
   * `<meta>` element to inform search engines about how the content is organized.
   * This follows schema.org specifications, and Google recommendations.
   *
   *   * https://schema.org/BreadcrumbList
   *   * https://developers.google.com/search/docs/data-types/breadcrumb#microdata
   *
   * @return int
   */
  private function next_level() {
    return ++$this->level;
  }

  /**
   * The breadcrumbs opening template partial.
   *
   * @param array $attrs
   *   $attrs[
   *     'id'    => (string) Optional. An ID name to apply to the opening `<ol>` element.
   *     'class' => (string) Optional. Additional class names to apply to the opening `<ol>` element.
   *   ]
   * @return string
   */
  private function template_open(array $attrs) {
    $id = isset($attrs['id']) ? sprintf('id="%s"', $attrs['id']) : '';
    $class = isset($attrs['class']) ? trim($attrs['class']) : '';

    ob_start();

    ?>

    <nav class="breadcrumb-nav" aria-label="Breadcrumb">
      <ol itemscope itemtype="http://schema.org/BreadcrumbList" <?= $id ?> class="breadcrumb-nav__list <?= $class ?>">

    <?php

    return ob_get_clean();
  }

  /**
   * The breadcrumbs closing template partial.
   *
   * @return string
   */
  private function template_close() {
    ob_start();

    ?>

      </ol>
    </nav>

    <?php

    return ob_get_clean();
  }

  /**
   * The breadcrumbs individual item template partial.  This will return the
   * fully-formatted breadcrumb with its name and associated link, if supplied.
   *
   * @param array $attrs
   *   $attrs[
   *     'item_class'  => (string) Optional. Additional class names to apply to the breadcrumb `<li>` element.
   *     'bread_class' => (string) Optional. Additional class names to apply to the breadcrumb `<a>` element.
   *     'url'         => (string) Optional. The URL of the breadcrumb.
   *     'name'        => (string) The full text value of the breadcrumb.
   *     'current'     => (bool)   Optional. Tells assistive technologies that the breadcrumb is that of the current
   *                               page. This should be applied to breadcrumbs with URLs only.
   *   ]
   * @return string
   */
  private function template_breadcrumb(array $attrs) {
    $item_class = isset($attrs['item_class']) ? trim($attrs['item_class']) : '';
    $bread_class = isset($attrs['bread_class']) ? trim($attrs['bread_class']) : '';
    $href = isset($attrs['url']) ? $attrs['url'] : '';
    $name = $attrs['name'];
    $aria_current = (isset($attrs['current']) && $attrs['current'] && !empty($href)) ? 'aria-current="page"' : '';
    $current_level = $this->next_level();

    ob_start();

    ?>

    <li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem" class="breadcrumb-nav__item <?= $item_class ?>">
      <?php if (!empty($href)): ?>
        <a itemprop="item" href="<?= $href ?>" class="breadcrumb-nav__link <?= $bread_class ?>" title="<?= $name ?>" <?= $aria_current ?>>
      <?php endif; ?>
        <span itemprop="name"><?= $name ?></span>
        <meta itemprop="position" content="<?= $current_level ?>">
      <?php if (!empty($href)): ?>
        </a>
      <?php endif; ?>
    </li>

    <?php

    return ob_get_clean();
  }

  /**
   * Call a breadcrumb template partial, and apply the supplied values.
   *
   * @param string $template_name The name of template partial to be used.
   * @param array $attrs The values to be passed to the template partial.
   * @return string|null Completed template partial, or null if the requested template partial does not exist.
   */
  public function part($template_name, $attrs = []) {
    $template_name = str_replace('-', '_', $template_name);

    if (method_exists($this, 'template_' . $template_name)) {
      return $this->{'template_' . $template_name}($attrs);
    }

    return null;
  }
}

// Breadcrumbs
function custom_breadcrumbs() {

  // Settings
  $breadcrums_id = 'breadcrumbs';
  $breadcrums_class = 'breadcrumbs';
  $home_title = 'Home';

  // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
  $custom_taxonomy	= 'product_cat';

  // Instantiate breadcrumb builder
  $breadcrumb = new UW_Breadcrumb();

  // Get the post information
  global $wp, $post, $wp_query;

  // Local, unmodified copy of the $post object
  // This is needed for Events Calendar plugin support
  $queried_object = $wp_query->get_queried_object();
  $post_raw = sanitize_post($queried_object);


  // Do not display on the homepage
  if (!is_front_page()) {

    // Build the breadcrumbs
    echo $breadcrumb->part(
      'open',
      [
        'id' => $breadcrums_id,
        'class' => $breadcrums_class
      ]
    );

    // Home page
    echo $breadcrumb->part(
      'breadcrumb',
      [
        'item_class' => 'item-home',
        'bread_class' => 'bread-link bread-home',
        'url' => get_home_url() . '/',
        'name' => $home_title
      ]
    );

    if (is_archive() && !is_tax() && !is_category() && !is_tag()) {

      $breadcrumb_tree = [];

      if (is_author()) {

        global $author;
        $userdata = get_userdata($author);

        $breadcrumb_tree[] = [
          'item_class' => 'item-current item-archive item-user-' . $userdata->user_nicename,
          'bread_class' => 'bread-current bread-archive bread-user-' . $userdata->user_nicename,
          'url' => home_url() . '/author/' . $userdata->user_nicename . '/',
          'name' => 'Author: ' . $userdata->display_name,
          'current' => true
        ];

      } else if (is_year() || is_month() || is_day()) {

        // https://www.php.net/manual/en/function.date.php
        $year = get_the_time('Y');  // Full four-digit year (e.g. 2020)
        $month = get_the_time('m'); // Two-digit month (e.g. 01)
        $day = get_the_time('d');   // Two-digit day of the month (e.g. 01)

        $breadcrumb_tree[] = [
          'item_class' => 'item-cat item-archive item-year item-year-' . $year,
          'bread_class' => 'bread-cat bread-archive bread-year bread-year-' . $year,
          'url' => get_year_link($year),
          'name' => 'Year: ' . $year
        ];

        if (is_year()) {
          $breadcrumb_tree[0]['item_class'] = 'item-current ' . $breadcrumb_tree[0]['item_class'];
          $breadcrumb_tree[0]['bread_class'] = 'bread-current ' . $breadcrumb_tree[0]['bread_class'];
          $breadcrumb_tree[0]['current'] = true;
        }

        if (is_month() || is_day()) {
          $breadcrumb_tree[] = [
            'item_class' => 'item-cat item-archive item-month item-month-' . $month,
            'bread_class' => 'bread-cat bread-archive bread-month bread-month-' . $month,
            'url' => get_month_link($year, $month),
            'name' => 'Month: ' . get_the_time('F')
          ];

          if (is_month()) {
            $breadcrumb_tree[1]['item_class'] = 'item-current ' . $breadcrumb_tree[1]['item_class'];
            $breadcrumb_tree[1]['bread_class'] = 'bread-current ' . $breadcrumb_tree[1]['bread_class'];
            $breadcrumb_tree[1]['current'] = true;
          }
        }

        if (is_day()) {
          $breadcrumb_tree[] = [
            'item_class' => 'item-current item-cat item-archive item-day item-day-' . $day,
            'bread_class' => 'bread-current bread-cat bread-archive bread-day bread-day-' . $day,
            'url' => get_day_link($year, $month, $day),
            'name' => 'Day: ' . $day,
            'current' => true
          ];
        }

      } else {

        if (
          function_exists('tribe_is_showing_all')
          && tribe_is_showing_all()
        ) {

          // Events Calendar all related events page

          $breadcrumb_tree[] = [
            'item_class' => 'item-cat item-archive',
            'bread_class' => 'bread-bread bread-archive',
            'url' => tribe_get_events_link(),
            'name' => 'Events'
          ];

          $breadcrumb_tree[] = [
            'item_class' => 'item-current item-archive',
            'bread_class' => 'bread-current bread-archive',
            'url' => home_url($wp->request),
            'name' => 'All Events for ' . $wp_query->posts[0]->post_title,
            'current' => true
          ];

        } else if (
          function_exists('tribe_is_month')
          && tribe_is_month()
        ) {

          // Events Calendar month page

          $breadcrumb_tree[] = [
            'item_class' => 'item-current item-archive',
            'bread_class' => 'bread-current bread-archive',
            'url' => tribe_get_events_link(),
            'name' => 'Events',
            'current' => true
          ];

        } else {

          $breadcrumb_tree[] = [
            'item_class' => 'item-current item-archive',
            'bread_class' => 'bread-current bread-archive',
            'url' => home_url($wp->request) . '/',
            'name' => get_the_archive_title(),
            'current' => true
          ];

        }

      }

      foreach ($breadcrumb_tree as $breadcrumb_attrs) {
        echo $breadcrumb->part(
          'breadcrumb',
          $breadcrumb_attrs
        );
      }

    } else if (is_archive() && is_tax() && !is_category() && !is_tag()) {

      // If post is a custom post type...

      $post_type = get_post_type();

      // Display the name and link if it is a custom post type
      if ($post_type !== 'post') {
        $post_type_object = get_post_type_object($post_type);
        $post_type_archive = get_post_type_archive_link($post_type);
        if (!empty($post_type_archive)){
          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-cat item-custom-post-type-' . $post_type,
              'bread_class' => 'bread-cat bread-custom-post-type-' . $post_type,
              'url' => $post_type_archive,
              'name' => $post_type_object->labels->name
            ]
          );
        }
      }

      if (
        function_exists('tribe_is_event_category')
        && tribe_is_event_category()
      ) {

        // Events Calendar event category page

        echo $breadcrumb->part(
          'breadcrumb',
          [
            'item_class' => 'item-cat',
            'bread_class' => 'bread-cat',
            'url' => tribe_get_events_link(),
            'name' => 'Events'
          ]
        );

        $custom_tax_name = get_queried_object()->name;
        echo $breadcrumb->part(
          'breadcrumb',
          [
            'item_class' => 'item-current item-archive',
            'bread_class' => 'bread-current bread-archive',
            'url' => home_url($wp->request) . '/',
            'name' => 'Category: ' . $custom_tax_name,
            'current' => true
          ]
        );

      } else {

        $custom_tax_name = get_queried_object()->name;
        echo $breadcrumb->part(
          'breadcrumb',
          [
            'item_class' => 'item-current item-archive',
            'bread_class' => 'bread-current bread-archive',
            'name' => $custom_tax_name
          ]
        );

      }

    } else if (is_single()) {

      // If post is a custom post type
      $post_type = get_post_type();

      // If it is a custom post type display name and link
      if ($post_type !== 'post') {
        $post_type_object = get_post_type_object($post_type);
        $post_type_archive = get_post_type_archive_link($post_type);
        if (!empty($post_type_archive)) {
          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-cat item-custom-post-type-' . $post_type,
              'bread_class' => 'bread-cat bread-custom-post-type-' . $post_type,
              'url' => $post_type_archive,
              'name' => $post_type_object->labels->name
            ]
          );
        }
      }

      // Get post category information.
      $category = get_the_category();
      if (
        !empty($category)
        && gettype($category) === 'array'
      ) {
        // Get the last category the post is in.
        $last_category = end($category);

        if ($last_category->slug === 'uncategorized') {
          unset($last_category);
        }
      }

      /**
       * Checks if it's a custom taxonomy in a custom post type.  Also checks if
       * custom taxonomy is associated to post ID to account for WooCommerce using
       * same "product_cat" taxonomy name.
       */
      if (
        empty($last_category)
        && !empty($custom_taxonomy)
        && taxonomy_exists($custom_taxonomy)
        && has_term('', $custom_taxonomy, $post->ID)
      ) {
        $taxonomy_terms = get_the_terms($post->ID, $custom_taxonomy);
        if (gettype($taxonomy_terms) === 'array') {
          $first_taxonomy_term = $taxonomy_terms[0];

          if (
            gettype($first_taxonomy_term) === 'object'
            && property_exists($first_taxonomy_term, 'term_id')
          )
          $category_id = $first_taxonomy_term->term_id;
        }
      }

      // Check if the post is in a category
      if (!empty($last_category)) {
          // Get parent any categories and create array
          $category_parents = get_category_parents($last_category->term_id, true, '|');
          if (
            !is_wp_error($category_parents)
            && gettype($category_parents) === 'string'
          ) {
            $category_parents_array = explode('|', rtrim($category_parents, '|'));

            foreach ( $category_parents_array as $parent ) {
              preg_match('/href=["\'](.*?)["\']/', $parent, $parent_url_matches);
              echo $breadcrumb->part(
                'breadcrumb',
                [
                  'item_class' => 'item-cat',
                  'bread_class' => 'bread-cat',
                  'url' => $parent_url_matches[1],
                  'name' => strip_tags($parent)
                ]
              );
          }
        }

        echo $breadcrumb->part(
          'breadcrumb',
          [
            'item_class' => 'item-current item-' . $post->ID,
            'bread_class' => 'bread-current bread-' . $post->ID,
            'url' => get_permalink($post->ID),
            'name' => get_the_title(),
            'current' => true
          ]
        );

      // Else if post is in a custom taxonomy
      } else if (!empty($category_id)) {

        if (!empty($taxonomy_terms)) {
          $category_data = get_term($taxonomy_terms[0]->term_id, $taxonomy_terms[0]->taxonomy);

          $category_tree = [$category_data];
          while ($category_data->parent > 0) {
            $category_data = get_term($category_data->parent, $category_data->taxonomy);
            $category_tree[] = $category_data;
          }
          $category_tree = array_reverse($category_tree);

          // Display the full parent tree
          $number_categories = count($category_tree);
          for ($i = 0; $i < $number_categories; $i++) {
            $category = $category_tree[$i];

            echo $breadcrumb->part(
              'breadcrumb',
              [
                'item_class' => 'item-cat item-cat-' . $category->term_id . ' item-cat-' . $category->slug,
                'bread_class' => 'bread-cat bread-cat-' . $category->term_id . ' bread-cat-' . $category->slug,
                'url' => get_category_link($category->term_id),
                'name' => $category->name
              ]
            );
          }
        }

        echo $breadcrumb->part(
          'breadcrumb',
          [
            'item_class' => 'item-current item-' . $post->ID,
            'bread_class' => 'bread-current bread-' . $post->ID,
            'url' => get_permalink($post->ID),
            'name' => get_the_title($post->ID),
            'current' => true
          ]
        );

      } else {

        if (
          function_exists('tribe_is_event')
          && tribe_is_event($post_raw->ID)
        ) {

          // Events Calendar single event page

          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-cat',
              'bread_class' => 'bread-cat',
              'url' => tribe_get_events_link(),
              'name' => 'Events'
            ]
          );

          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-current',
              'bread_class' => 'bread-current',
              'url' => home_url($wp->request) . '/',
              'name' => get_the_title($post_raw->ID),
              'current' => true
            ]
          );

        } else if (
          function_exists('tribe_is_venue')
          && tribe_is_venue($post_raw->ID)
        ) {

          // Events Calendar venue page

          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-cat',
              'bread_class' => 'bread-cat',
              'url' => tribe_get_events_link(),
              'name' => 'Events'
            ]
          );

          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-current',
              'bread_class' => 'bread-current',
              'url' => home_url($wp->request) . '/',
              'name' => 'Venue: ' . get_the_title($post_raw->ID),
              'current' => true
            ]
          );

        } else if (
          function_exists('tribe_is_organizer')
          && tribe_is_organizer($post_raw->ID)
        ) {

          // Events Calendar organizer page

          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-cat',
              'bread_class' => 'bread-cat',
              'url' => tribe_get_events_link(),
              'name' => 'Events'
            ]
          );

          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-current',
              'bread_class' => 'bread-current',
              'url' => home_url($wp->request) . '/',
              'name' => 'Organizer: ' . get_the_title($post_raw->ID),
              'current' => true
            ]
          );

        } else {

          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-current',
              'bread_class' => 'bread-current',
              'url' => home_url($wp->request) . '/',
              'name' => get_the_title($post->ID),
              'current' => true
            ]
          );

        }

      }

    } else if (is_category()) {

      // Category page

      $category_name = single_cat_title('', false);
      $category_id = get_cat_ID($category_name);
      $category_data = get_category($category_id);

      // Build the parent tree of the current category
      $category_tree = [$category_data];
      while (
        property_exists($category_data, 'parent')
        && $category_data->parent > 0
      ) {
        $category_data = get_category($category_data->parent);
        $category_tree[] = $category_data;
      }
      $category_tree = array_reverse($category_tree);

      // Display the full parent tree
      $number_categories = count($category_tree);
      for ($i = 0; $i < $number_categories; $i++) {
        $category = $category_tree[$i];

        if ($i < $number_categories - 1) {
          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-cat item-cat-' . $category->term_id . ' item-cat-' . $category->slug,
              'bread_class' => 'bread-cat bread-cat-' . $category->term_id . ' bread-cat-' . $category->slug,
              'url' => get_category_link($category->term_id),
              'name' => $category->name
            ]
          );
        } else {
          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-current item-' . $category->term_id,
              'bread_class' => 'bread-current bread-' . $category->term_id,
              'url' => get_category_link($category->term_id),
              'name' => $category->name,
              'current' => true
            ]
          );
        }
      }

    } else if (is_home()) {

      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-current item-cat',
          'bread_class' => 'bread-current bread-cat',
          'url' => get_permalink(get_option('page_for_posts')),
          'name' => wp_title('', false),
          'current' => true
        ]
      );

    } else if (is_page()) {

      // Standard page

      if($post->post_parent){

        // If child page, get parents
        $ancestors = get_post_ancestors($post->ID);
        $ancestors = array_reverse($ancestors);

        // Parent page loop
        foreach ($ancestors as $ancestor_id) {
          echo $breadcrumb->part(
            'breadcrumb',
            [
              'item_class' => 'item-parent item-parent-' . $ancestor_id,
              'bread_class' => 'bread-parent bread-parent-' . $ancestor_id,
              'url' => get_permalink($ancestor_id),
              'name' => get_the_title($ancestor_id)
            ]
          );
        }

        // Current page
        echo $breadcrumb->part(
          'breadcrumb',
          [
            'item_class' => 'item-current item-' . $post->ID,
            'bread_class' => 'bread-current bread-' . $post->ID,
            'url' => get_permalink($post->ID),
            'name' => get_the_title($post->ID),
            'current' => true
          ]
        );

      } else {

        // Just display current page if no parents

        echo $breadcrumb->part(
          'breadcrumb',
          [
            'item_class' => 'item-current item-' . $post->ID,
            'bread_class' => 'bread-current bread-' . $post->ID,
            'url' => get_permalink($post->ID),
            'name' => get_the_title($post->ID),
            'current' => true
          ]
        );

      }

    } else if (is_tag()) {

      // Get tag information
      $tag_id = get_query_var('tag_id');
      $tag_terms = get_term_by('id', $tag_id, 'post_tag');

      // Display the tag name

      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-current item-tag-' . $tag_id . ' item-tag-' . $tag_terms->slug,
          'bread_class' => 'bread-current bread-tag-' . $tag_id . ' bread-tag-' . $tag_terms->slug,
          'url' => get_tag_link($tag_id),
          'name' => 'Tag: ' . $tag_terms->name,
          'current' => true
        ]
      );

    } elseif (is_day()) {

      // Day archive

      $year = get_the_time('Y');
      $month = get_the_time('m');
      $day = get_the_time('j');

      // Year link
      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-year item-year-' . $year,
          'bread_class' => 'bread-year bread-year-' . $year,
          'url' => get_year_link( $year ),
          'name' => 'Year: ' . $year
        ]
      );

      // Month link
      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-month item-month-' . $month,
          'bread_class' => 'bread-month bread-month-' . $month,
          'url' => get_month_link( $year, $month ),
          'name' => 'Month: ' . get_the_time('F')
        ]
      );

      // Day link
      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-current item-day item-day-' . $day . ' item-' . $day,
          'bread_class' => 'bread-current bread-day bread-day-' . $day . ' bread-' . $day,
          'url' => get_day_link($year, $month, $day),
          'name' => '19 ' . 'Day: ' . $day,
          'current' => true
        ]
      );

    } else if (is_month()) {

      // Month Archive

      $year = get_the_time('Y');
      $month = get_the_time('m');

      // Year link
      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-year item-year-' . $year,
          'bread_class' => 'bread-year bread-year-' . $year,
          'url' => get_year_link($year),
          'name' => 'Year: ' . $year
        ]
      );

      // Month link
      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-month item-month-' . $month,
          'bread_class' => 'bread-month bread-month-' . $month,
          'url' => get_month_link($year, $month),
          'name' => 'Month: ' . get_the_time('F'),
          'current' => true
        ]
      );

    } else if (is_year()) {

      // Year archive

      // Year link
      $year = get_the_time('Y');

      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-current item-current-' . $year,
          'bread_class' => 'bread-current bread-current-' . $year,
          'url' => get_year_link($year),
          'name' => 'Year: ' . $year,
          'current' => true
        ]
      );

    } else if (is_author()) {

      // Author archive

      // Get the author information
      global $author;
      $userdata = get_userdata( $author );

      // Display author name
      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-current item-current-' . $userdata->user_nicename,
          'bread_class' => 'bread-current bread-current-' . $userdata->user_nicename,
          'name' => 'Author: ' . $userdata->display_name
        ]
      );

    } else if (get_query_var('paged')) {

      // UNUSED CODE?

      // Paginated archive

      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-current item-current-' . get_query_var('paged'),
          'bread_class' => 'bread-current bread-current-' . get_query_var('paged'),
          'name' => __('Page', 'uw-theme') . ' ' . get_query_var('paged')
        ]
      );

    } else if (is_search()) {

      // Search results page

      echo $breadcrumb->part(
        'breadcrumb',
        [
          'item_class' => 'item-current item-search',
          'bread_class' => 'bread-current bread-search',
          'url' => add_query_arg(['s' => urlencode(get_search_query())], home_url($wp->request)),
          'name' => 'Search results for: ' . get_search_query(),
          'current' => true
        ]
      );

    } elseif (is_404()) {

      // 404 page

      echo $breadcrumb->part(
        'breadcrumb',
        [
          'name' => 'Error 404'
        ]
      );

    }

    echo $breadcrumb->part('close');

  }

}
