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
Plugin Name: Mobile Barcode
Plugin URI: http://mobiforge.com/wordpress-mobile-pack
Description: Provides a widget (intended to be used on a desktop theme) that displays a 2D-barcode for navigating to the mobile site. This plugin is tested with WordPress 2.5, 2.6 and 2.7.
Version: v1.0.8223
Author: James Pearce, dotMobi
Author URI: http://www.mobiforge.com/users/james-pearce
*/


add_action('init', 'wpmp_barcode_init');

function wpmp_barcode_init() {
  wp_register_sidebar_widget('wpmp_barcode_widget', __('Mobile Barcode'), 'wpmp_barcode_widget',
    array('classname' => 'wpmp_barcode_widget', 'description' => __( "A 2D-barcode used for navigating to a mobile URL"))
  );
  wp_register_widget_control('wpmp_barcode_widget', __('Mobile Barcode'), 'wpmp_barcode_widget_control');
}
function wpmp_barcode_activate() {
  foreach(array(
    'wpmp_barcode_title'=>'Our mobile site',
    'wpmp_barcode_link'=>
      function_exists('wpmp_switcher_domains') ?
        "http://" . wpmp_switcher_domains('mobile', true) :
        ''
      ,
    'wpmp_barcode_size'=>'190',
    'wpmp_barcode_help'=>'true',
    'wpmp_barcode_reader_list'=>'true'
  ) as $name=>$value) {
    if (get_option($name)=='') {
      update_option($name, $value);
    }
  }
}

function wpmp_barcode_deactivate() {}

function wpmp_barcode_widget($args) {
	extract($args);
	if (($link = get_option('wpmp_barcode_link'))!='') {
    print $before_widget;
    if (($title = get_option('wpmp_barcode_title'))=='') {
      $title = "Our mobile site";
    }
    print $before_title . $title . $after_title;
    $size = get_option('wpmp_barcode_size');
    if(!is_numeric($size) && $size < 64) {
      $size = 190;
    } else {
      $size = floor($size);
    }
	 if ( is_page() ) {
		 $deep_link = get_page_link();
	 } else if ( is_single() ) {
		 $deep_link = the_permalink();
	 } else {
		 $deep_link = $link.$_SERVER['REQUEST_URI'];
	 }
    $url = "http://chart.apis.google.com/chart?chs=" .
           $size . "x" . $size .
           "&amp;cht=qr&amp;choe=UTF-8&amp;chl=" .
           urlencode($deep_link);
    print "<img width='$size' height='$size' src='$url' />";
    if(get_option('wpmp_barcode_help')=='true') {
      print "<p>";
      print __('This is a 2D-barcode containing the address of our');
      print " <a href='$link' target='_blank'>" . __('mobile site') . "</a>. ";
      print __('If your mobile has a barcode reader, simply snap this bar code with the camera and launch the site. ');
      print "</p>";
    }
    if(get_option('wpmp_barcode_reader_list')=='true') {
      print "<p>";
      print __('Many companies provide barcode readers that you can install on your mobile, and all of the following are compatible with this format:');
      print "</p>";
      include_once('barcode_reader_list.php');
      print "<ul>";
      foreach(wpmp_barcode_barcode_reader_list() as $name=>$url) {
        print "<li><a href='$url' target='_blank'>$name</a></li>";
      }
      print "</ul>";
    }
  	print $after_widget;
	}
}

function wpmp_barcode_widget_control() {
  if($_POST['wpmp_barcode']) {
    wpmp_barcode_widget_options_write();
  }
  include('wpmp_barcode_widget_admin.php');
}

function wpmp_barcode_widget_options_write() {
  foreach(array(
    'wpmp_barcode_title'=>false,
    'wpmp_barcode_link'=>false,
    'wpmp_barcode_size'=>false,
    'wpmp_barcode_help'=>true,
    'wpmp_barcode_reader_list'=>true,
  ) as $option=>$checkbox) {
    if(isset($_POST[$option])){
      $value = $_POST[$option];
			$value = trim($value);
			$value = stripslashes_deep($value);
      update_option($option, $value);
    } elseif ($checkbox) {
      update_option($option, 'false');
    }
  }
  if (!is_numeric(get_option('wpmp_barcode_size'))) {
    update_option('wpmp_barcode_size', '190');
  }
}

function wpmp_barcode_option($option, $onchange='', $class='', $style='') {
  switch ($option) {
    case 'wpmp_barcode_title':
    case 'wpmp_barcode_link':
    case 'wpmp_barcode_size':
      return wpmp_barcode_option_text(
        $option, $onchange, $class, $style
      );

    case 'wpmp_barcode_help':
    case 'wpmp_barcode_reader_list':
      return wpmp_barcode_option_checkbox(
        $option, $onchange
      );
  }
}

function wpmp_barcode_option_text($option, $onchange='', $class='', $style='') {
  if ($onchange!='') {
    $onchange = 'onchange="' . attribute_escape($onchange) . '" onkeyup="' . attribute_escape($onchange) . '"';
  }
  if ($class!='') {
    $class = 'class="' . attribute_escape($class) . '"';
  }
  if ($style!='') {
    $style = 'style="' . attribute_escape($style) . '"';
  }
  $text = '<input type="text" id="' . $option . '" name="' . $option . '" value="' . attribute_escape(get_option($option)) . '" ' . $onchange . ' ' . $class . ' ' . $style . '/>';
  return $text;
}

function wpmp_barcode_option_checkbox($option, $onchange='') {
  if ($onchange!='') {
    $onchange = 'onchange="' . attribute_escape($onchange) . '"';
  }
  $checkbox = '<input type="checkbox" id="' . $option . '" name="' . $option . '" value="true" ' . (get_option($option)==='true'?'checked="true"':'') . ' ' . $onchange . ' />';
  return $checkbox;
}



?>
