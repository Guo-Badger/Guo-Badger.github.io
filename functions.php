<?php

/**
 * Adds functionality(features) to the theme.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package UW Theme
 */

// check if uwmadison events plugin is already installed
function check_acf_plugin() {
	if ( is_plugin_active('advanced-custom-fields/acf.php') ) {
		add_action( 'admin_notices', function(){
			echo '<div class="error"><p>It looks like you have the <b>Advanced Custom Fields</b> plugin activated. The <abbr>UW</abbr> Theme bundles Advanced Custom Fields Pro. The theme will not work if the Advanced Custom Fields plugin is also active; please deactivate it.</p></div>';
		});
	}
	if ( is_plugin_active('advanced-custom-fields-pro/acf.php') ) {
		add_action( 'admin_notices', function(){
			echo '<div class="error"><p>It looks like you have the <b>Advanced Custom Fields Pro</b> plugin activated. The <abbr>UW</abbr> Theme bundles Advanced Custom Fields Pro. While the theme will still work if the Advanced Custom Fields Pro plugin is installed, it’s best to deactivate it.</p></div>';
		});
	}
	if ( is_plugin_active('uw-madison-events-calendar/uwmadison_events.php') ) {
		add_action( 'admin_notices', function(){
			echo '<div class="error"><p>It looks like you have the <b><abbr>UW</abbr> Events</b> plugin activated. The <abbr>UW</abbr> Theme bundles this plugin. It’s best to deactive the plugin and rely on the version used in the theme.</p></div>';
		});
	}
	return;
}
add_action( 'admin_init', 'check_acf_plugin' );


/**
 * Add Advanced Custom Fields(ACF) to theme. No need to activate this plugin
 * @link https://www.advancedcustomfields.com/
*/
add_filter('acf/settings/path', 'my_acf_settings_path');

function my_acf_settings_path( $path ) {

		// update path
		$path = get_template_directory() . '/advanced-custom-fields-pro/';

		// return
		return $path;

}

add_filter('acf/settings/dir', 'my_acf_settings_dir');

function my_acf_settings_dir( $dir ) {

		// update path
		$dir = get_template_directory_uri() . '/advanced-custom-fields-pro/';

		// return
		return $dir;

}
include_once( get_template_directory() . '/advanced-custom-fields-pro/acf.php' );


// saving acf-json for child themes
add_filter('acf/settings/save_json', function() {
	return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
	$paths = array(get_template_directory() . '/acf-json');

	if(is_child_theme())
	{
		$paths = array(
            get_stylesheet_directory() . '/acf-json',
            get_template_directory() . '/acf-json'
        );
	}

	return $paths;
});


/**
 * ACF filter to conditionally render the legacy hero field group
 * depending on if it has content or not.
 *
 * @return Array $options ACF options or false to not render field group
 **/
function acf_location_screen_options( $options, $field_group ) {
	global $pagenow; // the current wp-admin view

	// only check for the legacy hero field group (key = group_5743582783e2a)
	if ( "group_5743582783e2a" != $field_group['key'])
		return $options;

	// don't load the legacy hero field group for new pages
	if ( "post-new.php" == $pagenow )
		return false;

	// if it's a post edit view, check for legacy hero content
	if ( "post.php" == $pagenow ) {
		$legacy_hero_content = get_post_meta( $_GET['post'], "hero_content_area", true );

		// if no logecy hero content, don't render the legacy field group
		if ( empty($legacy_hero_content) )
			return false;
	}

	return $options;

}
add_filter('acf/location/screen', 'acf_location_screen_options', 10, 2);


/**
 * File includes
 *
 * The array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 */
$uwmadison_includes = array(
	'lib/constants.php', //Constants
	'lib/custom-acf.php',
	'lib/customizer.php',   // Theme customizer
	'lib/custom-fields.php', // Advanced Custom Fields
	'lib/template-tags.php', // Custom template tags
	'lib/shortcodes.php', // Custom shortcodes
	'lib/aria-walker-nav-menu.php', // WAI-ARIA Navigation Menu
	'lib/custom-post-types-taxonomies.php', // Custom Post Types
	'lib/page-builder.php',
	'lib/breadcrumbs.php',
	'lib/tool-page-converter.php',
	'lib/tool-theme-helper.php',
	'lib/vendor/uw-madison-events-calendar/uwmadison_events.php',
	'lib/staff-settings.php' // staff settings admin page
);

foreach ($uwmadison_includes as $file) {
	if (!$filepath = locate_template($file)) {
		trigger_error(sprintf(__('Error locating %s for inclusion', 'uw-theme'), $file), E_USER_ERROR);
	}

	require_once $filepath;
}
unset($file, $filepath);

if ( WP_DEBUG ) {
	@ini_set( 'display_errors', 1 );

	add_action('wp_footer', 'show_template');

	function show_template() {
			 global $template;
					 echo '<!--'.$template.'-->';
	}
} else {
	function remove_wp_version() {
		return '';
	}
	add_filter('the_generator', 'remove_wp_version');
}

/**
 * Theme only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/lib/back-compat.php';
}

if ( ! function_exists( 'uwmadison_switch_theme' ) ) :
  /**
   * Sets up theme defaults upon the theme activation process only via the
   * `after_switch_theme` hook.
   */
  function uwmadison_switch_theme() {
    // Check if site search has been set at any point. If not, set the default
    // value to to be enabled.
    if ( get_theme_mod( 'uwmadison_use_search', -1 ) === -1 ) {
      set_theme_mod( 'uwmadison_use_search', '1' );
    }
  }
  add_action( 'after_switch_theme', 'uwmadison_switch_theme' );
endif;

