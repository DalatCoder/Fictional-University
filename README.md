# TỰ HỌC WORDPRESS

Khoá học: Become a Wordpress Developer

## 1. Welcome

### Our goal: learn to code completely custom websites with Wordpress

## 2. Where do we begin?

- First step: Setting up a dev environment for ourselves so we can work locally
- WordPress needs an environment with...
  - 1.  PHP
  - 2.  Apache (NGINX)
  - 3.  MySQL (MariaDB)
- Sử dụng công cụ Local WordPress tại localwp.com để tạo môi trường chạy Wordpress.

- PHP: The language that Wordpress is written in.

## 3. First Coding Steps PHP

### 3.1. Create a new theme

Cần phải tạo 1 tối thiểu 2 file:

- `index.php`

- `style.css`: Ghi thông tin về theme

```css
/*
  Theme Name: Fictional University
  Author: Nguyen Trong Hieu
  Version: 1.0
*/
```

- `screenshot.png`: Ảnh đại diện của theme

### 3.2. PHP Function

```php
function greeting($name) {
  echo "Hello $name";
}

greeting('Hieu');

var_dump(bloginfo());
```

### 3.3. PHP Array

Think of an _array_ as **collection**

```php
  $names = array('Hieu', 'Ha');

  echo $names[0]; // Hieu
  echo $names[1]; // Ha

  echo count($names); // 2
```

### 3.4. PHP Loop

```php
  for ($names as $name) {
    echo $name;
  }
```

## 4. WordPress Specific PHP

### 4.1. The Famous WordPress Loop

```php
// index.php: Hiển thị toàn bộ post trong cơ sở dữ liệu

<?php
    while (have_posts()) {
        the_post();
        ?>
            <h2>
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>

            <?php the_content(); ?>

            <hr>
        <?php
    }
?>

// single.php: Trang được hiển thị khi click vào 1 post để xem chi tiết
// single.php: Chỉ được dùng để hiển thị single post
```

- `index.php`: Trang hiển thị toàn bộ post
- `single.php`: Trang được hiển thị khi bấm vào chi tiết 1 post
- `page.php`: Trang được hiển thị cho 1 page

- _note_: Dựa vào đường dẫn URL từ trang mà bạn vào, wordpress sẽ load các
  file tương ứng ở thư mục `theme`

- **the_loop**: Famous loop in WordPress

### 4.2. Header & Footer

- `header.php`: Header
- `footer.php`: Footer
- `functions.php`: Định nghĩa các hàm để load CSS/JS,...

Gọi hàm `wp_head()` ở file `header.php` để `php` tự động load các file `css` cần thiết.

Gọi hàm `wp_footer()` ở file `footer.php` để `php` tự động load các file `js` cần thiết
và load thanh điều hướng ở trên cùng của website.

### 4.3. Convert Static HTML Template into WordPress

- Đưa các file vào folder chứa template
- Chuyển `header` và `footer` vào các file tương ứng, sau đó là nội dung
- Dùng hàm `get_theme_file_uri` để lấy đường dẫn tới thư mục chứa `template`
  sau đó truyền tên các file tương ứng vào để liên kết vào HTML.

## 5. Pages

### 5.1. Interior Page Template

- `site_url()`: Trả về đường dẫn root của trang web
- `after_theme_setup` hooks: Dùng để setup `<title>`

### 5.2. Parent & Children Pages

- `get_the_ID()`: Trả về `post_id` của trang `post` hiện tại
- `wp_get_post_parent_id($post_id)`: Truyền vào `post_id`, trả về `ID` của trang cha.
  - Trả về `0` nếu đây là trang cha lớn nhất
- `the_title()`: Trả về tiêu đề của trang hiện tại
- `get_the_title($id)`: Trả về tiêu đề của trang tương ứng với `$id`
- `get_permalink(wp_get_post_parent_id(get_the_ID()))`: Trả về đường dẫn `uri` tới trang `parent`

### 5.3. Echo or not to Echo

- Có 1 số hàm trong WordPress không cần `echo`, một số hàm khác cần phải `echo`.
- Các hàm bắt đầu với `get_*` chỉ `return` về giá trị, vì vậy cần `echo` để hiển thị lên màn hình.
  - `get_the_title($id)`
  - `get_the_id($post_id)`
