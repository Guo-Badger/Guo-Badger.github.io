<?php
global $pe_heading_level;
if(!isset($pe_heading_level)) {
  $pe_heading_level = 'h3';
}

if( have_rows('image_group') ):
    if( !wp_script_is(get_template_directory_uri().'/dist/vendor/slick.min.js', 'enqueue') ) {
        // Register the Slick JavaScript library
        wp_register_script('slick-js', get_template_directory_uri().'/dist/vendor/slick.min.js', null, '1.6.0');
        wp_enqueue_script('slick-js');

        // Add the slick init inline script
        $slick_opts = "document.addEventListener('DOMContentLoaded', function(e) {

          var carousel_1 = jQuery('.carousel-1'),
              carousel_2 = jQuery('.carousel-2'),
              carousel_group = jQuery('.slide-sync');



          window.initTwoPanelCarousel = function() {
            var slide_images = carousel_2.find(\".centered-container > img\");

            slide_images.each(function(){
              carousel_1.append(jQuery(\"<div>\").append(jQuery(this)));
            }).promise().done( function(){ carousel_1.show(); initSlick(); carousel_2.find('.slick-dots li button').attr('aria-hidden',true).attr('tabindex',-1); } );

          }

          window.initSlick = function() {
            carousel_1.slick({
              swipe: false,
              slidesToShow: 1,
              slideToScroll: 1,
              arrows: false,
              // fade: true,
              useTransform: true,
              asNavFor: '.carousel-2'
            });
            carousel_2.slick({
              swipe: false,
              slidesToShow: 1,
              slideToScroll: 1,
              asNavFor: '.carousel-1',
              prevArrow: '<button type=\"button\" class=\"slick-prev uw-carousel-arrow\" aria-label=\"previous panel\">".preg_replace( "/\r|\n/", "", get_svg('uw-symbol-chevron-left') )."<span class=\"show-for-sr\">Previous</span></button>',
              nextArrow: '<button type=\"button\" class=\"slick-next uw-carousel-arrow\" aria-label=\"next panel\">".preg_replace( "/\r|\n/", "", get_svg('uw-symbol-chevron-right') )."<span class=\"show-for-sr\">Next</span></button>',
              fade: true,
              dots: true
            });
            carousel_initialized = true;

          }

          window.deinitTwoPanelCarousel = function() {
            var slide_images = carousel_1.find(\".slick-slide:not(.slick-cloned) > img\");
            var slides = carousel_2.find(\".centered-container\");
            slides.each(function(i){
              jQuery(this).prepend(slide_images[i]);
            }).promise().done( function(){ carousel_1.hide(); deinitSlick(); } );

          }

          window.deinitSlick = function() {
            carousel_1.slick('unslick').empty(); // clear the container's elements
            carousel_2.slick('unslick');
            carousel_initialized = false;
          }

          var carousel_initialized = false;
          jQuery(window).on('resize load',function(){
            if (window.matchMedia('(min-width: 620px)').matches) {
              if (!carousel_initialized) {
                initTwoPanelCarousel();
                // carousel is hidden on load then set to show when init is complete. This eliminates the reflow when the js gets called.
                carousel_group.css('visibility', 'visible');
              }
            } else {
              carousel_group.css('visibility', 'visible');
              if (carousel_initialized) {
                deinitTwoPanelCarousel();
              }
            }
          });

        });";

        // WordPress 4.5 feature
        wp_add_inline_script( 'slick-js', $slick_opts );
    } ?>
    <div class="row">
    <div class="small-12 large-10 large-offset-1">
        <noscript><style>.no-js .slide-sync { visibility:visible!important; } .no-js .carousel-2 { flex: 0 0 100%; max-width: 100%; } </style></noscript>
        <div class="slide-sync" style="visibility:hidden">
          <div class="row">
            <div class="carousel-1 carousel-photo" aria-hidden="true">
            </div> <!-- carousel-1 -->
            <div class="carousel-2 slick-with-uw-buttons primary-background carousel-content dust-bg-3">

            <?php while ( have_rows( 'image_group' )) : the_row(); ?>
                <div class="centered-container">

                <?php $image_id = get_sub_field('image'); echo wp_get_attachment_image( $image_id, 'uw-2panel-slider' ); ?>

                <<?php echo $pe_heading_level; ?> class="text-center"><?php echo get_sub_field( 'content_title' ); ?></<?php echo $pe_heading_level; ?>>

                <?php echo get_sub_field( 'content_panel' ); ?>

                <?php if( get_sub_field( 'button_link' ) ): ?>
                  <p class="text-center"><a href="<?php echo get_sub_field( 'button_link' ); ?>" class="uw-button button-cta button-cta-reverse" tabindex="0">Learn more</a></p>
                <?php endif; ?>

                </div>
            <?php endwhile; ?>

            </div>
          </div> <!-- row -->
        </div>
    </div></div>

    <?php
 endif;
