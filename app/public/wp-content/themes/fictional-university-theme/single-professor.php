<?php get_header(); ?>

<?php while (have_posts()) : ?>
    <?php the_post(); ?>

    <?php pageBanner(); ?>

    <?php
    $professorID = get_the_ID();

    $likeCountQuery = new WP_Query([
        'post_type' => 'like',
        'meta_query' => [
            [
                'key' => 'liked_professor_id',
                'compare' => '=',
                'value' => $professorID
            ]
        ]
    ]);
    $numberOfLike = $likeCountQuery->found_posts;

    $existStatus = 'no';
    $likeID = -1;
    if (is_user_logged_in()) {
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
            $existStatus = 'yes';
            $likeID = $existQuery->posts[0]->ID;
        }
    }

    wp_reset_postdata();
    ?>

    <div class="container container--narrow page-section">
        <div class="generic-content">
            <div class="row group">

                <div class="one-third">
                    <?php the_post_thumbnail('professorPortrait'); ?>
                </div>

                <div class="two-thirds">
                    <span class="like-box" data-like="<?php echo $likeID; ?>" data-professor="<?php echo $professorID; ?>" data-exists="<?php echo $existStatus; ?>">
                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                        <span class="like-count"><?php echo $numberOfLike; ?></span>
                    </span>
                    <?php the_content(); ?>
                </div>

            </div>
        </div>

        <?php $relatedPrograms = get_field('related_programs'); ?>

        <?php if (!is_null($relatedPrograms)) : ?>

            <hr class="section-break">

            <h2 class="headline headline--medium">Subject(s) Taught</h2>
            <ul class="link-list min-list">
                <?php foreach ($relatedPrograms as $program) : ?>
                    <li>
                        <a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>

        <?php endif; ?>

    </div>
<?php endwhile; ?>

<?php get_footer(); ?>
