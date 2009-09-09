<?php

/*
$Id$

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

include_once('functions_persist.php');

add_action('init', 'wpmp_theme_init_in_use');
add_filter('dynamic_sidebar_params', 'wpmp_theme_dynamic_sidebar_params');
add_action('pre_get_posts', 'wpmp_theme_pre_get_posts');
add_action('the_content', 'wpmp_theme_the_content');

function wpmp_theme_init_in_use() {
  global $wp_registered_widgets;
  foreach ($wp_registered_widgets as &$widget) {
    if(function_exists($function = 'wpmp_theme_widget_' . strtolower(str_replace(' ', '_', $widget['name'])))) {
      $widget['callback'] = $function;
    }
  }
}

function wpmp_theme_dynamic_sidebar_params($params) {
  global $wp_registered_widgets;
  $widget = $params[0]['widget_id'];
  $widgets = get_option('wpmp_theme_widget');
  if (!is_array($widgets) || array_search($widget, $widgets)===false) {
    $wp_registered_widgets[$widget]['callback'] = 'wpmp_theme_widget_removed';
  }
  return $params;
}
function wpmp_theme_widget_removed() {
}


function wpmp_theme_pre_get_posts($wp_query) {
  $wp_query->query_vars['posts_per_page'] = get_option('wpmp_theme_post_count');
  return $wp_query;
}

function wpmp_theme_the_content($content) {
  if (is_single() || is_page()) {
    wpmp_theme_transcode_content($content);
    return $content;
  }
  if(stripos($content, 'class="more-link"')!==false) {
    return strip_tags($content);
  }
  $content = preg_replace("/\r/Usi", "\n", $content);
  $content = preg_replace("/\<\/?p[^>]*\>/Usi", "\n", $content);
  $content = preg_replace("/\<\/?br[^>]*\>/Usi", "\n", $content);
  $content = preg_replace("/\n+/Usi", "\n", $content);
  $content = preg_replace("/[\x20\x09]+/Usi", " ", $content);
  $content = strip_tags($content);
  $content = trim($content);
  $content = array_shift(explode("\n", $content, 2));
  $length = get_option('wpmp_theme_teaser_length');
  if(strlen($content)>$length) {
    $content = substr($content, 0, $length);
    $content = substr($content, 0, strripos($content, ' ')) . "...";
  }
  $content = balanceTags($content, true);
  global $id;
  $content .= ' <a href="'. get_permalink() . "#more-$id\" class=\"more-link\">Read more</a>";
  return $content;
}

function wpmp_theme_transcode_content(&$content) {
  if(get_option('wpmp_theme_transcoder_remove_media')=='true' && function_exists('wpmp_transcoder_remove_media')) {
    wpmp_transcoder_remove_media($content);
  }
  if(get_option('wpmp_theme_transcoder_partition_pages')=='true' && function_exists('wpmp_transcoder_partition_pages')) {
    wpmp_transcoder_partition_pages($content);
  }
  if(get_option('wpmp_theme_transcoder_shrink_images')=='true' && function_exists('wpmp_transcoder_shrink_images')) {
    wpmp_transcoder_shrink_images($content);
  }
  if(get_option('wpmp_theme_transcoder_simplify_styling')=='true' && function_exists('wpmp_transcoder_simplify_styling')) {
    wpmp_transcoder_simplify_styling($content);
  }
}

function wpmp_theme_widget_search($args) {
  extract($args);
  print $before_widget . $before_title . __( 'Search Site' ) . $after_title;
  include (TEMPLATEPATH . "/searchform.php");
  print $after_widget;
}


function wpmp_theme_widget_archives($args) {
	extract($args);
	$options = get_option('widget_archives');
	$title = empty($options['title']) ? __('Archives') : $options['title'];
  print $before_widget . $before_title . $title . $after_title . "<ul>";
  ob_start();
	wp_get_archives("type=monthly&show_post_count=1");
  $html = ob_get_contents();
  ob_end_clean();
  print wpmp_theme_widget_trim_list($html, "<li><a href='/?archives=month'>...more months</a></li>");
	print "</ul>$after_widget";
}

function wpmp_theme_widget_categories($args, $widget_args=1) {
	extract($args, EXTR_SKIP);
	if (is_numeric($widget_args)) {
		$widget_args = array('number' => $widget_args);
  }
	$widget_args = wp_parse_args($widget_args, array('number'=>-1));
	extract($widget_args, EXTR_SKIP);
	$options = get_option('widget_categories');
	if (!isset($options[$number])) { return; }
	$title = empty($options[$number]['title']) ? __('Categories') : $options[$number]['title'];
  print $before_widget . $before_title . $title . $after_title . "<ul>";
  ob_start();
  wp_list_categories("orderby=name&hierarchical=0&show_count=1&title_li=0");
  $html = ob_get_contents();
  ob_end_clean();
  print wpmp_theme_widget_trim_list($html, "<li><a href='/?archives=category'>...more categories</a></li>");
	print "</ul>$after_widget";
}

function wpmp_theme_widget_tag_cloud($args) {
	extract($args);
	$options = get_option('widget_tag_cloud');
	$title = empty($options['title']) ? __('Tags') : $options['title'];
  $tags = get_tags();
  if(sizeof($tags)>0) {
    print $before_widget . $before_title . $title . $after_title . "<ul>";
    $limit = get_option('wpmp_theme_widget_list_count');
    foreach($tags as $tag) {
      if($limit==0) {
        print "<li><a href='/?archives=tag'>...more tags</a>";
        break;
      }
      $limit--;
      print "<li><a href='" . get_tag_link( $tag->term_id ) . "'>$tag->name</a> ($tag->count)</li>";
    }
    print "</ul>" . $after_widget;
  }
}

function wpmp_theme_widget_recent_comments($args) {
  ob_start();
  wp_widget_recent_comments($args);
  $original = ob_get_contents();
  ob_end_clean();
  print str_replace("&cpage", "&amp;cpage", $original);
}
function wpmp_theme_widget_calendar($args) {
  ob_start();
  wp_widget_calendar($args);
  $original = ob_get_contents();
  ob_end_clean();
  preg_match_all("/(^.*)\<caption\>(.*)\<\/caption\>.*\<thead\>(.*)\<\/thead\>.*\<tfoot\>(.*)\<\/tfoot\>.*\<tbody\>(.*)\<\/tbody\>(.*$)/Usi", $original, $parts);
  print str_ireplace("<h2>&nbsp;</h2>", "<h2>Calendar</h2>", $parts[1][0]) .
        "<tr><td colspan='7'>" . $parts[2][0] . "</td></tr>" .
        $parts[3][0] .$parts[5][0] . $parts[4][0] .
        $parts[6][0];
}

function wpmp_theme_widget_rss($args, $widget_args=1) {
  ob_start();
  wp_widget_rss($args, $widget_args);
  $html = ob_get_contents();
  ob_end_clean();
  print preg_replace("/\<img.*\>/Usi", "", $html);
}
function wpmp_theme_widget_trim_list($html, $more='') {
  preg_match_all("/\<li.*\>(.*)\<\/li/Usi", $html, $parts);
  for($p = 0; sizeof($parts[1])>0 && $p < get_option('wpmp_theme_widget_list_count'); $p++) {
    print "<li>" . array_shift($parts[1]) . "</li>";
  }
  if(sizeof($parts[1])>0) {
    print $more;
  }
}
?>
