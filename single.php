<?php

/**
 * wordpress-template の投稿ページのファイルです。
 *
 * @since wordpress-template 1.0.0
 */

get_header();

while (have_posts()) {
  the_post(); ?>

  <main class="main page-single">
    Single
  </main><!-- #site-content -->

<?php
}
get_footer();