if ( ! function_exists( 'uwmadison_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * Create your own uwmadison_setup() function to override in a child theme.
	 *
	 */
	function uwmadison_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on this theme, use a find and replace
		 * to change 'uw-theme' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'uw-theme', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 * @link http://codex.wordpress.org/Post_Thumbnails
		 * @link http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
		 * @link http://codex.wordpress.org/Function_Reference/add_image_size
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1200, 9999 );

		/*
		 * Register wp_nav_menu() menus
		 * This theme uses wp_nav_menu() in two locations.
		 * @link http://codex.wordpress.org/Function_Reference/register_nav_menus
		 */
		register_nav_menus( array(
			'main_menu' => esc_html__( 'Main Menu', 'uw-theme' ),
			'utility_menu'  => esc_html__( 'Utility Links Menu', 'uw-theme' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// add custom image size
		add_image_size( 'uw-hero', 1600, 500, true );
		add_image_size( 'uw-2panel-slider', 600, 400, true );
		add_image_size( 'uw-3x2', 900, 600, true );
		add_image_size( 'uw-headshot', 400, 400, true );

		// add edit_theme_options to Editor role
		$editor_role = get_role( 'editor' );
		$editor_role->add_cap( 'edit_theme_options' );
	}
endif;
add_action( 'after_setup_theme', 'uwmadison_setup' );


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 * @link https://codex.wordpress.org/Content_Width
 */
function uwmadison_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'uwmadison_width', 640 );
}
add_action( 'after_setup_theme', 'uwmadison_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
if ( ! function_exists( 'uwmadison_widgets_init' ) ) :
	/**
	 * Register our widgetized sidebar.
	 *
	 * @return void
	 */
	function uwmadison_widgets_init() {

		register_sidebar( array(
			'name' => __( 'Blog Sidebar', 'uw-theme' ),
			'id' => 'sidebar-blog',
			'before_widget' => '<div id="%1$s" class="widget uw-content-box %2$s">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

		register_sidebar( array(
			'name' => __( 'Archive Sidebar', 'uw-theme' ),
			'id' => 'sidebar-archive',
			'before_widget' => '<div id="%1$s" class="widget uw-content-box %2$s">',
			'after_widget' => "</div>",
			'before_title' => '<h3 class="widget-title">',
			'after_title' => '</h3>',
		) );

	}
endif;
add_action( 'widgets_init', 'uwmadison_widgets_init' );


if ( ! function_exists( 'set_uwmadison_body_classes' ) ) :
	/**
	 * Adds classes to the array of body classes.
	 * - column number
	 * - column order
	 * - background color
	 * - author type
	 * - singular post
	 * Applies the uwmadison_layout_classes() filter
	 *
	 * @since UW-Madison 1.0
	 */
	function set_uwmadison_body_classes( $classes ) {
		global $post;

		// set body background color option class
		$body_bgcolor_class = (get_theme_mod('uwmadison_body_bg','uw-white-bg') == "uw-white-bg") ? "uw-white-bg" : "uw-light-gray-bg";
		$classes[] = $body_bgcolor_class;

		// set author class
		if ( function_exists( 'is_multi_author' ) && ! is_multi_author() )
			$classes[] = 'single-author';

		// set singular class
		if ( is_singular() && ! is_home() && ! is_page_template( 'showcase.php' ) && ! is_page_template( 'sidebar-page.php' ) )
			$classes[] = 'singular';

		// apply filter
		$classes = apply_filters( 'uwmadison_body_classes', $classes );

		return $classes;
	}
endif;
add_filter( 'body_class', 'set_uwmadison_body_classes' );


// Google Fonts
if ( ! function_exists( 'uwmadison_add_google_fonts' ) ) :
	/**
	 * Adds Google fonts for DoIT Starter. This enqueues the fonts as an alternative to
	 * including the link in header.php.
	 *
	 * Create your own uwmadison_fonts_url() function to override in a child theme.
	 *
	 * @return string Google fonts URL for the theme.
	 */
	function uwmadison_add_google_fonts() {
		$fonts_url = '';
		$fonts     = array();
		$subsets   = 'latin,latin-ext';

		/*
		 * Use one of these font blocks for each google font you wish to use.
		 */
		// if ( 'off' !== _x( 'on', 'Josefin Sans font: on or off', 'uw-theme' ) ) {
		// 	 /* translators: If there are characters in your language that are not supported by Josefin Sans, translate this to 'off'. Do not translate into your own language. */
		// 	$fonts[] = 'Josefin Sans:400,600,700,400italic';
		// }

		if ( $fonts ) {
			$fonts_url = add_query_arg( array(
				'family' => urlencode( implode( '|', $fonts ) ),
				'subset' => urlencode( $subsets ),
			), 'https://fonts.googleapis.com/css' );
		}

		return $fonts_url;
	}
endif;


if ( ! function_exists( 'uwmadison_widgets_classes' ) ) :
	/**
	 * Add the uw-content-box class to sidebar widgets
	 *
	 * @param Array $params The widget's params
	 * @return Array The filtered params
	 **/
	function uwmadison_widgets_classes($params) {
		global $widget_classes;

		if ( $params[0]['name'] == "Main Sidebar" ) {
			$before_widget_string = $params[0]['before_widget'];
			$params[0]['before_widget'] = str_replace('class="', 'class="uw-content-box ' . $widget_classes[$params[0]['widget_id']], $before_widget_string);
		}

		return $params;
	}
	add_filter( 'dynamic_sidebar_params', 'uwmadison_widgets_classes', 10);
endif; // uwmadison_widgets_classes


if ( ! function_exists( 'uwmadison_auto_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis.
	 *
	 * To override this in a child theme, remove the filter and add your own
	 * function tied to the excerpt_more filter hook.
	 */
	function uwmadison_auto_excerpt_more( $more ) {
		return ' &hellip;';
	}
endif;
add_filter( 'excerpt_more', 'uwmadison_auto_excerpt_more' );


if ( ! function_exists( 'uwmadison_custom_excerpt_length' ) ) :
	/**
	 * Filter the except length to 35 words.
	 *
	 * @param int $length Excerpt length.
	 * @return int (Maybe) modified excerpt length.
	 */
	function uwmadison_custom_excerpt_length( $length ) {
			return 35;
	}
endif;
add_filter( 'excerpt_length', 'uwmadison_custom_excerpt_length', 999 );


/**
 * Adds the excerpt to pages
 *
 * @return void
 **/
add_action( 'init', 'my_add_excerpts_to_pages' );
function my_add_excerpts_to_pages() {
		 add_post_type_support( 'page', 'excerpt' );
}


if ( ! function_exists( 'uwmadison_page_menu_args' ) ) :
	/**
	 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
	 */
	function uwmadison_page_menu_args( $args ) {
		$args['show_home'] = true;
		$args['menu_class'] = $args['container_class'];
		return $args;
	}
endif;
add_filter( 'wp_page_menu_args', 'uwmadison_page_menu_args' );


if ( ! function_exists( 'uwmadison_scripts' ) ) :

	/**
	 * Enqueues scripts and styles.
	 *
	 */
	function uwmadison_scripts() {
		$theme_version="1.11.0";

		// enqueue UW fonts
		wp_register_style( 'uwmadison-fonts', get_template_directory_uri() . '/dist/fonts/uw160/fonts.css', false, '1.0.0' );
		wp_enqueue_style( 'uwmadison-fonts' );

		// Add custom fonts, used in the main stylesheet.
		wp_register_style( 'uwmadison-google-fonts', uwmadison_add_google_fonts(), false, $theme_version );
		wp_enqueue_style( 'uwmadison-google-fonts' );


		wp_register_script( 'uwmadison-ie', get_template_directory_uri() . '/dist/js/polyfills/classList.js', false, '1.0.0', true );
		wp_enqueue_script( 'uwmadison-ie' );
		wp_script_add_data( 'uwmadison-ie', 'conditional', 'lt IE 10' );

		// deregister WP's jQuery; register jQuery 2 for Foundation dependency
		wp_deregister_script( 'jquery' );
		wp_deregister_script( 'jquery-migrate' );

		wp_register_script( 'jquery', get_template_directory_uri() . '/dist/js/jquery/jquery.min.js' , false, '3.4.1', true );
		wp_register_script( 'jquery-migrate', 'https://code.jquery.com/jquery-migrate-3.1.0.js', ['jquery'], '3.1.0', true);

		// Theme assets.
		if ( !WP_DEBUG ) {
			wp_register_style( 'uwmadison-style', get_template_directory_uri() . '/dist/main.min.css' , false, $theme_version );
			wp_enqueue_style( 'uwmadison-style' );
			wp_register_script( 'uwmadison-script', get_template_directory_uri() . '/dist/main.min.js', array('jquery'), $theme_version, true );
			wp_enqueue_script( 'uwmadison-script' );
			wp_enqueue_script( 'jquery-migrate' );
		} else {
			wp_register_style( 'uwmadison-style', get_template_directory_uri() . '/dist/main.css' , false, $theme_version );
			wp_enqueue_style( 'uwmadison-style' );
			wp_register_script( 'uwmadison-script', get_template_directory_uri() . '/dist/main.js', array('jquery'), $theme_version, true );
			wp_enqueue_script( 'uwmadison-script' );
			wp_enqueue_script( 'jquery-migrate' );
		}

		// Load the Internet Explorer specific stylesheet.
		wp_register_style( 'uwmadison-ie', get_template_directory_uri() . '/dist/css/ie.css', array( 'uwmadison-style' ), $theme_version );
		wp_enqueue_style( 'uwmadison-ie' );
		wp_style_add_data( 'uwmadison-ie', 'conditional', 'lt IE 10' );

		if (is_single() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}

	}

endif;
add_action( 'wp_enqueue_scripts', 'uwmadison_scripts' );


/**
 * Remove support for Emoji styles
 *
 **/
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );


/**
 * Test if the site is using search or not
 *
 * @return boolean
 **/
function site_uses_search() {
	return get_theme_mod('uwmadison_use_search', false);
}


/**
 * Returns the GCSE ID isf set or false of not
 *
 * @return String GCSE ID or false
 **/
function gcse_id() {
	return get_theme_mod('uwmadison_google_cse_id', false);
}


/**
 * Test if the site is using a GCSE or not
 *
 * @return boolean
 **/
function site_uses_google_search() {
	return site_uses_search() && gcse_id();
}


/**
 * Test if the site has a main menu
 *
 * @return boolean
 **/
function has_main_menu() {
	$use_fallback_menu = get_theme_mod('uwmadison_menu_pages_fallback', false);
	return has_nav_menu('main_menu') || ($use_fallback_menu && !has_nav_menu('main_menu'));
}


/**
 * Test if the site has a secondary menu
 *
 * @return boolean
 **/
function has_secondary_menu() {
	$use_fallback_menu = get_theme_mod('uwmadison_menu_pages_fallback', false);
	return has_nav_menu('utility_menu');
}


/**
 * Test if the site should use the fallback menu function
 *
 * @return boolean
 **/
function uses_fallback_menu() {
	$use_fallback_menu = get_theme_mod('uwmadison_menu_pages_fallback', false);
	return !has_nav_menu('main_menu') && $use_fallback_menu;
}


/**
 * Test if the site has any menus
 *
 * @return boolean
 **/
function has_any_menus() {
	return has_main_menu() || has_secondary_menu();
}

/**
 * Filter out search query param if site is using GCSE
 * so we avoid an unnecessary query
 *
 * @return void
 **/
function filter_search_query( $query, $error = true ) {
	$gcse_id = site_uses_google_search();
	if ( is_search() && $gcse_id && !is_admin()) {
		$query->query_vars['s'] = false;
		$query->query['s'] = false;
	}
}
add_action( 'parse_query', 'filter_search_query' );


if ( ! function_exists( 'uwmadison_search_join' ) ) :

	/**
	 * Extends WP native search to join on terms tables
	 *
	 * @return String JOIN SQL part
	 **/
	function uwmadison_search_join( $join ){
		global $wpdb;
		if( is_search() && !site_uses_google_search() ) {
			$join .= "LEFT JOIN " . $wpdb->term_relationships. "
							ON " . $wpdb->posts . ".ID = ". $wpdb->term_relationships . ".object_id
							LEFT JOIN " . $wpdb->term_taxonomy . "
							ON " . $wpdb->term_taxonomy . ".term_taxonomy_id = " . $wpdb->term_relationships . ".term_taxonomy_id
							LEFT JOIN " . $wpdb->terms . "
							ON " . $wpdb->terms . ".term_id = " . $wpdb->term_taxonomy . ".term_id
							LEFT JOIN " . $wpdb->postmeta . "
							ON " . $wpdb->posts . ".ID = " . $wpdb->postmeta . ".post_id";
		}
		return $join;
	}

endif;
if (!is_admin()){ add_filter('posts_join', 'uwmadison_search_join' ); }


if ( ! function_exists( 'uwmadison_search_where' ) ) :
	/**
	 * Extends WP native search to also search against category and tag terms
	 *
	 * @return String WHERE SQL part
	 **/
	function uwmadison_search_where( $where ){
		global $wpdb;
		$s = esc_sql($wpdb->esc_like(get_query_var( 's' )));
		if( is_search() && !site_uses_google_search() ) {
			$where = preg_replace(
							"/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
							"(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1 AND ("
									.$wpdb->postmeta.".meta_key LIKE '%text_block_content' OR "
									.$wpdb->postmeta.".meta_key LIKE '%quote_text' OR "
									.$wpdb->postmeta.".meta_key LIKE '%accordion_panel_title' OR "
									.$wpdb->postmeta.".meta_key LIKE '%accordion_panel_body' OR "
									.$wpdb->postmeta.".meta_key LIKE '%tab_title' OR "
									.$wpdb->postmeta.".meta_key LIKE '%tab_body' OR "
									.$wpdb->postmeta.".meta_key LIKE '%alternating_content_headline' OR "
									.$wpdb->postmeta.".meta_key LIKE '%alternating_content_text' OR "
									.$wpdb->postmeta.".meta_key LIKE '%link_display_name'
								))", $where );
			$where .= " OR (" . $wpdb->posts . ".post_status = 'publish' AND " . $wpdb->terms . ".name LIKE '%$s%' AND " . $wpdb->term_taxonomy . ".taxonomy IN ('category','post_tag','uw_staff_type','uw_document_type'))";
		}
		return $where;
	}

endif;
if (!is_admin()){ add_filter('posts_where', 'uwmadison_search_where' ); }


/**
 * Prevent duplicates
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_distinct
 */
function cf_search_distinct( $where ) {
		global $wpdb;

		if ( is_search() ) {
			return "DISTINCT";
		}

		return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );


if ( ! function_exists( 'add_google_analytics' ) ) :

	/**
	 * Add GA tracking code in footer
	 *
	 * @return void
	 **/
	function add_google_analytics() {
		if ( is_user_logged_in() )
			return false;

		$ga_tracking_id = get_theme_mod('uwmadison_ga_tracking_id', false);

		if (!$ga_tracking_id)
			return false;
		?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga_tracking_id ?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', '<?php echo $ga_tracking_id ?>');
		</script>

	<?php }

endif;
add_action('uw_after_head_open_tag', 'add_google_analytics', 0);

/**
 * return whether the site is using breadcrumbs or not
 *
 * @return boolean
 **/
function site_uses_breadcrumbs() {
	return get_theme_mod('uwmadison_breadcrumbs', true);
}

$SVG = simplexml_load_string(file_get_contents(get_template_directory() . '/dist/images/uw-icons.svg'));

/**
 * get_svg function grabs symbol from SVG/XML object, processes, and returns for embedding in HTML.
 **/
function get_svg($symbol_id, array $args = array()) {
	global $SVG;
	// Create XML object that will be used by get_svg function throughout theme.
	$oSVGXML = $SVG;

	// Add or override whatever SVG attributes you want simply by including them in the args array.
	// SVG attributes in SVG file override defaults below.
	// Then function parameters override attributes in SVG file.
	// Some examples of $args array keys are: title, role, width, length, class, and addclasses
	// Two array keys are special and are added to the SVG as child nodes (or override existing nodes): title and desc
	// The args key, no_title_id, will return an SVG with an id on the title element or any aria-describedby or aria-labelledby attrs (for when you can't call get_svg uniquely; see link list walker_menu)
	// global $oSVGXML;
	// Set up defaults
	$aDefault = array(
		'version'=>'1.1',
		'title'=>'This image needs a title.',
		'role'=>'img',
		'focusable' => 'false'
	);
	$oSVG = $oSVGXML->xpath("//*[@id='" . $symbol_id . "']");
	$oXML = $oSVG[0];
	// Get nodes/attributes that can override or add to defaults
	$aSymbolDefaults = array();
	if (property_exists($oXML, 'title')) {
		$aSymbolDefaults['title'] = (string)$oXML->title;
	}
	if (isset($oXML['role'])) {
		$aSymbolDefaults['role'] = $oXML['role'];
	}
	$aDefaultSymbol = array_merge($aDefault, $aSymbolDefaults);
	// Get function parameters that can override or add to defaults and svg symbol
	$aDefaultSymbolParms = array_merge($aDefaultSymbol, $args);
	// Alter svg/xml based on final array
	foreach($aDefaultSymbolParms as $key => $value) {
		if (strtolower($key) == "title") {
			$oXML->title = $value;
		} elseif (strtolower($key) == "desc") {
			$oXML->desc = $value;
		} elseif (strtolower($key) == "addclasses") {
			// Process this later
		}	else {
			$oXML[$key] = $value;
		}
	}
	if (array_key_exists('addclasses', $aDefaultSymbolParms)) {
		if (strlen($oXML['class']) >= 1) {
			$oXML['class'] = $oXML['class'] . ' ' . $aDefaultSymbolParms['addclasses'];
		} else {
			$oXML['class'] = $aDefaultSymbolParms['addclasses'];
		}
	}
	// If there is a title, add aria-labelledby
	if (property_exists($oXML, 'title')) {
		$sGeneratedID = uniqid('dynid', true);
		$oXML->title['id'] = $sGeneratedID;
		$oXML['aria-labelledby'] = $sGeneratedID;
	}
	// If there is a desc, add aria-describedby
	if (property_exists($oXML, 'desc')) {
		$sGeneratedID = uniqid('dynid');
		$oXML->desc['id'] = $sGeneratedID;
		$oXML['aria-describedby'] = $sGeneratedID;
	}
	// If no_title_id, remove the title id attribute
	if (array_key_exists('no_title_id', $aDefaultSymbolParms)) {
		unset($oXML['no_title_id']);
		unset($oXML->title['id']);
		unset($oXML['aria-labelledby']);
		unset($oXML['aria-describedby']);
	}
	// Return svg result for embedding in html
	return(str_ireplace(' id="'.$symbol_id.'"','',str_ireplace('</symbol>','</svg>',str_ireplace('<symbol ','<svg ',$oXML->asXML()))));
}

if ( ! function_exists( 'news_oembed_filter' ) ) :

	/**
	 * Wrap oembeds in a div for use as a responsive hook
	 *
	 * @return String The oembed markup
	 **/
	function news_oembed_filter($html, $url, $attr, $post_ID) {
		if ( strpos($url, "soundcloud") ) {
			$css_classes = "uw-oembed uw-oembed-soundcloud";
		} elseif ( strpos($url, "youtube") ) {
			$css_classes = " responsive-embed widescreen uw-oembed-video-youtube";
		} elseif ( strpos($url, "vimeo") ) {
			$css_classes = " responsive-embed widescreen uw-oembed-video-vimeo";
		} elseif ( strpos($url, "twitter") ) {
			$css_classes = " uw-oembed uw-oembed-twitter";
		} elseif ( strpos($url, "instagram") ) {
			$css_classes = " uw-oembed uw-oembed-instagram";
		} elseif ( strpos($url, "vine") ) {
			$css_classes = " uw-oembed uw-oembed-vine";
		} else {
			$css_classes = "";
		}
		$return = '<div class="'. $css_classes . '">'.$html.'</div>';
		return $return;
	}

endif;
add_filter( 'embed_oembed_html', 'news_oembed_filter', 10, 4 ) ;


if ( ! function_exists( 'uwmadison_posts_pagination' ) ) :
	/**
	 * filter posts pagination template
	 *
	 * @return String template markup
	 * @author
	 **/
	function uwmadison_posts_pagination( $template, $class) {

		if ("pagination" != $class && "page-links" != $class)
			return $template;

		$links = paginate_links(
			array(
				'mid_size' => 2,
				'type' => 'array',
				'prev_text' => 'Previous <span class="show-for-sr">page</span>',
				'next_text' => 'Next <span class="show-for-sr">page</span>'
			)
		);

		$new_template = '<nav class="pagination-container"  aria-label="Pagination"><ul class="pagination">';

		foreach ($links as $key => $link) {
			$li_classes = array();
			$li_start = '';
			if (strpos($link,"prev page-numbers") !== false)
				$li_classes[] = "pagination-previous";
			if (strpos($link,"next page-numbers") !== false)
				$li_classes[] = "pagination-next";
			if (strpos($link,"page-numbers current") !== false) {
				$li_classes[] = "current";
				$link = "<span class=\"show-for-sr\">You're on page</span> " . strip_tags($link);
			}
			if (!empty($li_classes)) {
				$li_start .= '<li class="' . join(" ", $li_classes) . '">';
			} else {
				$li_start .= '<li>';
			}
			if (strpos($link,"page-numbers dots") !== false) {
				$li_start = '<li class="ellipsis" aria-hidden="true">';
				$link = '';
			}
			$new_template .= $li_start;
			$new_template .= $link;
			$new_template .= '</li>';
		}
		$new_template .= '</ul></nav>';
		return $new_template;
	}
endif;
add_filter( 'navigation_markup_template', 'uwmadison_posts_pagination', 10 ,2 );


/**
 * Remove TinyMCE buttons from full toolbar in ACF wysiwygs
 *
 * @return Array
 **/
function uwmadison_wysiwyg_toolbars($toolbars)
 {
 		// define array of buttons to remove from the full toolbar
		$remove_from_full = array('forecolor');
		foreach ($remove_from_full as $value) {
			// search second row first; it's more likely where we'll remove buttons from
			if( ($key = array_search($value, $toolbars['Full' ][2])) !== false ) {
			  unset( $toolbars['Full' ][2][$key] );
			} elseif( ($key = array_search($value, $toolbars['Full' ][1])) !== false ) {
			  unset( $toolbars['Full' ][1][$key] );
			}
		}
		return $toolbars;
 }
add_filter('acf/fields/wysiwyg/toolbars','uwmadison_wysiwyg_toolbars');


/**
 * Rename theme modifications after activation if options
 * for the new theme name have not been set yet (aside from
 * the default 2 — the two registered menus)
 *
 * @return void
 **/
function copy_theme_mods () {
	$old_options = get_option("theme_mods_uw-theme");
	$new_options = get_option("theme_mods_uw-theme");
	if ( !empty($old_options) && isset($new_options) && count($new_options) == 2) {
		update_option( 'theme_mods_uw-theme', $old_options );
	}
}
add_action('after_switch_theme', 'copy_theme_mods');


if ( ! function_exists( 'uwmadison_archive_title' ) ) :

	/**
	 * Modifies the archive title output to strip words like
	 * 'Archive', 'Category', and 'Tag'.
	 *
	 **/
	function uwmadison_archive_title( $title ) {
	    if ( is_category() ) {
	        $title = single_cat_title( '', false );
	    } elseif ( is_tag() ) {
	        $title = single_tag_title( '', false );
	    } elseif ( is_author() ) {
	        $title = '<span class="vcard">' . get_the_author() . '</span>';
	    } elseif ( is_post_type_archive() ) {
	        $title = post_type_archive_title( '', false );
	    } elseif ( is_tax() ) {
	        $title = single_term_title( '', false );
	    }

	    return $title;
	}

endif;
add_filter( 'get_the_archive_title', 'uwmadison_archive_title' );


if ( ! function_exists( 'uwmadison_add_custom_types' ) ) :

	/**
	 * Modifies the archive query to include any custom post types
	 *
	 **/
	function uwmadison_add_custom_types( $query ) {
	  if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
	    if ( !is_post_type_archive() && $query->is_archive() ) {
	      $post_types = get_post_types( '', 'names' );
	      $query->set( 'post_type', $post_types);
	      return $query;
	    }
	  }
	}

endif;

if(!is_admin()) {
	add_filter( 'pre_get_posts', 'uwmadison_add_custom_types' );
}

/**
	 * Sorts custom post type archives alphabetically by title. Do not apply
	 * when querying for event post types to populate an instance of the Events
	 * Calendar plugin. https://theeventscalendar.com/product/wordpress-events-calendar
	 *
	 **/
function uwmadison_sort_custom_types_alpha($query) {
	if(is_post_type_archive() && $query->get('post_type') !== 'tribe_events') {
		$query->set('order', 'ASC');
		$query->set('orderby', 'title');
	}
}
add_action('pre_get_posts', 'uwmadison_sort_custom_types_alpha');

if ( ! function_exists( 'uwmadison_customize_tmce' ) ) :

	/**
	 * Limit TMCE block formats to p,h2-6
	 *
	 * @return Array The TMCE options arrays
	 **/
	function uwmadison_customize_tmce($options) {
	  $options['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Heading 5=h5;Heading 6=h6';
	  return $options;
	}

endif;
add_filter('tiny_mce_before_init', 'uwmadison_customize_tmce');


if ( ! function_exists( 'uwmadison_page_title' ) ) :

	/**
	 * Add UW–Madison to end of page titles
	 *
	 * @return Array The TMCE options arrays
	 **/
	function uwmadison_page_title( $title ) {
		if ( isset($title['site']) ) {
			$title['site'] .= " - UW–Madison";
		} else {
			$title['site'] = "UW–Madison";
		}
	  return $title;
	}

endif;
add_filter( 'document_title_parts', 'uwmadison_page_title', 999, 1 );


/**
 * Loads the `latest_posts` ACF select field with the child theme's available
 * public custom post types.
 *
 * @param array $field The `latest_posts` select field model whose choice data should be replaced with the child theme's public custom post types.
 * @return array
 */
function load_custom_posts($field) {
  // Only show custom public post types.
  $args = array(
    'public' => true,
    '_builtin' => false
  );
  $post_types = get_post_types($args);

  // Exclude uw_staff from selection.
  unset($post_types['uw_staff']);
  $field['choices'] = $post_types;

  return $field;
}
// Filter by field's name.
add_filter('acf/load_field/name=custom_post_type', 'load_custom_posts');


/** Adds support for Kaltura oEmbed videos using the
 *  code developed by Tony Block for the
 *  UW-Madison Kaltura Enable oEmbed plugin
 *  more info at: https://kb.wisc.edu/page.php?id=56746
 **/
add_action( 'init', 'uwmad_kaltura_add_oembed_handlers');
function uwmad_kaltura_add_oembed_handlers(){
    wp_oembed_add_provider( 'https://mediaspace.wisc.edu/id/*', 'https://mediaspace.wisc.edu/oembed/', false );
}


/** Gravity Forms is initalized in the header before
 *  our jQuery loads, so forms with conditional logic
 *  do not display. This fix is a filter that initializes
 *  GF scripts in the footer: https://goo.gl/kXv3iA
 **/
add_filter('gform_init_scripts_footer', '__return_true');


/** Adds a website issues contact email line.
 *  Uses the admin email as set in Settings -> General unless
 *  a user provides a different email in the Customizer.
 **/
if ( ! function_exists( 'website_issues_contact') ) :

function uwmadison_website_issues_contact() {
  $uwmadison_website_issues_email = get_theme_mod( 'website_issues_email');
  if (empty($uwmadison_website_issues_email)) {
  	$uwmadison_website_issues_email = get_option( 'admin_email' );
  }
  $output = sprintf('Feedback, questions or accessibility issues: <a href="mailto:%s">%s</a>', $uwmadison_website_issues_email, $uwmadison_website_issues_email);

  return $output;
}

endif;

/**
 * Allow custom 404 pages
 *
 **/
function uw_custom_404() {
	global $post;

	// Add edit page link to admin bar on custom 404 pages
	add_action( 'wp_before_admin_bar_render', function() {
    global $wp_admin_bar, $post;
    if ( !is_admin_bar_showing() ) return;
    $wp_admin_bar->add_menu( array(
        'id' => 'edit',
        'parent' => false,
        'title' => __( 'Edit Page'),
				'class' => 'ab-item',
        'href' => get_edit_post_link($post->id)
    ) );
	}, 8 );

	// Add error404 class to body
	add_filter( 'body_class', function($classes) {
        $classes[] = 'error404';
        return $classes;
	});

	// Construct page
	$post = get_post( get_theme_mod( 'uwmadison_404_page_id' ) );
	query_posts( array( 'page_id' => $post->ID ) );
	get_template_part('page');
}

/**
 * Determines whether the post has a custom excerpt.
 *
 * Replaces the WordPress Core `has_excerpt` function.  This replacement goes
 * beyond core functionality by trimming whitespace, and _then_ checks if the
 * excerpt is empty.  Additionally, the PHP `trim` function is enhanced to look
 * for non-breaking space characters, which it does not do by default.
 *
 * @param int|WP_Post $post_id Optional. Post ID or WP_Post object. Default is global $post.
 * @return bool True if the post has a custom excerpt, false otherwise.
 */
function uw_has_excerpt($post_id = 0) {
  $post = get_post($post_id);
  return !empty( trim($post->post_excerpt, " \t\n\r\0\x0B" . chr(0xC2) . chr(0xA0)) );
}

/**
*
*	Generate page builder page excerpt from ACF content
*
*   Performs recursive search of ACF Page Builder to find
*   'text_block_content' fields and uses them to construct
*   an auto generated excerpt that will be saved as post meta
*   with the key "uw_auto_excerpt"
*
*/
function uw_acf_excerpt( $post_id ) {
	global $post;
	$post = get_post( $post_id );

	$primary_content_area = get_post_meta($post_id, "primary_content_area");
	$uses_page_builder = empty( $primary_content_area ) ? false : true;

	if (!$uses_page_builder)
		return;

    ob_start();
    uw_recursive_search(
        array(
            'array' => get_fields( $post_id ),
            'key' => 'text_block_content'
        )
    );
    $content = ob_get_clean();
    remove_action( 'save_post', 'uw_acf_excerpt' );
    update_post_meta($post_id, 'uw_auto_excerpt', wp_trim_words( $content, 55 ));
    add_action( 'save_post', 'uw_acf_excerpt' );
}
add_action( 'save_post', 'uw_acf_excerpt' );

/**
*
*	Replace content of the excerpt with auto generated content (Pages only)
*
*   If the excerpt field is left blank any calls to "the_excerpt" or
*   "get_the_excerpt" will return an auto generated excerpt.
*
*   The auto generated excerpt is saved as post meta with the key "uw_auto_excerpt"
*
*/
function uw_auto_excerpt_filter($post_excerpt, $post){
    if($post->post_type === 'page' && !uw_has_excerpt($post->ID)) {
        return get_post_meta($post->ID, 'uw_auto_excerpt', true);
    }
    return $post_excerpt;
}
add_filter('get_the_excerpt', 'uw_auto_excerpt_filter', null, 2);

// perform recursive array search of ACF fields
function uw_recursive_search( $fields ) {
	if ( !empty( $fields ) ) {
		$array = $fields['array'];
		$key = $fields['key'];
		if ( is_array( $array ) ) {
			if( array_key_exists( $key, $array ) ) {
				echo wp_strip_all_tags( $array[$key] );
			} else if( !array_key_exists( $key, $array ) ) {
				foreach ( $array as $index   =>  $subarray ) {
					if( is_array( $subarray ) ) {
						uw_recursive_search(
							array(
								'array' => $subarray,
								'key' 	=> $key
							)
						);
					}
				}
			}
		}
	}
}

// disable comments on targeted pages
function uw_filter_media_comment_status( $open, $post_id ) {
    $post = get_post( $post_id );
    if( $post->post_type == 'attachment' ) {
        return false;
    }
    return $open;
}
add_filter( 'comments_open', 'uw_filter_media_comment_status', 10 , 2 );


/**
 * Sets the <figure> inline width to max-width so images and captions don't overflow their container
 **/
add_filter( 'img_caption_shortcode', 'uw_img_caption_shortcode', 10, 3 );

function uw_img_caption_shortcode( $empty, $attr, $content ){
    $attr = shortcode_atts( array(
        'id'      => '',
        'align'   => 'alignnone',
        'width'   => '',
        'caption' => ''
    ), $attr );
    if ( 1 > (int) $attr['width'] || empty( $attr['caption'] ) ) {
        return '';
    }
    if ( $attr['id'] ) {
        $attr['id'] = 'id="' . esc_attr( $attr['id'] ) . '" ';
    }
    return '<figure ' . $attr['id']
    . 'class="wp-caption ' . esc_attr( $attr['align'] ) . '" '
    . 'style="max-width: ' . ( (int) $attr['width'] ) . 'px;">'
    . do_shortcode( $content )
    . '<figcaption class="wp-caption-text">' . $attr['caption'] . '</figcaption>'
    . '</figure>';
}

// Hide featured image from post
function hide_featured_image( $content, $post_id ) {
	if ( get_field('hide_featured_image') && is_single( $post_id ) ) {
		return "";
	} else {
		return $content;
	}
}
add_filter( 'post_thumbnail_html', 'hide_featured_image', 10, 2 );

// add tag manager to head
if ( ! function_exists( 'uw_tag_manager_head' ) ) :
	function uw_tag_manager_head() {
		if ( is_user_logged_in() )
			return false;

		$gtm_tracking_id = get_theme_mod('uwmadison_gtm_tracking_id', false);

		if (!$gtm_tracking_id)
			return false;
		?>
			<!-- Google Tag Manager -->
			<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer', '<?php echo $gtm_tracking_id; ?>');</script>
			<!-- End Google Tag Manager -->
		<?php
	}
endif;
add_action('uw_after_head_open_tag', 'uw_tag_manager_head', 0);

// add tag manager to body
if ( ! function_exists( 'uw_tag_manager_body' ) ) :
	function uw_tag_manager_body() {
		if ( is_user_logged_in() )
			return false;

		$gtm_tracking_id = get_theme_mod('uwmadison_gtm_tracking_id', false);

		if (!$gtm_tracking_id)
			return false;
		?>
			<!-- Google Tag Manager (noscript) -->
			<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $gtm_tracking_id; ?>"
			height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
			<!-- End Google Tag Manager (noscript) -->
		<?php
	}
endif;
add_action('uw_after_body_open_tag', 'uw_tag_manager_body', 0);

// Fixes the favicon showing the default WordPress icon instead of the
// university-branded crest "W" icon. This functionality was changed by
// WordPress with the Core v5.4.0 release.
//
// The code must `exit` as this is a WordPress 302 redirect for `favicon.ico`.
//
// Related reading: https://make.wordpress.org/core/2020/02/19/enhancements-to-favicon-handling-in-wordpress-5-4/
function uw_favicon_root() {
  $favicon = get_site_icon_url(16, get_template_directory_uri() . '/dist/images/favicon.ico');

  if ($favicon) {
    wp_redirect($favicon);
  }

  exit;
}
add_action('do_faviconico', 'uw_favicon_root');

// This function inserts the icons for apple and android mobile devices.
if (!function_exists('uw_default_favicon')) {
  function uw_default_favicon() {
    ?>
    <link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/dist/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/dist/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/dist/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/dist/images/favicons/site.webmanifest">
    <link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/dist/images/favicons/safari-pinned-tab.svg" color="#c5050c">
    <link rel="icon" href="/favicon.ico">
    <meta name="msapplication-TileColor" content="#c5050c">
    <meta name="msapplication-config" content="<?php echo get_template_directory_uri(); ?>/dist/images/favicons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <?php
  }
}
add_action('uw_favicon', 'uw_default_favicon');

function social_media_meta_tags(){
  global $post;
  if ($post === NULL || is_search()) {
    return;
  }

	if ( is_archive() ) {
	  $title = get_the_archive_title();
	} else {
	  $title = get_the_title();
	}
	$title = strip_tags($title);

  $thumb = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'large');
  $thumb_url = ( !empty($thumb[0]) ) ? $thumb[0] : false;
  $thumb_height = ( !empty($thumb[2]) ) ? $thumb[2] : false;
  $thumb_width = ( !empty($thumb[1]) ) ? $thumb[1] : false;

  if (is_singular()) {
      $excerpt = get_the_excerpt($post->ID);
  } elseif ( get_the_archive_description() ) {
        $excerpt = get_the_archive_description();
  } else {
        $excerpt = get_bloginfo('description');
  }
  $excerpt = trim(strip_tags($excerpt));
  ?>
	<meta name="description" content="<?php echo $excerpt; ?>" />

	<!-- Schema.org markup for Google+ -->
	<meta itemprop="name" content="<?php echo $title; ?>">
	<meta itemprop="description" content="<?php echo $excerpt; ?>">
	<?php if ( $thumb_url ) : ?>
		<meta itemprop="image" content="<?php echo $thumb_url; ?>">
	<?php endif; ?>

	<!-- Open Graph data -->
	<?php if ( is_single() ) : ?>
		<meta property="og:type" content="article" />
		<meta property="article:published_time" content="<?php echo get_the_date(get_the_ID()); ?>" />
		<meta property="article:modified_time" content="<?php echo get_the_modified_date(get_the_ID()); ?>" />
	<?php else: ?>
		<meta property="og:type" content="website" />
	<?php endif; ?>

	<meta property="og:title" content="<?php echo $title; ?>" />
	<meta property="og:url" content="<?php the_permalink(); ?>" />
	<meta property="og:description" content="<?php echo $excerpt; ?>" />
	<meta property="og:site_name" content="<?php echo get_bloginfo(); ?>" />
	<?php if ( $thumb_url && (( $thumb_width > 200 ) && ( $thumb_height > 200 ))) : ?>
		<meta property="og:image" content="<?php echo $thumb_url; ?>" />
		<meta property="og:image:alt" content ="<?php echo $title; ?>" />
		<meta property="og:image:width" content="<?php echo $thumb_width; ?>"/>
		<meta property="og:image:height" content="<?php echo $thumb_height; ?>"/>
	<?php endif; ?>

	<!-- Twitter Card data -->
	<?php if (( $thumb_width > 300 ) && ( $thumb_height > 157 )) : ?>
		<meta name="twitter:card" content="summary_large_image" />
	<?php elseif (( $thumb_width > 144 ) && ( $thumb_height > 144 )) : ?>
		<meta name="twitter:card" content="summary" />
	<?php endif; ?>

	<meta name="twitter:title" content="<?php echo $title; ?>" />
	<meta name="twitter:description" content="<?php echo $excerpt; ?>" />
	<?php if ( $thumb_url && (( $thumb_width > 144 ) && ( $thumb_height > 144 ))) : ?>
		<meta name="twitter:image" content="<?php echo $thumb_url; ?>" />
		<meta name="twitter:image:src" content="<?php echo $thumb_url; ?>" />
		<meta name="twitter:image:alt" content="<?php echo $title; ?>" />
	<?php endif; ?>
	<?php // Action hook for apending additional meta tag
		do_action( 'uw_social_media_meta_tags' ); ?>
  <?php
}

add_action('wp_head', 'social_media_meta_tags');

/**
 *
 * Add Google Search Console Site Verification Meta Tag
 *
 * https://support.google.com/webmasters/answer/35179
 *
 */

if ( ! function_exists( 'uw_google_verification' ) ) {
	function uw_google_verification() {
		$uwmadison_google_console_id = get_theme_mod('uwmadison_google_console_id', false);
		if (!$uwmadison_google_console_id)
			return false;
			echo '<meta name="google-site-verification" content="' . $uwmadison_google_console_id . '" />';
	}
}
add_action('wp_head', 'uw_google_verification');

/*
* Enqueues the cookie consent script. You can override this function in a
* child theme to pass options to the script. Available options are:
*  var options = {
                 "enabled": true, // false disables the dialog
                 "testing": false // set to true for development environments only
              }
*
* Note that the script is only enqueued if the domain of the website ends
* in wisc.edu. The script will not work as intended on other domains.
*
*/
if(!function_exists('uwmadison_cookie_consent_script')) {
	function uwmadison_cookie_consent_script() {
		$url = get_home_url();
		if(substr($url, -8, 8) === 'wisc.edu') {
			$version = '1.0.1';
			$url = 'https://cdn.wisc.cloud/cookie-consent/'.$version.'/uwcookieconsent.min.js';
			wp_enqueue_script('uw-cookie-consent', $url, array(), $version, true);
			$script = 'window.addEventListener("load", function(){window.cookieconsent.initialize()});';
			wp_add_inline_script('uw-cookie-consent', $script, 'after');
		}
	}
}
add_action('wp_enqueue_scripts', 'uwmadison_cookie_consent_script');

/**
*
*	Show the excerpt metabox in editor by default
*
*/
function uw_show_excerpt_by_default() {
	global $current_screen;

	// Pages
	if ( 'page' == $current_screen->id ) {
		$user = wp_get_current_user();
		// Get array of hidden fields
		$hidden_metaboxes = get_user_meta( $user->ID, 'metaboxhidden_page', true );

		// If the $hidden_metaboxes variable is NOT an array, array_search will die
		if (!is_array($hidden_metaboxes)) $hidden_metaboxes = [ $hidden_metaboxes ];

		$key = array_search( 'postexcerpt', $hidden_metaboxes );
		// Check if 'postexcerpt' is hidden
		if ( FALSE !== $key ) {
			// Remove 'postexcerpt' from array of hidden metaboxes
			array_splice( $hidden_metaboxes, $key, 1 );
			update_user_meta( $user->ID, 'metaboxhidden_page', $hidden_metaboxes );
		}
	}

	// Posts
	if ( 'post' == $current_screen->id ) {
		$user = wp_get_current_user();
		// Get array of hidden fields
		$hidden_metaboxes = get_user_meta( $user->ID, 'metaboxhidden_post', true );

		// If the $hidden_metaboxes variable is NOT an array, array_search will die
		if (!is_array($hidden_metaboxes)) $hidden_metaboxes = [ $hidden_metaboxes ];

		$key = array_search( 'postexcerpt', $hidden_metaboxes );
		// Check if 'postexcerpt' is hidden
		if ( FALSE !== $key ) {
			// Remove 'postexcerpt' from array of hidden metaboxes
			array_splice( $hidden_metaboxes, $key, 1 );
			update_user_meta( $user->ID, 'metaboxhidden_post', $hidden_metaboxes );
		}
	}
}
add_action( 'current_screen', 'uw_show_excerpt_by_default', 10 );
