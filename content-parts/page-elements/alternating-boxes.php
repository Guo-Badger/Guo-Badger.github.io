<?php
global $pe_heading_level;
if(!isset($pe_heading_level)) {
  $pe_heading_level = 'h3';
}
if(get_sub_field('alternating_content_area_headline')) {
  echo '<'.$pe_heading_level.' class="uw-mini-bar uw-mini-bar-center text-center">' . get_sub_field('alternating_content_area_headline') . '</'.$pe_heading_level.'>';
}
$acb_heading_level = ($pe_heading_level === 'h3' ? 'h4' : 'h3');
?>

<?php if( have_rows('content_box') ):

  while( have_rows('content_box') ): the_row();
    $headline = get_sub_field('alternating_content_headline');
    $text = get_sub_field('alternating_content_text');
    $image = get_sub_field('alternating_content_image');
?>

  <div class="alternating-content">
    <div class="alternating-content-box">
      <div class="column">
        <?php
          if($headline){ echo '<'.$acb_heading_level.'>' . $headline . '</'.$acb_heading_level.'>'; }
          if($text){ echo $text; }
          get_template_part( 'content-parts/page-elements/link', 'list' );
        ?>
      </div>
    </div>
    <div class="alternating-content-box">
      <?php if($image):?>
        <img src="<?php echo $image['sizes']['uw-2panel-slider']; ?>" alt="<?php echo htmlspecialchars($image['alt']) ?>" />
      <?php endif; ?>
    </div>
  </div>

  <?php endwhile; ?>
<?php endif; ?>
