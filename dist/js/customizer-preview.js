// var $ = require ('jquery');
( function( $ ){

  wp.customize( 'blogname', function( value ) {
    value.bind( function( to ) {
      $( '#site-title a' ).html( to );
    } );
  } );

  wp.customize( 'blogdescription', function( value ) {
    value.bind( function( to ) {
      $( '#site-description' ).html( to );
    } );
  } );

  wp.customize( 'uwmadison_body_bg', function( value ) {
    value.bind( function( to ) {
      $( 'body' ).toggleClass( 'uw-white-bg uw-light-gray-bg' );
    } );
  } );

  wp.customize( 'uwmadison_header_style', function( value ) {
    value.bind( function( to ) {
      $( '.uw-global-bar' ).toggleClass( 'uw-global-bar-inverse' );
      $( '.uw-main-nav .uw-nav-menu' ).toggleClass( 'uw-nav-menu-reverse' );
      $( '.uw-nav-menu.uw-nav-menu-secondary' ).toggleClass( 'uw-nav-menu-secondary-reverse' );
    } );
  } );

} )( jQuery );