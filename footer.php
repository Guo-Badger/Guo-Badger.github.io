<?php
/**
 * The template for displaying the footer.
 *
 * @package UW Theme
 */
?>

  <?php
  /* Hook for adding custom code before the <footer>
   * In a child theme, add a function like this:
   *
   *     function your_custom_code() {
   *      // your custom code here
   *      }
   *      add_action('uw_before_footer', 'your_custom_code');
   *
   * More about hooks: https://developer.wordpress.org/reference/functions/do_action/
  */
  do_action('uw_before_footer');
  ?>

	<footer id="colophon" class="uw-footer">
    <h2 class="show-for-sr uw-footer-header">Site footer content</h2>
		<div class="uw-footer-content">
			<div class="uw-logo">
				<a href="http://www.wisc.edu" aria-label="Link to main university website">
          <?php echo get_svg('uw-symbol-crest-footer', array("title"=>"University logo that links to main university website")); ?>
        </a>
			</div>
      <?php
        for ($i = 1; $i <= 2; $i++) {

          $uwmadison_footer_menu = wp_get_nav_menu_object( get_theme_mod("uwmadison_footer_menu_$i",null) );

          if ( $uwmadison_footer_menu ) { ?>
              <div>
                <h3 class="uw-footer-header"><?php echo $uwmadison_footer_menu->name ?></h3>
                <?php
                  wp_nav_menu(
                    array(
                      'menu'=>$uwmadison_footer_menu->term_id,
                      'menu_class'=>'',
                      'menu_id'=>'',
                      'container'=>null

                    )
                  );
                ?>
              </div>

        <?php } ?>
      <?php } ?>

			<?php echo uwmadison_footer_contact(); ?>
		</div>

    <?php
    /* Adding custom content to the footer
     *
     * There are two ways to add your own custom content inside
     * the footer.
     *
     * Option 1: Use a hook (recommended)
     *    In a child theme, add a function like this:
     *
     *     function your_custom_code() {
     *      // your custom code here
     *      }
     *      add_action('uw_inside_footer', 'your_custom_code');
     *
     *    More about hooks: https://developer.wordpress.org/reference/functions/do_action/
    */
    do_action('uw_inside_footer');

    /* Option 2: Template partial
     *    This option works just as well as the hook, but for consistency,
     *    we recommend using option 1 whenever possible.
     *    To use the template partial, make a copy in your child theme of the
     *    blank file found here: content-parts/page-elements/footer-content.php
     */
    get_template_part('content-parts/page-elements/footer', 'content');

    ?>

		<div class="uw-copyright">
            <p><?php echo uwmadison_website_issues_contact(); ?>.</p>
            <p>This site was built using the <a href="https://uwtheme.wordpress.wisc.edu/">UW Theme</a> | <?php echo uwmadison_footer_privacy(); ?> | &copy; <?php echo date('Y'); ?> Board of Regents of the <a href="http://www.wisconsin.edu">University of Wisconsin System.</a>
            </p>
            <?php
            /* Hook for adding custom code inside the uw-copyright content area
             * In a child theme, add a function like this:
             *
             *     function your_custom_code() {
             *      // your custom code here
             *      }
             *      add_action('uw_inside_copyright', 'your_custom_code');
             *
             * More about hooks: https://developer.wordpress.org/reference/functions/do_action/
            */
            do_action('uw_inside_copyright');
        ?>

    </div>

	</footer>

  <?php
  /* Hook for adding custom code after the <footer>
   * In a child theme, add a function like this:
   *
   *     function your_custom_code() {
   *      // your custom code here
   *      }
   *      add_action('uw_after_footer', 'your_custom_code');
   *
   * More about hooks: https://developer.wordpress.org/reference/functions/do_action/
  */
  do_action('uw_after_footer');
  ?>

  <?php wp_footer(); ?>
</body>
</html>
