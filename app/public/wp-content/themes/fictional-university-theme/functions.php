<?php

require get_theme_file_path('/inc/debug-utils.php');

require get_theme_file_path('/inc/search-route.php');
require get_theme_file_path('/inc/like-route.php');

// Customize REST API
function university_custom_rest()
{
    register_rest_field('post', 'authorName', [
        'get_callback' => function () {
            return get_the_author();
        }
    ]);
}

add_action('rest_api_init', 'university_custom_rest');

// Inject CSS and JS
function university_files()
{
    wp_enqueue_style(
        'custom_google_font',
        '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i'
    );

    wp_enqueue_style(
        'font_awesome',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
    );

    // Load default style.css
    // wp_enqueue_style('university_main_style', get_stylesheet_uri());

    // Load javascript
    // File at /js/scripts-bundled.js
    // NULL for no dependencies
    // '1.0' is the version
    // true for loading at the bottom (body), false for loading at html head
    // wp_enqueue_script('university_main_js', get_theme_file_uri('/js/scripts-bundled.js'), NULL, '1.0', true);

    if (strstr($_SERVER['SERVER_NAME'], 'fictional-university.local')) {
        wp_enqueue_script('university_main_js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
    } else {
        wp_enqueue_style('university_main_style', get_theme_file_uri('/bundled-assets/styles.2835ee98f35de5b07fe8.css'));
        wp_enqueue_script('university_vendor_js', get_theme_file_uri('/bundled-assets/vendors~scripts.1fa169383e64a33bfd0c.js'), NULL, '1.0', true);
        wp_enqueue_script('university_main_js', get_theme_file_uri('/bundled-assets/scripts.2835ee98f35de5b07fe8.js'), NULL, '1.0', true);
    }

    wp_localize_script('university_main_js', 'universityData', [
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ]);
}

function university_features()
{
    // Add <title> to head tag
    add_theme_support('title-tag');

    // Add support for image thumbnails
    add_theme_support('post-thumbnails');

    // Create new image size when upload new image thumbnail
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
    add_image_size('pageBanner', 1500, 350, true);

    // Add dynamic navigation menu support
    // args1: any name, use for calling function: wp_nav_menu
    // args2: name that show on WordPress admin
    // register_nav_menu('headerMenuLocation', 'Header Menu Location');
    // register_nav_menu('footerLocation1', 'Footer Location 1');
    // register_nav_menu('footerLocation2', 'Footer Location 2');
}


add_action('wp_enqueue_scripts', 'university_files');

add_action('after_setup_theme', 'university_features');

function university_adjust_queries($query)
{
    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');

        $today = date('Ymd');
        $query->set('meta_query', [
            'key' => 'event_date',
            'compare' => '>=',
            'value' => $today,
            'type' => 'numeric'
        ]);
    }
}

add_action('pre_get_posts', 'university_adjust_queries');

function universityMapKey($api)
{
    $api['key'] = 'AIzaSyDDhM0guDi_XHpXml-tubsIDEB9BIl-Tyw';
    return $api;
}

add_filter('acf/fields/google_map/api', 'universityMapKey');

?>

<?php function pageBanner($args = [])
{
    $title = get_the_title();
    $subtitle = get_field('page_banner_subtitle');
    $photo = get_theme_file_uri('/images/ocean.jpg');

    if (isset($args['title']))
        $title = $args['title'];

    if (isset($args['subtitle']))
        $subtitle = $args['subtitle'];

    if (isset($args['photo']))
        $photo = $args['photo'];
    else 
        if (get_field('page_banner_background_image') && !is_archive() && !is_home())
        $photo = get_field('page_banner_background_image')['sizes']['pageBanner'];
?>

    <div class="page-banner">
        <div class="page-banner__bg-image" style="background-image: url(<?php echo $photo;  ?>);">
        </div>
        <div class="page-banner__content container container--narrow">
            <h1 class="page-banner__title"><?php echo $title; ?></h1>
            <div class="page-banner__intro">
                <p><?php echo $subtitle; ?></p>
            </div>
        </div>
    </div>
<?php } ?>

<?php

// Redirect subscriber accounts out of admin and onto homepage
add_action('admin_init', 'redirectSubsToFrontend');

function redirectSubsToFrontend()
{
    if (!is_user_logged_in()) return;

    $user = wp_get_current_user();
    $numOfRoles = count($user->roles);
    $role = $user->roles[0];

    if ($numOfRoles == 1 && $role == 'subscriber') {
        wp_redirect(site_url('/'));
        exit;
    }
}

// Remove top admin bar for subscriber member
add_action('wp_loaded', 'noSubsAdminBar');

function noSubsAdminBar()
{
    if (!is_user_logged_in()) return;

    $user = wp_get_current_user();
    $numOfRoles = count($user->roles);
    $role = $user->roles[0];

    if ($numOfRoles == 1 && $role == 'subscriber') {
        show_admin_bar(false);
    }
}

// Customize login screen
add_filter('login_headerurl', 'ourHeaderURL');

function ourHeaderURL()
{
    return esc_url(site_url('/'));
}

add_action('login_enqueue_scripts', 'ourLoginCSS');

function ourLoginCSS()
{
    wp_enqueue_style(
        'custom_google_font',
        '//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i'
    );

    wp_enqueue_style(
        'font_awesome',
        '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'
    );

    wp_enqueue_style('university_main_style', get_theme_file_uri('/bundled-assets/styles.2835ee98f35de5b07fe8.css'));
}

// Change login title
add_filter('login_headertext', 'ourLoginTitle');

function ourLoginTitle()
{
    return get_bloginfo('name');
}

// Force note posts to be private
add_filter('wp_insert_post_data', 'makeNotePrivate', 10, 2);

function makeNotePrivate($data, $postarr)
{
    $postType = $data['post_type'];
    $postStatus = $data['post_status'];
    $limitNotePerUser = 10;
    $isPostExist = isset($postarr['ID']);

    if ($postType == 'note') {
        // Limit post type
        if (count_user_posts(get_current_user_id(), $postType) >= $limitNotePerUser && !$isPostExist) {
            die('You have reached your note limit.');
        }

        $data['post_content'] = sanitize_textarea_field($data['post_content']);
        $data['post_title'] = sanitize_text_field($data['post_title']);
    }

    if ($postType == 'note' && $postStatus != 'trash') {
        $data['post_status'] = 'private';
    }

    return $data;
}
