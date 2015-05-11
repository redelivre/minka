<?php
	get_header();
	$term = false;
	if(get_query_var('cat') != '')
	{
		$term = get_category(get_query_var('cat'));
	}
	$cats = get_terms('category');
?>
<div class="home-entry" style="background: #FFF">
    <div class="container">

<div class="solution-category-archive-entry container home-entry" style="#FFF">
	<div class="solution-category-archive-content row">	
        <div class="solution-search row col-lg-12">
                <div class="col-md-6 col-lg-6 search">
                    <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
                </div>
                <div class="col-lg-2 col-md-2">
                    <span id="see-all-solutions" class="pull-left btn btn-primary see-all" style="display:none">Ver Todas</span>
                </div>
                <div class="col-lg-4 col-md-4">
                	<a href="/new-solution/" class="pull-right btn btn-primary btn-new-solution">Publica una nueva solución</a>
                </div>
        </div>
   </div>

	<div class="text-center filter-toolbar row">
		<div class="col-lg-12 ">
			<div role="tabpanel">
				 	 <?php isotope_categories() ?>
			</div>
		</div>
	</div>

   <hr >
   <div class="solution-category-archive-category-list row">
   		<div id="solutions-items" class="isotope solutions col-lg-12">
   			<?php
				Minka::getSolutionsList($term);
			?>
   		</div>
   	</div>

</div>
			
</div>
</div>
<?php get_footer(); ?>
