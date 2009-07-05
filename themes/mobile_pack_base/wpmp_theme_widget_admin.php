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

?><div class="wrap">
  <h2>
    <?php _e('Mobile Widgets') ?>
    <p style='font-size:small;font-style:italic;margin:0'>
      <?php _e('Part of the WordPress Mobile Pack'); ?>
    </p>
  </h2>
  <form method="post" action="">
    <?php global $wp_registered_sidebars, $wp_registered_widgets; ?>
    <?php $enabled = get_option('wpmp_theme_widget'); ?>
    <?php $sidebar_widgets = wp_get_sidebars_widgets(); ?>
    <?php foreach($sidebar_widgets as $sidebar=>$widgets) { ?>
      <h3>
        <?php print $wp_registered_sidebars[$sidebar]['name']; ?>
      </h3>
      <p>
        <?php _e('Select which of the'); ?>
        <a target='_blank' href='/wp-admin/widgets.php?sidebar=<?php print urlencode($sidebar); ?>'><?php _e('widgets enabled for this sidebar'); ?></a>
        <?php _e('will show on the mobile theme:'); ?>
      </p>
      <table class="form-table">
        <?php
          $mobile_widgets = array();
          $non_mobile_widgets = array();
          foreach($widgets as $widget) {
            if(stripos($wp_registered_widgets[$widget]['name'], 'mobile')!==false &&
               stripos($wp_registered_widgets[$widget]['name'], 'barcode')===false) {
              $mobile_widgets[] = $widget;
            } else {
              $non_mobile_widgets[] = $widget;
            }
          }
          $widgets = array_merge($mobile_widgets, $non_mobile_widgets);
        ?>
        <?php foreach($widgets as $widget) { ?>
          <?php if ($name = $wp_registered_widgets[$widget]['name']) { ?>
            <tr>
              <th><?php print $name; ?></th>
              <td>
                <input type='checkbox'
                       class='wpmp_theme_widget'
                       name='wpmp_theme_widget[]'
                       value='<?php print attribute_escape($widget); ?>'
                       onchange='wpmpThemeWidget(this)'
                       <?php if (is_array($enabled) && array_search($widget, $enabled)!==false) { print "checked='true'"; } ?>
                />
              </td>
            </tr>
          <?php } ?>
        <?php } ?>
      </table>
    <?php } ?>
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Save Changes'); ?>" />
    </p>
  </form>
</div>

<script>
  var wpmp_pale = 0.3;
  var wpmp_speed = 'slow';
  function wpmpThemeWidgets(speed) {
    widgets = jQuery(".wpmp_theme_widget").get();
    for(widget in widgets) {
      wpmpThemeWidget(widgets[widget], speed);
    }
  }
  function wpmpThemeWidget(widget, speed) {
    if (speed==null) {speed=wpmp_speed;}
    if(widget.checked) {
      jQuery(widget).parent().siblings().fadeTo(speed, 1);
    } else {
      jQuery(widget).parent().siblings().fadeTo(speed, wpmp_pale);
    }
  }
  wpmpThemeWidgets(-1);
</script>
