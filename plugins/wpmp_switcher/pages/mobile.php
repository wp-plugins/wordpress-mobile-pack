<?php

/*
$Id$

$URL$

Copyright (c) 2009 mTLD Top Level Domain Limited

Online support: http://mobiforge.com/forum/dotmobi/wordpress

This file is part of the WordPress Mobile Pack.

The WordPress Mobile Pack is Licensed under the Apache License, Version 2.0
(the "License"); you may not use this file except in compliance with the
License.

You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software distributed
under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR
CONDITIONS OF ANY KIND, either express or implied. See the License for the
specific language governing permissions and limitations under the License.
*/

function wpmp_ms_mobile_top($title, $menu=array()) {
  print "<?xml version='1.0' encoding='UTF-8'?>";
?>
<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
  <head profile="http://gmpg.org/xfn/11">
    <?php if (get_bloginfo('stylesheet_url') != $base_style = get_theme_root_uri() . '/mobile_pack_base/style.css') { ?>
      <link href="<?php print $base_style ?>" rel="stylesheet" type="text/css" />
    <?php } ?>
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php print get_theme_root_uri(); ?>/mobile_pack_base/style_structure.css" rel="stylesheet" type="text/css" />

    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php bloginfo('name'); ?> <?php print $title; ?></title>
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>
  </head>
  <body>
    <div id="page">
      <div id="header">
        <h1><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></h1>
        <h2><?php bloginfo('description'); ?></h2>
      </div>
      <?php
        if($menu) {
          $base = get_option('home');
          print '<div id="menu"><ul>';
          $page = $_SERVER['REQUEST_URI'];
          if(substr($page, -9)=="/wp-admin") {
            $page="$base/wp-admin/index.php";
          }
          foreach($menu as $name=>$link) {
            $item = '<li class="';
           if(strpos(strtolower($page), strtolower($link))!==false) {
              $item .= 'current_';
              $title = substr($name, ($name[0]=='_')?1:0);
            }
            if(substr($link, 0, 7)!="http://" && substr($link, 0, 8)!="https://") {
              $link = $base . $link;
            }
            $item .= 'page_item"><a href="' . $link . '" title="' . $name . '">' . __($name) . '</a></li>';
            if ($name[0]!='_') {
              print $item;
            }
          }
          print '</ul>&#160;</div>';
        }
      ?>
      <div id="wrapper">
        <div id="content">
          <h2><?php print $title; ?></h2>
          <?php
          }

          function wpmp_ms_mobile_bottom() {
          ?>
        </div>
      </div>
        <div id="footer">
        <p>Powered by the <a href="http://mobiforge.mobi/wordpress-mobile-pack">WordPress Mobile Pack</a> | Theme designed by <a href="http://ribot.co.uk">ribot</a></p>
        <?php wpmp_switcher_wp_footer(true); ?>
      </div>
    </div>
  </body>
</html>
<?php
}
?>
