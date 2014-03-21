<?php
/*
 * XML Sitemap Template
 */
/*
/--------------------------------------------------------------------\
|                                                                    |
| License: GPL                                                       |
|                                                                    |
| Simple Multisite Sitemaps                                         |
| Copyright (C) 2012, Jan Brinkmann                                  |
| http://the-luckyduck.de                                            |
|                                                                    |
| This program is free software; you can redistribute it and/or      |
| modify it under the terms of the GNU General Public License        |
| as published by the Free Software Foundation; either version 2     |
| of the License, or (at your option) any later version.             |
|                                                                    |
| This program is distributed in the hope that it will be useful,    |
| but WITHOUT ANY WARRANTY; without even the implied warranty of     |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the      |
| GNU General Public License for more details.                       |
|                                                                    |
| You should have received a copy of the GNU General Public License  |
| along with this program; if not, write to the                      |
| Free Software Foundation, Inc.                                     |
| 51 Franklin Street, Fifth Floor                                    |
| Boston, MA  02110-1301, USA                                        |   
|                                                                    |
\--------------------------------------------------------------------/

*/

header( 'HTTP/1.0 200 OK' );
header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ), true );
echo '<?xml version="1.0" encoding="'.get_option( 'blog_charset' ).'"?'.'>'; 
?>
<urlset	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
	    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php
$q = get_bloginfo('name');
include 'api.php';
$pxml = aws_signed_request($region, array("Operation"=>"ItemSearch","AssociateTag"=>$associate_tag,"Keywords"=>$q,"ResponseGroup"=>"Large","SearchIndex"=>"All","ItemPage"=>1), $public_key, $private_key);
//print the entire xml
//print_r($pxml);
$root = new SimpleXMLElement($pxml);
$results = $root->Items->Item;
$i = 0;
foreach ($results as $result => $v) {
$asinku = explode ('/',$v->DetailPageURL );
$asinbaru= explode ('%3F',$asinku[5] );
$judul = $v->ItemAttributes->Title;
$merk = $v->ItemAttributes->ProductGroup;
echo '<url>'; 
echo '<loc>'. get_home_url().'/'.ubah_tanda(hilangkan_spesial_karakter($judul)).'-'.strtolower($asinbaru[0]).'.html</loc> ';
echo '<lastmod>2012-10-11T04:13:38+00:00</lastmod> '; 
echo '<changefreq>weekly</changefreq> '; 
echo '<priority>0.6</priority>'; 
echo '</url>'; 
   if (++$i == 8) break;
}
?>
</urlset>