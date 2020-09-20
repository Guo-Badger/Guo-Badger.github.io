<?php
/**
 * The sidebar for the theme.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package UW Theme
 */
?>

<?php if ( (is_home() || is_singular('post')) && is_active_sidebar( 'sidebar-blog' )  ) : ?>
  <aside id="secondary" class="sidebar widget-area">
    <?php dynamic_sidebar( 'sidebar-blog' ); ?>
  </aside>
<?php endif; ?>

<?php if ( (is_search() || is_archive()) && is_active_sidebar( 'sidebar-archive' )  ) : ?>
  <aside id="secondary" class="sidebar widget-area">
    <?php dynamic_sidebar( 'sidebar-archive' ); ?>
  </aside>
<?php endif; ?>