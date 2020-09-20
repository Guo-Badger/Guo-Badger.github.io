<?php

/**
 * Adds Page to reset custom page templates and delete any ACF Fields in the database
 *
 * @return void
 **/
function add_migration_helper_menu(){
		$permission = ( ( is_multisite() && is_super_admin() ) || ( !is_multisite() && current_user_can('administrator') ) );
		$permission = apply_filters( 'uw_add_theme_helper_permission_filter', $permission );
    if( $permission ){
        add_theme_page( 'Theme Helper', 'Theme Helper', 'manage_options', 'uw-theme-helper', 'theme_helper_page' );
    }
}
add_action( 'admin_menu', 'add_migration_helper_menu' );

// Render the theme helper page
function theme_helper_page(){
    echo '<div class="wrap">'; 

    // Run action if the URL param is set
    if(isset($_GET['action'])){
        if($_GET['action'] === "migration-delete-acf"){

            uw_remove_unsupported_acf();
            echo '<div class="update notice notice-success is-dismissible"><p>Unsupported fields have been removed!</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';

        }

        if($_GET['action'] === "migration-reset-templates"){
            uw_reset_templates();
            echo '<div class="updated notice notice-success is-dismissible"><p>Templates have been reset!</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
        }
    }

    ?>
        <h1>Theme Helper</h1>
        <p>
            <strong>Warning: The actions on this page will modify the database of your site! We recommend backing up your database before proceeding!</strong>
            <br />
            Only run these actions if you are sure you know what you are doing, and you know they will not have any adverse effects on your site.
            <br />

            If you are developing a custom child theme, or have modified the UW Theme in any way these actions could break your site!
        </p>

        <hr />
    <?php
    
    // If the site still has custom templates or ACF fields in the database
    if(uw_has_templates_set() || uw_has_acf_posts()){
        ?>
        <p>
            It looks like you switched from another theme to the UW Theme! There is a bit of housekeeping to do.
            <br />
            If you are able to access this page, it's because you have pages that are using unsupported templates, or there are custom fields that are not supported by the UW Theme. To help provide the best site editing experience, it would be best to fix these issues. You will find more info below!
        </p>
        <?php
    } else {
        echo '<p>Looks like everything is good to go!</p>';

        // If there are pages that can be converted, link to the page converter
        $classic_pages = classic_wp_pages();
        if ( !empty( $classic_pages ) ) {
            echo '<p>Make sure you convert your pages to the UW Themes page builder! <a href="/wp-admin/themes.php?page=uw-page-converter">Click here</a> to open the page converter!</p>';
        }
    }

    echo "<hr/>";

    if(uw_has_templates_set()){
        ?>
            <h2>Unsupported Templates</h2>
            <p>Your site has pages that are using unsupported templates. This will make it so the UW Theme page builder will not work on those pages. Resetting the templates back to the default will enable the page builder!</p>

            <a href="/wp-admin/themes.php?page=uw-theme-helper&action=migration-reset-templates" class="button button-primary">Reset Templates</a>
            <br />
            <br />
            <hr/>
        <?php
    }

    if(uw_has_acf_posts()){
        ?>
            <h2>ACF Fields</h2>
            <p>The UW Theme, and many other sites use a plugin called Advanced Custom Fields (ACF) to help manage and build content. It looks like your site has some field data saved in the database. This means that there are probably unsupported custom field in your editor interface. This could lead to confusion and possibly errors, so it's best to remove this data.</p>

            <a href="/wp-admin/themes.php?page=uw-theme-helper&action=migration-delete-acf" class="button button-primary">Remove ACF Data</a>
            <br />
            <br />
            <hr/>
        <?php
    }
    echo '</div>';
}

// Get and return any ACF field group posts
function uw_has_acf_posts(){
    $wp_query_args = array(
        'post_type' => ['acf-field-group', 'acf'],
        'post_status'      => 'publish',
        'posts_per_page' => -1
      );
    
      $acf = get_posts( $wp_query_args );

      return $acf;
}

// Get and return any custom templates metadata
function uw_has_templates_set(){
    global $wpdb;
    
    if( is_multisite() ){
        $prefix = $wpdb->base_prefix . get_current_blog_id() . '_';
    } else {
        $prefix = $wpdb->prefix;
    }

    $results = $wpdb->get_results( "SELECT * FROM {$prefix}postmeta WHERE meta_key='_wp_page_template'" );
    return $results;
}

// Deletes all page template meta data
function uw_reset_templates(){
    global $wpdb;
    
    if( is_multisite() ){
        $prefix = $wpdb->base_prefix . get_current_blog_id() . '_';
    } else {
        $prefix = $wpdb->prefix;
    }

    $results = $wpdb->get_results( "DELETE FROM {$prefix}postmeta WHERE meta_key='_wp_page_template'" );

    return $results;
}

// Delete all ACF field group posts
function uw_remove_unsupported_acf(){
    $wp_query_args = array(
        'post_type' => ['acf-field-group', 'acf'],
        'post_status'      => 'publish',
        'posts_per_page' => -1
      );
    
      $acf = get_posts( $wp_query_args );

      foreach($acf as $post){
        wp_delete_post($post->ID);
      }
}