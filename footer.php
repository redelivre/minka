<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package minka
 */
?>


<footer id="colophon" class="site-footer" role="contentinfo">
	
		<div class="footer-area footer-area-top ">
		 	<div class="container">
				<div class="footer-area-top-title row">
					<div class="footer-area-top-title-text">						
						<?php echo get_theme_mod('minka_footer_text_top', __("Redes Amigas de MINKA", 'minka')); ?>
					</div>
				</div>
				<div class="footer-entry footer-entry-to row">
					<div class="footer-top">
						<?php dynamic_sidebar('footer-1'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-area footer-area-bottom">
			<div class="container">
				<div class="header-social-list">
					<?php
					Minka::socialList();
					?>
				</div>

				<div class="footer-entry footer-entry-bottom row">
					<div class="footer-bootom col-lg-12">
						<?php dynamic_sidebar('footer-2'); ?>
					</div>
					<div class="footer-bottom-text row">
						<div class="col-lg-12">
							<?php echo get_theme_mod('minka_footer_text', __("Minka - Banco de las redes. Todos los derechos reservados, copyright 2014", 'minka')); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	
</footer><!-- #colophon -->

<?php wp_footer(); ?>
<!--script src="<?php echo get_template_directory_uri(); ?>/inc/bootstrap/js/bootstrap.min.js" type="text/javascript"/-->
<script type="text/javascript">
    (function($) {
    
    
})( jQuery );
</script>
<script type="text/javascript"> 
   jQuery(document).ready(function() {
		jQuery('.btn-toggle').click(function() {
		    jQuery(this).find('.btn').toggleClass('active');  
		    
		    if (jQuery(this).find('.btn-primary').size()>0) {
		    	jQuery(this).find('.btn').toggleClass('btn-primary');
		    }
		    
		    jQuery(this).find('.btn').toggleClass('btn-default');
		       
		});
	});
</script>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/isotope.pkgd.min.js"></script>


<script>
jQuery(window).load(function(){
	jQuery('.carousel').carousel({
	    pause: true,
	    interval: 4000,
	  });
	
	jQuery('#solution-nav a').click(function (e) {
  		e.preventDefault()
  		jQuery(this).tab('show')
	});

	var qsRegex;
	var buttonFilter;

	var $container = jQuery('#solutions-items').isotope({
		masonry: {
		},
		itemSelector: '.item2',
		filter: function() {
	      var $this = jQuery(this);
	      var searchResult = qsRegex ? $this.text().match( qsRegex ) : true;
	      var buttonResult = buttonFilter ? $this.is( buttonFilter ) : true;
	      return searchResult && buttonResult;
	    }
	});
	jQuery('.filters').on( 'click', 'button', function() {
	  	var filterValue = jQuery(this).attr('data-filter');
	  	$container.isotope({ filter: filterValue });
        $('#see-all-solutions').show();
	});

	jQuery('.parent-filter').on( 'click', function() {
	  	$container.isotope({ filter: '*'});
        $('#see-all-solutions').hide();
	});

	jQuery('#see-all-solutions').on( 'click', function() {
	  	$container.isotope({ filter: '*'});
        $('#solution-nav li').removeClass('active');
        $('.filter-toolbar .tab-pane').removeClass('active');
        $('#clear_categories').addClass('active');
        $('#see-all-solutions').hide();
	});



	var $quicksearch = jQuery('#quicksearch').keyup( debounce( function() {
		qsRegex = new RegExp( $quicksearch.val(), 'gi' );
		$container.isotope();
	}) );

	function debounce( fn, threshold ) {
	  var timeout;
	  return function debounced() {
	    if ( timeout ) {
	      clearTimeout( timeout );
	    }
	    function delayed() {
	      fn();
	      timeout = null;
	    }
	    setTimeout( delayed, threshold || 100 );
	  };
	}
	
});
</script>
</body>
</html>
