<?php
add_shortcode('program_schedule', 'render_program_schedule');

function render_program_schedule() {
    // Enqueue the script for AJAX navigation
    wp_enqueue_script('program-schedule-ajax', plugin_dir_url(__FILE__) . 'js/program-schedule.js', ['jquery'], null, true);
    wp_localize_script('program-schedule-ajax', 'programScheduleAjax', [
        'ajax_url' => admin_url('admin-ajax.php'),
    ]);

    // HTML structure for the calendar
    return '
    <div id="program-schedule">
        <h1>Program Schedule</h1>
        <div class="navigation-buttons">
            <button id="prev-week" class="nav-button">Previous Week</button>
            <button id="next-week" class="nav-button">Next Week</button>
        </div>
        <div id="schedule-content">
            <p>Loading schedule...</p>
        </div>
    </div>';
}