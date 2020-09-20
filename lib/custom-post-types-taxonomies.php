<?php


//add custom post types
add_action( 'init', 'all_custom_post_types' );

//create a new custom post type and define settings
function all_custom_post_types() {
	post_type_settings('uw_documents', 'Documents Page', 'Document', 'documents', 'dashicons-media-default', array( 'title', 'editor', 'excerpt', 'thumbnail', 'help' ), true );
	post_type_settings('uw_staff', 'Faculty/Staff Members', 'Faculty/Staff Member', 'staff',  'dashicons-groups', array( 'title', 'editor', 'excerpt', 'help' ), false );
}

// universal function for custom post type settings
// do not modify or duplicate this function... to create a new
// post type and define settings, add a line to all_custom_post_types()
function post_type_settings( $key_name, $name, $singular_name, $url_slug, $icon = true, $supports, $has_archive = false ) {
	$labels = array(
		'name'					=> $name,
		'singular_name'			=> $singular_name,
		'add_new'				=> 'Add New',
		'add_new_item'			=> 'Add New ' . $singular_name,
		'edit_item'				=> 'Edit ' . $singular_name,
		'new_item'				=> 'New ' . $singular_name,
		'view_item'				=> 'View ' . $singular_name,
		'search_items'			=> 'Search ' . $name,
		'not_found'				=> 'No ' . $name . ' found',
		'not_found_in_trash'	=> 'No ' . $name . ' found in Trash',
		'parent_item_colon'		=> '',
		'menu_name'				=> $name
	);
	$rewrite = array(
		'slug'					=> $url_slug,
		'with_front'			=> true,
		'pages'					=> true,
		'feeds'					=> true,
	);
	$args = array(
		'labels'				=> $labels,
		'public'				=> true,
		'publicly_queryable'	=> true,
		'show_ui'				=> true,
		'menu_icon'				=> $icon,
		'query_var'				=> true,
		'rewrite'				=> $rewrite,
		'capability_type'		=> 'post',
		'hierarchical'			=> false,
		'menu_position'			=> '5',
		'has_archive'			=> $has_archive,
		'exclude_from_search'	=> false,
		'supports'				=> $supports,
		'taxonomies'			=> array('category', 'post_tags')
	);

	// add a filter for customizing post types from a child theme or plugin
    $args = apply_filters( 'uw_ctp_args', $args, $key_name );

    register_post_type( $key_name, $args );
}

// add custom taxonomies
add_action( 'init', 'all_custom_taxonomies');

function all_custom_taxonomies() {
  taxonomy_settings( 'uw_staff_type', 'Faculty Types', 'Faculty Type', 'staff-type', array( 'uw_staff' ), true );
  taxonomy_settings( 'uw_document_type', 'Document Types', 'Document Type', 'document-type', array( 'uw_documents' ), true );
}

function taxonomy_settings( $key_name, $name, $singular_name, $url_slug, $post_type_keys, $is_hierarchical ) {

  $labels = array(
    'name'                       => $name,
    'singular_name'              => $singular_name,
    'menu_name'                  => null,
    'all_items'                  => 'All ' . $name,
    'edit_item'                  => 'Edit ' . $singular_name,
    'view_item'                  => 'View ' . $singular_name,
    'update_item'                => 'Update ' . $singular_name,
    'add_new_item'               => 'Add New ' . $singular_name,
    'new_item_name'              => 'New ' . $singular_name . ' Name',
    'parent_item'                => 'Parent Category',
    'parent_item_colon'          => 'Parent Category',
    'search_items'               => 'Search ' . $name,
    'popular_items'              => 'Common ' . $name,
    'separate_items_with_commas' => 'Separate ' . $name . ' with commas',
    'add_or_remove_items'        => 'Add or remove ' . $name,
    'choose_from_most_used'      => 'Choose from the most used ' . $name,
    'not_found'                  => 'No ' . $name . ' found'
  );

  $rewrite = array(
    'slug'                       => $url_slug,
    'with_front'                 => true,
    'hierarchical'               => true,
  );

  $args = array(
    'labels'                     => $labels,
    'hierarchical'               => $is_hierarchical,
    'public'                     => true,
    'show_ui'                    => true,
    'show_in_menu'               => true,
    'show_admin_column'          => true,
    'show_in_quick_edit'         => true,
    'show_in_nav_menus'          => true,
    'show_tagcloud'              => true,
    'query_var'                  => true,
    'rewrite'                    => $rewrite,
  );

  register_taxonomy( $key_name, $post_type_keys, $args );
}

/**
* Post-type specific functions
**/

