<?php


/**
 * Displays notices for required plugins in WordPress Admin.
 *
 *
 */
function my_theme_dependencies()
{

    if (!function_exists('wp_rest_menus_init')) {
        echo '<div class="error"><p>' . __('Warning: ' . wp_get_theme() . ' requires the "WP API Menus". Install it <a href="' . get_admin_url() . '/plugin-install.php?s=WP+API+Menus&tab=search&type=term">here.</a>') . '</p></div>';
    }

    if (!class_exists('acf')) {
        echo '<div class="error"><p>' . __('Warning: ' . wp_get_theme() . ' requires the "Advanced Custom Fields PRO". Download it <a target="_blank" href="https://www.advancedcustomfields.com/pro/">here.</a>') . '</p></div>';
    }

}


/**
 * Allow cross origin requests, necessary for our webpack dev server
 *
 *
 */
function add_cors_http_header()
{
    header("Access-Control-Allow-Origin: *");
}


/**
 * Register Custom Image Sizes and add theme support for post thumbnail
 *
 *
 */
add_theme_support('post-thumbnails');
set_post_thumbnail_size(672, 372, true);
add_image_size('max', 1920, 1080, false);
add_image_size('icon', 32, 32, false);


/**
 * Register Navigation Menu's
 *
 *
 */
register_nav_menus([
    'main' => __('Main Navigation'),
    'footer' => __('Footer Navigation'),
]);


/**
 * Enqueue Front-end Scripts/Styles
 *
 *
 */
function alt_enqueue_frontend_scripts_styles()
{
//        wp_enqueue_script('jquery', null, null, null, true);
    wp_enqueue_script('MainJs', get_template_directory_uri() . '/dist/bundle.js', null, null, true);
    wp_enqueue_style('FontAwesome', '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css', null, null, null);
}


/**
 * Register Global Options Page
 *
 *
 */
if (function_exists('acf_add_options_page')) {
    acf_add_options_page('Global Options');
}


/**
 * Add Actions
 *
 *
 */
add_action('init', 'add_cors_http_header');
add_action('admin_notices', 'my_theme_dependencies');
add_action('wp_enqueue_scripts', 'alt_enqueue_frontend_scripts_styles');

/**
 * Remove Actions
 *
 *
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

