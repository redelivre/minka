<?php
/*
Template Name: Semana
*/
get_header(); 
$highlight = array();?>

<div class="container">

    <?php
        wp_reset_postdata();
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        global $wp_query;
        $args = array(
            'post_type' => array( 'post' ),
            'category_name' => 'semana-2',
            'paged' => $paged,
            'order' => 'DESC',
            'orderby' => 'modified',
            'post__not_in' => $highlight
        );
        $the_query = new WP_Query($args);
    ?>

    <!-- Main Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <div id="post-<?php the_ID(); ?>" class="post-preview">
                                <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) {
                                    the_post_thumbnail('homepage-thumb');	
                                } ?>
                                    <h2 class="post-title">
                                        <a href="<?php the_permalink(); ?>" rel="bookmark">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>
                                    <h3 class="post-subtitle">

                                    <span class="date"></span>
                                        <?php the_excerpt(); ?>
                                    </h3>
                                </a>
                                <p class="post-meta"><?php echo the_date(); ?></p>
                            </div>
                            <hr>
                        <?php endwhile; ?>

                    </div>
                </div>
            </div>
            <div class="col-md-3 semana-sidebar">
                <?php dynamic_sidebar('semana-sidebar'); ?>
            </div>
        </div>
                
    </div>


<?php get_footer(); ?>
