<?php

add_action('acf/input/admin_head', 'my_acf_admin_head');

function my_acf_admin_head() {
	?>
	<style>
	.layout[data-layout="one_column_content_layout"] > .acf-fc-layout-handle,
	.layout[data-layout="two_column_content_layout"] > .acf-fc-layout-handle,
	.layout[data-layout="three_column_content_layout"] > .acf-fc-layout-handle,
	div[data-name="hero_content"] .layout[data-layout="hero_carousel"] > .acf-fc-layout-handle,
	/*legacy - retire with old hero */div[data-name="hero_content_area"] .layout[data-layout="single_image"] > .acf-fc-layout-handle,
	/*legacy - retire with old hero */div[data-name="hero_content_area"] .layout[data-layout="image_carousel"] > .acf-fc-layout-handle,
	div[data-name="lower_content_area"] .layout[data-layout="single_image"] > .acf-fc-layout-handle {
		background: #0085BA;
		color: white;
	}
	.layout[data-layout="text_block"] > .acf-fc-layout-handle {
		background-color: #00b8ae;
		color: #fff;
	}
	.layout[data-layout="image_gallery"] > .acf-fc-layout-handle {
		background-color: #00b871;
		color: #fff;
	}
	.layout[data-layout="image_carousel"] > .acf-fc-layout-handle {
		background-color: #00b890;
		color: #fff;
	}
	.layout[data-layout="tabbed_content"] > .acf-fc-layout-handle {
		background-color: #b83400;
		color: #fff;
	}
	.layout[data-layout="accordion_panel"] > .acf-fc-layout-handle {
		background-color: #b87100;
		color: #fff;
	}
	.layout[data-layout="embed_content"] > .acf-fc-layout-handle {
		background-color: #b8ae00;
		color: #fff;
	}
	.layout[data-layout="callout_block"] > .acf-fc-layout-handle {
		background-color: #0065b8;
		color: #fff;
	}
	.layout[data-layout="alternating_content_boxes"] > .acf-fc-layout-handle {
		background-color: #5300b8;
		color: #fff;
	}
	.layout[data-layout="group_of_links"] > .acf-fc-layout-handle {
		background-color: #ae00b8;
		color: #fff;
	}
	.layout[data-layout="featured_content"] > .acf-fc-layout-handle {
		background-color: #b80009;
		color: #fff;
	}
	.layout[data-layout="stylized_quote"] > .acf-fc-layout-handle {
		background-color: #b85300;
		color: #fff;
	}
	.layout[data-layout="image"] > .acf-fc-layout-handle {
		background-color: #b80073;
		color: #fff;
	}
	.layout[data-layout="latest_posts"] > .acf-fc-layout-handle {
		background-color: #5cb800;
		color: #fff;
	}
	.layout[data-layout="faculty_list_options"] > .acf-fc-layout-handle {
		background-color: #b8007a;
		color: #fff;
	}
	.layout[data-layout="todaywiscedu_events"] > .acf-fc-layout-handle {
		background-color: #b85600;
		color: #fff;
	}
	.acf-table .acf-th {
		font-weight: bold;
	}
	.acf-fields > .acf-field:nth-last-child(1):nth-child(1) > .acf-label, .layout[data-layout="image_carousel"] .acf-field-message .acf-label {
		display: none;
	}
	.acf-fields > .acf-field[data-name="action_hook_slug"] > .acf-label {
		display: block !important;
	}
	label {
		cursor: default;
	}
	#page-layouts-meta-box {
		margin-top: 20px;
	}
	.page-layout {
		width: 15%;
		display: inline-block;
		text-align: center;
	}
	#two-column-width-radio,
	#single-image-options,
	#group-links-options,
	.layout[data-layout="image_carousel"] .acf-field-message,
	.acf-field-577d30c78b0e2,
	.acf-field-577d1ee185a4a,
	.acf-field-577d30d38b0e3,
	.acf-field-577d1f0785a4b,
	.acf-field-577d1da785a49,
	.acf-field-577d30a18b0e1,
	.acf-field-589c9a754b7a0,
	.acf-field-589c9a9d4b7a1,
	.acf-field-2589c9a754b7a0,
	.acf-field-2589c9a9d4b7a1,
	.acf-field-3589c9a754b7a0,
	.acf-field-3589c9a9d4b7a1
	{
		background-color: #f9f9f9;
	}
	.settings-gear {
		width: 20px;
		height: 19px;
		color: #fff;
		text-decoration: none;
		margin-left: 5px;
	}
	.settings-gear .dashicons {
		font-size: 15px;
		line-height: 1.3;
	}
	.settings-gear:hover {
		color: #b4b9be;
	}
	.acf-flexible-content .layout .acf-fc-layout-controls .acf-icon.-plus, .acf-flexible-content .layout .acf-fc-layout-controls .acf-icon.-minus {
		visibility: visible;
	}

	.acf-repeater .acf-row-handle .acf-icon {
		display: block;
	}
	/* Gives repeater a thicker border to distinguish between elements */
	.acf-repeater .acf-table > tbody > tr > td {
		border-bottom: 4px solid #dfdfdf;
	}

	/* Warnings about outgoing hero area */
	.inside.acf-fields.-top .acf-field.acf-field-flexible-content.acf-field-574358326cf6f {
		border: solid 8px darkred !important;
	}
	.acf-field.acf-field-flexible-content.acf-field-574358326cf6f:before {
		content: 'ALERT';
		background: darkred;
		color: white;
		padding: 0 6rem;
		font-size: 1.6rem;
	}



	#postdivrich .mce-toolbar-grp, #postdivrich #wp-content-editor-tools {
		width: 100% !important; /* force post_content tinymce to draw correctly */
	}

	</style>
	<script type="text/javascript">
	(function($) {

		settings_button = '<a href="#" class="settings-gear acf-icon" data-event="settings" title="Settings"><span class="dashicons dashicons-admin-generic"></span></a>';
		function toggleSettings(e) {
			// Layout Settings customizations
			// To add new fields to the gear icon toggle first create a field and add the class of 'hidden-by-conditional-logic'. This will hide the field on load.
			// Next provide the unique field class to the proper 'settings_fields' variable.

			var eventTarget = $(e.target),
				current_layout = eventTarget.parent().parent().parent(),
				current_fields = '',
				layout_type = current_layout.attr('data-layout'),
				settings_fields = [];

			// Show if layout is collapsed
			if ( current_layout.hasClass('-collapsed') ) {
				current_layout.removeClass('-collapsed');

				acf.do_action('refresh', current_layout);
			}

			// Determine the settings fields for a specific layout
			if ( layout_type == "one_column_content_layout" ) {
				settings_fields = ['.acf-field-577d30a18b0e1',
								   '.acf-field-577d1da785a49',
								   '.acf-field-589c9a754b7a0',
								   '.acf-field-589c9a9d4b7a1' ];
			} else if ( layout_type == "two_column_content_layout" ) {
				settings_fields = ['.acf-field-577d30c78b0e2',
								   '.acf-field-577d1ee185a4a',
								   '.acf-field-576022303fead',
								   '.acf-field-2589c9a754b7a0',
								   '.acf-field-2589c9a9d4b7a1' ];
			} else {
				settings_fields = ['.acf-field-577d30d38b0e3',
								   '.acf-field-577d1f0785a4b',
								   '.acf-field-3589c9a754b7a0',
								   '.acf-field-3589c9a9d4b7a1' ];
			}

			// Select all settings fields
			current_fields = current_layout.find( settings_fields.join(', ') );

			// Hide / Show fields
			current_fields.each(function(){
				// Toggle the hidden class
				$(this).toggleClass('hidden-by-conditional-logic');

				// If the current field is the background choice field, check the choice to see if it is "Upload Image"
				if( $(this).attr('data-name') === 'background_choice' && $('select', this).val() === 'Upload Image' ){
					// Get the background image field and toggle the hidden class
					$('[data-name="background_image"]', $(this).parent() ).toggleClass('hidden-by-conditional-logic');
				}
			});
		}

		function toggleBackgroundImage(e){
			// Get the field value
			var value = e.target.value;

			// Get the field group parent elmeent
			var fieldGroup = $(e.target).parent().parent().parent();

			// Show / Hide the field based on the value
			if(value === "Upload Image"){
				$('[data-name="background_image"]', fieldGroup).removeClass('hidden-by-conditional-logic');
			} else {
				$('[data-name="background_image"]', fieldGroup).addClass('hidden-by-conditional-logic');
			}
		}

		acf.add_action('load', function( $el ) {
			// Add settings button to any existing layouts
			$('div[data-layout="one_column_content_layout"], div[data-layout="two_column_content_layout"], div[data-layout="three_column_content_layout"]').not('.acf-clone')
				.find('> .acf-fc-layout-controls:visible')
				.prepend(settings_button);
			// Add click event to icon
			$('.settings-gear').on('click.settings', function(e) { toggleSettings(e) });
		});

		acf.add_action('ready', function(){
			// Add confirmation dialog for removal of any element
			$('body').on('click', 'a[data-event="remove-layout"]', function( e ){
				var elementName = jQuery(this).parent().parent().find('> .acf-fc-layout-handle').text().substr(2);
				return confirm("Delete " + elementName + "?");
			});

			// Hide layout backgrounds
			$('[data-name="primary_content_area"] [data-name="background_image"]').addClass('hidden-by-conditional-logic');
			$('[data-name="primary_content_area"] [data-name="background_choice"]').on('change', function(e){ toggleBackgroundImage(e) });

		});
		acf.add_action('append', function( $el ) {
			// Check for a layout and add settings button
			$element = $el.attr('data-layout');
			if ( ( $element == 'one_column_content_layout' ) || ( $element == 'two_column_content_layout' ) || ( $element == 'three_column_content_layout' ) ) {
				$el.find('.acf-fc-layout-controls').eq(0).prepend(settings_button);

				// $el.find('[data-name="background_image"]').removeClass('hidden-by-conditional-logic');
			}
			// Add click event to icon, in some cases the event as added twice with the predefined layout. The event is unbound first as a precaution.
			$('.settings-gear').off('click.settings').on('click.settings', function(e) { toggleSettings(e) });

			// Add change listener to new background selects
			$('[data-name="primary_content_area"] [data-name="background_choice"]').on('change', function(e){ toggleBackgroundImage(e) });

		});

		$(document).on('change', '#page_template', function() {
			var value = $(this).find('option:selected').val(),
					page_layouts_box = $('#page-layouts-meta-box');
			if ( value != 'default' ) {
				page_layouts_box.hide();

				// trigger WP TMCE resize so editor draws correctly
				setTimeout(function(){
					jQuery(window).trigger("resize.editor-expand"); 
				},500); 
			} else {
				page_layouts_box.show();
			}
		});

	})(jQuery);
	</script>
	<?php
}

