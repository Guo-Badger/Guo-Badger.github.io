<?php
$quote = get_sub_field('quote_text');
$author = get_sub_field('quote_author');

if($quote) : ?>
  <blockquote class="uw-mini-bar uw-mini-bar-center stylized-quote">
    <?php echo $quote;
    if($author) : ?>
      <small>
        <span aria-hidden="true">&mdash;</span><?php echo $author; ?>
      </small>
    <?php endif; ?>
  </blockquote>
<?php endif; ?>
