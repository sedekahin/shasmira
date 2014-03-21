<?php get_header(); ?>
<div id="container">
<div id="contents">
<h1><?php 
$sapi = get_search_query(); 
$kucing = explode(" ", $sapi);
$asinku = end(array_values($kucing));
$judul = str_replace($asinku,"",$sapi);
echo $judul;
?></h1>
<div id="paragraph"><?php scraping_search_act1(); ?></div>
<?php fastestwp_amazon_show(); ?>
<?php scraping_search_act2(); ?>
<div style="clear: both"></div>
</div>
<?php get_footer(); ?>