<?
//Single Ngamason 

get_header();
$key1_thumb="thumb";
$key2_price="price";
$key3_rating="rating";
$key4_review="review";
$key5_listprice="listprice";
$key6_disc="disc";
$key7_desc="desc";
$key8_afflink="afflink";

$gambar_thumb=get_post_meta($post->ID, $key1_thumb, true);
$harga=get_post_meta($post->ID, $key2_price, true);
$rating=get_post_meta($post->ID,$key3_rating,true);
$review=get_post_meta($post->ID,$key4_review,true);
$listprice=get_post_meta($post->ID,$key5_listprice,true);
$diskon=get_post_meta($post->ID,$key6_disc,true);
$deskripsi=get_post_meta($post->ID,$key7_desc,true);
$afflink=get_post_meta($post->ID,$key8_afflink,true);
?>

    <div id="single">
          <h2 style="text-align:center"><?php the_title(); ?></h2>
          
          <div id="detail1">
           <img src="<? echo bloginfo('template_directory')?>/timthumb.php?src=<?=$gambar_thumb?>&w=250&h=250&zc=0">
          <br>
           <p align="center"><a href="<?=$afflink?>" class="tombol">BUY HERE</a></p>
            </div>
            
            <div id="detail2">
            
            <div id="ket1">Rating</div>
            <div id="ket2"> : <?=$rating?></div>
            <div class="clear"></div>
            
            <div id="ket1">Review</div>
            <div id="ket2"> : <?=$review?></div>
             <div class="clear"></div>
             
            <div id="ket1">Listprice</div>
            <div id="ket2"> : <?=$listprice?></div>
            <div class="clear"></div>
            
            <div id="ket1">Price</div>
            <div id="ket2"> : $<?=$harga?></div>
            <div class="clear"></div>
            
            <div id="ket1">Disc</div>
            <div id="ket2"> : <?=$diskon?></div>
            <div class="clear"></div>
            <br>
            
            <p><?=$deskripsi?></p>
			</div>
			<div class="entry-content">
         	<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'ngamason' ) ); ?>
           	</div> 
           
            <br>
         
     
             <div class="clear"></div>
        
        <div id="produk-random">
         <p> <b>Interested another product :</b></p>
         
             
<?php
$args = array( 'posts_per_page' => 3, 'orderby' => 'rand' );
$rand_posts = get_posts( $args );
 foreach ( $rand_posts as $post ) : 
 $gambar_thumb_acak=get_post_meta($post->ID, $key1_thumb, true);
  setup_postdata( $post ); ?>
       <div id="kotak-acak">
             
             <img src="<? echo bloginfo('template_directory')?>/timthumb.php?src=<?=$gambar_thumb_acak?>&w=100&h=100&zc=0" class="gambar-acak">
       <div id="ndukur">      
      <a href="<?php the_permalink(); ?>" class="judul"><?php the_title(); ?></a><br>
     </div>
     <div id="ngisor">
      <a href="<?=$afflink?>" class="tombol2">BUY HERE</a></div>
     </div>
       <?php endforeach; 
wp_reset_postdata(); ?>
       
        <div class="clear"></div>
        <br><br>
           </div>
           </div>
<?
get_footer(); 
?>
