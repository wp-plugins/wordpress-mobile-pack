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

header('Content-Type: text/html; charset=' . get_bloginfo('charset'));
header('Vary: user-agent, accept');
header('Cache-Control: no-cache, no-transform');

print '<?xml version="1.0" encoding="UTF-8"?>';

if (file_exists($wpmp_include = wpmp_theme_group_file('header.php'))) {
  include_once($wpmp_include);
} else {
  ?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.1//EN" "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile11.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
  <head profile="http://gmpg.org/xfn/11">
    <?php if (get_bloginfo('stylesheet_url') != wpmp_theme_base_style()) { ?>
      <link href="<?php print wpmp_theme_base_style() ?>" rel="stylesheet" type="text/css" />
    <?php } ?>
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php print get_theme_root_uri(); ?>/mobile_pack_base/style_structure.css" rel="stylesheet" type="text/css" />
  <?php
}
?>

  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?>&#187; Blog Archive <?php } ?><?php wp_title('&#187;'); ?></title>
  <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
  <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
  <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
  <?php wp_head(); ?>
</head>
<body class='<?php print wpmp_theme_group(); ?>'>
  <div id="wrap">
    <div id="header" style='height:auto'>
      <p><a href="<?php echo get_option('home'); ?>/"><strong><?php bloginfo('name'); ?></strong></a></p>
      <p><?php bloginfo('description'); ?></p>
    </div>
    <div id="menu">
      <ul class="breadcrumbs">
        <?php if (get_option('wpmp_theme_home_link_in_menu')=='true') {?>
          <li class="<?php if (is_home()) { ?>current_page_item<?php } else { ?>page_item<?php } ?>"><a href="<?php bloginfo('url'); ?>/" title="Home">Home</a></li>
        <?php } ?>
        <?php wp_list_pages('title_li=&depth=1'); ?>
      </ul>
    </div>