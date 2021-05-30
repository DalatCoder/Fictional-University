<?php get_header(); ?>

<?php
while (have_posts()) {
    the_post();
?>

    <?php
    pageBanner();
    ?>

    <div class="container container--narrow page-section">

        <?php $post_parent_id = wp_get_post_parent_id(get_the_ID()); ?>
        <?php if ($post_parent_id != 0) : ?>
            <div class="metabox metabox--position-up metabox--with-home-link">
                <p>
                    <a class="metabox__blog-home-link" href="<?php echo get_permalink($post_parent_id); ?>">
                        <i class="fa fa-ho  me" aria-hidden="true"></i>
                        Back to <?php echo get_the_title($post_parent_id); ?>
                    </a>
                    <span class="metabox__main"><?php the_title(); ?></span>
                <p>
            </div>
        <?php endif; ?>

        <?php $current_children_pages = get_pages([
            'child_of' => get_the_ID()
        ]); ?>
        <?php if ($post_parent_id != 0 or count($current_children_pages) > 0) : ?>
            <div class="page-links">
                <h2 class="page-links__title">
                    <a href="<?php echo get_permalink($post_parent_id); ?>">
                        <?php echo get_the_title($post_parent_id); ?>
                    </a>
                </h2>
                <ul class="min-list">
                    <?php
                    $args = [
                        'title_li' => NULL,
                        'sort_column' => 'menu_order'
                    ];

                    if ($post_parent_id != 0)
                        $args['child_of'] = $post_parent_id;
                    else
                        $args['child_of'] = get_the_ID();

                    wp_list_pages($args);
                    ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="generic-content">
            <?php get_search_form(); ?>
        </div>
    </div>
<?php
}
?>

<?php get_footer(); ?>
