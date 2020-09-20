<?php
/**
 * The header for the theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package UW Theme
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<?php
	/* Hook for adding custom code after the <head> tag.
	 * In a child theme, add a function like this:
	 *
	 *     function your_custom_code() {
	 * 	    // your custom code here
	 *      }
	 *      add_action('uw_after_head_open_tag', 'your_custom_code');
	 *
	 * More about hooks: https://developer.wordpress.org/reference/functions/do_action/
	*/
	do_action('uw_after_head_open_tag');
	?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( !has_site_icon() ) :
		do_action('uw_favicon');
	endif; ?>
	<script>(function(H){H.className=H.className.replace(/\bno-js\b/,'')})(document.documentElement)</script>

	<?php wp_head(); ?>

	<?php
		// get theme mods
	  $uwmadison_title_style = get_theme_mod('uwmadison_main_title_color','uw-red-title');
		$uwmadison_header_style = get_theme_mod('uwmadison_header_style','uw-white-top-bar');
		$uwmadison_tagline_url = get_theme_mod('uwmadison_tagline_url', null);
	?>
</head>

<body <?php body_class(); ?>>
<?php
	/** 
	 * WP body open action, added in WordPress v5.2
	 *
	 * This action was created to replace custom actions that immediately follow
	 * the opening body tag. It is required for compatibility with some plugins.
	 *
	*/
	wp_body_open();
?>
<a class="show-on-focus" href="#main" id="skip-link">Skip to main content</a>

	<?php
	/* Hook for adding custom code after the <body> tag.
	 * In a child theme, add a function like this:
	 *
	 *     function your_custom_code() {
	 * 	    // your custom code here
	 *      }
	 *      add_action('uw_after_body_open_tag', 'your_custom_code');
	 *
	 * More about hooks: https://developer.wordpress.org/reference/functions/do_action/
	*/
	do_action('uw_after_body_open_tag');
	?>

	<div class="uw-global-bar <?php echo ($uwmadison_header_style == "uw-white-top-bar") ? "uw-global-bar-inverse" : "" ?>" role="navigation">
		<a class="uw-global-name-link" href="http://www.wisc.edu" aria-label="University of Wisconsin Madison home page">U<span>niversity <span class="uw-of">of</span> </span>W<span>isconsin</span>–Madison</a>
	</div>
	<header class="uw-header <?php echo (site_uses_search()) ? "uw-has-search" : ""; ?>">
		<div class="uw-header-container">
			<div class="uw-header-crest-title">
				<?php get_template_part('content-parts/page-elements/header', 'crest'); ?>
				<div class="uw-title-tagline">
					<?php $title_tag = is_front_page() ? "h1" : "div"; ?>
					<<?php echo $title_tag; ?> id="site-title" class="uw-site-title <?php echo $uwmadison_title_style;?> ">
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo get_bloginfo( 'name', 'display' ); ?></a>
					</<?php echo $title_tag; ?>>

					<?php 
						$tagline = get_bloginfo( 'description', 'display' ); 
						if ( !empty($tagline) && !empty($uwmadison_tagline_url) ) {
						 	$tagline = '<a href="' . esc_url($uwmadison_tagline_url) . '">' . $tagline . '</a>';
						 } 
					?>

					<?php if (!empty($tagline)) { ?>
						<div id="site-description" class="uw-site-tagline"><?php echo $tagline ?></div>
					<?php } ?>
				</div>
			</div>
			<?php
				if (site_uses_search()) { ?>
					<div class="uw-header-search">
						<?php get_search_form();?>
					</div>
			<?php } ?>
		</div>
	</header><!-- #branding -->

	<?php
	/* Hook for adding custom code after the <header>.
	 * In a child theme, add a function like this:
	 *
	 *     function your_custom_code() {
	 * 	    // your custom code here
	 *      }
	 *      add_action('uw_after_header', 'your_custom_code');
	 *
	 * More about hooks: https://developer.wordpress.org/reference/functions/do_action/
	*/
	do_action('uw_after_header');
	?>

	<?php if (has_any_menus()) { ?>
		<button class="uw-mobile-menu-button-bar <?php echo ($uwmadison_header_style == "uw-white-top-bar") ? "" : "uw-mobile-menu-button-bar-reversed" ?>" aria-label="Open menu" aria-expanded="false" aria-controls="uw-top-menus"><span>Menu</span><?php echo get_svg('uw-symbol-menu'); echo get_svg('uw-symbol-close'); ?></button>

		<div id="uw-top-menus" class="uw-is-visible uw-horizontal uw-hidden" aria-hidden="false">
			<?php if (has_main_menu()) { ?>
				<div class="uw-main-nav">
					<?php
						/* Our navigation menu. If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assigned to the primary location is the one used. If one isn't assigned, the menu with the lowest ID is used. */
							$menu_class = "uw-nav-menu";
							$menu_class .= ($uwmadison_header_style == "uw-white-top-bar") ? "" : " uw-nav-menu-reverse";
					?>
					<nav class="<?php echo $menu_class; ?>" aria-label="<?php _e( 'Main Menu', 'uw-theme' ); ?>">
						<?php
							$fallback_cb = (uses_fallback_menu()) ? 'uwmadison_page_menu_fallback' : false;
							wp_nav_menu(
								array(
									'theme_location' => 'main_menu',
									'container' => false,
									'menu_id' => "uw-main-nav",
									'menu_class' => false,
									'depth' => 2,
									'walker' => new Aria_Walker_Nav_Menu(),
									'fallback_cb' => $fallback_cb
								)
							); ?>
					</nav>
				</div>
			<?php } ?>
			<?php if (has_secondary_menu()) { ?>
				<div class="uw-secondary-nav">
					<?php
						$menu_class = "uw-nav-menu uw-nav-menu-secondary";
						$menu_class .= ($uwmadison_header_style == "uw-white-top-bar") ? " uw-nav-menu-secondary-reverse" : ""; ?>
						<nav class="<?php echo $menu_class; ?>" aria-label="<?php _e( 'Secondary Menu', 'uw-theme' ); ?>">
							<?php
								wp_nav_menu(
									array(
										'theme_location' => 'utility_menu',
										'container' => false,
										'menu_id' => "uw-secondary-nav",
										'menu_class' => 'utility-menu',
										'depth' => 2,
										'walker' => new Aria_Walker_Nav_Menu(),
										'fallback_cb' => false
									)
								);
							?>
						</nav>
				</div>
			<?php
			}

			/* Hook for adding custom code after all menus.
			 * This is inside of the .uw-top-menus wrapper, so anything
			 * added here will go inside the collapsed/hamburger/mobile menu
			 * In a child theme, add a function like this:
			 *
			 *     function your_custom_code() {
			 * 	    // your custom code here
			 *      }
			 *      add_action('uw_after_menus_inside', 'your_custom_code');
			 *
			 * More about hooks: https://developer.wordpress.org/reference/functions/do_action/
			*/
			do_action('uw_after_menus_inside');
			?>

		</div>
	<?php } ?>

	<?php
	/* Hook for adding custom code after all menus.
	 * This is outside of the .uw-top-menus wrapper, so it will add
	 * your custom code outside of the collapsed/hamburger/mobile menu
	 * In a child theme, add a function like this:
	 *
	 *     function your_custom_code() {
	 * 	    // your custom code here
	 *      }
	 *      add_action('uw_after_menus_outside', 'your_custom_code');
	 *
	 * More about hooks: https://developer.wordpress.org/reference/functions/do_action/
	*/
	do_action('uw_after_menus_outside');
	?>

