<?php

/*
$Id: wpmp_barcode_widget_admin.php 180811 2009-12-08 06:13:51Z jamesgpearce $

$URL: http://plugins.svn.wordpress.org/wordpress-mobile-pack/trunk/plugins/wpmp_barcode/wpmp_barcode_widget_admin.php $

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

?>


<div class="wrap">
  <h2>
    <?php _e('mpexo') ?>
    <p style='font-size:small;font-style:italic;margin:0'>
      <?php _e('Part of the WordPress Mobile Pack'); ?>
    </p>
  </h2>
  <p><?php printf(e_("<a%s>mpexo</a> is an online directory of mobile sites built using the WordPress Mobile Pack."), " target='_blank' href='http://www.mpexo.com'"); ?></p>
  <p><?php _e("Using the settings below, you can easily, and automatically, get your own site listed on mpexo. It's a safe and easy way to drive traffic to the mobile version of your site."); ?></p>
  <p><strong><?php _e("This feature is currently in beta."); ?></strong> <?php _e("It is therefore disabled by default, but will be <em>enabled</em> by default in the forthcoming v2.0 of the WordPress Mobile Pack. Please provide feedback in the meantime."); ?></p>
  <form method="post" action="">
    <table class="form-table">
      <tr>
        <th><?php _e('List my site on mpexo'); ?></th>
        <td>
          <?php print wpmp_mpexo_option('wpmp_mpexo_enabled_beta', 'wpmpMpexo();'); ?>
          <br />
          <?php _e('Publish summary information about your site to the mpexo server. This makes it easier for mobile users to find it.'); ?>
        </td>
      </tr>

      <tr class='wpmp_mpexo'>
        <th><?php _e('Site description'); ?></th>
        <td>
          <?php print wpmp_mpexo_option('wpmp_mpexo_description', 'wpmpMpexo();'); ?>
          <br />
          <?php _e('mpexo can display a description of your blog. This can be the tagline in your <a href="options-general.php">general settings</a>, or some custom text.'); ?>
          <br />
          <?php print wpmp_mpexo_option('wpmp_mpexo_description_override'); ?>
        </td>
      </tr>
      <tr class='wpmp_mpexo_description_custom'>
        <th><?php _e('Custom description'); ?></th>
        <td>
          <?php print wpmp_mpexo_option('wpmp_mpexo_description_custom', '', 'regular-text'); ?>
          <br />
          <?php _e("Use this custom description instead of the blog's tagline."); ?>
        </td>
      </tr>
      <tr class='wpmp_mpexo'>
        <th><?php _e('Publish classification'); ?></th>
        <td>
          <?php print wpmp_mpexo_option('wpmp_mpexo_classification'); ?>
          <br />
          <?php _e("mpexo can display your site's tags and categories, helping readers discover the topics you cover."); ?>
        </td>
      </tr>
      <tr class='wpmp_mpexo'>
        <th><?php _e('Publish content titles'); ?></th>
        <td>
          <?php print wpmp_mpexo_option('wpmp_mpexo_content'); ?>
          <br />
          <?php _e('mpexo can display the titles of your posts and pages so readers can see teasers of your recent content.'); ?>
        </td>
      </tr>
      <tr class='wpmp_mpexo'>
        <th><?php _e('Gather mobile popularity'); ?></th>
        <td>
          <?php print wpmp_mpexo_option('wpmp_mpexo_popularity'); ?>
          <br />
          <?php _e("This will gather an aggregated summary of your site's popularity amongst mobile users. This data is never published on a per-site basis: it is merely used to order blogs by popularity."); ?>
        </td>
      </tr>
      <tr class='wpmp_mpexo'>
        <th><?php _e('Gather diagnostics'); ?></th>
        <td>
          <?php print wpmp_mpexo_option('wpmp_mpexo_diagnostics'); ?>
          <br />
          <?php _e("This gathers non-sensitive details regarding your Mobile Pack configuration. This is never published: it is merely used to diagnose issues you may have with your site."); ?>
        </td>
      </tr>
      <tr class='wpmp_mpexo'>
        <th><?php _e('Register email address'); ?></th>
        <td>
          <?php print wpmp_mpexo_option('wpmp_mpexo_email'); ?>
          <br />
          <?php _e("This registers your email address so we can contact you regarding updates to mpexo and the Mobile Pack. This is never published or shared: unchecking this box will unsubscribe you from any mailings."); ?>
        </td>
      </tr>
    </table>
    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Save Changes'); ?>" />
    </p>
  </form>
</div>

<script>
  var wpmp_pale = 0.3;
  var wpmp_speed = 'slow';
  function wpmpMpexo(speed) {
    if (speed==null) {speed=wpmp_speed;}
    var mpexo_enabled = jQuery("#wpmp_mpexo_enabled_beta")[0].checked;
    var description = jQuery("#wpmp_mpexo_description").val();
    jQuery(".wpmp_mpexo").children().fadeTo(speed, mpexo_enabled ? 1 : wpmp_pale);
    jQuery(".wpmp_mpexo_description_custom").children().fadeTo(speed, (mpexo_enabled && description=='custom') ? 1 : wpmp_pale);
  }
  wpmpMpexo(-1);
</script>