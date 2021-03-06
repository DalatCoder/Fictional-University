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

        <div class="create-note">
            <h2 class="headline headline--medium">Create New Note</h2>
            <input class="new-note-title" placeholder="Title" type="text">
            <textarea class="new-note-body" placeholder="Your note here..." name="" id="" cols="30" rows="10"></textarea>
            <span class="submit-note">Create Note</span>
        </div>

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
                $title = str_replace("Private: ", "", esc_attr(get_the_title()));
                $content = esc_attr(wp_strip_all_tags(get_the_content()));
                ?>

                <li data-id="<?php the_id(); ?>">
                    <input readonly class="note-title-field" type="text" value="<?php echo $title; ?>">
                    <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                    <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                    <textarea readonly class="note-body-field" name="" id="" cols="30" rows="10"><?php echo $content; ?></textarea>
                    <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                </li>

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>

        </ul>
    </div>
<?php endwhile; ?>

<?php get_footer(); ?>
