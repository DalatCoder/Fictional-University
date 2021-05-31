<?php
function university_post_types()
{
    // Create event post type
    register_post_type('event', [
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'excerpt'],
        'rewrite' => ['slug' => 'events'],
        'has_archive' => true,
        'public' => true,
        'labels' => [
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ],
        'menu_icon' => 'dashicons-calendar'
    ]);

    // Create program post type
    register_post_type('program', [
        'show_in_rest' => true,
        'supports' => ['title'],
        'rewrite' => ['slug' => 'programs'],
        'has_archive' => true,
        'public' => true,
        'labels' => [
            'name' => 'Programs',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Programs',
            'singular_name' => 'Program'
        ],
        'menu_icon' => 'dashicons-awards'
    ]);

    // Create professor post type
    register_post_type('professor', [
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'public' => true,
        'labels' => [
            'name' => 'Professors',
            'add_new_item' => 'Add New Professors',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All Professors',
            'singular_name' => 'Professor'
        ],
        'menu_icon' => 'dashicons-welcome-learn-more'
    ]);

    // Create compus post type
    register_post_type('campus', [
        'capability_type' => 'campus',
        'map_meta_cap' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'excerpt'],
        'rewrite' => ['slug' => 'campuses'],
        'has_archive' => true,
        'public' => true,
        'labels' => [
            'name' => 'Campus',
            'add_new_item' => 'Add New Campus',
            'edit_item' => 'Edit Campus',
            'all_items' => 'All Campuses',
            'singular_name' => 'Campus'
        ],
        'menu_icon' => 'dashicons-location-alt'
    ]);

    // Create note post type
    register_post_type('note', [
        'show_in_rest' => true,
        'supports' => ['title', 'editor'],
        'public' => false,
        'show_ui' => true,
        'labels' => [
            'name' => 'Notes',
            'add_new_item' => 'Add New Note',
            'edit_item' => 'Edit Note',
            'all_items' => 'All Notes',
            'singular_name' => 'Note'
        ],
        'menu_icon' => 'dashicons-welcome-write-blog'
    ]);
}

add_action('init', 'university_post_types');
