<?php
/**
 * The template for displaying search forms in UW-Madison
 *
 * @package WordPress
 * @subpackage UW_Madison
 * @since UW-Madison 1.0
 */
?>
  <form role="search" class="uw-search-form" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label for="s" class="show-for-sr"><?php _e( 'Search', 'uw-theme' ); ?></label>
    <input type="text" class="field uw-search-input" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'uw-theme' ); ?>" />
    <input type="submit" class="submit uw-search-submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'uw-theme' ); ?>" />
  </form>
