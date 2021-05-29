<?php get_header(); ?>

<?php pageBanner([
    'title' => 'Past Events',
    'subtitle' => 'A recap of our past events.'
]) ?>

<div class="container container--narrow page-section">

    <?php

    $today = date('Ymd');
    $currentPage = get_query_var('paged', 1);

    $pageEvents = new WP_Query([
        'paged' => $currentPage,
        'post_type' => 'event',
        'meta_key' => 'event_date',
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'meta_query' => [
            'key' => 'event_date',
            'compare' => '<',
            'value' => $today,
            'type' => 'numeric'
        ]
    ]);

    ?>


    <?php while ($pageEvents->have_posts()) : ?>
        <?php $pageEvents->the_post(); ?>

        <?php get_template_part('template-parts/content-event'); ?>

    <?php endwhile; ?>

    <?php
    echo paginate_links([
        'total' => $pageEvents->max_num_pages
    ]);
    ?>
</div>
<?php get_footer(); ?>
