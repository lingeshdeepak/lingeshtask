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

    // Enqueue styles
    wp_enqueue_style('rps-style', plugin_dir_url(__FILE__) . 'styles/rps-style.css');
    wp_enqueue_script('program-schedule-ajax', plugin_dir_url(__FILE__) . 'js/program-schedule.js', ['jquery'], null, true);
    wp_localize_script('program-schedule-ajax', 'rps_ajax', ['ajax_url' => admin_url('admin-ajax.php')]);
}
add_action('wp_enqueue_scripts', 'rps_enqueue_scripts');

add_action('admin_enqueue_scripts', 'rps_enqueue_admin_scripts');
function rps_enqueue_admin_scripts($hook) {
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        wp_enqueue_script(
            'rps-admin-schedule',
            plugin_dir_url(__FILE__) . 'js/admin-schedule.js', // Replace with your file path
            ['jquery'],
            '1.0',
            true
        );

        // Pass the AJAX URL and nonce to the script
        wp_localize_script('rps-admin-schedule', 'rpsAjax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('rps_save_schedule'),
        ]);
    }
}



// AJAX Handler for fetching the schedule
add_action('wp_ajax_get_program_schedule', 'get_program_schedule');
add_action('wp_ajax_nopriv_get_program_schedule', 'get_program_schedule');

function get_program_schedule() {
    $week_offset = isset($_POST['week']) ? intval($_POST['week']) : 0;

    // Calculate start and end dates of the requested week
    $start_date = date('Y-m-d', strtotime("monday this week +$week_offset week"));
    $end_date = date('Y-m-d', strtotime("sunday this week +$week_offset week"));

    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
    $schedule = array_fill_keys($days, []);
    $day_dates = [];

    // Calculate the date for each day of the week
    foreach ($days as $index => $day_name) {
        $day_dates[$day_name] = date('Y-m-d', strtotime("$start_date +$index days"));
    }

    $day_map = [
        'Mon' => 'Monday',
        'Tue' => 'Tuesday',
        'Wed' => 'Wednesday',
        'Thu' => 'Thursday',
        'Fri' => 'Friday',
        'Sat' => 'Saturday',
        'Sun' => 'Sunday',
    ];
    
    // Query programs for the given week
    $query = new WP_Query([
        'post_type' => 'program',
        'post_status' => 'publish',            
        'posts_per_page' => -1,
        'meta_query' => [
            'relation' => 'AND',
            [
                'key' => '_rps_start_date',
                'value' => $end_date,
                'compare' => '<=',
                'type' => 'DATE',
            ],
            [
                'key' => '_rps_end_date',
                'value' => $start_date,
                'compare' => '>=',
                'type' => 'DATE',
            ],
        ],
    ]);

  
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();

        // Retrieve the raw meta value
        $raw_broadcast_schedule = get_post_meta($post_id, '_rps_broadcast_schedule', true);

        foreach ($raw_broadcast_schedule as $day => $time) {
        
            // Skip if time is empty
            if (empty($time)) {
                continue;
            }

            // Convert abbreviation to full day name
            $day_name = isset($day_map[$day]) ? $day_map[$day] : $day; // Fallback to original if not found

            if (array_key_exists($day_name, $schedule)) {
                $schedule[$day_name][] = [
                    'name' => get_the_title(),
                    'time' => $time,
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                ];
            }
        }
    }

    wp_reset_postdata();
    wp_send_json(['schedule' => $schedule, 'dates' => $day_dates]);
}