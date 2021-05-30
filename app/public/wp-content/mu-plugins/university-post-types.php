<?php
function university_post_types()
{
    // Create event post type
    register_post_type('event', [
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
            'name' => 'professors',
            'add_new_item' => 'add new professor',
            'edit_item' => 'edit professor',
            'all_items' => 'all professors',
            'singular_name' => 'professor'
        ],
        'menu_icon' => 'dashicons-welcome-learn-more'
    ]);

    // Create compus post type
    register_post_type('campus', [
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
}

add_action('init', 'university_post_types');
