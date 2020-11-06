<?php

/**
 * 404リダイレクトに関する処理
 */
function tt_404_redirect() {

  if ( is_404() ) {
    wp_safe_redirect( home_url( '/' ) );
    exit();
  }

}

add_action('template_redirect', 'tt_404_redirect');


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tt_theme_support() {

  // Add default posts and comments RSS feed links to head.
  add_theme_support( 'automatic-feed-links' );

  // Custom background color.
  add_theme_support(
    'custom-background',
    array(
      'default-color' => 'fff',
    )
  );

  // Set content-width.
  global $content_width;
  if ( ! isset( $content_width ) ) {
    $content_width = 580;
  }

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
   */
  add_theme_support( 'post-thumbnails' );

  // Set post thumbnail size.
  set_post_thumbnail_size( 1200, 9999 );

  /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
  add_theme_support( 'title-tag' );

  /*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'script',
      'style',
    )
  );

  // Add support for full and wide align images.
  add_theme_support( 'align-wide' );

  // Add support for responsive embeds.
  add_theme_support( 'responsive-embeds' );

  // 管理バーの非表示
  add_filter('show_admin_bar', '__return_false');

}

add_action( 'after_setup_theme', 'tt_theme_support' );


///**
// * 言語に関する処理
// */
//function tt_set_lang() {
//
//  global $lang;
//
//  if ( strpos( home_url(), 'en' ) !== false ) {
//    $lang = 'en';
//  } else {
//    $lang = 'jp';
//  }
//
//}
//
//add_action('after_setup_theme', 'tt_set_lang');


/**
 * Register and Enqueue Styles.
 */
function tt_register_styles() {

  $theme_version = wp_get_theme()->get( 'Version' );
  $dir = get_stylesheet_directory_uri();

  wp_enqueue_style( 'tt-style', get_stylesheet_uri(), array(), $theme_version );
  wp_enqueue_style( 'tt-style-reset', $dir . '/assets/css/reset.css', array(), $theme_version );
  wp_enqueue_style( 'tt-style-common', $dir . '/assets/css/common.css', array( 'tt-style-reset' ), $theme_version );

  // 各ページのCSSを読み込み
  if ( is_front_page() ) {
    wp_enqueue_style( 'tt-style-top', $dir . '/assets/css/pages/top.css', array( 'tt-style-common' ), $theme_version );
  } elseif ( is_home() ) {
    wp_enqueue_style( 'tt-style-posts', $dir . '/assets/css/pages/posts.css', array( 'tt-style-common' ), $theme_version );
  } elseif ( is_page('**') ) {
    wp_enqueue_style( 'tt-style-**', $dir . '/assets/css/pages/**.css', array( 'tt-style-common' ), $theme_version );
  } elseif ( is_singular() ) {
    wp_enqueue_style( 'tt-style-post', $dir . '/assets/css/post/post.css', array( 'tt-style-common' ), $theme_version );
  } else {
    wp_enqueue_style( 'tt-style-default', $dir . '/assets/css/pages/default.css', array( 'tt-style-common' ), $theme_version );
  }

}

add_action( 'wp_enqueue_scripts', 'tt_register_styles' );


/**
 * Register and Enqueue Scripts.
 */
function tt_register_scripts() {

  $theme_version = wp_get_theme()->get( 'Version' );
  $dir = get_stylesheet_directory_uri();

  wp_enqueue_script( 'tt-js-jquery', $dir . '/assets/js/jquery-3.4.1.min.js', array(), '3.4.1', false );
  wp_enqueue_script( 'tt-js-jquery-cookie', $dir . '/assets/js/jquery.cookie.js', array('tt-js-jquery'), $theme_version, false );
  wp_enqueue_script( 'tt-js-main', $dir . '/assets/js/common.js', array('tt-js-jquery'), $theme_version, false );

  // 各ページのJSを読み込み
  if ( is_front_page() ) {
    wp_enqueue_script( 'tt-js-top', $dir . '/assets/js/pages/top.js', array( 'tt-js-main' ), $theme_version, false );
  } elseif ( is_home() ) {
    wp_enqueue_script( 'tt-js-posts', $dir . '/assets/js/pages/posts.js', array( 'tt-js-main' ), $theme_version, false );
  } elseif ( is_page('**') ) {
    wp_enqueue_script( 'tt-js-**', $dir . '/assets/js/pages/**.js', array( 'tt-js-main' ), $theme_version, false );
  } elseif ( is_singular() ) {
    wp_enqueue_script( 'tt-js-post', $dir . '/assets/js/posts/post.js', array( 'tt-js-main' ), $theme_version, false );
  } else {
    wp_enqueue_script( 'tt-js-default', $dir . '/assets/js/pages/default.js', array( 'tt-js-main' ), $theme_version, false );
  }

}

add_action( 'wp_enqueue_scripts', 'tt_register_scripts' );


add_action('phpmailer_init', function($phpmailer) {
  $phpmailer->SMTPKeepAlive = true;
  $phpmailer->Sender = get_bloginfo('admin_email');
});
