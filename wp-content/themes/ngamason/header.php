<html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="<? echo bloginfo('template_directory')?>style.css" type="text/css" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php wp_head(); ?>

</head>

<body>
	<div id="wrapper">
    	<div id="header">
        	<div id="atas">
            <div id="judul"><h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <p class="tag-line"><?php bloginfo( 'description' ); ?></p>
            </div>
            
            <div id="kanannya-judul">
            </div>
            <div class="clear"></div>
            </div>
            
        	<div id="navigasi">
            	<div id="menu-page">
                <ul>
             
               <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'Menu 1' ) ); ?>
                </ul>
                </div>
            </div>
        
        </div>
        <div id="isi">