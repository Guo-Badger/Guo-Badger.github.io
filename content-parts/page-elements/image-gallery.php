<?php
  if( !wp_script_is(get_template_directory_uri().'/dist/vendor/magnific-popup.min.js', 'enqueue') ) {
    // Register the Magnific Popop JavaScript library
    wp_register_script('magnific-popup-js', get_template_directory_uri().'/dist/vendor/magnific-popup.min.js', null, '1.1.0');
    wp_enqueue_script('magnific-popup-js');

    // Add the slick init inline script
    $magnific_init = "document.addEventListener('DOMContentLoaded', function(e) {
       jQuery('.image-gallery-item').magnificPopup({
        type: 'image',
        delegate: 'button',
        gallery:{
          enabled:true
        },
        image: {
          titleSrc: 'data-caption'
        }
      });
    });";
    // WordPress 4.5 feature
    wp_add_inline_script( 'magnific-popup-js', $magnific_init );
  }


$images = get_sub_field('image_gallery');
if ( $images ) :
	echo '<div class="image-gallery">';
	foreach ($images as $image) :
		$image_attributes = wp_get_attachment_image_src( $image['id'], 'medium_large' ); ?>
		<div class="image-gallery-item">
      <div class="image-gallery-content">
        <div class="image-gallery-content-image">
          <button class="" data-mfp-src="<?php echo $image_attributes[0] ?>" <?php if (!empty($image['caption'])){ echo 'data-caption="'.esc_attr($image['caption']).'"';}  ?> ><?php echo wp_get_attachment_image( $image['id'], 'medium' ); ?></button>
        </div>
        <div class="image-gallery-content-text text-center">
          <?php echo $image['title']; ?>
        </div>
      </div>
		</div>
	<?php endforeach;
	echo '</div>';
endif;