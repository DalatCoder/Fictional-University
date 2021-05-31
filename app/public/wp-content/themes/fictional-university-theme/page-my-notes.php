<?php
if (!is_user_logged_in()) {
    wp_redirect(esc_url(site_url('/')));
    exit;
}
?>

<?php get_header(); ?>

<?php while (have_posts()) : ?>
    <?php the_post(); ?>
    <?php pageBanner(); ?>

    <div class="container container--narrow page-section">
        <?php
        $userNotes = new WP_Query([
            'post_type' => 'note',
            'posts_per_page' => -1,
            'author' => get_current_user_id()
        ]);
        ?>

        <ul class="min-list link-list" id="my-notes">
            <?php while ($userNotes->have_posts()) : ?>
                <?php $userNotes->the_post(); ?>

                <?php
                $title = esc_attr(get_the_title());
                $content = esc_attr(wp_strip_all_tags(get_the_content()));
                ?>

                <li>
                    <input class="note-title-field" type="text" value="<?php echo $title; ?>">
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea class="note-body-field" name="" id="" cols="30" rows="10"><?php echo $content; ?></textarea>
                </li>

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>

        </ul>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>