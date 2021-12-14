<?php

/**
 * 404リダイレクトに関する処理
 */
function aliz_404_redirect() {

  if ( is_404() ) {
    wp_safe_redirect( home_url( '/' ) );
    exit();
  }

}

add_action('template_redirect', 'aliz_404_redirect');


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function aliz_theme_support() {

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

add_action( 'after_setup_theme', 'aliz_theme_support' );


///**
// * 言語に関する処理
// */
//function aliz_set_lang() {
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
//add_action('after_setup_theme', 'aliz_set_lang');


/**
 * Register and Enqueue Styles.
 */
function aliz_register_styles() {

  $theme_version = wp_get_theme()->get( 'Version' );
  $dir = get_stylesheet_directory_uri();

  wp_enqueue_style( 'aliz-style', get_stylesheet_uri(), array(), $theme_version );
  wp_enqueue_style( 'aliz-style-reset', $dir . '/assets/css/reset.css', array(), $theme_version );
  wp_enqueue_style( 'aliz-style-common', $dir . '/assets/css/common/index.css', array( 'aliz-style-reset' ), $theme_version );
  wp_enqueue_style( 'aliz-style-parts', $dir . '/assets/css/parts/index.css', array( 'aliz-style-reset' ), $theme_version );

  // 各ページのCSSを読み込み
  if ( is_front_page() ) {
    wp_enqueue_style( 'aliz-style-top', $dir . '/assets/css/pages/top.css', array( 'aliz-style-common', 'aliz-style-parts' ), $theme_version );
  } elseif ( is_home() ) {
    wp_enqueue_style( 'aliz-style-posts', $dir . '/assets/css/pages/posts.css', array( 'aliz-style-common', 'aliz-style-parts' ), $theme_version );
  } elseif ( is_page('**') ) {
    wp_enqueue_style( 'aliz-style-**', $dir . '/assets/css/pages/**.css', array( 'aliz-style-common', 'aliz-style-parts' ), $theme_version );
  } elseif ( is_singular() ) {
    wp_enqueue_style( 'aliz-style-post', $dir . '/assets/css/pages/post.css', array( 'aliz-style-common', 'aliz-style-parts' ), $theme_version );
  } else {
//    wp_enqueue_style( 'aliz-style-default', $dir . '/assets/css/pages/default.css', array( 'aliz-style-common' ), $theme_version );
  }

}

add_action( 'wp_enqueue_scripts', 'aliz_register_styles' );


/**
 * Register and Enqueue Scripts.
 */
function aliz_register_scripts() {

  $theme_version = wp_get_theme()->get( 'Version' );
  $dir = get_stylesheet_directory_uri();

  wp_enqueue_script( 'aliz-js-main', $dir . '/assets/js/common.js', array('aliz-js-jquery'), $theme_version, false );

  // 各ページのJSを読み込み
  if ( is_front_page() ) {
    wp_enqueue_script( 'aliz-js-top', $dir . '/assets/js/pages/top.js', array( 'aliz-js-main' ), $theme_version, false );
  } elseif ( is_home() ) {
    wp_enqueue_script( 'aliz-js-posts', $dir . '/assets/js/pages/posts.js', array( 'aliz-js-main' ), $theme_version, false );
  } elseif ( is_page('**') ) {
    wp_enqueue_script( 'aliz-js-**', $dir . '/assets/js/pages/**.js', array( 'aliz-js-main' ), $theme_version, false );
  } elseif ( is_singular() ) {
    wp_enqueue_script( 'aliz-js-post', $dir . '/assets/js/pages/post.js', array( 'aliz-js-main' ), $theme_version, false );
  } else {
//    wp_enqueue_script( 'aliz-js-default', $dir . '/assets/js/pages/default.js', array( 'aliz-js-main' ), $theme_version, false );
  }

}

add_action( 'wp_enqueue_scripts', 'aliz_register_scripts' );


add_action('phpmailer_init', function($phpmailer) {
  $phpmailer->SMTPKeepAlive = true;
  $phpmailer->Sender = get_bloginfo('admin_email');
});
