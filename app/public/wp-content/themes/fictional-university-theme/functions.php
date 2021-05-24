<?php

function university_files() {
    // Load default style.css
    wp_enqueue_style('university_main_style', get_stylesheet_uri());
}

add_action('wp_enqueue_scripts', 'university_files');
