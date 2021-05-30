<?php

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
    register_rest_route('university/v1', 'search', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'universitySearchResults'
    ]);
}

function universitySearchResults($data)
{
    $clientKeyword = $data['term'];
    $clientKeyword = sanitize_text_field($clientKeyword);

    $mainQuery = new WP_Query([
        'post_type' => ['post', 'page', 'professor', 'program', 'campus', 'event'],
        's' => $clientKeyword
    ]);

    $results = [
        'generalInfo' => [],
        'professors' => [],
        'programs' => [],
        'events' => [],
        'campuses' => []
    ];

    while ($mainQuery->have_posts()) {
        $mainQuery->the_post();

        $postType = get_post_type();

        switch ($postType) {
            case 'professor':
                array_push($results['professors'], [
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                ]);
                break;

            case 'program':
                array_push($results['programs'], [
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                ]);
                break;

            case 'campus':
                array_push($results['campuses'], [
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                ]);
                break;

            case 'event':
                array_push($results['events'], [
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink()
                ]);
                break;

            default:
                array_push($results['generalInfo'], [
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'postType' => $postType,
                    'authorName' => get_the_author()
                ]);
                break;
        }
    }

    return $results;
}
