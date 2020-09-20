<?php

$image_id = get_sub_field('single_image');
// get image meta data
$image_info = get_post($image_id);
// get true/false value of display caption
$display_caption = get_sub_field('image_caption');
// get image caption
$caption = $image_info->post_excerpt;

if ( !empty($image_id) ) {
	if ( $display_caption ) {
		echo '<figure class="wp-caption single-image">';
			echo wp_get_attachment_image( $image_id, 'medium_large' );
			if ( $caption ) {
				echo '<figcaption class="wp-caption-text">' . $caption . '</figcaption>';
		echo '</figure>';
			}
		} else {
			echo wp_get_attachment_image( $image_id, 'medium_large' );
	}
}

?>
