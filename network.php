<?php
/*
Template Name: Network
*/
get_header(); 
$highlight = array();?>

<div class="home-entry" style="background: #FFF">
<div class="container">
	<!--div class="network-sidebar">
		<?php dynamic_sidebar('network-sidebar'); ?>
	</div-->
    <article class="network-article" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">
                <div class="solution-single-header">
                    <div class="title">
                            <?php the_title( '<h2>', '</h2>' ); ?>
                    </div>
                </div>
        </header><!-- .entry-header -->
        <!--div class="row">
            <div class="col-md-12 entry-content">
                
                <?php the_content(); ?>
            </div>
        </div-->

        <div class="row">
            <div class="network-entry col-md-12">
                    <div class="title">
                    Sumate al mapa!
                    </div>
                <div class="row">
                    <p class="col-md-9">
    Quiénes son y donde están los protagonistas de la economía colaborativa? A través del Mapa Minka es simple y rápido encontrar experiencias en todo el mundo.   
    Conoce personas y proyectos con los que impulsar nuevas ideas. 
                    </p>
                    <a href="https://docs.google.com/forms/d/1_WCjPMtuahS1ZYJTRzlv4R2_Y6E5hM18TCQ78Wm9iRE/viewform" class="btn btn-lg btn-primary col-md-3 pull-right see-all-blog" target="_blank">Sumate al mapa</a>
                </div>
                <!--div class="network-content" >
                    <div class="network-content-text" ><?php
                         $meta = get_post_meta(get_the_ID(), '.map-top', true);
                         if($meta == '')
                         {
                            _e('Who and where are the protagonists of the collaborative economy', 'minka');
                         }
                         else 
                         {
                            echo $meta;
                         }?>
                    </div>
                    <a class="new-solution-link" href="https://docs.google.com/forms/d/1_WCjPMtuahS1ZYJTRzlv4R2_Y6E5hM18TCQ78Wm9iRE/viewform"" target="_blank">
                        <div class="new-solution-link-text"><?php _e("To join the map", "minka") ?></div>
                    </a> 
                </div-->
            </div>
        </div>

        <div class="row">
            <div class="network-map col-md-12" >

                <div class="map clear">
                    <iframe class="fusion-map" src="https://www.google.com/fusiontables/embedviz?q=select+col7+from+1s0BRcG_iCRt8CvSqPvkY9csIz2LeT0tyVYt6JMN6&viz=MAP&h=false&lat=11.819012113821227&lng=-23.55164621875008&t=1&z=2&l=col7&y=2&tmplt=2&hml=ONE_COL_LAT_LNG"></iframe> 
                </div>
            </div>
        </div>
        <div class="row network-info">
            <div class="col-md-12">
                <div class="title">
                    Catálogo 
                </div>
                <p>
Sumá soluciones al catálogo online, compartiendo información sobre páginas web pensadas para compartir recursos de todo tipo. Juntos colaboramos con la difusión de los sistemas que permiten financiar con y sin dinero ideas y proyectos de todo tipo.
                </p>
                <div class="row invitation-actions center-block">
                    <a class="btn btn-lg btn-primary post-new " href="<?php bloginfo('url')?>/new-solution">Publica una nueva solución</a>
                    <a class="btn btn-lg btn-primary see-all" href="<?php bloginfo('url')?>/solution">Ver todas</a>                 
                </div>

            </div>

        </div>
        <div class="row network-info">
            <div class="col-md-12">
                <div class="title">
                    Organiza actividades en tu ciudad
                </div>
                <p>
Organiza tu propio Open Minka (encuentros de consultoría colaborativa), sumate a la Semana de la Economía Colaborativa, participa en Zona Colaborativa, en Hospeda Cultura o planifica espacios de intercambio y aprendizaje colaborativo. 
                </p>
            </div>
        </div>
        <div class="row network-info">
            <div class="col-md-12">
                <div class="title">
                    Se parte del equipo Minka
                </div>
                <p>
Sos economista, desarrollador, creativo, abogado, gestor, artista, contador, programador, o tenés experiencia o interés en economía solidaria y colaborativa?
                </p>
                <p>
                    Podés ser parte de nuestros equipos permanentes:
                </p>
                <ul>
                    <li>Producción</li>
                    <li>Formación</li>
                    <li>Investigación</li>
                    <li>Diseño y comunicación</li>
                </ul> 
                <p>
                Buscamos manos, cabezas y voluntarixs interesados en:
                </p>
                <ul>
                    <li>aprender</li>
                    <li>participar</li>
                    <li>colaborar</li>
                    <li>crecer</li>
                    <li>conectar</li>
                </ul>
                <p> 
                Sumate al equipo de trabajo escribiendo a informacionminka@gmail.com
                </p>
            </div>
        </div>
        <div class="row network-info">
            <div class="col-md-12">
                <div class="title">
Acerca tu propuesta
                </div>
                <p>
Tenés una idea, proyecto o actividad en tu ciudad? Compartila con la red   
Te ayudamos en la gestión, producción y difusión de tu propia agenda de economía colaborativa. 
                </p>
            </div>
        </div>



            </div>
            <!--div class="network-page-list-entry">
                <div class="network-page-list">
                    <?php
                    wp_reset_query();
                    global $wp_query;
                    
                    $cat_ori = get_term_by('slug', 'network', 'page_category');
                    
                    if($cat_ori != false)
                    {
                    
                        $cat_id = $cat_ori->term_id;
                        
                        if(function_exists('icl_object_id'))
                        {
                            $cat_id = icl_object_id($cat_id, "page_category", true, ICL_LANGUAGE_CODE);
                        }
                        
                        $wp_query = new WP_Query(array(
                            'post_type' => array( 'page' ),
                            'posts_per_page' => -1,
                            'order' => 'DESC',
                            'orderby' => 'modified',
                            'tax_query' => array(
                                array(
                                        'taxonomy' => 'page_category',
                                        'field'    => 'id',
                                        'terms'    => $cat_id,
                                ),
                            ),
                        ));
                        
                        if(have_posts())
                        {
                            while (have_posts())
                            {
                                the_post();?>
                                <div class="network-page-box" >
                                    <span class="network-page-title" ><h2><?php echo the_title();?></h2></span>
                                    <div class="network-page-box-content" >
                                        <div class="network-page-image">
                                            <div class="network-page-thumbnail" style="background-image: url(<?php echo wp_get_attachment_url( get_post_thumbnail_id() ); ?>)"></div>
                                        </div>
                                        <div class="network-page-box-text" ><?php the_content(); ?></div>
                                    </div>
                                </div><?php
                            }?>
                            <div class="clear"> </div>
                            <?php
                        }
                    } 
                ?></div>
            </div-->
        </div>
    </article><!-- #post-## -->
 	<div class="clear"> </div>
</div><!-- entry -->
</div><!-- entry -->
<?php get_footer(); ?>
