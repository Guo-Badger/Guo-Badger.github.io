<?php

  if(get_field('document_file')) {
    $file = get_field('document_file');
    $title = trim($file['title']);
    if( ! empty($file['title']) && $file['title'] !== '')
    {
      $link_text = $title;
    }
    elseif (trim(get_the_title()) !== ''){
      $link_text = get_the_title();
    }
    else {
      $link_text = $file['filename']; 
    }
    echo 'Download <a href="' . $file['url'] . '">' . $link_text . '</a>';
  }

  if(trim(get_the_content()) !== '') {
    the_content();
  } else {
    if(get_field('document_summary')) {
      $summary = get_field('document_summary');
      echo $summary;
    }
  }