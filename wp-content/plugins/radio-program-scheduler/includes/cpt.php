<?php
// Register Custom Post Type
add_action('init', 'rps_register_program_cpt');
function rps_register_program_cpt() {
    register_post_type('program', [
        'labels' => [
            'name' => 'Programs',
            'singular_name' => 'Program',
        ],
        'public' => true,
        'has_archive' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
    ]);
}
?>