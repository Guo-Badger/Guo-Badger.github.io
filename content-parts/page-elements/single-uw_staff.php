<?php

$last_to_first = get_sub_field('last_name_first') || false;
$first_name = get_field('first_name');
$last_name = get_field('last_name');
$credentials = get_field('credentials');
$email = get_field('email');
$phone = get_field('phone');
$position = get_field('title_position');
$address = trim(get_field('address'));
$linkedin_url = get_field('linkedin');
$biography = get_field('biography');

$full_name = $last_to_first ? "{$last_name}, {$first_name}" : "{$first_name} {$last_name}";

?>

<div class="faculty-headshot-contact">
  <div class="faculty-contact">
    <h1 class="page-title uw-mini-bar"><?= $full_name ?></h1>

    <?php if ($credentials): ?>
      <p class="faculty-credentials"><span class="screen-reader-text">Credentials: </span><?= $credentials ?></p>
    <?php endif; ?>

    <?php if ($position): ?>
      <p class="position-title"><span class="screen-reader-text">Position title: </span><?= $position ?></p>
    <?php endif; ?>

    <?php if ($email): ?>
      <p><span class="screen-reader-text">Email: </span><a href="mailto:<?= $email ?>"><?= $email ?></a></p>
    <?php endif; ?>

    <?php if ($phone): ?>
      <p><span class="screen-reader-text">Phone: </span><?= $phone ?></p>
    <?php endif; ?>

    <?php if ($address):
      // The address value needs to have its opening/closing `<p>` tags removed, or
      // this will result in malformed output with nested tags in the raw HTML, but
      // empty paragraphs in the DOM before/after the actual address.
    ?>
      <p class="faculty-address"><span class="screen-reader-text">Address: <br></span><?= preg_replace(['/^<p>/', '/<\/p>$/'], '', trim($address)) ?></p>
    <?php endif; ?>

    <?php if ($linkedin_url): ?>
      <ul class="uw-social-icons">
        <li class="uw-social-icon">
          <a href="<?= $linkedin_url ?>">
            <?= get_svg('uw-symbol-linkedin', array('title' => "LinkedIn profile for {$full_name}")) ?>
          </a>
        </li>
      </ul>
    <?php endif; ?>

    <?php if (have_rows('extra_fields')): ?>
      <dl class="faculty-extra">
        <?php while (have_rows('extra_fields')):
          the_row();
          $extra_label = get_sub_field('extra_label');
          $extra_value = get_sub_field('extra_value');
          $extra_url = get_sub_field('extra_url');
          ?>
          <dt class="faculty-extra-label"><?= $extra_label ?></dt>
          <dd class="faculty-extra-value">
            <?php if (!empty($extra_url)): ?>
              <a href="<?= $extra_url ?>">
            <?php endif; ?>
            <?= $extra_value; ?>
            <?php if (!empty($extra_url)): ?>
              </a>
            <?php endif; ?>
          </dd>
        <?php endwhile; ?>
      </dl>
    <?php endif; ?>
  </div>
  <div class="faculty-headshot">
    <?php
    $image_id = get_field('headshot');
    if ($image_id) :
      echo wp_get_attachment_image($image_id, 'medium');
    else :
      ?><img src="<?= get_template_directory_uri() ?>/dist/images/bucky-head.png" alt="<?= $full_name ?>"><?php
    endif;
    ?>
  </div>
</div>
<?php
if (!empty($biography)): ?>
  <div class="faculty-bio">
    <?= $biography ?>
  </div>
<?php endif; ?>
