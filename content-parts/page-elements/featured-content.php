<?php
// Featured Content block
// user can select to display post content or type in content
global $pe_heading_level;
if(!isset($pe_heading_level)) {
  $pe_heading_level = 'h3';
}

$image = get_sub_field('featured_image');
$title = get_sub_field('featured_title');
$text = get_sub_field('featured_text');
$link = get_sub_field('featured_link');
$use_post_object = get_sub_field('use_post_object');

?>

<div class="uw-featured-content">

<?php
//if the user is populating title, text, and link with a page/post
if( $use_post_object == 'Yes, select a post or page' ):

  $post_object = get_sub_field('featured_post_object');

  if( $post_object ):

    // override $post
    $post = $post_object;
    setup_postdata( $post );
    ?>
    <?php if($image): ?>
    <a href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
        <img src="<?php echo $image['sizes']['uw-3x2']; ?>" alt="<?php echo htmlspecialchars($image['alt']); ?>">
    </a>
    <?php endif; ?>
    <<?php echo $pe_heading_level; ?> class="uw-mini-bar">
      <a href="<?php the_permalink(); ?>">
        <?php the_title(); ?>
      </a>
    </<?php echo $pe_heading_level; ?>>

    <p><?php echo get_the_excerpt(); ?></p>

    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
  <?php endif; ?>

<?php else: //if the user is entering their own title, text, and link?>
  <?php if($link && $image): ?>
    <a href="<?php echo $link; ?>" aria-hidden="true" tabindex="-1">
  <?php endif; ?>

  <?php if($image): ?>
    <img src="<?php echo $image['sizes']['uw-3x2']; ?>" alt="<?php echo htmlspecialchars($image['alt']); ?>">
  <?php endif; ?>

  <?php if($link && $image): ?>
    </a>
  <?php endif; ?>

  <?php if($title): ?>
    <<?php echo $pe_heading_level; ?> class="uw-mini-bar">
      <?php if($link): ?>
        <a href="<?php echo $link; ?>">
      <?php endif; ?>
      <?php echo $title; ?>
      <?php if($link): ?>
        </a>
      <?php endif; ?>
    </<?php echo $pe_heading_level; ?>>
  <?php endif; ?>

  <?php if($text): ?>
    <?php echo $text; ?>
    <?php if (empty($title) && $link): ?>
      <a href="<?php echo $link; ?>" class="uw-more-link">Read more</a>
    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>

</div>
