<?php
// Shortcode and AJAX
add_shortcode('program_schedule', 'rps_program_schedule_shortcode');
function rps_program_schedule_shortcode() {
    return '<div id="program-schedule">
                <button id="prev-week">Previous Week</button>
                <button id="next-week">Next Week</button>
                <div id="schedule-content"></div>
            </div>';
}

add_action('wp_ajax_rps_get_schedule', 'rps_get_schedule');
add_action('wp_ajax_nopriv_rps_get_schedule', 'rps_get_schedule');
function rps_get_schedule() {
    $week = isset($_POST['week']) ? intval($_POST['week']) : 0;
    $start_date = date('Y-m-d', strtotime("this week +$week week"));
    $end_date = date('Y-m-d', strtotime("this week +$week week +6 days"));

    $query = new WP_Query([
        'post_type' => 'program',
        'meta_query' => [
            [
                'key' => '_rps_start_date',
                'value' => [$start_date, $end_date],
                'compare' => 'BETWEEN',
                'type' => 'DATE',
            ],
        ],
    ]);

    $schedule = [];
    while ($query->have_posts()) {
        $query->the_post();
        $schedule[] = [
            'name' => get_the_title(),
            'thumbnail' => get_the_post_thumbnail_url(),
            'schedule' => get_post_meta(get_the_ID(), '_rps_broadcast_schedule', true),
        ];
    }

    wp_send_json($schedule);
}
?>