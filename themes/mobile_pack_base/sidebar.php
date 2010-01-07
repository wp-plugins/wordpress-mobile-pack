<?php

/*
$Id: sidebar.php 189239 2010-01-03 17:14:41Z jamesgpearce $

$URL: http://plugins.svn.wordpress.org/wordpress-mobile-pack/trunk/themes/mobile_pack_base/sidebar.php $

Copyright (c) 2009 James Pearce & friends, portions mTLD Top Level Domain Limited, ribot, Forum Nokia

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


if (file_exists($wpmp_include = wpmp_theme_group_file('sidebar.php'))) {
  include_once($wpmp_include);
} else {
  $before_sidebar = '<ul>';
  $after_sidebar = '</ul>';
}

print '<div id="sidebar">';
ob_start();
ob_start();
dynamic_sidebar();
$list = ob_get_contents();
ob_end_clean();
$list = ob_get_contents() . $list; //ob stack funny stuff in old widgets
ob_end_clean();
if ($list) {
  print $before_sidebar . $list . $after_sidebar;
}
print '</div>';

?>
