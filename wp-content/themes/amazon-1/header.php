<!DOCTYPE html>
<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8">
<title> <?php
$sapi = get_search_query(); 
$kucing = explode(" ", $sapi);
$asinku = end(array_values($kucing));
$judul = str_replace($asinku,"",$sapi);
?>
<?php if ( is_home() ) { ?>
<?php bloginfo('name'); ?> - <?php bloginfo('description');?>
<?php } elseif ( is_search() ) { ?>
<?php echo $judul; ?> - <?php bloginfo('name'); ?>
<?php } ?>
</title>
<?php get_template_part( 'ai' ); ?>	
<link rel="Shortcut Icon" href="<?php echo get_template_directory_uri();?>/images/favicon.ico" type="image/x-icon" />
<?php wp_head(); ?>
<?php if ( is_search()) : ?>
<link rel="canonical" href="<?php bloginfo('url');?>/<?php $ab=strtolower($s); echo str_replace(' ', '-',$ab); ?>.html" />
<meta name='description' content='best buy for <?php echo $judul; ?> , and all product <?php echo $judul; ?> at <?php bloginfo('name'); ?>'/>
<?php $keyword = str_replace(" ",",",$judul); ?>
<meta name='keywords' content='<?php echo $keyword; ?> '/>
<?php endif ?> 
</head>
<body> 
<div id="wrap">
<header id="header">
<a href="<?php echo home_url() ; ?>"><div class="logo"><?php bloginfo('name'); ?></div></a>
<div style="clear: both"></div>
<div class="desc"><?php bloginfo('description'); ?></div>
</header>
<div style="clear: both"></div>
<?php if (is_search()) { ?> 
<div xmlns:v="http://rdf.data-vocabulary.org/#" id="breadchumb">
<span typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php bloginfo('url'); ?>">Home</a></span> » <span class="hidden" typeof="v:Breadcrumb"><a rel="v:url" property="v:title" href="<?php bloginfo('url');?>/<?php $ab=strtolower($s); echo str_replace(' ', '-',$ab); ?>.html"><?php echo $judul; ?></a></span> 
</div>
<?php }?>