<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=7">
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Load header information: title, css, js -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <header class="site-header">
        <div class="container">
            <h1 class="school-logo-text float-left">
                <a href="<?php echo site_url('/'); ?>"><strong>Fictional</strong> University</a>
            </h1>
            <a href="<?php echo esc_url(site_url('/search')); ?>" class="js-search-trigger site-header__search-trigger">
                <i class="fa fa-search" aria-hidden="true"></i>
            </a>
            <i class="site-header__menu-trigger fa fa-bars" aria-hidden="true"></i>
            <div class="site-header__menu group">
                <nav class="main-navigation">

                    <?php
                    /*
                    wp_nav_menu([
                        'theme_location' => 'headerMenuLocation'
                    ]);
                    */
                    ?>

                    <ul>
                        <?php

                        $about_page_link = site_url('/about-us');
                        $blog_page_link = site_url('/blog');
                        $event_page_link = get_post_type_archive_link('event');
                        $program_page_link = get_post_type_archive_link('program');
                        $campust_page_link = get_post_type_archive_link('campus');

                        $is_about_us_page = is_page('about-us');
                        $post_parent_id = wp_get_post_parent_id(get_the_ID());
                        $is_about_us_child_page = $post_parent_id == 14;

                        $is_blog_page = get_post_type() == 'post';
                        $is_event_page = (get_post_type() == 'event') || (is_page('past-events'));
                        $is_program_page = (get_post_type() == 'program');
                        $is_campus_page = get_post_type() == 'campus';

                        ?>

                        <li class="<?php echo ($is_about_us_page || $is_about_us_child_page) ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo site_url('/about-us'); ?>">About Us</a>
                        </li>

                        <li class="<?php echo $is_program_page ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo $program_page_link;  ?>">Programs</a>
                        </li>

                        <li class="<?php echo $is_event_page ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo $event_page_link; ?>">Events</a>
                        </li>

                        <li class="<?php echo $is_campus_page ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo $campust_page_link; ?>">Campuses</a>
                        </li>

                        <li class="<?php echo ($is_blog_page) ? 'current-menu-item' : ''; ?>">
                            <a href="<?php echo site_url('/blog'); ?>">Blog</a>
                        </li>
                    </ul>
                </nav>
                <div class="site-header__util">

                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(site_url('/my-notes')); ?>" class="btn btn--small btn--orange float-left push-right">My Notes</a>
                        <a href="<?php echo wp_logout_url(); ?>" class="btn btn--small btn--dark-orange float-left btn--with-photo">
                            <span class="site-header__avatar"><?php echo get_avatar(get_current_user_id(), 60); ?></span>
                            <span class="btn__text">Log Out</span>
                        </a>
                    <?php else : ?>
                        <a href="<?php echo wp_login_url(); ?>" class="btn btn--small btn--orange float-left push-right">Login</a>
                        <a href="<?php echo esc_url(site_url('/wp-signup.php')); ?>" class="btn btn--small btn--dark-orange float-left">Sign Up</a>
                    <?php endif; ?>

                    <a href="<?php echo esc_url(site_url('/search')); ?>" class="search-trigger js-search-trigger">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>
