<?php

/*
$Id$

$URL$

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

get_header();

?>
<div id="wrapper">
  <div id="content">
    <div class="post">
      <h2><?php _e('Archives by Month:', 'wpmp'); ?></h2>
      <ul>
        <?php wp_get_archives('type=monthly'); ?>
      </ul>
    </div>
    <div class="post">
      <h2><?php _e('Archives by Subject:', 'wpmp'); ?></h2>
      <ul>
        <?php wp_list_categories(); ?>
      </ul>
    </div>
  </div>
  <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
