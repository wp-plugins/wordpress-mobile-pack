<?php

/*
$Id: header.php 132044 2009-07-05 06:26:08Z jamesgpearce $

$URL: http://plugins.svn.wordpress.org/wordpress-mobile-pack/trunk/themes/mobile_pack_base/header.php $

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

?><!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head profile="http://gmpg.org/xfn/11">
    <link href="<?php print $wpmp_group_templates; ?>/styles/reset-low.css" rel="stylesheet" type="text/css" />
    <?php if (get_bloginfo('stylesheet_url') != $base_style = get_theme_root_uri() . '/mobile_pack_base/style.css') { ?>
      <link href="<?php print $base_style ?>" rel="stylesheet" type="text/css" />
    <?php } ?>
    <link href="<?php bloginfo('stylesheet_url'); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php print $wpmp_group_templates; ?>/styles/baseStyles-low.css" rel="stylesheet" type="text/css" />
    <?php if (get_bloginfo('stylesheet_url') != $base_style = get_theme_root_uri() . '/mobile_pack_base/style.css') { ?>
      <link href="<?php print $base_style ?>.nokia.css" rel="stylesheet" type="text/css" />
    <?php } ?>
    <link href="<?php bloginfo('stylesheet_url'); ?>.nokia.css" rel="stylesheet" type="text/css" />
    <?php wpmp_theme_head(); ?>
  </head>
  <body class='<?php print $wpmp_group; ?>'>
    <div id="wrap">
      <div id="header" style='height:auto'>
        <p><a href="<?php echo get_option('home'); ?>/"><strong><?php bloginfo('name'); ?></strong></a></p>
        <p><?php bloginfo('description'); ?></p>
      </div>
      <?php wpmp_theme_menu(false); ?>