<?php
global $pe_heading_level;
if(!isset($pe_heading_level)) {
	$pe_heading_level = 'h3';
}
$sub_heading_level = ($pe_heading_level === 'h3' ? 'h4' : 'h3');
// Helper function that returns a the "More Posts" link as a text string
if (!function_exists('uw_create_more_link')) {
	function uw_create_more_link($text = false, $url = false){
		if(!$url && !$text) { return false; }

		return '<li><a class="uw-more-link" href="' . $url
		. '">' . $text . ' '
		. get_svg('uw-symbol-more', array("aria-hidden" => "true")) . '</a></li>';
	}
}

$header = get_sub_field('header_text');
$post_list_type = get_sub_field('post_list_type');
$category_ids = get_sub_field('category_id');
$individual_posts = get_sub_field('individual_post');
$custom_post_type = get_sub_field('custom_post_type');
$count = get_sub_field('number_of_posts');
$show_date = get_sub_field('show_date');
$show_date = get_sub_field('show_date');
$show_excerpt = get_sub_field('show_excerpt');
$show_image = get_sub_field('show_image');
$show_more_posts_link = get_sub_field('show_more_link');
$link_text = false;
$custom_link_text = get_sub_field('more_posts_text');
$custom_link_url = get_sub_field('more_posts_url');

// Get the default blog link
// Check if there is a static home page set
if ( get_option( 'show_on_front' ) == 'page' ) {
		// Check if there is a page set to display posts. Goes to a
		// generic posts query if no blog page is selected.
		if ( get_option( 'page_for_posts' ) ) {
				$blog_link_url = get_permalink(get_option('page_for_posts'));
		} else {
				$blog_link_url = home_url('/?post_type=post');
		}
// Link goes to the home page if that is the blog page
} else {
		$blog_link_url = home_url( '/' );
}

// Build more posts links
if($show_more_posts_link){

	// Check if either custom text or a custom URL is set
	// If neither are set, generate the default more posts link
	if($custom_link_text || $custom_link_url){

		if($custom_link_text && $custom_link_url){

				// If both URL and text are set
				$link_text = uw_create_more_link( $custom_link_text, $custom_link_url );

		} else if (!$custom_link_text && $custom_link_url) {

			// If only link URL is set
			$link_text = uw_create_more_link("More Posts", $custom_link_url );

		} else {

				// If only teh text is set
				$link_text = uw_create_more_link($custom_link_text, $blog_link_url);

		}

	} else {

		// Generate default links
		switch ($post_list_type) {

			case 'Custom Post Types':
				$custom_post_title = get_post_type_object( $custom_post_type )->labels->name;
				$link_text = uw_create_more_link($custom_post_title, get_post_type_archive_link( $custom_post_type ));
				break;

			case 'Posts by Categories':
				if(empty( $category_ids )){ break; }

				$categories = get_categories( array('include' => $category_ids) );
				$link_text = "";
				foreach ($categories as $category) {
						$link_text .= uw_create_more_link("More <i>". $category->name ."</i> posts",get_category_link( $category->cat_ID ));
				}

				break;

			case "Select Individual Posts":
				$link_text = uw_create_more_link("More Posts", esc_url($blog_link_url));
				break;

			default:
				$link_text = uw_create_more_link("More News", esc_url($blog_link_url));
				break;
		}

	}

}

// checks if user has selected specific
// taxonomy terms and set the query accordingly
if ( $post_list_type == "Posts by Categories" ){
	$args = array(
        'category__in' => $category_ids,
    	'posts_per_page' => $count,
    	'post_type' => 'post',
    	'orderby' => 'date',
        'order' => 'DESC'
    );
} elseif ( $post_list_type == "Select Individual Posts" ){
    // redefine $list_posts - individual posts are already selected
    $list_posts = $individual_posts;
} elseif ( $post_list_type == "Custom Post Types" ) {
	$args = array(
			'post_type' => $custom_post_type,
			'posts_per_page' => $count,
			'orderby' => 'title',
			'order' => 'ASC'
		);
} else {
    // default args
    $args = array(
    	'posts_per_page' => $count,
    	'post_type' => 'post',
    	'orderby'=> 'date',
    	'order' => 'DESC'
    );
}

if (!empty($header)) {
    echo '<'.$pe_heading_level.' class="uw-mini-bar uw-content-box-header">' . $header . '</'.$pe_heading_level.'>';
}
if ( $post_list_type !== "Select Individual Posts") {
    // get array of posts matching defined $args
    $list_posts = get_posts($args);
}
// Checking for array of posts and has posts
if ( is_array($list_posts) && !empty($list_posts) ) {
    echo '<ul class="uw-posts-listing">';
    global $post;
    // for each item of array, put it in $post
    foreach( $list_posts as $post ) {
        setup_postdata( $post );
        echo '<li class="uw-post align-middle">';
        	// check post for featured image
        	if( $show_image  && has_post_thumbnail() ) {
                echo '<div class="uw-post-img align-self-top">';
            	echo wp_get_attachment_image(get_post_thumbnail_id($post->ID));
                echo '</div>';
            }
            echo '<div class="uw-post-text">';
                echo '<'.$sub_heading_level.'><a href="' . get_permalink($post->ID) . '">' . get_the_title() . '</a></'.$sub_heading_level.'>';

                if ($show_excerpt) {
                  echo '<p class="uw-post-excerpt">' . get_the_excerpt($post->ID) . '</p>';
                }
                if ( $show_date ) {
                  echo '<span class="uw-post-date">' . get_the_date() . '</span>';
                }
            echo '</div>';
        echo '</li>';
    }

    if( $show_more_posts_link && $link_text ){
			echo $link_text;
		}

    echo '</ul>';
} else {
  echo '<p>No posts currently available to show</p>';
}
wp_reset_postdata();
?>
