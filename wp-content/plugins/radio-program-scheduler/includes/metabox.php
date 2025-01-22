<?php

// Add Meta Box for Schedule
add_action('add_meta_boxes', 'rps_add_schedule_metabox');
function rps_add_schedule_metabox() {
    add_meta_box(
        'rps_broadcast_schedule',
        'Broadcast Schedule',
        'rps_schedule_metabox_callback',
        'program',
        'normal',
        'high'
    );
}

function rps_schedule_metabox_callback($post) {
    $schedule = get_post_meta($post->ID, '_rps_broadcast_schedule', true) ?: [];
    $schedule_start_date = get_post_meta($post->ID, '_rps_start_date', true);
    $schedule_end_date = get_post_meta($post->ID, '_rps_end_date', true);
    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    // Error container for AJAX
    echo '<div id="rps-error-messages"></div>';

    // Nonce for security
    wp_nonce_field('rps_save_schedule', 'rps_schedule_nonce');

    // Start date and end date fields
    echo '<p><b><label for="rps_schedule_start_date">Start Date:</label></b></p>';
    echo '<input type="date" id="rps_schedule_start_date" name="rps_schedule_start_date" value="' . esc_attr($schedule_start_date) . '" style="width: 80%;">';

    echo '<p><b><label for="rps_schedule_end_date">End Date:</label></b></p>';
    echo '<input type="date" id="rps_schedule_end_date" name="rps_schedule_end_date" value="' . esc_attr($schedule_end_date) . '" style="width: 80%;">';

    // Broadcast schedule
    echo '<p><b><label for="rps_schedule">Broadcast Schedule:</label></b></p>';
    echo '<table>';
    foreach ($days as $day) {
        $time = isset($schedule[$day]) ? $schedule[$day] : '';
        echo "<tr><td>$day:</td><td><input type='time' name='rps_schedule[$day]' value='" . esc_attr($time) . "'></td></tr>";
    }
    echo '</table>';
}

// Validate and Save Schedule
add_action('wp_ajax_rps_validate_schedule', 'rps_validate_schedule');
function rps_validate_schedule() {
    wp_nonce_field('rps_save_schedule', 'rps_schedule_nonce');
    // Verify nonce for security
    if (!isset($_POST['rps_schedule_nonce']) || !wp_verify_nonce($_POST['rps_schedule_nonce'], 'rps_save_schedule')) {
        error_log('Nonce validation failed.');
        wp_send_json_error(['errors' => [__('Invalid nonce. Please refresh and try again.', 'text-domain')]]);
    }

    $post_id = isset($_POST['post_ID']) ? intval($_POST['post_ID']) : 0;
    // error_log($post_id);

    if (!$post_id || get_post_type($post_id) !== 'program') {
        error_log('Invalid post ID: ' . $post_id);
        wp_send_json_error(['errors' => [__('Invalid post ID.', 'text-domain')]]);
        return;
    }

    $errors = [];
    $sanitized_schedule = [];

    // Required Field Validation: Start Date
    $start_date = isset($_POST['rps_schedule_start_date']) ? sanitize_text_field($_POST['rps_schedule_start_date']) : '';
    if (empty($start_date)) {
        $errors[] = __('Start Date is required.', 'text-domain');
    }

    // Required Field Validation: End Date
    $end_date = isset($_POST['rps_schedule_end_date']) ? sanitize_text_field($_POST['rps_schedule_end_date']) : '';
    if (empty($end_date)) {
        $errors[] = __('End Date is required.', 'text-domain');
    }

    // Date Range Validation
    if (!empty($start_date) && !empty($end_date) && strtotime($start_date) > strtotime($end_date)) {
        $errors[] = __('Start Date cannot be later than the End Date.', 'text-domain');
    }

    // Required Field Validation: At least one broadcast time must be entered
    if (isset($_POST['rps_schedule']) && is_array($_POST['rps_schedule'])) {
        $has_valid_schedule = false; // Flag to check if at least one time is provided
        foreach ($_POST['rps_schedule'] as $day => $time) {
            $day = sanitize_text_field($day);
            $time = esc_html($time);

            // Skip empty times
            if (!empty($time)) {
                $has_valid_schedule = true;
                $sanitized_schedule[$day] = $time;
            }
        }

        if (!$has_valid_schedule) {
            $errors[] = __('At least one broadcast time must be entered.', 'text-domain');
        }
    } else {
        $errors[] = __('The broadcast schedule is required.', 'text-domain');
    }

    // Return errors if any
    if (!empty($errors)) {
        wp_send_json_error(['errors' => $errors]);
        error_log('Validation failed: ' . print_r($errors, true));
    }

    // // Save the valid data
    // $post_id = isset($_POST['post_ID']) ? intval($_POST['post_ID']) : 0;
    update_post_meta($post_id, '_rps_broadcast_schedule', $sanitized_schedule);
    update_post_meta($post_id, '_rps_start_date', $start_date);
    update_post_meta($post_id, '_rps_end_date', $end_date);

    wp_send_json_success(['message' => 'Schedule saved successfully.']);
}


// Check for duplicate time
function get_duplicate_time_for_day($day, $time) {
    $query = new WP_Query([
        'post_type' => 'program',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => '_rps_broadcast_schedule',
                'compare' => 'EXISTS',
            ],
        ],
    ]);

    while ($query->have_posts()) {
        $query->the_post();
        $schedule = get_post_meta(get_the_ID(), '_rps_broadcast_schedule', true);
        if (isset($schedule[$day]) && $schedule[$day] === $time) {
            wp_reset_postdata();
            return true;
        }
    }

    wp_reset_postdata();
    return false;
}
