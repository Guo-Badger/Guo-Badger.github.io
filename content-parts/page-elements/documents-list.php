<?php
global $pe_heading_level;
if(!isset($pe_heading_level)) {
  $pe_heading_level = 'h3';
}

// checks if user has selected specific
// taxonomy terms and set the query accordingly
$documents_list_title = get_sub_field('documents_list_title');
$document_list_type = get_sub_field('document_list_type');
$document_category = get_sub_field('document_category');
$document_type = get_sub_field('document_type');
$individual_documents = get_sub_field('individual_documents');

// set query args for when a taxonomy is selected
if($document_list_type == "Documents by Category/Type") :
    if ($document_category && !$document_type) :
        $tax_query = array(
          array(
              'taxonomy' => 'category',
              'field'    => 'term_id',
              'terms'    => $document_category,
          )
      );
    elseif (!$document_category && $document_type) :
        $tax_query =  array(
          array(
              'taxonomy' => 'uw_document_type',
              'field'    => 'term_id',
              'terms'    => $document_type,
          )
        );
    else :
       $tax_query = array(
        'relation' => 'OR',
          array(
              'taxonomy' => 'category',
              'field'    => 'term_id',
              'terms'    => $document_category,
          ),
          array(
              'taxonomy' => 'uw_document_type',
              'field'    => 'term_id',
              'terms'    => $document_type,
          )
      );
    endif;

    $args = array(
      'posts_per_page' => -1,
      'post_type' => 'uw_documents',
      'tax_query' => $tax_query,
      'orderby'=> 'title',
      'order' => 'ASC'
    );
else :
    //default args
    $args = array(
      'posts_per_page' => -1,
      'post_type' => 'uw_documents',
      'orderby'=> 'title',
      'order' => 'ASC'
    );

endif;
?>


<div class="documents-list">
  <?php
  if( get_posts($args) ) :
    if ($documents_list_title) :
      echo '<'.$pe_heading_level.'>' . $documents_list_title . '</'.$pe_heading_level.'>';
    endif;
  ?>

  <ul class="uw-link-list">

    <?php

    if($document_list_type == "Select individual documents" && $individual_documents) :
      $documents = $individual_documents;
    else :
      $documents = get_posts($args);
    endif;

    foreach( $documents as $post_object):
      $file = get_field('document_file', $post_object->ID);
      $summary = get_field('document_summary', $post_object->ID);

      echo '<li>';
        if($file && trim(get_the_content() == '')) :
          echo get_svg('uw-symbol-document', array("class" => "uw-symbol-document")) . ' <a href="' . $file['url'] . '">';
        else:
          echo '<a href="' . get_permalink($post_object->ID) . '">';
        endif;
          echo get_the_title($post_object->ID) . ' ' . get_svg('uw-symbol-more', array("aria-hidden" => "true"));
          echo '</a>';

        if(get_sub_field('include_summary')) :
          if($summary) :
            echo $summary;
          else:
            the_excerpt();
          endif;
        endif;
      echo '</li>';
    endforeach;

  endif; wp_reset_postdata();
  ?>

  </ul>
</div>
