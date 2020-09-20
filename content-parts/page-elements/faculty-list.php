<?php

global $pe_heading_level;
if (!isset($pe_heading_level)) {
  $pe_heading_level = 'h3';
}

$people_list_title = get_sub_field('listing_title');
$people_list_type = get_sub_field('people_list_type');
$individual_people = get_sub_field('individual_people');
$terms = get_sub_field('faculty_type');

// checks if user has selected specific
// taxonomy terms and set the query accordingly
if ($people_list_type == "Faculty/Staff by category" && $terms) {
  $args = array(
    'posts_per_page' => -1,
    'post_type' => 'uw_staff',
    'tax_query' => array(
      array(
        'taxonomy' => 'uw_staff_type',
        'field' => 'term_id',
        'terms' => $terms
      )
    ),
    'orderby' => 'title',
    'order' => 'ASC'
  );
} else {
  $args = array(
    'posts_per_page' => -1,
    'post_type' => 'uw_staff',
    'orderby' => 'title',
    'order' => 'ASC'
  );
}

if (get_posts($args)): // Closes at the end of the file.

$columns = get_sub_field('columns');
$foundation_grid_cols = '';
$one_column_layout = false;
$last_to_first = get_sub_field('last_name_first');
$show_credentials = get_sub_field('show_credentials');
$show_email = get_sub_field('show_email');
$show_phone = get_sub_field('show_phone');
$show_title = get_sub_field('show_title');
$show_linkedin = get_sub_field('show_linkedin');
$show_address = get_sub_field('show_address');
$show_bio = get_sub_field('show_bio');
$display_photos = get_sub_field('display_photos');
$image_size = get_sub_field('image_size');
$custom_width = get_sub_field('custom_image_width');
$custom_height = get_sub_field('custom_image_height');

if ($columns == 3) { $foundation_grid_cols = 4; } // Default
else if ($columns == 2) { $foundation_grid_cols = 6; }
else if ($columns == 4) { $foundation_grid_cols = 3; }
else { $foundation_grid_cols = 12; $one_column_layout = true; }

if ($people_list_title): ?>
  <<?= $pe_heading_level ?> class="text-center uw-mini-bar-center"><?= $people_list_title ?></<?= $pe_heading_level ?>>
<?php endif; ?>

<div class="faculty-list">

  <?php
  if ($people_list_type == "Select individual people" && $individual_people) {
    $people = $individual_people;
  } else {
    $people = get_posts($args);
  }

  foreach ($people as $person):
    $first_name = get_field('first_name', $person->ID);
    $last_name = get_field('last_name', $person->ID);
    $full_name = $last_to_first ? "{$last_name}, {$first_name}" : "{$first_name} {$last_name}";

    $image_id = get_field('headshot', $person->ID);
    ?>

    <div class="faculty-member column small-12 medium-<?= $foundation_grid_cols ?>">
      <div class="faculty-member-content">

        <?php if ($one_column_layout): ?>
          <div class="row">
          <?php if ($display_photos): ?>
            <div class="column shrink">
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($display_photos):

          if ($image_size == 'Thumbnail (site default)') {
            $image_src = 'thumbnail';
            $image_class = 'thumbnail';
          } else if ($image_size == 'Custom') {
            $image_src = array($custom_width, $custom_height);
            $image_class = 'custom';
          } else {
            $image_src = 'uw-headshot';
            $image_class = 'default';
          }

          ?>
          <div class="faculty-image<?= " {$image_class}" ?>"
            <?php if ($image_size == 'Custom') : // Set custom dimensions as max-width and max-height ?>
              style="max-width: <?= $custom_width; ?>px; max-height: <?= $custom_height; ?>px;"
            <?php endif; ?>
          >
            <a href="<?php the_permalink($person->ID) ?>" tabindex="-1" aria-hidden="true">
              <?php if ($image_id): ?>
                <?= wp_get_attachment_image($image_id, $image_src) ?>
              <?php else: ?>
                <img class="buckyhead" src="<?php echo get_template_directory_uri() . '/dist/images/bucky-head.png'; ?>" alt="<?php echo $full_name; ?>">
              <?php endif; ?>
            </a>
          </div>
        <?php endif; // endif $display_photos ?>

        <?php if ($one_column_layout): ?>
          <?php if ($display_photos): ?>
            </div>
          <?php endif; ?>
          <div class="column">
        <?php endif; ?>

        <h3>
          <a href="<?php the_permalink($person->ID); ?>"><?= $full_name ?></a>
        </h3>

        <?php if ($show_credentials):
          $credentials = get_field('credentials', $person->ID);
          if (!empty($credentials)): ?>
            <p class="faculty-credentials"><span class="screen-reader-text">Credentials: </span><b><?= $credentials ?></b></p>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($show_title):
          $position_title = get_field('title_position', $person->ID);
          if (!empty($position_title)): ?>
            <p class="position-title"><span class="screen-reader-text">Position title: </span><?= $position_title ?></p>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($show_email):
          $email_address = get_field('email', $person->ID);
          if (!empty($email_address)): ?>
            <p><span class="screen-reader-text">Email: </span><a href="mailto:<?= $email_address ?>"><?= $email_address ?></a></p>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($show_phone):
          $phone_number = get_field('phone', $person->ID);
          if (!empty($phone_number)): ?>
            <p><span class="screen-reader-text">Phone: </span><?= $phone_number ?></p>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($show_address):
          $street_address = trim(get_field('address', $person->ID));
          if (!empty($street_address)):
          // The address value needs to have its opening/closing `<p>` tags removed, or
          // this will result in malformed output with nested tags in the raw HTML, but
          // empty paragraphs in the DOM before/after the actual address.
          ?>
            <p class="faculty-address"><span class="screen-reader-text">Address: <br></span><?= preg_replace(['/^<p>/', '/<\/p>$/'], '', $street_address) ?></p>
          <?php endif; ?>
        <?php endif; ?>

        <?php if ($show_linkedin):
          $linkedin_icon = get_field('linkedin', $person->ID);
          if (!empty($linkedin_icon)) : ?>
            <ul class="uw-social-icons">
              <li class="uw-social-icon">
                <a href="<?= $linkedin_icon ?>"><?= get_svg('uw-symbol-linkedin', array('title' => "LinkedIn profile for {$full_name}",)) ?></a>
              </li>
            </ul>
          <?php endif;
        endif;

        if ($show_bio):
          $biography_format = get_sub_field('biography_format');
          $biography_excerpt = trim(get_the_excerpt($person->ID)); ?>
            <div class="bio">
              <?php if ($biography_format == "excerpt" && $biography_excerpt !== ''): // show excerpt ?>
                <p class="bio"><?= get_the_excerpt($person->ID) ?></p>
              <?php elseif ($biography_format == "excerpt" && $biography_excerpt === ''): // show truncated biography ?>
                <p class="bio"><?= wp_trim_words(get_field('biography', $person->ID), uwmadison_custom_excerpt_length('')) ?></p>
              <?php else: // show biography ?>
                <?= get_field('biography', $person->ID); ?>
              <?php endif; ?>
            </div>
        <?php endif;
        if ($one_column_layout): ?>
          </div></div>
        <?php endif; ?>
      </div>
    </div>

  <?php endforeach; ?>
<?php wp_reset_postdata(); ?>
<?php endif; // endif get_posts($args) ?>
</div>
