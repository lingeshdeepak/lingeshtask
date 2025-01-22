<?php
// Register Custom Post Type
add_action('init', 'rps_register_program_cpt');
function rps_register_program_cpt() {

    $labels = array(
        'name'               => 'Programs',
        'singular_name'      => 'Program',
        'menu_name'          => 'Programs',
        'name_admin_bar'     => 'Program',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Program',
        'new_item'           => 'New Program',
        'edit_item'          => 'Edit Program',
        'view_item'          => 'View Program',
        'all_items'          => 'All Programs',
        'search_items'       => 'Search Programs',
        'not_found'          => 'No Programs found.',
        'not_found_in_trash' => 'No Programs found in Trash.',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'programs'),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'has_archive'        => true,
    );

    register_post_type('program', $args);
}
?>