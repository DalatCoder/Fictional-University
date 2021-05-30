<?php

require get_theme_file_path('/inc/debug-utils.php');

add_action('rest_api_init', 'universityRegisterSearch');

function universityRegisterSearch()
{
    register_rest_route('university/v1', 'search', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'universitySearchResults',
        'permission_callback' => '__return_true'
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
                    'image' => get_the_post_thumbnail_url(get_post(), 'professorLandscape')
                ]);
                break;

            case 'program':
                array_push($results['programs'], [
                    'id' => get_the_ID(),
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
                $eventDate = new DateTime(get_field('event_date'));
                $description = null;

                if (has_excerpt())
                    $description = get_the_excerpt();
                else
                    $description = wp_trim_words(get_the_content(), 18);

                array_push($results['events'], [
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'month' => $eventDate->format('M'),
                    'day' => $eventDate->format('d'),
                    'description' => $description
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

    if (count($results['programs']) > 0) {
        wp_reset_postdata();

        $filters = [];

        foreach ($results['programs'] as $program) {
            array_push($filters, [
                'key' => 'related_programs',
                'compare' => 'LIKE',
                'value' => '"' . $program['id'] . '"'
            ]);
        }

        $programRelationshipQuery = new WP_Query([
            'post_type' => 'professor',
            'meta_query' => [
                'relation' => 'OR',
                $filters
            ]
        ]);


        while ($programRelationshipQuery->have_posts()) {
            $programRelationshipQuery->the_post();

            if (get_post_type() === 'professor') {
                array_push($results['professors'], [
                    'title' => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image' => get_the_post_thumbnail_url(get_post(), 'professorLandscape')
                ]);
            }
        }

        $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));
    }

    return $results;
}