- Các hàm bắt đầu với `the_*`, WordPress đã `echo` giá trị lên màn hình.

  - `the_title()`: Tiêu đề của post hiện tại
  - `the_ID()`: `ID` của post hiện tại

- **Tham khảo**:
  - `https://codex.wordpress.org`
  - `https://developer.wordpress.org`

### 5.4. Menu of child page links

Hiển thị danh sách `menu` với các item cha và con:

- `wp_list_pages($assoc_array)`: Truyền vào 1 `associative array` để cusom danh sách menu
  - `title_li => NULL`: Không hiển thị tiêu đề của menu
  - `sort_column => menu_order`: Hiển thị menu con theo thứ tự ở trang `admin`
  - `child_of => $parent_id`: Chỉ hiển thị các menu của `$parent_id`

Kiểm tra nếu 1 page không có các menu con:

```php
$current_children_pages = get_pages([
  'child_of' => get_the_ID() ]
);

if (count($current_children_pages) == 0) { ... }
```

### 5.5. Few improvements

Thêm 1 số thẻ quan trọng vào `<head>`

```htm
<meta charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!-- Load header information: title, css, js -->
<?php wp_head(); ?>
```

Thêm thuộc tính `lang` vào thẻ `<html>`

```html
<html <?php language_attributes(); ?>
  >
</html>
```

Thêm 1 số `class` mô tả chi tiết về trang hiện tại ở thẻ `body`

```html
<body <?php body_class(); ?>
  >
</body>
```

### 5.5. Dynamic Navigation Menus

Hỗ trợ quản lý `menu` ở giao diện `admin`

- Khởi tạo lệnh hỗ trợ menu ở `after_theme_setup` hook

```php
add_action('after_setup_theme', 'university_features');

function university_features() {
    // Add dynamic navigation menu support
    // args1: any name, use for calling function: wp_nav_menu
    // args2: name that show on WordPress admin
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerLocation1', 'Footer Location 1');
    register_nav_menu('footerLocation2', 'Footer Location 2');
}
```

- Khai báo lệnh chèn `menu` trong file `html` tương ứng

```php
wp_nav_menu([
  'theme_location' => 'headerMenuLocation'
]);
```

- Vào trang WordPress `admin`, mục `Appearance`, chọn `Menus`

### 5.6. Add `current-menu-item` class to page

- `is_page('about-us')`: Trả về `boolean`, kiểm tra xem trang hiện tại có phải `about-us` hay không
- `current-menu-item`: Tên class thêm vào `menu` tương ứng với trang để có hiệu ứng `css` đặc biệt

## 6. Building Blog Section

### 6.1. Blog Listing Page

Bình thường khi vào trang `/`, WordPress sẽ hiển thị danh sách các `post`.
Trong dự án này, chúng ta muốn chia `route` như sau:

- `/`: Hiển thị trang `home`
- `/blog`: Hiển thị trang `blog`

Để làm được điều này, trước tiên vào mục `setting`, phần `reading` ở `WP Admin`,
chọn phần `your homepage displays`, chuyển thành `static page`.

Lúc này, ta có 2 `page` mới:

- `HomePage`: Trang `home`, tương ứng với file `front-page.php`
- `PostsPage`: Trang hiển thị danh sách `posts`, tương ứng với file `index.php`

Hiển thị 1 số thông tin tổng quan về `post` ở trang `PostsPage`

- `while(have_posts())`: Lặp danh sách tất cả `post`
- `the_post()`: Lấy `post` hiện tại trong vòng lặp
- `the_permalink()`: Lấy địa chỉ `URI` của `post`
- `the_title()`: Lấy tiêu đề bài `post`
- `the_author_posts_link()`: Hiển thị `author` kèm `link`
- `the_time('j-n-y')`: Hiển thị thời gian tạo `post` theo format: `dd/mm/yyyy`
- `get_the_category_list()`: Lấy danh sách các nhóm mà bài `post` thuộc về
- `the_exerpt()`: Lấy tổng quan ngắn về bài `post`

### 6.2. Pagination

Vào mục `Setting`, `reading`, `Blog pages show at most`

```php
<?php echo paginate_links(); ?>
```

