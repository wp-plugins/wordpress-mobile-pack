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

/*
Plugin Name: WordPress Mobile Pack
Plugin URI: http://mobiforge.com/wordpress-mobile-pack
Description: The dotMobi WordPress Mobile Pack is a complete toolkit to help mobilize your WordPress site and blog. It includes a <a href='themes.php?page=wpmp_switcher_admin'>mobile switcher</a>, <a href='themes.php?page=wpmp_theme_widget_admin'>filtered widgets</a>, and content adaptation for mobile device characteristics. Activating this plugin will also install a selection of mobile <a href='themes.php'>themes</a>. Also check out <a href='http://mobiforge.com/wordpress-mobile-pack' target='_blank'>the documentation</a> and <a href='http://mobiforge.com/forum/dotmobi/wordpress' target='_blank'>the forums</a>.
Version: 1.1
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

if(!$warning=get_option('wpmp_warning')) {
  foreach($wpmp_plugins as $wpmp_plugin) {
    if (file_exists($wpmp_plugin_file = dirname(__FILE__) . "/plugins/$wpmp_plugin/$wpmp_plugin.php")) {
      include_once($wpmp_plugin_file);
    }
  }
}

register_activation_hook('wordpress-mobile-pack/wordpress-mobile-pack.php', 'wordpress_mobile_pack_activate');
register_deactivation_hook('wordpress-mobile-pack/wordpress-mobile-pack.php', 'wordpress_mobile_pack_deactivate');
add_action('admin_notices', 'wordpress_mobile_pack_admin_notices');

function wordpress_mobile_pack_admin_notices() {
  if($warning=get_option('wpmp_warning')) {
    print "<div class='error'><p><strong style='color:#770000'>Critical WordPress Mobile Pack Issue</strong></p><p>$warning</p><p><small>(" . __('Deactivate and re-activate the WordPress Mobile Pack once resolved.') . ")</small></p></div>";
  }
}

function wordpress_mobile_pack_activate() {
  update_option('wpmp_warning', '');
  if (wordpress_mobile_pack_readiness_audit()) {
    wordpress_mobile_pack_soft_copy(dirname(__FILE__) . "/themes", get_theme_root());
    wordpress_mobile_pack_hook('activate');
  }
}

function wordpress_mobile_pack_readiness_audit() {
  $ready = true;
  $why_not = array();

//  if (version_compare(PHP_VERSION, '5.0.0', '<')) {
//    $ready = false;
//    $why_not[] = __('<strong>PHP version not compatible.</strong> PHP version 5 is required for this plugin, and you have version ') . PHP_VERSION;
//  }

  if (version_compare(PHP_VERSION, '6.0.0', '>=')) {
    $ready = false;
    $why_not[] = __('<strong>PHP version not supported.</strong> PHP versions 6 and greater are not yet supported by this plugin, and you have version ') . PHP_VERSION;
  }

  $cache_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'wpmp_transcoder' . DIRECTORY_SEPARATOR . 'c';
  if(!file_exists($cache_dir) || !is_writable($cache_dir) || !is_executable($cache_dir)) {
    $ready = false;
    $why_not[] = __('<strong>Not be able to cache images</strong> to ') . $cache_dir . __('. Please ensure that the web server has write- and execute-access to that directory.');
  }

  $theme_dir = get_theme_root();
  if(!file_exists($theme_dir) || !is_writable($theme_dir) || !is_executable($theme_dir)) {
    $ready = false;
    $why_not[] = __('<strong>Not able to install theme files</strong> to ') . $theme_dir . __('. Please ensure that the web server has write- and execute-access to that directory.');
  } // a similar check is in wordpress_mobile_pack_soft_copy, checking lower directories as it recurses down


  if (!$ready) {
    update_option('wpmp_warning', join("<hr />", $why_not));
  }
  return $ready;
}


function wordpress_mobile_pack_soft_copy($source_dir, $destination_dir) {
  if(file_exists($destination_dir)) {
    if (!is_writable($destination_dir) || !is_executable($destination_dir)) {
      update_option('wpmp_warning', __('<strong>Could not install theme files</strong> to ') . $destination_dir . ('. Please ensure that the web server has write- and execute-access to that directory.'));
      return;
    }
  } elseif (!is_dir($destination_dir)) {
    mkdir($destination_dir);
  }

  $dir_handle = opendir($source_dir);
  while($source_file = readdir($dir_handle)) {
    if ($source_file[0] == ".") {
      continue;
    }
    if (file_exists($destination_child = "$destination_dir/$source_file")) {
      continue;
    }
    if (is_dir($source_child = "$source_dir/$source_file")) {
      wordpress_mobile_pack_soft_copy($source_child, $destination_child);
      continue;
    }
    copy($source_child, $destination_child);
  }
  closedir($dir_handle);
}

function wordpress_mobile_pack_deactivate() {
  wordpress_mobile_pack_hook('deactivate');
}

function wordpress_mobile_pack_hook($action) {
  global $wpmp_plugins;
  foreach($wpmp_plugins as $wpmp_plugin) {
    if (function_exists($function = $wpmp_plugin . "_" . $action)) {
      call_user_func($function);
    }
  }
}




?>
