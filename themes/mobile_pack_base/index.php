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

get_header();

$wpmp_group = wpmp_theme_device_group();

$wpmp_title = '';
$wpmp_archives = false;
$wpmp_not_found = false;
if (isset($_GET['archives']) && ($archives = $_GET['archives'])!='') {
  $wpmp_title = "Blog archives";
  $wpmp_archives = true;
} elseif (have_posts()) {
  $post = $posts[0];
  if (is_search()) {
    $wpmp_title = "Search results";
  } elseif (is_tag()) {
    $wpmp_title = "Archive for the '" . single_tag_title('', false) . "' tag";
  } elseif (is_category()) {
    $wpmp_title = "Archive for the '" . single_cat_title('', false) . "' category";
  } elseif (is_day()) {
    $wpmp_title = "Archive for " . get_the_time('F jS, Y');
  } elseif (is_month()) {
    $wpmp_title = "Archive for " . get_the_time('F, Y');
  } elseif (is_year()) {
    $wpmp_title = "Archive for " . get_the_time('Y');
  } elseif (is_author()) {
    $wpmp_title = "Author archive";
  } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
    $wpmp_title = "Blog archives";
  }
} else {
  $wpmp_title = "Page not found";
  $wpmp_not_found = true;
}

if ($wpmp_title!='') {
  if ($wpmp_group == 'nokia_low' || $wpmp_group == 'nokia_mid' || $wpmp_group == 'nokia_high') {
    print "<div id='wrapper'><div id='content'>";
    print "<h1>$wpmp_title</h1>";
  } else {
    print "<h2 class='pagetitle'>$wpmp_title</h2>";
    print "<div id='wrapper'><div id='content'>";
  }
} else {
  print "<div id='wrapper'><div id='content'>";
}

?>

<?php
  if ($wpmp_not_found) {
    print "<p>Use the menu to navigate the site, or search for a keyword:</p>";
    include (TEMPLATEPATH . "/searchform.php");
  
  } elseif ($wpmp_archives) {
    if ($archives=='category') {
      print "<h2>Archives by category</h2>";
      $links = array();
      foreach(get_categories() as $category) {
        $links[] = "<a href='" . get_category_link( $category->term_id ) . "'>$category->name</a>";
      }
      $links = implode(', ', $links);
    } elseif ($archives=='tag') {
      print "<h2>Archives by tag</h2>";
      $links = array();
      foreach(get_tags() as $tag) {
        $links[] = "<a href='" . get_tag_link( $tag->term_id ) . "'>$tag->name</a> ($tag->count)";
      }
      $links = implode(', ', $links);
    } elseif ($archives=='week' || $archives=='month' || $archives=='year') {
      print "<h2>Archives by $archives</h2>";
      $links = " ";
      wp_get_archives(array('type'=>$archives.'ly', 'show_post_count'=>true));
    }
    if($links) {
      print "<p>$links</p>";
    } else {
      print "<p>No archives found. Use the menu to navigate the site, or search for a keyword:</p>";
      include (TEMPLATEPATH . "/searchform.php");
    }
  
  } else { 
  ?>

  <?php $summary = get_option('wpmp_theme_post_summary'); ?>
  <?php global $more; ?>
  <?php $more=(is_single() || is_page())?1:0; ?>
  <?php $first = true; ?>
  <?php while (have_posts()) { ?>
    <?php the_post(); ?>
    <div class="post" id="post-<?php the_ID(); ?>">
      <?php if(is_single() || is_page()) { ?>
        <h1><?php the_title(); ?></h1>
        <p class="metadata"><?php the_time('F jS, Y') ?> by <?php the_author() ?></p>
        <p class="entry">
          <?php the_content(); ?>
        </p>
      <?php } else { ?>
        <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Link to <?php the_title(); ?>"><?php the_title(); ?></a></h2>
        <p class="metadata"><?php the_time('F jS, Y') ?> by <?php the_author() ?></p>
        <?php if ($summary!='none' && ($summary!='firstteaser' || $first)) { ?>
          <p class="entry">
            <?php the_content('Read more'); ?>
          </p>
        <?php } ?>
      <?php } ?>
      <p class="metadata">Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit','',' |'); ?> <?php comments_popup_link('No comments', '1 comment', '% comments'); ?>
        <?php if(is_single() || is_page()) { ?>
          <br />
          <?php if ($post->comment_status=='open') { ?>
            You can <a href="#respond">leave a comment</a> for this post.
          <?php } else { ?>
            Comments are closed for this post.
          <?php } ?>
        <?php } ?>
      </p>
    </div>
    <?php if((is_single() || is_page()) && (!function_exists('wpmp_transcoder_is_last_page') || wpmp_transcoder_is_last_page())) { comments_template(); } ?>
    <?php $first = false; ?>
  <?php } ?>
  <div class="navigation">
    <?php next_posts_link('Older') ?> <?php previous_posts_link('Newer') ?>
  </div>

  <?php
  }
?>

  </div>
  <?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
