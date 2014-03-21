<?php get_header(); ?>
<div id="container">
<div id="contents">
<?php if (have_posts()) : while (have_posts()) : the_post();  ?>
<article class="post">
<h1><?php the_title(); ?></h1>
<div class="tags"><?php edit_post_link('Edit', '', ''); ?> <?php the_time('l, F jS Y.') ?> </div></section>  
<?php the_content(); ?>	
<div style="clear: both"></div>
<?php the_tags('tags: ',', ',''); ?>
</article>
<?php endwhile; ?>
<?php else : ?>
<article class="post"><h2>Not Found</h2>Sorry, but you are looking for something that isn't here.</article>
<?php endif; ?>
</div>
<?php get_footer(); ?>