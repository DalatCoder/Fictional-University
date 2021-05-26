<?php

function university_files()
{
    wp_enqueue_style(
        'custom_google_font',
        '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i'
    );

    wp_enqueue_style(
        'font_awesome',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
    );

    // Load default style.css
    // wp_enqueue_style('university_main_style', get_stylesheet_uri());

    // Load javascript
    // File at /js/scripts-bundled.js
    // NULL for no dependencies
    // '1.0' is the version
    // true for loading at the bottom (body), false for loading at html head
    // wp_enqueue_script('university_main_js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);

    if (strstr($_SERVER['SERVER_NAME'], 'fictional-university.locall')) {
        wp_enqueue_script('university_main_js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
    } else {
        wp_enqueue_style('university_main_style', get_theme_file_uri('/bundled-assets/styles.bc49dbb23afb98cfc0f7.css'));
        wp_enqueue_script('university_vendor_js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);
        wp_enqueue_script('university_main_js', get_theme_file_uri('/bundled-assets/scripts.bc49dbb23afb98cfc0f7.js'), NULL, '1.0', true);
    }
}

function university_features()
{
    // Add <title> to head tag
    add_theme_support('title-tag');

    // Add dynamic navigation menu support
    // args1: any name, use for calling function: wp_nav_menu
    // args2: name that show on WordPress admin
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocation1', 'Footer Location 1');
    register_nav_menu('footerLocation2', 'Footer Location 2');
}

add_action('wp_enqueue_scripts', 'university_files');

add_action('after_setup_theme', 'university_features');
