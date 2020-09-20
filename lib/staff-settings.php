<?php
/**
 *
 * Override Faculty/Staff URL slug
 *
 */
function uw_rewrite_staff_cpt_slug( $args, $post_type ) {

	// Override uw_staff slugs w/ user defined values
    if ( 'uw_staff' === $post_type ) {
		$uw_staff_cpt_slug = get_option( 'uw_staff_cpt_slug' );
		if ( strtolower( $uw_staff_cpt_slug ) !== "staff" ) {
			if ( $args['rewrite']['slug'] !== $uw_staff_cpt_slug ) {
				if ( !empty($uw_staff_cpt_slug) ) {
					// Rewrite slug
					$args['rewrite']['slug'] = $uw_staff_cpt_slug;
				} else {
					// Revert to default slug
					$args['rewrite']['slug'] = "staff";
				}
				// Check if permalinks need to be cleared
				if ( get_option( 'uw_staff_rewrite' ) ) {
					// Clear permalinks
					flush_rewrite_rules();
					// Unset rewrite bool
					update_option('uw_staff_rewrite', 0);
				}
			}
		}
    }

    return $args;
}
add_filter( 'register_post_type_args', 'uw_rewrite_staff_cpt_slug', 10, 2 );

/**
 * Adds a submenu page under the Faculty/Staff Members parent menu in the admin sidebar
 */
add_action( 'admin_menu', function() {
	add_submenu_page(
		'edit.php?post_type=uw_staff',
		__( 'Faculty/Staff Post Type Settings', 'uw-theme' ),
		__( 'Settings', 'uw-theme' ),
		'manage_options',
		'staff-cpt-settings',
		'staff_cpt_settings_callback'
	);
});

/**
 * Display the settings page as the last item in the Fac/staff CPT submenu
 */
function staff_cpt_settings_menu_order() {
    global $submenu;
    if ( !empty( $submenu['staff-cpt-settings'] ) && !empty( $submenu['staff-cpt-settings'][0] )  ) {
        $submenu['staff-cpt-settings'][100] = $submenu['staff-cpt-settings'][0];
        unset($submenu['staff-cpt-settings'][0]);
    }
}
add_action('custom_menu_order', 'staff_cpt_settings_menu_order');

/**
 * Fac/staff CPT settings submenu page HTML
 */
function staff_cpt_settings_callback() {
	global $uw_staff_cpt_settings_form_response;
	$uw_staff_cpt_settings_form_response = '';
	$uw_staff_cpt_slug = get_option( 'uw_staff_cpt_slug' );

	// Validate form submissions
	if (isset($_POST['submit']) && isset($_POST['uw_staff_cpt_settings'])) {

		// Validate CPT Name
		if (isset($_POST['uw_staff_cpt_slug'])) {
			$uw_staff_cpt_slug = trim($_POST['uw_staff_cpt_slug']);
            $curr_uw_staff_cpt_slug = get_option('uw_staff_cpt_slug');
            $valid_characters = array('-');
            // Check if value has changed
			if ($uw_staff_cpt_slug != $curr_uw_staff_cpt_slug) {
				if (ctype_alnum(str_replace($valid_characters, '', $uw_staff_cpt_slug)) || empty($uw_staff_cpt_slug) ) {
					// Set CPT slug
					update_option('uw_staff_cpt_slug', strtolower( $uw_staff_cpt_slug ));
					// Set rewrite bool
					update_option('uw_staff_rewrite', 1);
					// Display success message
					$uw_staff_cpt_settings_form_response .= "
					<div class=\"notice notice-success is-dismissible\">
						<p>The staff slug has been successfully updated.</p>
					</div>";
				} else {
					// Display error message
					$uw_staff_cpt_settings_form_response .= "
					<div class=\"notice notice-error is-dismissible\">
						<p>Error: The staff slug may contain alphanumeric characters only.</p>
					</div>";
				}
			}
		}
	}
	// Display Fac/Staff settings page
    ?>
	<div class="wrap">
		<h1><?php _e( 'Faculty/Staff Post Type Settings', 'uw-theme' ); ?></h1>
		<form action="" method="post">
			<?php
			$uw_staff_cpt_slug = get_option( 'uw_staff_cpt_slug' );
			if ( !empty( $uw_staff_cpt_settings_form_response ) ) : ?>
				<?php echo $uw_staff_cpt_settings_form_response; ?>
			<?php endif; ?>
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="uw_cpt_name"><b>URL Slug</b></label>
						</th>
						<td>
							<input class="regular-text" id="uw_staff_cpt_slug" name="uw_staff_cpt_slug" value="<?php echo $uw_staff_cpt_slug; ?>" type="text" />
							<p class="description" style="max-width: 480px;">
								<u>This will change the URL structure for your staff pages.</u> If changed in a production environment, you may need to add redirects to avoid broken links to your pages.
							</p>
						</td>
					</tr>
				</tbody>
			</table>
			<input type="hidden" name="uw_staff_cpt_settings" value="uw_staff_cpt_settings" />
			<p class="submit">
				<input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes">
			</p>
		</form>
	</div>
    <?php
}