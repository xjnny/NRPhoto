<?php

/**
 * wp_underscore functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wp_underscore
 */
if (!function_exists('wp_underscore_setup')) :

  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function wp_underscore_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     * If you're building a theme based on wp_underscore, use a find and replace
     * to change 'wp_underscore' to the name of your theme in all the template files.
     */
    load_theme_textdomain('wp_underscore', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(array(
        'menu-1' => esc_html__('Primary', 'wp_underscore'),
    ));

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Set up the WordPress core custom background feature.
    add_theme_support('custom-background', apply_filters('wp_underscore_custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    )));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');
  }

endif;
add_action('after_setup_theme', 'wp_underscore_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wp_underscore_content_width() {
  $GLOBALS['content_width'] = apply_filters('wp_underscore_content_width', 640);
}

add_action('after_setup_theme', 'wp_underscore_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wp_underscore_widgets_init() {
  register_sidebar(array(
      'name' => esc_html__('Sidebar', 'wp_underscore'),
      'id' => 'sidebar-1',
      'description' => esc_html__('Add widgets here.', 'wp_underscore'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget' => '</section>',
      'before_title' => '<h2 class="widget-title">',
      'after_title' => '</h2>',
  ));

  register_sidebar(array('name' => 'Contact Widget'));
}

add_action('widgets_init', 'wp_underscore_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function wp_underscore_scripts() {
  wp_register_style('Source_Sans_Pro', 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600');
  wp_enqueue_style('Source_Sans_Pro');

  wp_register_style('Font_Awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
  wp_enqueue_style('Font_Awesome');
  
  wp_enqueue_style('wp_underscore-style', get_stylesheet_uri());

  wp_enqueue_script('wp_underscore-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true);

  wp_enqueue_script('wp_underscore-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true);

  wp_enqueue_script('jquery', get_template_directory_uri() . '/js/jquery-3.2.1.min.js', array(), 1.1, true);

  wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', array('jquery'), 1.1, true);

  wp_enqueue_script('tweenmax', get_template_directory_uri() . '/js/TweenMax.min.js', array('jquery'), 1.1, true);

  wp_enqueue_script('scrollreveal', get_template_directory_uri() . '/js/scrollreveal.min.js', array('jquery'), 1.1, true);


  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}

add_action('wp_enqueue_scripts', 'wp_underscore_scripts');

//add support for custom logo in customizer
function theme_prefix_setup() {

  add_theme_support('custom-logo', array(
      'height' => 480,
      'width' => 1600,
      'flex-width' => true,
      'header-selector' => '.site-title a'
  ));
}

add_action('after_setup_theme', 'theme_prefix_setup');

function theme_prefix_the_custom_logo() {

  if (function_exists('the_custom_logo')) {
    the_custom_logo();
  }
}

// set up woocommerce support
add_action('after_setup_theme', 'woocommerce_support');

function woocommerce_support() {
  add_theme_support('woocommerce');
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Load metabox files.
 */
require get_template_directory() . '/inc/hover-image-metabox.php';
require get_template_directory() . '/inc/about-metaboxes.php';
require get_template_directory() . '/inc/contact-metaboxes.php';

// hide description and reviews tabs for woocommerce
add_filter('woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98);

function wcs_woo_remove_reviews_tab($tabs) {
  unset($tabs);
  return $tabs;
}

/*
 * change labels for 'Posts' in admin dashboard to 'Galleries'
 */

function change_post_label() {
  global $menu;
  global $submenu;
  $menu[5][0] = 'Galleries';
  $submenu['edit.php'][5][0] = 'Galleries';
  $submenu['edit.php'][10][0] = 'Add Gallery';
  $submenu['edit.php'][16][0] = 'Gallery Tags';
}

function change_post_object() {
  global $wp_post_types;
  $labels = &$wp_post_types['post']->labels;
  $labels->name = 'Galleries';
  $labels->singular_name = 'Gallery';
  $labels->add_new = 'Add Gallery';
  $labels->add_new_item = 'Add Gallery';
  $labels->edit_item = 'Edit Gallery';
  $labels->new_item = 'Gallery';
  $labels->view_item = 'View Gallery';
  $labels->search_items = 'Search Galleries';
  $labels->not_found = 'No Gallery found';
  $labels->not_found_in_trash = 'No Gallery found in Trash';
  $labels->all_items = 'All Galleries';
  $labels->menu_name = 'Galleries';
  $labels->name_admin_bar = 'Galleries';
}

add_action('admin_menu', 'change_post_label');
add_action('init', 'change_post_object');

// add category nicenames in body and post class
function category_id_class($classes) {
  global $post;
  foreach (( get_the_category($post->ID)) as $category) {
    $classes[] = $category->category_nicename;
  }
  return $classes;
}

add_filter('post_class', 'category_id_class');
add_filter('body_class', 'category_id_class');


// Enable shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');
