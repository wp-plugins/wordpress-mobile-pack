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

?>

      <div id="footer">
        <?php
          if (file_exists($wpmp_include = wpmp_theme_group_file('footer.php'))) {
            include_once($wpmp_include);
          } else {
            ?>
              <p>Powered by the <a href="http://mobiforge.mobi/wordpress-mobile-pack">WordPress Mobile Pack</a> | Theme designed by <a href="http://ribot.co.uk">ribot</a></p>
            <?php
          }
        ?>
        <?php wp_footer(); ?>
      </div>
    </div>
  </body>
</html>