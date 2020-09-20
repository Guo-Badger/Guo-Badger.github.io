<?php
global $pe_heading_level;
if(!isset($pe_heading_level)) {
	$pe_heading_level = 'h3';
}

$today_url = get_sub_field('todaywiscedu_url');
$count = get_sub_field('number_of_events');
$header = get_sub_field('header_text');

// Switch timezone temporarily
$wp_timezone = date_default_timezone_get();
date_default_timezone_set('America/Chicago');

if ( ! function_exists( 'my_uw_events_group_by' ) ) :
	/**
	 * Filter the date string to group events by month
	 *
	 * @return String PHP strftime format string (http://php.net/manual/en/function.strftime.php)
	 */
	function my_uw_events_group_by($group_by) {
		return "%B %Y";
	}
	add_filter('uwmadison_events_group_by', 'my_uw_events_group_by');
endif;

// get our data
$event_feed = uwmadison_events_get_remote($today_url, array('limit' => (int)$count));

if (!empty($header))
	echo '<'.$pe_heading_level.' class="uw-mini-bar uw-content-box-header">' . $header . '</'.$pe_heading_level.'>';

// loop through events; events will be grouped by month
if (!empty(array_filter($event_feed->data))) {

	// check first and last group; if years differ, show year in group label
	$keys = array_keys($event_feed->data['grouped']);
	$firstGroup = $keys[0];
	$lastGroup = $keys[count($keys)-1];
	$start_year = substr($firstGroup, -4);
	$end_year = substr($lastGroup, -4);
	$showYear = ($start_year == $end_year) ? false : true;

	echo '<ul class="uw-events">';
	foreach ($event_feed->data['grouped'] as $monthYear => $events) {
		$groupLabel = ($showYear) ? $monthYear : substr_replace($monthYear, '', -5) ;
		if ( !empty($events) ) {
			echo '<li><span class="uw-event-month">' . $groupLabel . '</span>';
				echo '<ul class="uw-events">';

				foreach ($events as $event) {
					echo '<li class="uw-event">';

						echo '<div class="uw-event-date">';
							echo '<span class="show-for-sr">' . date('F', $event->start_timestamp) . '</span>';
							echo ' ' . date('j', $event->start_timestamp);
						echo '</div>';

						echo '<div class="uw-event-listing">';
							echo '<span class="uw-event-title"><a href="' . $event->link . '">' . $event->title . '</a></span>';

							if ( !empty($event->subtitle) )
								echo '<span class="uw-event-subtitle">' . $event->subtitle . '</span>';

							echo '<span class="uw-event-time">' . date('g:i A', $event->start_timestamp) . '</span>';

							if ( !empty($event->location) ) {
								echo ', <span class="uw-event-location">';

								if ( !empty($event->uw_map_url))
									echo '<a href="' . $event->uw_map_url . '">';

								echo $event->location;

								if ( !empty($event->uw_map_url))
									echo '</a>';

								echo '</span>';
							}
						echo '</div>';
					echo '</li>';
				}

				echo '</ul>';
			echo '</li>';
		}
	}
	echo '</ul>';
	echo '<div><a class="uw-more-link" href="' . $today_url . '">More events ' . get_svg('uw-symbol-more', array("aria-hidden" => "true")) . '</a></div>';
} else {
	echo '<p>No events returned.</p>';
}

// revert timezone
date_default_timezone_set($wp_timezone);
