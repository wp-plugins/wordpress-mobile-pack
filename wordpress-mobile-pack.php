<?php

/*
$Id: wordpress-mobile-pack.php 8197 2009-04-29 06:49:22Z jpearce $

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

/*
Plugin Name: WordPress Mobile Pack
Plugin URI: http://mobiforge.com/wordpress-mobile-pack
Description: The dotMobi WordPress Mobile Pack is a complete toolkit to help mobilize your WordPress site and blog. It includes a <a href='themes.php?page=wpmp_switcher_admin'>mobile switcher</a>, <a href='themes.php?page=wpmp_theme_widget_admin'>filtered widgets</a>, and content adaptation for mobile device characteristics. Activating this plugin will also install a selection of mobile <a href='themes.php'>themes</a>. Also check out <a href='http://mobiforge.com/wordpress-mobile-pack' target='_blank'>the documentation</a> and <a href='http://mobiforge.com/forum/dotmobi/wordpress' target='_blank'>the forums</a>.
Version: v1.0
Author: James Pearce, dotMobi
Author URI: http://www.mobiforge.com/users/james-pearce
*/

// you could disable sub-plugins here
global $wpmp_plugins;
$wpmp_plugins = array(
  "wpmp_switcher",
  "wpmp_barcode",
  "wpmp_ads",
  "wpmp_deviceatlas",
  "wpmp_transcoder",
);

foreach($wpmp_plugins as $wpmp_plugin) {
  if (file_exists($wpmp_plugin_file = dirname(__FILE__) . "/plugins/$wpmp_plugin/$wpmp_plugin.php")) {
    include_once($wpmp_plugin_file);
  }
}

register_activation_hook('wordpress-mobile-pack/wordpress-mobile-pack.php', 'wordpress-mobile-pack_activate');
register_deactivation_hook('wordpress-mobile-pack/wordpress-mobile-pack.php', 'wordpress-mobile-pack_deactivate');
add_action('admin_notices', 'wordpress-mobile-pack_admin_notices');

function wordpress-mobile-pack_admin_notices() {
  if($warning=get_option('wpmp_warning')) {
    print "<div class='error'><p>$warning</p><p><small>(" . __('Deactivate and re-activate the WordPress Mobile Pack once resolved.') . ")</small></p></div>";
  }
}

function wordpress-mobile-pack_activate() {
  update_option('wpmp_warning', '');
  wordpress-mobile-pack_soft_copy(dirname(__FILE__) . "/themes", get_theme_root());
  wordpress-mobile-pack_hook('activate');
}

function wordpress-mobile-pack_soft_copy($source_dir, $destination_dir) {
  if(file_exists($destination_dir) && !is_writable($destination_dir)) {
    update_option('wpmp_warning', __('<strong>Could not install files</strong> to ') . $destination_dir . ('. Please ensure that the web server has write-access to that directory.'));
    return;
  }
  if(!file_exists($destination_dir) || !is_dir($destination_dir)) {
    mkdir($destination_dir, 0777, true);
  }
  foreach(scandir($source_dir) as $source_file) {
    if ($source[0] == ".") {
      continue;
    }
    if (file_exists($destination_child = "$destination_dir/$source_file")) {
      continue;
    }
    if (is_dir($source_child = "$source_dir/$source_file")) {
      wordpress-mobile-pack_soft_copy($source_child, $destination_child);
      continue;
    }
    copy($source_child, $destination_child);
  }
}

function wordpress-mobile-pack_deactivate() {
  wordpress-mobile-pack_hook('deactivate');
}

function wordpress-mobile-pack_hook($action) {
  global $wpmp_plugins;
  foreach($wpmp_plugins as $wpmp_plugin) {
    if (function_exists($function = $wpmp_plugin . "_" . $action)) {
      call_user_func($function);
    }
  }
}




?>
