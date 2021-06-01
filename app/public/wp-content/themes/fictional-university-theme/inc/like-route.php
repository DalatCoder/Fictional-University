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
    if (!is_user_logged_in()) {
        die('Only logged in user can create a like.');
    }

    $professorID = sanitize_text_field($data['professorID']);
    $isProfessorExists = get_post_type($professorID) == 'professor';

    if (!$isProfessorExists) {
        die('Invalid Professor ID');
    }

    $likeExists = false;

    $existQuery = new WP_Query([
        'author' => get_current_user_id(),
        'post_type' => 'like',
        'meta_query' => [
            [
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => $professorID
            ]
        ]
    ]);

    if ($existQuery->found_posts) {
        $likeExists = true;
    }

    if ($likeExists) {
        die('Invalid professor ID');
    }

    return wp_insert_post([
        'post_type' => 'like',
        'post_status' => 'publish',
        'meta_input' => [
            'liked_professor_id' => $professorID
        ]
    ]);
}

function deleteLike($data)
{
    if (!is_user_logged_in()) {
        die('Only logged in user can delete a like.');
    }

    $likeID = sanitize_text_field($data['likeID']);

    log_me($likeID);

    $isLikeExists = get_post_type($likeID) == 'like';
    if (!$isLikeExists) {
        die('Invalid like ID');
    }

    $isThisLikeBelongToUser = get_current_user_id() == get_post_field('post_author', $likeID);
    if (!$isThisLikeBelongToUser) {
        die('You dont have permissions to perform this action.');
    }

    return wp_delete_post($likeID, true);
}
