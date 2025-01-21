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
    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
    echo '<table>';
    foreach ($days as $day) {
        $time = isset($schedule[$day]) ? $schedule[$day] : '';
        echo "<tr><td>$day:</td><td><input type='time' name='rps_schedule[$day]' value='$time'></td></tr>";
    }
    echo '</table>';
}

add_action('save_post', 'rps_save_schedule');
function rps_save_schedule($post_id) {
    if (array_key_exists('rps_schedule', $_POST)) {
        update_post_meta($post_id, '_rps_broadcast_schedule', $_POST['rps_schedule']);
    }
}
?>