<?php get_header(); 
	$term = false;
?>

<div class="home-entry" >
    <div class="row">
        <div class="col-lg-12 sections-description">
            <!--h2 class="text-center">Minka.me es una plataforma para promover y difundir la Economía Colaborativa</h2-->
        </div>
    </div>
</div>
<div class="home-entry" style="background: #FFF">
    <div class="container">
        <div class="row minka-site-map">
            <div class="col-md-3 col-sm-6 minka-section section-formation">
                <a href="<?php bloginfo('url')?>/blog-2-2/">
                    <div class="thumbnail" id="thumb-formation">
                        <div class="caption section-top">                      
                            <h4 class="text-center">Novedades</h4>
                        </div>
                        <div class="caption section-bottom">
                            <p class="text-center">minka ofrece actividades virtuales y presenciales para aprender cómo aplicar la economía colaborativa a tu propuesta</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 minka-section section-services">
                <a href="<?php bloginfo('url')?>/servicios/">
                <div class="thumbnail" id="thumb-services">
                    <div class="caption section-top">
                        <h4 class="text-center">Servicios</h4>
                    </div>
                    <div class="caption section-bottom">
                        <p class="text-center">Diseñamos estrtegias de sustentabilidad a medida. ORganizamos encuentros y eventos para el intercambio  de conocimiento y consuloría colaborativa</p>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-3 col-sm-6 minka-section section-catalogue">
                <a href="<?php bloginfo('url')?>/solution/">
                <div class="thumbnail" id="thumb-catalogue">
                    <div class="caption section-top">
                        <h4 class="text-center">Catalogo</h4>
                    </div>
                    <div class="caption section-bottom">
                        <p class="text-center">Accede a plataformas de todo el mundo que te permiten compartir financiamiento, saberes y conocimientos, equipamientos e infraestructuras, contactos, entre</p>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-md-3 col-sm-6 minka-section section-network">
                <a href="<?php bloginfo('url')?>/participa/">
                <div class="thumbnail" id="thumb-network">
                    <div class="caption section-top">
                        <h4 class="text-center">Red Minka</h4>
                    </div>
                    <div class="caption section-bottom">
                        <p class="text-center">Comparte tu mapa de conexiones y entra en contacto con personas y organizaciones de todo el continente. Un mundo de oportunidades para los interesados en economía colaborativa</p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="home-entry" style="background: #FFF">
    <a href="/?p=521">
<div class="semana-section  text-center container">
        <!--img src="<?php bloginfo('template_url'); ?>/images/semana_actual.png" /-->
</div>
    </a>
</div>

<div class="minka-site-catalogo-shortcuts">
	<div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12 shortcuts-invitation text-center">
                <div class="row">
                    <h3>Conoce el Catálogo de la economía colaborativa y encuentra soluciones para potenciar tu proyecto</h3>
                </div>
                <div class="row invitation-actions">
                    <a class="btn btn-lg btn-primary post-new " href="<?php bloginfo('url')?>/new-solution">Publica una nueva solución</a>
                    <a class="btn btn-lg btn-primary see-all" href="<?php bloginfo('url')?>/solution">Ver todas</a>                 
                </div>
                <div class="row invitation-search">
                    <?php echo do_shortcode('[wpdreams_ajaxsearchlite]'); ?>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12 shortcuts">
                <ul class="list-unstyled">
                    <li>
                        <a href="<?php bloginfo('url')?>/category/espacios-materiales-y-equipamientos-fisicos-y-digitales/?post_type=solution"> 
                        <span class="fa-stack fa-lg">
                            <i class=" sh-house fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-home fa-stack-1x fa-inverse"></i>
                        </span>
                        Espacios y Materiales
                        </a>
                    </li>
                    <li>
                        <a href="<?php bloginfo('url')?>/category/mapeo-contactos-y-gestion/?post_type=solution"> 
                        <span class="fa-stack fa-lg">
                            <i class=" sh-group fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-group fa-stack-1x fa-inverse"></i>
                        </span>
                        Mapeo y Gestión
                        </a>
                    </li>
                    <li>
                        <a href="<?php bloginfo('url')?>/category/financiamiento-y-voluntariado/?post_type=solution"> 
                        <span class="fa-stack fa-lg">
                            <i class=" sh-money fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-money fa-stack-1x fa-inverse"></i>
                        </span>
                        Financiamiento y Voluntariado
                        </a>
                    </li>
                    <li>
                        <a href="<?php bloginfo('url')?>/category/saberes/?post_type=solution"> 
                        <span class="fa-stack fa-lg">
                            <i class=" sh-book fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-book fa-stack-1x fa-inverse"></i>
                        </span>
                        Saberes y Formación
                        </a>
                    </li>
                </ul>
            </div>
        </div>
</div>
</div>

<div class="home-entry soluciones" style="background: #FFF">
	<div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="tagline">Algunas Soluciones</h3>
            </div>
        </div>
        <div class="row solutions">
            <div class="col-lg-12">           
                <?php
                wp_reset_postdata();
                $args = array(
                    'posts_per_page'   => 4,
                    'orderby'          => 'rand',
                    'post_type'		   => 'solution'
                );
                $the_query = new WP_Query($args);
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    include(locate_template('home_category_list_post.php'));
                }
                wp_reset_postdata();
                ?>            
            </div>       
        </div>
        <div class="text-center">
            <a class="btn btn-lg btn-primary see-all" href="<?php bloginfo('url')?>/solution/">Ver Catalogo Completo</a>          
        </div>
    </div>
</div>

<div class="minka-novedades " style="background: #FFF">
    <div class="home-entry">
    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <h3 class="tagline">Novedades</h3>
            </div>   
        </div>
        <div class="row minka-site-last-posts block-center">
            <div class="col-lg-12">                
                <?php
                wp_reset_postdata();
                $args = array(
                    'posts_per_page'   => 3,
                    'orderby'          => 'date',
                    'order'          => 'DESC',
                    'post_type'        => 'post'
                );
                $the_query = new WP_Query($args);
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    include(locate_template('home_post_list.php'));
                }
                wp_reset_postdata();
                ?>                     
            </div>
        </div>   
        <div class="text-center">
            <a class="btn btn-lg btn-primary see-all-blog" href="<?php bloginfo('url')?>/blog">Blog</a>    
        </div>
    </div>
</div>
</div>


<?php get_footer(); ?>
