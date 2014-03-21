<?php if (have_posts()) : while (have_posts()) : the_post();  ?>
<article class="post" id="post-<?php the_ID(); ?>"> 
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
 <section class="tags"><?php the_date(); ?> | <?php the_category(', ') ?> </section>  
</article>
<?php endwhile; ?>
<?php else : ?>
<article class="post"><h2>Not Found</h2>Sorry, but you are looking for something that isn't here.</article>
<?php endif; ?>