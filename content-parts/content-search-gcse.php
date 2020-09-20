<header class="page-header">
  <h1 class="page-title uw-mini-bar"><?php printf( __( 'Search Results for: %s', 'uw-theme' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
</header><!-- .page-header -->

<div class="uw-gcse">
  <script>
    (function() {
      var cx = '<?php echo gcse_id(); ?>';
      var gcse = document.createElement('script');
      gcse.type = 'text/javascript';
      gcse.async = true;
      gcse.src = 'https://cse.google.com/cse.js?cx=' + cx;
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(gcse, s);
    })();
  </script>
  <gcse:search queryParameterName="s" enableHistory="true"></gcse:search>
</div>