Hiển thị chi tiết 1 `post`, trang `single.php`

- `get_header()`: Thêm header chung từ file `header.php`
- `get_footer()`: Thêm footer chung từ file `footer.php`
- `while(have_posts())`: Lấy bài post
- `the_title()`: Lấy thông tin tiêu đề bài `post`
- `the_content()`: Lấy thông tin nội dung bài `post`

### 6.3. Archives (category, author, date, etc,...)

Xem danh sách các bài `post` thuộc về:

- 1 `author`
- 1 `category`
- 1 `dd/mm/yyyy`
- 1 `mm/yyyy`
- 1 `yyyy`
- ...

Những cách hiển thị tiêu đề cho page `Archive.php`

- Nhanh nhất, sử dụng có sẵn: `the_archive_title();`: Hàm có sẵn của WordPress,
  sẽ hiển thị tương ứng cho trang `author`, `category`, `date`, ...
- Tuỳ ý chỉnh sửa tiêu đề:
  - Dùng `if (is_category)` để check xem page `archive` hiện tại có phải page về
    `category` hay không
  - `the_archive_*()`: Để hiển thị thông tin tương ứng
- Hiển thị mô tả thêm: `the_archive_description()`

### 6.4. What is a `custom query`?

Oposites?

- What is a `normal` WordPress query?
- What is a `default` query?

WordPress automatically queries content based on the current `URL`

- `about-us`: Query about us page
- `blog`: Query latest 10 posts
- `have_posts()` và `the_post()` chứa các `query` mặc định của WordPress

=> Default WordPress queries

Custom queries: `Custom queries` allows us to load whatever we want
wherever we want.

VD: Load danh sách 2 post mới nhất để hiển thị lên giao diện trang chủ

Khai báo đối tượng `WP_Query()` để custom `query`:

```php
  $homePagePosts = new WP_Query([
      'posts_per_page' => 2,
      'post_type' => 'post'
  ]);
```

Vòng lặp `while`

- `have_posts` chứa query mặc định kiểm tra xem còn `post` hay không
  - => `$homePagePosts->have_posts()`
- `the_post`: chứa query mặc định để lấy tiêu đề bài post
  - => `$homePagePosts->the_post()`

**Lưu ý**: Sau khi thực hiện `Custom query`, yêu cần gọi lại phương thức này để
`Reset` các biến `Global` của Wordpress

```php
wp_reset_postdata();
```

## 7. Workflow and automation

- Cài các pakage cần thiết trong file `package.json`
- Chạy 1 số câu lệnh:

- `npm run devFast`: chạy môi trường `development`, `hot reload`
- `npm run build`: optimize cho môi trường `production`

- Chỉnh sửa 1 số thông tin trong file `functions.php`
  - Kiểm tra xem có ở môi trường `development` hay không
  - Ở môi trường `production`, các file sẽ được tự động `rename` khi chạy lệnh `build`, chèn thêm `hash`, không sợ lỗi `cache`

```php
    if (strstr($_SERVER['SERVER_NAME'], 'fictional-university.local')) {
        wp_enqueue_script('university_main_js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
    } else {
        wp_enqueue_style('university_main_style', get_theme_file_uri('/bundled-assets/styles.bc49dbb23afb98cfc0f7.css'));
        wp_enqueue_script('university_vendor_js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);
        wp_enqueue_script('university_main_js', get_theme_file_uri('/bundled-assets/scripts.bc49dbb23afb98cfc0f7.js'), NULL, '1.0', true);
    }
```

- Khi muốn tích hợp bộ `automation` vào dự án khác thì chỉnh sửa file `webpack.config.js`

## 8. Event Post Types

### 8.1. Custom Post Type

Mặc định, WordPress có sẵn 2 `post type` là `Post` và `Page`

`Page` thực chất cũng chỉ là 1 `Post` với `label` khác.

Tất cả các đối tượng nội dung trong WordPress thực chất chỉ là `Post` nhưng khác về `Label`, `Post Type Label`

Cách tạo 1 `post type` mới:

```php
    register_post_type('event', [
        'public' => true,
        'labels' => [
            'name' => 'Events',
            'add_new_item' => 'Add New Event',
            'edit_item' => 'Edit Event',
            'all_items' => 'All Events',
            'singular_name' => 'Event'
        ],
        'menu_icon' => 'dashicons-calendar'
    ]);
```

