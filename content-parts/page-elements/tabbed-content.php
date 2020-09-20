<?php

$tabs = get_sub_field('tab_group');

if ($tabs) :
	$counter_tabs = 1;
	$counter_content = 1; ?>

	<div class="tabs-container">
		<ul id="tabs" class="tabs" role="tablist" data-tabs data-deep-link="true">
			<?php foreach ( $tabs as $tab ) :
				$id = sanitize_title($tab['tab_title']); ?>

				<li class="tabs-title <?php echo $counter_tabs == 1 ? 'is-active' : ''; ?>"><a href="#<?php echo $id; ?>"><?php echo $tab['tab_title'] ?></a></li>

			<?php $counter_tabs++; ?>
			<?php endforeach; ?>
		</ul>

		<div class="tabs-content" data-tabs-content="tabs">
			<?php foreach ( $tabs as $tab ) :
				$id = sanitize_title($tab['tab_title']); ?>

				<div id="<?php echo $id; ?>" class="tabs-panel <?php echo $counter_content == 1 ? 'is-active' : ''; ?>">
					<?php echo $tab['tab_body']; ?>
				</div>

			<?php $counter_content++; ?>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>
