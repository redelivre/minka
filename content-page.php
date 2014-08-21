<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package minka
 */
?>

<?php
$thumbnail_id = get_post_thumbnail_id(); 
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' );
		if(intval($thumbnail_id) > 0)
		{?>
			<div class="post-thumbnail-box">
				<div class="post-thumbnail" style="background-image: url(<?php echo wp_get_attachment_url( $thumbnail_id ); ?>);">
				</div>
			</div><?php
		}?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'minka' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<footer class="entry-footer">
		<?php edit_post_link( __( 'Edit', 'minka' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
