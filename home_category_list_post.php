<?php
	
?>

<div class="home-cat-post-box">
	<span class="home-cat-post-cat" ><?php echo ''; ?></span>
	<h2 class="home-cat-post-title" ><?php echo the_title();?></h2>
	<span class="home-cat-post-thumbnail" ><?php echo the_post_thumbnail();?></span>
	<span class="home-cat-post-content" ><?php echo the_excerpt();?></span>
</div>