function add_custom_meta_box() {
	// function add_meta_box( $id, $title, $callback, $screen = null, $context = 'advanced', $priority = 'default', $callback_args = null )
	add_meta_box("page-layouts-meta-box", "Page Layouts", "page_layouts_meta_box_markup", "page", "advanced", "high", null);
}
add_action("load-page-new.php", "add_custom_meta_box");

// Move all "advanced" metaboxes above the default editor
add_action('edit_form_after_title', function() {
    global $post, $wp_meta_boxes;
    do_meta_boxes(get_current_screen(), 'advanced', $post);
    unset($wp_meta_boxes[get_post_type($post)]['advanced']);
});

function page_layouts_meta_box_markup() {
	$img_path = get_template_directory_uri() . '/dist/images/';
	?>
	<div class="page-layout"><a href="#" class="default-layout"><img src="<?php echo $img_path .'1col-default.png' ?>"/><br />One Column Default Layout</a></div>
	<div class="page-layout"><a href="#" class="two-col-60-40"><img src="<?php echo $img_path .'2col60-40.png' ?>"/><br/>Two Column Layout (60-40)</a></div>
	<div class="page-layout"><a href="#" class="two-col-40-60"><img src="<?php echo $img_path .'2col40-60.png' ?>"/><br/>Two Column Layout (40-60)</a></div>
	<div class="page-layout"><a href="#" class="two-col"><img src="<?php echo $img_path .'/2col.png' ?>"/><br/>Two Column Layout (50-50)</a></div>

		<script type="text/javascript">
		/**
		 *
		 * Custom Layout Builder by Joe Van Boxtel (joe.vanboxtel@wisc.edu)
		 * This is an extension of the ACF Flexible Content Element to allow switching of layouts to a predefined layout set.
		 * New layout can be added an removed relatively easily and switching layouts is as easy as clicking links in admin.
		 * The below javascript triggers the UI click events on the page. This was the only way to get this to work without using PHP
		 * and refreshing the page.
		 */

		var confirmClearMessage = "Are you sure want to reset your page layout?\n\nThis will delete any content that is currently in the Primary Content Area of the page and create an empty page template."


		/**
		 *
		 * Removes all layouts on the page
		 *
		 */
		function clearLayout() {
			// Confirm the user wants to clear their layout
			/*
				ACF now asks to confirm that you wish to remove a layout
				Thankfully you can actually just click the minus button twice to confirm this

				So we now need to trigger the clicks twice to actually clear the fields
			*/
			for(var x = 0; x <= 1; x++){
				jQuery(".acf-field-56a66cfb6ddaf .layout[data-layout='one_column_content_layout']:not('.acf-clone') > .acf-fc-layout-controls .-minus").trigger('click');
				jQuery(".acf-field-56a66cfb6ddaf .layout[data-layout='two_column_content_layout']:not('.acf-clone') > .acf-fc-layout-controls .-minus").trigger('click');
				jQuery(".acf-field-56a66cfb6ddaf .layout[data-layout='three_column_content_layout']:not('.acf-clone') > .acf-fc-layout-controls .-minus").trigger('click');
			}
		}

		/**
		 *
		 * This add 1-3 column layout to the page.
		 * creation is delayed by 300ms to allow the layout to be added to the DOM and seemed to be the magic number to waiting
		 * before interacting with the 'Plus' to add a page element. Uses a promise for sequential execution
		 */
		function addColumnContentLayout(columns) {
			var dfd = new jQuery.Deferred();
			setTimeout(function() {
				// acf.fields.flexible_content.add(columns + '_column_content_layout');
				jQuery('[data-name="primary_content_area"] .acf-button[data-name="add-layout"]').trigger('click')
				.next( jQuery('[data-layout="' + columns + '_column_content_layout"]').trigger('click') );
				jQuery('.acf-fc-popup').remove();
			dfd.resolve();
			}, 300);
			return dfd.promise();
		}

		/**
		 * To get a field class follow this css selector:
		 * .layout .acf-fields .acf-field-###########
		 * elements are as follows: text_block, image_gallery, embed_content, accordion_panel, tabbed_content
		 * Note: The creation of these elements have been delayed by 1ms since the layout has to exist before the page element
		 */
		function addPageElement(fieldClass, element) {
			setTimeout(function() {
				jQuery('.' + fieldClass + ' .acf-flexible-content.empty .button-primary[data-event="add-layout"]')
					.trigger('click').next().find('a[data-layout="' + element + '"]').trigger('click');
				jQuery('.acf-fc-popup').remove();
			},1);
		}

		// Default Layout:
		// 		One Column Content Layout
		//			|--Text Block
		jQuery('.default-layout').on('click', function() {
			if(!confirm(confirmClearMessage)){ return false; }

			// Always clear the layout before creating a new one.
			clearLayout();
			// Default layout
			var promise = addColumnContentLayout('one');
			promise.done(function() {
				// addPageElement('acf-field-56a8d83a184a9', 'text_block');
				jQuery('[data-name="one_column_page_elements"] .acf-button[data-name="add-layout"]').trigger('click')
				.next( jQuery('.acf-tooltip [data-layout="text_block"]').trigger('click') )
			});
		});

		// Two Column Layout:
		// 		Two Column Content Layout (50-50)
		jQuery('.two-col').on('click', function() {
			if(!confirm(confirmClearMessage)){ return false; }

			clearLayout();
			// Two Column layout
			addColumnContentLayout('two');
		});
		// Two Column Layout:
		// 		Two Column Content Layout (60-40)
		jQuery('.two-col-60-40').on('click', function() {
			if(!confirm(confirmClearMessage)){ return false; }

			clearLayout();
			// Two Column layout
			var promise = addColumnContentLayout('two');
			promise.done(function() {
				jQuery("#two-column-width-radio input[value='Left 60%  Right 40%']").trigger('click');
			});
		});
		jQuery('.two-col-40-60').on('click', function() {
			if(!confirm(confirmClearMessage)){ return false; }

			clearLayout();
			// Two Column layout
			var promise = addColumnContentLayout('two');
			promise.done(function() {
				jQuery("#two-column-width-radio input[value='Left 40%  Right 60%']").trigger('click');
			});
		});
		</script>
    <?php
}



add_filter('acf/load_value/name=primary_content_area', 'add_starting_repeater', 10, 3);
function  add_starting_repeater($value, $post_id, $field) {
	// Loads the default layout when creating a new page.
	if ($value == NULL) {
		$value = array(
			array(
				'acf_fc_layout' => 'one_column_content_layout',
				'field_56a8d83a184a9' => array (
					array (
						'acf_fc_layout' => 'text_block'
					)
				)
			),
		);
	}
	return $value;
}
// Changes the height of the content editor, this gives us more room on the page.
function wptiny($initArray){
    $initArray['height'] = '200px';
    return $initArray;
}
add_filter('tiny_mce_before_init', 'wptiny');