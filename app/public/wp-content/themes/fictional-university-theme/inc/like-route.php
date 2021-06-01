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

function createLike()
{
    return 'Create new like';
}

function deleteLike()
{
    return 'Delete a like';
}
