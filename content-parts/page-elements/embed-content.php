<?php
  // get iframe HTML
  $iframe = get_sub_field('embed');

  // get iframe src
  preg_match('/src="(.+?)"/', $iframe, $matches);
  $src = $matches[1];

  if ( strpos($src, "youtube") !== false ) {
      // extra params
      $youtube_params = array(
          'showinfo' => 0
      );

      // add params to src
      $youtube_src = add_query_arg($youtube_params, $src);

      // replace src
      $iframe = str_replace($src, $youtube_src, $iframe);

      echo '<div class="responsive-embed widescreen">' . $iframe . '</div>';
  } else if ( strpos($src, "vimeo") !== false || strpos($src, "kaltura") !== false ) {
      echo '<div class="responsive-embed widescreen">' . $iframe . '</div>';
  } else {
      echo '<div class="responsive-embed">' . $iframe . '</div>';
  }
 ?>
