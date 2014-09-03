/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );
	
	//Update site colors in real time...
	wp.customize( 'minka_bg_color_header', function( value ) {
		value.bind( function( newval ) {
			$('.site-header').css('background-color', newval );
		} );
	} );
	
	wp.customize( 'minka_bg_color_footer', function( value ) {
		value.bind( function( newval ) {
			$('.site-footer').css('background-color', newval );
		} );
	} );
	
	wp.customize( 'minka_bg_color_col2', function( value ) {
		value.bind( function( newval ) {
			$('.column-2').css('background-color', newval );
		} );
	} );
	
	wp.customize( 'minka_font_color', function( value ) {
		value.bind( function( newval ) {
			$('.page-content').css('color', newval );
		} );
	} );
	
	wp.customize( 'minka_font_color_header', function( value ) {
		value.bind( function( newval ) {
			$('.site-header span').css('color', newval );
		} );
	} );
	
	wp.customize( 'minka_font_color_titles', function( value ) {
		value.bind( function( newval ) {
			$('.page-title').css('color', newval );
		} );
	} );
	
	wp.customize( 'minka_font_color_col2', function( value ) {
		value.bind( function( newval ) {
			$('.join-meta').css('color', newval );
		} );
	} );
	
	wp.customize( 'minka_footer_text_top', function( value ) {
		value.bind( function( newval ) {
			$('.footer-area-top-title-text').text(newval);
		} );
	} );
	
	wp.customize( 'minka_footer_text', function( value ) {
		value.bind( function( newval ) {
			$('.footer-bottom-text').text(newval);
		} );
	} );
	
	wp.customize( 'minka_home_video_enabled', function( value ) {
		value.bind( function( newval ) {
			$('.home-stick').toggle();
			$('.home-search-form').toggle();
			$('.header-search-form').toggle();
		} );
	} );
	
} )( jQuery );
