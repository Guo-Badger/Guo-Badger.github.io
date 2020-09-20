<?php

// apply uw content box styles if checked
if (get_sub_field('apply_uw_box_style')): ?>
  <div class="uw-content-box"><?php the_sub_field('text_block_content') ?></div>
<?php else: the_sub_field('text_block_content');
endif; ?>
