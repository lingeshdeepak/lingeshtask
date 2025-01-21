<?php
/**
 * Plugin Name: Radio Program Scheduler
 * Description: Manage and display radio programs with an import feature.
 * Version: 1.0
 * Author: Your Name
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

include_once plugin_dir_path(__FILE__) . 'includes/cpt.php';
include_once plugin_dir_path(__FILE__) . 'includes/metabox.php';
include_once plugin_dir_path(__FILE__) . 'includes/csv-import.php';
include_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';

// Enqueue Scripts
function rps_enqueue_scripts() {
    wp_enqueue_script('rps-ajax-script', plugin_dir_url(__FILE__) . 'js/rps-ajax.js', ['jquery'], null, true);
    wp_localize_script('rps-ajax-script', 'rps_ajax', ['ajax_url' => admin_url('admin-ajax.php')]);
}
add_action('wp_enqueue_scripts', 'rps_enqueue_scripts');
?>