/**
* Update the title field with first_name and last_name
*
* @return array WP post data form edit form
**/
function set_faculty_list_title( $data, $postarr ) {
	if ( 'uw_staff' == $postarr['post_type'] && isset($postarr['acf']['field_575efa0f1eaea']) && isset($postarr['acf']['field_575efa041eae9']) ) {
	 $data['post_title'] = $postarr['acf']['field_575efa0f1eaea'] . ', ' . $postarr['acf']['field_575efa041eae9'];
	}
	return $data;
}
add_action( 'wp_insert_post_data', 'set_faculty_list_title', 10, 2 );

add_filter( 'manage_edit-uw_staff_columns', 'uw_staff_columns' );
function uw_staff_columns( $columns ) {
	$columns = array(
		'cb' =>   '<input type="checkbox" />',
		'title' => __( 'Title', 'uw-theme' ),
		'credentials' => __('Credentials', 'uw-theme'),
		'headshot' => __( 'Headshot', 'uw-theme' ),
		'email' => __( 'Email', 'uw-theme' ),
		'uw_staff_type' => __( 'Faculty Type', 'uw-theme' ),
		'title_position' => __( 'Title/Position', 'uw-theme' ),
		'date' => __( 'Date', 'uw-theme' )
	);
	return $columns;
}


/**
 * Adds a help menu to the UW Faculty/Staff Members edit page.
 */
function my_contextual_help() {
  $current_screen = get_current_screen();

  // Add the help tabs to the edit page.
  if ($current_screen->id === 'edit-uw_staff') {
    $current_screen->add_help_tab([
      'id' => 'edit-uw_staff-help-overview',
      'title' => 'Overview',
      'content' => '
        <h2>Faculty Members</h2>
        <p>To display these faculty members on a page create a new page and select a "One Column Content Layout" then add a "Faculty List Options" page element.</p>
      '
    ]);
  }
}
add_action('load-edit.php', 'my_contextual_help');


/**
 *
 * Adds Faculty Type Filter to Dashboard admin
 *
 */
add_action( 'restrict_manage_posts', 'my_restrict_manage_posts' );
function my_restrict_manage_posts() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    $post_type = 'uw_staff';
    if ($typenow == $post_type) {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        $filters = array( 'uw_staff_type' );

        foreach ($filters as $tax_slug) {
            // retrieve the taxonomy object
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;

            // retrieve array of term objects per taxonomy
            $terms = get_terms($tax_slug);
            $current_v = isset($_GET[$tax_slug]) ? $_GET[$tax_slug] : '';

            // output html for taxonomy dropdown filter
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>All $tax_name</option>";
            foreach ($terms as $term) {
                // output each select option line, check against the last $_GET to show the current option selected
            	echo '<option value="' . $term->slug . '"', $current_v == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';            }
            echo "</select>";
        }
    }
}



// Displays the correct columns in the 'Faculty Members' list view
add_action( 'manage_uw_staff_posts_custom_column', 'manage_uw_staff_columns', 10, 2 );
function manage_uw_staff_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {
		case 'headshot' :
			$image_id = get_field( 'headshot' );
			if ( $image_id ) {
				echo wp_get_attachment_image( $image_id, 'thumb' );
			} else {
				echo '<img src="' . get_template_directory_uri() . '/dist/images/bucky-head.png" style="width:100%"/>';
			}
		break;

		case 'name' :
			$name = get_field( 'name' );
			if ( $name ) {
				echo $name;
			}
		break;
		case 'credentials' :
			$credentials = get_field( 'credentials' );
			if ( $credentials ) {
				echo $credentials;
			}
		case 'email' :
			$email = get_field( 'email' );
			if ( $email ) {
				echo $email;
			}
		break;

		case 'uw_staff_type' :
		$term_names = wp_get_post_terms( $post_id, 'uw_staff_type', array("fields" => "names"));
		if ( $term_names ) {
			foreach ($term_names as $term) {
				echo $term . '<br/>';
			}
		}
		break;

		case 'title_position' :
		$title_position = get_field( 'title_position' );
		if ( $title_position ) {
			echo $title_position;
		}
		break;

		default :
		break;
	}
}
add_action('acf/input/admin_head', 'my_acf_admin_head_faculty');
// Hides the page title input because we generate it on save with the first/last name
function my_acf_admin_head_faculty() {
	?>
	<style>
	.post-type-uw_staff #poststuff #titlewrap {
		display: none;
	}
	</style>
	<?php
}

/**
 *
 *	Display the archive page for the UW Staff Type taxonomy in alphabetical order
 *
 */
function uw_staff_type_taxonomy_sort_order( $query ) {
	if ( $query->is_tax('uw_staff_type') ) {
		$query->set('orderby', 'title');
		$query->set('order', 'ASC');
	}
}
add_action( 'pre_get_posts', 'uw_staff_type_taxonomy_sort_order' );
