<?php

/*
$Id: wpmp_ads_widget_admin.php 8197 2009-04-29 06:49:22Z jpearce $

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

?>

<p>
  <label for="wpmp_ads_title"><?php _e('Title:'); ?></label>
  <?php print wpmp_ads_option('wpmp_ads_title', '', 'widefat'); ?>
</p>
<p>
  <label for="wpmp_ads_provider"><?php _e('Provider:'); ?></label>
  <?php print wpmp_ads_option('wpmp_ads_provider'); ?>
</p>
<p>
  <label for="wpmp_ads_publisher_id"><?php _e('Publisher ID:'); ?></label>
  <br />
  <?php print wpmp_ads_option('wpmp_ads_publisher_id', '', 'widefat'); ?>
  <br />Examples: a14948dbe57548e (for AdMob) or pub-2709587966093607 (for Google)
</p>
<p>
  This widget should only be used on mobile themes. If you are using a theme from, or derived from, the WordPress Mobile Pack, you will need to enable this widget <a href='/wp-admin/themes.php?page=wpmp_theme_widget_admin' target='_blank'>here</a>.
</p>
<p>
  <?php print wpmp_ads_option('wpmp_ads_desktop_disable'); ?>
  <label for="wpmp_ads_desktop_disable"><?php _e('Attempt to automatically disable for desktop themes (when switcher is running)'); ?></label>
</p>
<p>
  Note also that this widget will be completely hidden if no ads are returned from the provider you have selected.
</p>
<input type="hidden" id="wpmp_ads" name="wpmp_ads" value="1" />
