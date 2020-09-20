<?php
/**
 * Theme Customizer.
 *
 * @package UW Theme
 */

require_once("menu-dropdown-custom-control.php");

/**
 * Implements UW-Madison theme options into Theme Customizer
 *
 * @param $wp_customize Theme Customizer object
 * @return void
 *
 * @since UW-Madison 1.3
 */
function uwmadison_customize_register( $wp_customize ) {
  $defaults = uwmadison_get_default_theme_mods();

  $wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
  $wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';


  // Add settings sections
  $wp_customize->add_section( 'uwmadison_colors', array(
    'title'    => __( 'Colors', 'uw-theme' ),
    'priority' => 40,
  ) );
  $wp_customize->add_section( 'uwmadison_search', array(
    'title'    => __( 'Search Options', 'uw-theme' ),
    'priority' => 145,
  ) );
  $wp_customize->add_section( 'uwmadison_footer', array(
    'title'    => __( 'Footer', 'uw-theme' ),
    'priority' => 140,
  ) );
  $wp_customize->add_section( 'uwmadison_analytics', array(
    'title'    => __( 'Google Services', 'uw-theme' ),
    'priority' => 150,
  ) );
  $wp_customize->add_section( 'uwmadison_menu_options', array(
    'title' => __( 'Menu options', 'uw-theme' ),
    'priority' => 10,
    'panel'    => 'nav_menus'
  ) );
  $wp_customize->add_section( 'uwmadison_breadcrumbs', array(
    'title'    => __( 'Breadcrumbs', 'uw-theme' ),
    'priority' => 155,
  ) );
	$wp_customize->add_section( 'uwmadison_404_page' , array(
		'title'       => __( 'Custom 404 Page', 'uw-theme' ),
		'priority'    => 165
  ) );


  // Add colors and typography settings and controls
  $wp_customize->add_setting( 'uwmadison_tagline_url', array(
    'default'           => $defaults['uwmadison_tagline_url'],
    'sanitize_callback' => 'esc_url_raw'
  ) );
  $wp_customize->add_control( 'uwmadison_tagline_url', array(
    'section'    => 'title_tagline',
    'label' => 'Tagline URL',
    'capability'        => 'edit_theme_options',
  ) );

  // Add colors and typography settings and controls
  $wp_customize->add_setting( 'uwmadison_main_title_color', array(
    'default'           => $defaults['uwmadison_main_title_color'],
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->get_setting( 'uwmadison_main_title_color' )->transport = 'postMessage';
  $wp_customize->add_control( 'uwmadison_main_title_color', array(
    'section'    => 'uwmadison_colors',
    'label' => 'Main Title color',
    'type'       => 'radio',
    'choices'    => uwmadison_get_settings_choices( 'titlecolors' ),
    'capability'        => 'edit_theme_options',
  ) );

  $wp_customize->add_setting( 'uwmadison_body_bg', array(
    'default'           => $defaults['uwmadison_body_bg'],
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->get_setting( 'uwmadison_body_bg' )->transport = 'postMessage';
  $wp_customize->add_control( 'uwmadison_body_bg', array(
    'section'    => 'uwmadison_colors',
    'label' => 'Page background color',
    'type'       => 'radio',
    'choices'    => uwmadison_get_settings_choices( 'bgcolors' ),
    'capability'        => 'edit_theme_options',
  ) );

  $wp_customize->add_setting( 'uwmadison_header_style', array(
    'default'           => $defaults['uwmadison_header_style'],
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->get_setting( 'uwmadison_header_style' )->transport = 'postMessage';
  $wp_customize->add_control( 'uwmadison_header_style', array(
    'section'    => 'uwmadison_colors',
    'label' => 'Menu bar colors',
    'type'       => 'radio',
    'choices'    => uwmadison_get_settings_choices( 'header_styles' ),
    'capability'        => 'edit_theme_options',
  ) );


  // Add search settings and controls
  $wp_customize->add_setting( 'uwmadison_use_search', array(
    'default'           => $defaults['uwmadison_use_search'],
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'uwmadison_use_search', array(
    'section'    => 'uwmadison_search',
    'label'      => 'Use search on this site',
    'type'       => 'checkbox'
  ) );
  $wp_customize->add_setting( 'uwmadison_google_cse_id', array(
    'default'           => $defaults['uwmadison_google_cse_id'],
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'uwmadison_google_cse_id', array(
    'section'    => 'uwmadison_search',
    'label'      => 'Optional: Using Google Search',
    'description' => 'By default, this theme uses the native Wordpress search. If you prefer to use a Google Custom Search Engine, enter its GCSE ID below. See <a href="https://kb.wisc.edu/wiscweb/page.php?id=69294">KB doc</a> for help with setting up a Google Custom Search Engine.',
    'input_attrs' => array(
      'placeholder' => 'Enter GCSE ID'
    )
  ) );
	$wp_customize->add_setting( 'uwmadison_google_console_id', array(
    'default'           => "",
    'sanitize_callback' => 'sanitize_text_field',
  ) );
	$wp_customize->add_control( 'uwmadison_google_console_id', array(
    'section'    => 'uwmadison_analytics',
    'label'      => 'Google Search Console Verification',
    'description' => 'See <a href="https://kb.wisc.edu/wiscwebcms/page.php?id=90062">KB doc</a> for help generating a Google Site Verification ID.',
    'input_attrs' => array(
      'placeholder' => 'Google Site Verification ID'
    ),
		'priority'    => 100,
  ) );


  // add menu fallback option
  $wp_customize->add_setting( 'uwmadison_menu_pages_fallback', array(
    'default'           => $defaults['uwmadison_menu_pages_fallback'],
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'uwmadison_menu_pages_fallback', array(
    'section'    => 'uwmadison_menu_options',
    'label' => 'Add all published pages to menu',
    'description' => 'Check this option if you want your main menu to use your published pages instead of a defined menu.',
    'type'        => 'checkbox'
  ) );


  // add footer contact and social
  $wp_customize->add_setting( 'uwmadison_address', array(
    'sanitize_callback' => 'sanitize_textarea',
  ) );
  $wp_customize->add_control( 'uwmadison_address', array(
    'section'    => 'uwmadison_footer',
    'label'      => 'Campus address',
    'type'       => 'textarea',
    'input_attrs' => array(
      'rows' => '4'
    )
  ) );
  $wp_customize->add_setting( 'uwmadison_map_url', array(
    'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'uwmadison_map_url', array(
    'section'    => 'uwmadison_footer',
    'label'      => 'Map URL'
  ) );

  $wp_customize->add_setting( 'uwmadison_email', array(
    'sanitize_callback' => 'sanitize_email',
  ) );
  $wp_customize->add_control( 'uwmadison_email', array(
    'section'    => 'uwmadison_footer',
    'label' => 'Contact email'
  ) );

  $wp_customize->add_setting( 'uwmadison_phone', array(
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'uwmadison_phone', array(
    'section'    => 'uwmadison_footer',
    'label' => 'Contact phone'
  ) );

  $wp_customize->add_setting( 'uwmadison_social[facebook]', array(
    'sanitize_callback' => 'esc_url_raw',
  ) );
  $wp_customize->add_control( 'uwmadison_social[facebook]', array(
    'section'    => 'uwmadison_footer',
    'label' => 'Facebook URL'
  ) );

  $wp_customize->add_setting( 'uwmadison_social[twitter]', array(
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'uwmadison_social[twitter]', array(
    'section'    => 'uwmadison_footer',
    'label' => 'Twitter URL'
  ) );

  $wp_customize->add_setting( 'uwmadison_social[instagram]', array(
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'uwmadison_social[instagram]', array(
    'section'    => 'uwmadison_footer',
    'label' => 'Instagram URL'
  ) );

  $wp_customize->add_setting( 'uwmadison_social[youtube]', array(
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'uwmadison_social[youtube]', array(
    'section'    => 'uwmadison_footer',
    'label' => 'Youtube URL'
  ) );

  $wp_customize->add_setting( 'uwmadison_social[linkedin]', array(
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'uwmadison_social[linkedin]', array(
    'section'    => 'uwmadison_footer',
    'label' => 'LinkedIn URL'
  ) );

  $wp_customize->add_setting( 'uwmadison_social[flickr]', array(
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'uwmadison_social[flickr]', array(
    'section'    => 'uwmadison_footer',
    'label' => 'Flickr URL'
  ) );

  $wp_customize->add_setting( 'uwmadison_social[pinterest]', array(
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'uwmadison_social[pinterest]', array(
    'section'    => 'uwmadison_footer',
    'label' => 'Pinterest URL'
  ) );

  $wp_customize->add_setting( 'uwmadison_footer_menu_1', array(
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( new Menu_Dropdown_Custom_Control( $wp_customize, 'uwmadison_footer_menu_1', array(
      'label'   => 'Footer Menu 1',
      'section' => 'uwmadison_footer',
      'settings'   => 'uwmadison_footer_menu_1',
      'priority' => 90
  ) ) );

  $wp_customize->add_setting( 'uwmadison_footer_menu_2', array(
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( new Menu_Dropdown_Custom_Control( $wp_customize, 'uwmadison_footer_menu_2', array(
      'label'   => 'Footer Menu 2',
      'section' => 'uwmadison_footer',
      'settings'   => 'uwmadison_footer_menu_2',
      'priority' => 100
  ) ) );

  // Adds site contact for questions, reporting issues, accessibility
  $default_admin_email = get_option( 'admin_email' );
  $wp_customize->add_setting( 'website_issues_email', array(
    'sanitize_callback' => 'sanitize_email',
  ) );
  $wp_customize->add_control( 'website_issues_email', array(
    'section'    => 'uwmadison_footer',
    'priority' => 100,
    'label' => __('Website issues contact'),
    'description' => __('Used for feedback, questions or accessibility issues. Default is the site admin email from Settings -> General. <a href="https://it.wisc.edu/services/email-lists-wisclist/" title="Email lists (WiscList)">Learn about options for group email lists (WiscList)</a>.'),
    'input_attrs' => array(
      'placeholder' => '',
    ),
  ) );


  // adds google analytics section
  $wp_customize->add_setting( 'uwmadison_ga_tracking_id', array(
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'uwmadison_ga_tracking_id', array(
    'section'    => 'uwmadison_analytics',
    'label' => 'Google Analytics Tracking ID'
  ) );

		// adds google analytics section
  $wp_customize->add_setting( 'uwmadison_gtm_tracking_id', array(
    'sanitize_callback' => 'sanitize_text_field',
  ) );
  $wp_customize->add_control( 'uwmadison_gtm_tracking_id', array(
    'section'    => 'uwmadison_analytics',
    'label' => 'Google Tag Manager Tracking ID'
  ) );

  // adds breadcrumbs section
  $wp_customize->add_setting( 'uwmadison_breadcrumbs', array(
    'default'           => $defaults['uwmadison_breadcrumbs'],
    'sanitize_callback' => 'sanitize_key',
  ) );
  $wp_customize->add_control( 'uwmadison_breadcrumbs', array(
    'section'    => 'uwmadison_breadcrumbs',
    'label'      => 'Use breadcrumbs on this site',
    'type'       => 'checkbox'
  ) );


	// add custom 404 page options
	$wp_customize->add_setting( 'uwmadison_404_page_id' );
	$wp_customize->add_control( 'uwmadison_404_page_id', array(
			'label'    => __( 'Custom 404 Page', 'uw-theme' ),
			'section'  => 'uwmadison_404_page',
			'settings' => 'uwmadison_404_page_id',
			'description' => 'Leave blank to display default 404 page.',
			'type'     => 'dropdown-pages'
	) );

}
add_action( 'customize_register', 'uwmadison_customize_register' );


/**
 * Returns the default options for UW-Madison.
 *
 * @return Array default values for each setting
 * @since UW-Madison 1.0
 */
function uwmadison_get_default_theme_mods() {
  $default_theme_mods = array(
    'uwmadison_tagline_url' => null,
    'uwmadison_header_style' => 'uw-white-top-bar',
    'uwmadison_main_title_color' => 'uw-red-title',
    'uwmadison_body_bg' => 'uw-white-bg',
    'uwmadison_use_search' => false,
    'uwmadison_google_cse_id' => null,
    'uwmadison_menu_pages_fallback' => false,
    'uwmadison_breadcrumbs' => true
  );

  if ( is_rtl() )
    $default_theme_mods['uwmadison_theme_layout'] = 'sidebar-content';

  return apply_filters( 'uwmadison_get_default_theme_mods', $default_theme_mods );
}


/**
 * Settings options array for uw-madison theme settings
 *
 * @return Array The settings options array
 * @since UW-Madison 2.0
 **/
function uwmadison_setting_options() {

  $setting_options = array(
    'titlecolors' => array(
      'uw-red-title' => array(
        'value' => 'uw-red-title',
        'label' => __( 'Badger Red', 'uw-theme' )
      ),
      'uw-dark-gray-title' => array(
        'value' => 'uw-dark-gray-title',
        'label' => __( 'Gray', 'uw-theme' )
      ),
      'uw-white-title' => array(
        'value' => 'uw-white-title',
        'label' => __( 'White (dark backgrounds only)', 'uw-theme' )
      ),
    ),

    'bgcolors' => array(
      'uw-white-bg' => array(
        'value' => 'uw-white-bg',
        'label' => __( 'White', 'uw-theme' )
      ),
      'uw-light-gray-bg' => array(
        'value' => 'uw-light-gray-bg',
        'label' => __( 'Light gray', 'uw-theme' )
      ),
    ),

    'header_styles' => array(
      'uw-red-top-bar' => array(
        'value' => 'uw-red-top-bar',
        'label' => __( 'Red top bar, white main menu', 'uw-theme' )
      ),
      'uw-white-top-bar' => array(
        'value' => 'uw-white-top-bar',
        'label' => __( 'White top bar, red main menu', 'uw-theme' )
      ),
    )
  );

  return apply_filters( 'uwmadison_setting_options', $setting_options );
}


/**
 * Return values and options for requested setting to be use in add_control()
 *
 * @param String $setting The key for the setting
 * @return Array Value and options for the setting
 * @since UW-Madison 2.0
 **/
function uwmadison_get_settings_choices( $setting ){
  $choices = array();
  $setting_options = uwmadison_setting_options();
  foreach ( $setting_options[$setting] as $option ) {
    $choices[$option['value']] = $option['label'];
  }
  return $choices;
}


/**
 * Sanitize and preserve new lines
 *
 * @return String
 **/
function sanitize_textarea($text) {
  return esc_textarea( $text );
}


/**
 * Print JS for customizer UI
 *
 * @return void
 * @since UW-Madison 2.0
 */
function uwmadison_customizer_js() {
  wp_enqueue_script( 'uwmadison-customizer-js', get_template_directory_uri() . '/dist/js/customizer-ui.js', array( 'jquery' ), '2.0', true );
}
add_action( 'customize_controls_print_footer_scripts', 'uwmadison_customizer_js' );


/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 * Used with blogname and blogdescription.
 *
 * @return void
 * @since UW-Madison 1.3
 */
function uwmadison_customize_preview_js() {
  wp_enqueue_script( 'uwmadison-customizer-preview', get_template_directory_uri() . '/dist/js/customizer-preview.js', array( 'customize-preview' ), '2.0', true );
}
add_action( 'customize_preview_init', 'uwmadison_customize_preview_js' );


/**
 * Load custom CSS for customizer UI layout option
 *
 * @return void
 **/
function uw_customizer_css() { ?>
  <style>
    #accordion-section-uwmadison_menu_options {
      margin-bottom: 15px;
    }
    #customize-control-uwmadison_menu_pages_fallback .description {
      margin-top: .5rem;
    }
  </style>
<?php }
add_action('customize_controls_print_styles', 'uw_customizer_css');
