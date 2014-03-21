<?
get_header(); ?>
<div id="produk">
           
          <?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
            
              <div id="kotak">
            <p><a href="<?php the_permalink(); ?>" class="judul"><?php the_title(); ?></a></p>
            <? $key1="thumb";
			   $key2="price";
			   $gambar_thumb=get_post_meta($post->ID, $key1, true);
			   $harga=get_post_meta($post->ID, $key2, true);
			   ?>
            <img src="<? echo bloginfo('template_directory')?>/timthumb.php?src=<?=$gambar_thumb?>&w=180&h=180&zc=0">
            <p class="harga"> 
			<? if(empty($harga)) { } else {?>
            $<? echo $harga;?>
            <? } ?></p>
            </div>
            	<?php endwhile; ?>
            	
         	<?php endif; // end have_posts() check ?>
          
            
            <div class="clear"></div>
            <div id="nav-halaman">
            <?php 
			if(function_exists('wp_pagenavi')) {
				wp_pagenavi(); 
			} else {
				echo "Silahkan install plugin wp pagenavi dulu gan..";	
			}
			?>
            </div>
            <br><br>
        </div>
        
        <div class="clear"></div>
        
   <?php get_footer(); ?>