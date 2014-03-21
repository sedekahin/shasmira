<? get_header(); ?>
  <div id="pages">
  
 
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php comments_template( '', true ); ?>
			<?php endwhile; // end of the loop. ?>
  
  </div>
  <br><br>
<? get_footer();?>