<?php get_header(); ?>

<?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <?php pageBanner(); ?>

    <div class="container container--narrow page-section">
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p>
                <a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>">
                    <i class="fa fa-ho  me" aria-hidden="true"></i>
                    All Campuses
                </a>
                <span class="metabox__main">
                    <?php the_title(); ?>
                </span>
            <p>
        </div>

        <div class="generic-content"><?php the_content(); ?></div>

        <?php

        $relatedPrograms = new WP_Query([
            'posts_per_page' => -1,
            'post_type' => 'program',
            'orderby' => 'title',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => 'related_campus',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"',
                ]
            ]
        ]);

        ?>

        <?php if ($relatedPrograms->have_posts()) : ?>

            <hr class="section-break">
            <h2 class="headline headline--medium">Programs Available At This Campus</h2>

            <ul class="min-list link-list">
                <?php while ($relatedPrograms->have_posts()) : ?>
                    <?php $relatedPrograms->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

        <?php

        $today = date('Ymd');
        $relatedEvents = new WP_Query([
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_key' => 'event_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => 'event_date',
                    'compare' => '>=',
                    'value' => $today,
                    'type' => 'numeric'
                ],
                [
                    'key' => 'related_programs',
                    'compare' => 'LIKE',
                    'value' => '"' . get_the_ID() . '"',
                ]
            ]
        ]);

        ?>

        <?php if ($relatedEvents->have_posts()) : ?>

            <hr class="section-break">
            <h2 class="headline headline--medium">Upcoming <?php the_title(); ?> Events</h2>

            <?php while ($relatedEvents->have_posts()) : ?>
                <?php $relatedEvents->the_post(); ?>

                <?php get_template_part('template-parts/content-event'); ?>

            <?php endwhile; ?>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </div>
<?php endwhile; ?>

<?php get_footer(); ?>
