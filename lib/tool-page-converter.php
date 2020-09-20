<?php 

/**
 * Adds Page converter menu itom to admin>tools if the site has any published classic pages
 *
 * @return void
 **/
function add_page_converter_menu(){
	$permission = ( ( is_multisite() && is_super_admin() ) || ( !is_multisite() && current_user_can('administrator') ) );
	$permission = apply_filters( 'uw_add_page_converter_permission_filter', $permission );
	if ( $permission ) {
		add_theme_page( 'Convert Pages to Page Builder', 'Convert Pages', 'manage_options', 'uw-page-converter', 'convert_pages_page' );
	}
}
add_action( 'admin_menu', 'add_page_converter_menu' );


/**
 * Content for page converter tool
 *
 * @return String HTML markup for page
 **/
function convert_pages_page() {
  if ( !current_user_can( 'manage_options' ) )  :
    wp_die( __( 'You do not have sufficient permissions to access this page.', 'uw-theme' ) );
  endif;

  // check nonces and convert page
  if ( isset($_GET['post']) && isset($_GET['action']) && "convert" == $_GET['action'] ) :
    $post = $_GET['post'];
    if ( is_array($post) ) :
      check_admin_referer( 'convert-pages' );
      foreach ($post as $page_id) {
        convert_to_uw_page_builder($page_id);
        show_feedback_notice(true);
      }
    else:
      check_admin_referer( 'convert-page_'.$post );
      convert_to_uw_page_builder($post);
      show_feedback_notice();
    endif;
  endif;

  $classic_pages = classic_wp_pages();

  echo '<div class="wrap">
      <h1>Convert Classic Page to UW Page Builder Pages</h1>
      <p>Standard Wordpress pages should be converted to the UW theme’s Page Builder structure (i.e. a one-column layout with a single text area page element in it.</p>';

  if ( empty($classic_pages) ) :
    echo '<p>This site does not have any classic Wordpress pages to convert.</p>';
  else:
    echo '<form action="themes.php?page=uw-page-converter" method="get" id="classic_pages_to_convert">';
    echo '<input type="hidden" name="action" value="convert">';
    echo '<input type="hidden" name="page" value="uw-page-converter">';
    wp_nonce_field( 'convert-pages' );
    echo '<input type="submit" id="doaction" class="button action" value="Bulk convert">';
    echo '<table class="wp-list-table widefat fixed striped pages">';
    echo '<thead>';
    echo '<tr>';
    echo '<td id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></td>';
    echo '<th>Title</th><th>Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    foreach ($classic_pages as $page) {
      echo '<tr>';
      echo '<td><label class="screen-reader-text" for="cb-select-' . $page->ID . '">Select' . $page->post_title . '</label><input id="cb-select-' . $page->ID . '" type="checkbox" name="post[]" value="' . $page->ID . '">';
      echo '<td>' . $page->post_title . '</td>';
      $action_url = '?post=' . $page->ID . '&action=convert&page=uw-page-converter';
      echo '<td><a href="' . wp_nonce_url( $action_url, 'convert-page_'.$page->ID ) . '">Convert</a></td>';
      echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
    echo '</form>';
  endif;

  echo '</div>';
}


/**
 * returns classic pages
 *
 * @return Array post IDs
 **/
function classic_wp_pages() {
  $wp_query_args = array(
    'post_type' => 'page',
    'post_status'      => 'publish',
    'posts_per_page' => -1
  );

  $pages = get_posts( $wp_query_args );

  return array_filter($pages, "is_classic_page");

}


/**
 * Tests if page is "classic" or not
 * (i.e. , with content in post_content and without any custom fields)
 *
 * @param Object $page A WP post object
 * @return boolean
 **/
function is_classic_page($page){

  // first verify the page is not using a custom template
  $page_template = get_post_meta( $page->ID, '_wp_page_template', true );
  if ( !empty( $page_template ) && "default" != $page_template)
    return false;

  // does the post have post_content?
  $has_post_content = empty( $page->post_content ) ? false : true;

  // does the post use UW Theme's Page Build? (i.e. does it have a non-empty meta value for 'primary_content_area')
  $primary_content_area = get_post_meta($page->ID, "primary_content_area");
  $uses_page_builder = empty( $primary_content_area ) ? false : true;

  // it's a "classic" page if it has post content but does not use the page builder
  return $has_post_content && !$uses_page_builder;
}

/**
 * Converts a page to UW Page Builder one-column text element
 *
 * @param Integer $page_id a Wordpress post ID
 * @return void
 **/
function convert_to_uw_page_builder($page_id){

  $page = get_post($page_id);

  // double check we have a classic page before conversion
  if ( !is_classic_page($page))
    return false;

  add_post_meta( $page->ID, '_primary_content_area', "field_56a66cfb6ddaf" );
  add_post_meta( $page->ID, 'primary_content_area', array("one_column_content_layout") );

  add_post_meta( $page->ID, '_lower_content_area', "field_5762f248ae50f" );
  add_post_meta( $page->ID, 'lower_content_area', "" );

  add_post_meta( $page->ID, '_hero_content_area', "field_574358326cf6f" );
  add_post_meta( $page->ID, 'hero_content_area', "" );

  add_post_meta( $page->ID, '_primary_content_area_0_row_headline', "field_577d30a18b0e1" );
  add_post_meta( $page->ID, 'primary_content_area_0_row_headline', "" );

  add_post_meta( $page->ID, '_primary_content_area_0_background_choice', "field_577d1da785a49" );
  add_post_meta( $page->ID, 'primary_content_area_0_background_choice', "default" );

  add_post_meta( $page->ID, '_primary_content_area_0_one_column_page_elements', "field_56a8d83a184a9" );
  add_post_meta( $page->ID, 'primary_content_area_0_one_column_page_elements', array("text_block") );

  add_post_meta( $page->ID, '_primary_content_area_0_one_column_page_elements_0_text_block_content', "field_5745f89f07744" );
  add_post_meta( $page->ID, 'primary_content_area_0_one_column_page_elements_0_text_block_content', $page->post_content );

}


/**
 * WP Admin feedback message block, plualized as needed
 *
 * @return String feedback message
 **/
function show_feedback_notice($plural = false){
  $pluralized = $plural ? "s" : "";
  echo '<div id="message" class="updated notice notice-success is-dismissible"><p>Page' . $pluralized . ' converted.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
}


/**
 * Insert some JS to handle the check all feature
 *
 * @return void
 **/
function admin_inline_js(){
  if ( isset($_GET['page']) && "uw-page-converter" == $_GET['page']) : ?>
    <script type='text/javascript'>
      (function ($) {
        $("#cb-select-all-1").on("change",function(e){
          var checkBoxes = $('.wp-list-table tbody input[type="checkbox"]');
          if (this.checked) {
            checkBoxes.prop("checked", true);
          } else {
            checkBoxes.prop("checked", false);
          }
        });
      })(jQuery);
    </script>
<?php  endif;
}
add_action( 'admin_footer', 'admin_inline_js' );