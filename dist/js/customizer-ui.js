/**
 * File customizer.js.
 *
 */
( function( $ ){

  function show_gcse_control(el) {
    var gcse_control = $("#customize-control-uwmadison_google_cse_id");

    if (el.checked) {
      gcse_control.show();
    } else {
      gcse_control.hide();
      // If we want to remove the GCSE ID value too
      // var gcse_id = $('[data-customize-setting-link="uwmadison_google_cse_id"]');
      // gcse_id.val('');
    }
  }

  // bind change to search control toggle
  $("#customize-controls").on("change", '[data-customize-setting-link="uwmadison_use_search"]', function(){
    show_gcse_control(this);
  });

  // target to observe
  var theme_controls = $('#customize-theme-controls')[0];

  // create an observer instance
  var observer = new MutationObserver(function(mutations) {
    mutations.forEach(function(mutation) {
      // check for when the search section is added
      if (mutation.type == "childList" && mutation.addedNodes.length > 0 && mutation.addedNodes[0].id == "accordion-section-uwmadison_search") {

        var use_search = $('[data-customize-setting-link="uwmadison_use_search"]');
        show_gcse_control(use_search[0]);

        observer.disconnect();
      }
    });
  });

  // configuration of the observer:
  var config = { attributes: true, childList: true, characterData: true, subtree: true };

  // pass in the target node, as well as the observer options
  observer.observe(theme_controls, config);


} )( jQuery );