Đặt đoạn code tạo `post type` mới ở đâu là hợp lý nhất?

- `functions.php` trong thư mục `theme`: Khi người dùng đổi `theme`, code sẽ không chạy, mặc dù `event post type` vẫn
  nằm trong CSDL, nhưng không có giao diện nào để truy cập vào cả.
- Tạo 1 `plugin` mới: Người dùng có thể dễ dàng `activate` và `deactivate`
- Sử dụng `must use plugin` để bắt buộc `event post type` được `load`

#### Must use plugin

Các file trong thư mục này sẽ chắc chắn được WordPress load và thực thi

Tạo 1 folder mới:

- Đường dẫn: `wp-content`
- Tên: `mu-plugins`

Tạo 1 file mới trong thư mục này và đưa đoạn code khởi tạo `event post type` vào.

### 8.2. Display Custom Post Types

Tạo `custom query` để lấy danh sách các `event post type` từ CSDL

```php
  $homePageEvents = new WP_Query([
      'posts_per_page' => 2,
      'post_type' => 'event'
  ]);
```

Tạo vòng lặp `while($homePageEvents->have_posts())` để lấy từng `event` và hiển thị tương ứng lên màn hình.

Khi click vào `link`, WordPress báo `Page not found`.

- Vào trang `admin`, phần `settings`, mục `Permalink()`, không cần thay đổi gì cả và nhấn `Save changes`.

Ta cần phải build lại cấu trúc `url` bởi vì WordPress không hề biết về sự tồn tại của `event post type`.

#### Tạo file để hiển thị chi tiết 1 custom post type

Trong thư mục `theme`, tạo 1 file mới tên `single-[type]` với `type` là tên của `custom post type` vừa tạo.
Trong trường hợp này, ta tạo 1 file mới và đặt tên: `single-event.php`.
Đây là file hiển thị chi tiết về 1 `event` khi ta bấm vào link xem chi tiết.

#### Tạo trang archive để hiển thị danh sách custom post type

- Đặt thuộc tính `has_archive` với giá trị `true`
- Tuỳ ý chỉnh sửa lại địa chỉ `url`

  - Ban đầu: `/event`
  - Sau khi thay đổi: `/events`

- **Lưu ý**: Sau khi thay đổi, phải tiến hành `load` lại cấu trúc URL
  - Vào `admin page`
  - `Setting` -> `Permalink()` -> `Save Changes`

```php
  register_post_type('event', [
      'rewrite' => ['slug' => 'events'],
      'has_archive' => true,
  ]);
```

#### Tạo file để hiển thị danh sách toàn bộ custom post type

Trang hiển thị danh sách các `post` được gọi là `archive`.

Để hiển thị toàn bộ các `event`, ta cần tạo 1 file mới trong thư mục `theme` và đặt tên là `archive-event.php`.

Setup HTML để hiển thị danh sách toàn bộ `event` lên màn hình

#### Lấy đường dẫn tới trang archive của custom post type

- Hàm `site_url()`: không tối ưu, bởi vì `slug` có thể bị thay đổi trong tương lai
- Hàm `get_post_type_archive_link('postTypeName')`: chỉ cần truyền vào tên `postType`, hàm sẽ trả về đường dẫn tương ứng
  - `get_post_type_archive_link('event')` => Trả về liên kết đến trang `archive-event.php`

### 8.3. Some Update

Thêm 1 số thông tin cho `custom post type`

- `show_in_rest`: hỗ trợ REST API, chuyển đổi editor sang phiên bản `mordern`
- `supports`: mảng các thuộc tính mà `event post type` hỗ trợ
  - `title`: cột tiêu đề
  - `editor`: cột nội dung, nếu không có cột này, giao diện sẽ mặc định ở mode `classic`
  - `excerpt`: mô tả ngắn

```php
  register_post_type('event', [
      'show_in_rest' => true,
      'supports' => ['title', 'editor', 'excerpt'],
  ]);
```

### 8.4. Custom Fields

Hiện tại, `event post type` đang thiếu 1 `field` để lưu trữ thông tin về nyày
diễn ra sự kiện.

