<?php
  global $pe_heading_level;
  if(!isset($pe_heading_level)) {
    $pe_heading_level = 'h3';
  }

  if( !wp_script_is('uw-accordion', 'enqueued') ) {
    // Register the script

    wp_register_script('uw-accordion', get_template_directory_uri().'/dist/js/uw-accordion.min.js', null, '1.0.0');
    wp_enqueue_script('uw-accordion');


    //Add the uw accordion init inline script
    $uw_accordion_init = "
      var uw_accordions = jQuery('.uw-accordion');

      uw_accordions.each(function(i){
        var accordion_el = jQuery(this);
        var uw_accordion = new UWAccordion(this);

        var expandButton = accordion_el.find('.uw-accordion-expand-all');
        var collapseButton = accordion_el.find('.uw-accordion-collapse-all');

        // Toggle the states of the two buttons and expand or collapse all
        jQuery(this).find('.uw-accordion-controls > button').on('click', function(e){
          var clickedButton = jQuery(this);
          var otherButton = clickedButton.hasClass('uw-accordion-expand-all') ? collapseButton : expandButton;

          clickedButton.prop('disabled', true);
          clickedButton.attr('aria-pressed', true);
          otherButton.prop('disabled', false);
          otherButton.attr('aria-pressed', false);

          if (clickedButton.text() == 'Expand all') {
            uw_accordion.openAll();
          }
          if (clickedButton.text() == 'Collapse all') {
            uw_accordion.closeAll();
          }

        });

        // On panel toggle, adjust the expand, collapse button states
        jQuery(this).on('panel-toggle', function(e) {

          // es5-friendly array includes test
          var contains = function(a, obj) {
              for (var i = 0; i < a.length; i++) {
                  if (a[i] === obj) {
                      return true;
                  }
              }
              return false;
          }

          states = uw_accordion.states.map(function(state) {
            return state.state;
          });

          collapseButton.attr('aria-pressed', !contains(states, 'open'));
          collapseButton.prop('disabled', !contains(states, 'open'));
          expandButton.attr('aria-pressed', !contains(states, 'closed'));
          expandButton.prop('disabled', !contains(states, 'closed'));

        });

        // Debounce function
        var uw_debounce = function(func, wait, immediate) {
          var timeout;
          return function() {
            var context = this, args = arguments;
            var later = function() {
              timeout = null;
              if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
          };
        };

        // Watch for resize of accordion
        window.addEventListener('resize', uw_debounce(function() {
          uw_accordion.calculateOpenPanelsHeight();
        }, 50));

      });

    ";

    wp_add_inline_script( 'uw-accordion', $uw_accordion_init );
  }
?>

<div class="uw-accordion">
  <p class="show-for-sr">This is an accordion element with a series of buttons that open and close related content panels.</p>

  <div class="uw-accordion-controls">
    <button class="uw-button-unstyle uw-accordion-expand-all" aria-label="Expand all panels" aria-pressed="false">Expand all</button><button class="uw-button-unstyle uw-accordion-collapse-all" aria-label="Collapse all panels" aria-pressed="true" disabled>Collapse all</button>
  </div>

  <?php while ( have_rows('accordion_panel_group') ) : the_row(); ?>

    <<?php echo $pe_heading_level; ?> class="uw-accordion-header">
      <?php echo get_sub_field('accordion_panel_title'); ?>
    </<?php echo $pe_heading_level; ?>>

    <div class="uw-accordion-panel -uw-accordion-is-hidden" role="region">
      <div class="uw-accordion-panel-inner uw-clearfix">
        <?php echo get_sub_field('accordion_panel_body') ?>
      </div>
    </div>

  <?php endwhile; ?>
</div>
