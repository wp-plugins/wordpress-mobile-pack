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
Plugin URI: http://wordpress.org/extend/plugins/wordpress-mobile-pack/
Description: The dotMobi WordPress Mobile Pack is a complete toolkit to help mobilize your WordPress site and blog. It includes a <a href='themes.php?page=wpmp_switcher_admin'>mobile switcher</a>, <a href='themes.php?page=wpmp_theme_widget_admin'>filtered widgets</a>, and content adaptation for mobile device characteristics. Activating this plugin will also install a selection of mobile <a href='themes.php'>themes</a> by <a href='http://ribot.co.uk'>ribot</a>, a top UK mobile design team. Also check out <a href='http://mobiforge.com/wordpress-mobile-pack' target='_blank'>the documentation</a> and <a href='http://mobiforge.com/forum/dotmobi/wordpress' target='_blank'>the forums</a>. If you like the plugin, please rate us on the <a href='http://wordpress.org/extend/plugins/wordpress-mobile-pack/'>WordPress directory</a>.
Version: 1.1.3
Author: James Pearce, dotMobi, and team
Author URI: http://www.assembla.com/spaces/wordpress-mobile-pack
*/

define('WPMP_VERSION', '1.2.0');

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
add_action('admin_menu', 'wordpress_mobile_pack_admin_menu');

add_action('send_headers', 'wordpress_mobile_pack_send_headers');
add_filter('get_the_generator_xhtml', 'wordpress_mobile_pack_generator');
add_filter('get_the_generator_html', 'wordpress_mobile_pack_generator');

function wordpress_mobile_pack_send_headers($wp) {
  @header("X-Mobilized-By: WordPress Mobile Pack " . WPMP_VERSION);
}
function wordpress_mobile_pack_generator($generator) {
  return '<meta name="generator" content="WordPress ' . get_bloginfo( 'version' ) . ', fitted with the WordPress Mobile Pack ' . WPMP_VERSION . '" />';
}

function wordpress_mobile_pack_admin_notices() {
  if($warning=get_option('wpmp_warning')) {
    print "<div class='error'><p><strong style='color:#770000'>Critical WordPress Mobile Pack Issue</strong></p><p>$warning</p><p><small>(" . __('Deactivate and re-activate the WordPress Mobile Pack once resolved.') . ")</small></p></div>";
  }
  if($flash=get_option('wpmp_flash')) {
    print "<div class='error'><p><strong style='color:#770000'>Important WordPress Mobile Pack Notice</strong></p><p>$flash</p></div>";
    update_option('wpmp_flash', '');
  }
}

function wordpress_mobile_pack_admin_menu() {
  if (isset($_POST['wordpress_mobile_pack_force_copy_theme'])){  //user has forced theme upgrade
    update_option('wpmp_warning', '');
    update_option('wpmp_flash', '');
    wordpress_mobile_pack_directory_copy_themes(dirname(__FILE__) . "/themes", get_theme_root(), false);
    $redirect = explode("?", $_SERVER['REQUEST_URI']);
    wp_redirect($redirect[0]);
  }
}

function wordpress_mobile_pack_activate() {
  update_option('wpmp_warning', '');
  update_option('wpmp_flash', '');
  if (wordpress_mobile_pack_readiness_audit()) {
    wordpress_mobile_pack_directory_copy_themes(dirname(__FILE__) . "/themes", get_theme_root());
    wordpress_mobile_pack_hook('activate');
  }
}

function wordpress_mobile_pack_readiness_audit() {
  $ready = true;
  $why_not = array();

  if (version_compare(PHP_VERSION, '6.0.0', '>=')) {
    $ready = false;
    $why_not[] = __('<strong>PHP version not supported.</strong> PHP versions 6 and greater are not yet supported by this plugin, and you have version ') . PHP_VERSION;
  }

  $cache_dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'wpmp_transcoder' . DIRECTORY_SEPARATOR . 'c';
  $cache_does = '';
  if (!file_exists($cache_dir)) {
  	$cache_does = "does not exist";
  } elseif (!is_writable($cache_dir)) {
  	$cache_does = "is not writable";
  } elseif (!is_executable($cache_dir) && DIRECTORY_SEPARATOR=='/') {
  	$cache_does = "is not executable";
  }
  if($cache_does!='') {
    $ready = false;
    $why_not[] = __('<strong>Not able to cache images</strong> to ') . $cache_dir . __('. That directory ') . $cache_does . __('. Please ensure that the web server has write- and execute-access to it.');
  }

  $theme_dir = str_replace('/', DIRECTORY_SEPARATOR, get_theme_root());
  $theme_does = '';
  if (!file_exists($theme_dir)) {
  	$theme_does = "does not exist";
  } elseif (!is_writable($theme_dir)) {
  	$theme_does = "is not writable";
  } elseif (!is_executable($theme_dir) && DIRECTORY_SEPARATOR=='/') {
  	$theme_does = "is not executable";
  }
  if($theme_does!='') {
    $ready = false;
    $why_not[] = __('<strong>Not able to install theme files</strong> to ') . $theme_dir . __('. That directory ') . $theme_does . __('. Please ensure that the web server has write- and execute-access to it.');
  } // a similar check is in wordpress_mobile_pack_directory_copy_themes, checking lower directories as it recurses down


  if (!$ready) {
    update_option('wpmp_warning', join("<hr />", $why_not));
  }
  return $ready;
}


function wordpress_mobile_pack_directory_copy_themes($source_dir, $destination_dir, $benign=true) {
  if(file_exists($destination_dir)) {
  	$dir_does = '';
	  if (!is_writable($destination_dir)) {
	  	$dir_does = "is not writable";
	  } elseif (!is_executable($destination_dir) && DIRECTORY_SEPARATOR=='/') {
	  	$dir_does = "is not executable";
	  }
	  if($dir_does!='') {
      update_option('wpmp_warning', __('<strong>Could not install theme files</strong> to ') . $destination_dir . __('. That directory ') . $dir_does . __('. Please ensure that the web server has write- and execute-access to it.'));
      return;
    }
  } elseif (!is_dir($destination_dir)) {
    if ($destination_dir[0] != ".") {
	    mkdir($destination_dir);
	  }
  }

  $dir_handle = opendir($source_dir);
  while($source_file = readdir($dir_handle)) {
    if ($source_file[0] == ".") {
      continue;
    }
    if (file_exists($destination_child = "$destination_dir/$source_file") && $benign) {
      update_option('wpmp_flash', "<strong>Existing Mobile Pack theme files were found</strong>, but they were not overwritten by the plugin activation." .
                    "</p><p>You are advised to upgrade your Mobile Pack theme files to version " . WPMP_VERSION .
                    "</p><p>(<strong>NB</strong>: take precautions if you have manually edited any existing Mobile Pack theme files - your changes will need to be re-applied after upgrade.) " .
                    "</p><br /><form method='post' action='" . $_SERVER['REQUEST_URI'] . "'>".
                    "<input type='submit' name='wordpress_mobile_pack_force_copy_theme' value='Yes please - I&apos;ll upgrade all my themes' />&nbsp;&nbsp;".
                    "<input type='submit' value='No thanks - I&apos;ll leave my themes as they are' />".
                    "</form><p>");
      continue;
    }
    if (is_dir($source_child = "$source_dir/$source_file")) {
      wordpress_mobile_pack_directory_copy_themes($source_child, $destination_child, $benign);
      continue;
    }

    if (file_exists($destination_child) && !is_writable($destination_child)) {
      update_option('wpmp_warning', __('<strong>Could not install file</strong> to ') . $destination_child . __('. Please ensure that the web server has write- access to that file.'));
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
