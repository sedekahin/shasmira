<?php get_header(); ?>
<div id="container">
<div id="contents">
<h1><?php bloginfo('name'); ?> - <?php bloginfo('description'); ?> <?php  if ( get_query_var('paged') ) { echo ' ('; echo _e('page') . ' ' . get_query_var('paged');   echo ')';  } ?></h1>
<div id="amazon"><?php fastestwp_amazon_home(); ?></div>
</div>
<?php get_footer(); ?>