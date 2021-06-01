<?php

add_action('rest_api_init', 'universityLikeRoute');

function universityLikeRoute()
{
    $namespace = 'university/v1';
    $nameRoute = 'manageLike';

    // Create Like
    register_rest_route($namespace, $nameRoute, [
        'methods' => WP_REST_Server::CREATABLE,
        'callback' => 'createLike',
        'permission_callback' => '__return_true'
    ]);

    // Delete Like
    register_rest_route($namespace, $nameRoute, [
        'methods' => WP_REST_Server::DELETABLE,
        'callback' => 'deleteLike',
        'permission_callback' => '__return_true'
    ]);
}

function createLike($data)
{
    $professorID = sanitize_text_field($data['professorID']);

    wp_insert_post([
        'post_type' => 'like',
        'post_status' => 'publish',
        'meta_input' => [
            'liked_professor_id' => $professorID
        ]
    ]);
}

function deleteLike()
{
    return 'Delete a like';
}
