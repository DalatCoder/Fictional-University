<?php

function university_files() {
    wp_enqueue_style(
        'custom_google_font',
        '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i'
    );

    wp_enqueue_style(
        'font_awesome', 
        '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
    );

    // Load default style.css
    wp_enqueue_style('university_main_style', get_stylesheet_uri());

    // Load javascript
    // File at /js/scripts-bundled.js
    // NULL for no dependencies
    // '1.0' is the version
    // true for loading at the bottom (body), false for loading at html head
    wp_enqueue_script('university_main_js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);
}

add_action('wp_enqueue_scripts', 'university_files');