=> `Custom field` để tạo ra field này.

Thêm `custom-fields` vào phần `supports` của `event post type`

```php
  register_post_type('event', [
      'supports' => ['title', 'editor', 'excerpt', 'custom-fields'],
  ]);
```

Vào chỉnh sửa 1 `event` bất kỳ, chọn dấu ':' ở góc tnên bên phải, chọn mục `Advanced`,
bật tuỳ chọn `Custom Field` và thêm các `field` vào.
_Tuy nhiên cách này không hiệu quả_.

#### Cách hiệU quả để thêm `custom field`

The Two Main (`Custom Field`) Plugins

- Advanced Custom Fields (ACF)
- CMB2 (Custom Metaboxes 2)

Theo ý kiến tác giả, ổng không thích plugins, ổng cố gắng để sử dụng càng ít
plugin càng tốt.

Trong khoá học này, chúng ta sử dụng `ACF plugin`. Bởi vì nó dễ sử dụng hơn 1 tí.

Bỏ phần tử `custom-fields` ở thuộc tính `supports`. Phần `custom-fields` sẽ do
plugin quản lý

```php
    register_post_type('event', [
        'supports' => ['title', 'editor', 'excerpt'],
    ]);
```

#### Cài đặt plugin ACF

- Vào phần `plugins`
- `Add New`
- Tìm kiếm `Advanced Custom Fields`
- Cài `plugin` của tác giả `Elliot Condon`, sau đó `activate plugin`

#### Thêm custom field với plugin ACF

- Vào menu `Custom Fields`, chọn `Add New`
- Đặt tên field là `Event Date`, và chọn `Add New`
- `Display format`: chọn `d/m/Y`
- `Return format`: chọn `Ymd` (Để dễ làm việc khi hiển thị dữ liệu lên màn hình)

#### Lấy dữ liệu và hiển thị lên màn hình

- `get_field('event_date')`: Trả về dữ liệu ở của cột `event_date`
- `the_field('event_date')`: `echo` cột `event_date` lên màn hình

#### Format datetime trong php

Để hiển thị mỗi tháng, ta truyền chuỗi ngày tháng tương ứng vào Constructor `DateTime`,
ở dạng `dmY`

Sau đó, dùng phương thức `format` để hiển thị tương ứng lên màn hình

```php
  $eventDate = new DateTime(get_field('event_date'));
  echo $eventDate->format('M');
```

### 8.5. Custom Queries: Ordering/Sorting

- Lấy tất cả `post` khi giá trị `posts_per_page` là `-1`.
- Sắp xếp `giảm dần` theo giá trị thời gian tạo `post_date` (Mặc định)
- Lấy giá trị `random` sau mỗi lần `reload` trang: `orderby => rand`

```php
  $homePageEvents = new WP_Query([
      'posts_per_page' => -1,
      'post_type' => 'event',
      'orderby' => 'post_date',
      'order' => 'DESC'
  ]);
```

Sắp xếp giảm dần theo `event_date`

Trong thế giới WordPress, `meta` có nghĩa là những thứ được thêm vào, được `custom` với kiểu dữ
liệu `post` ban đầu.
Trong trường hợp này, `event_date` là 1 trường được thêm vào, vì vậy nó được gọi là `meta`

Sử dụng `meta_query` để thực thi câu lệnh truy vấn `where`, `filter` các giá trị theo điều kiện
nhất định.
Trong đoạn code phía dưới, chương trình chỉ lọc ra các `event` có `event_date` lớn hơn hoặc
bằng với ngày hôm nay (không hiển thị những sự kiện đã qua lên trang chủ)

Thêm phần kiểu dữ liệu so sánh trong `custom query`

- `orderby`:
  - `meta_value`: mặc định
  - `meta_value_num`: trong trường hợp này, `event_date` có giá trị `Ymd` nên là số,
    ta khai báo thêm kiểu dữ liệu để `order` dễ hơn
- `type`:
  - `numeric`: khai báo thêm kiểu dữ liệu cho `event_date` trong `custom_query` để
    tiến hành `filter` tốt hơn.

```php
  $homePageEvents = new WP_Query([
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
          ]
      ]
  ]);
```
