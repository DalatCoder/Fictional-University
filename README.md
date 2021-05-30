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

### 8.6. Edit Default Query (Existing query)

Lần này, ta xét về trang `archive-event`, liệt kê toàn bộ `event`

Đường dẫn `URI` có dạng `http://fictional-university.local/events`

Các `query` mặc định của WordPress tự động dựa vào từ khoá `events` trên đường dẫn để lấy
danh sách tất cả `event` có trong CSDL.

Ta không muốn thay đổi điều này, tuy nhiên ta cần phải hiển thị `post` theo thứ
tự tăng dần (`ASC`) và chỉ hiển thị các `event` trong tương lai.

Lựa chọn đầu tiên là `custom query`, tuy nhiên vẫn còn 1 lựa chọn khác tốt hơn.
Đó chính là `edit` lại `default query` của WordPress cho hợp ý mình.

`Custom query` dùng cho các trường hợp không liên quan đến việc lấy thông tin
thông qua đường dẫn `URL`

#### Chỉnh sửa `default query`

Mở file `functions.php`, gắn 1 sự kiện vào `pre_get_posts` hook

Trước khi `posts` được `get`, chúng ta gọi hàm `university_adjust_queries` để thay đổi
1 số thuộc tính trên `query` này.

Hàm này nhận vào tham số `query`, chính là `query` được gửi về CSDL để lấy dữ liệu

- `is_admin()`: `hook` này ảnh hưởng đến cả trang `admin`, vì vậy ta check điều kiện để
  nó chỉ xảy ra ở trang `client` thôi
- `is_post_type_archive`: `hook` này ảnh hưởng đến tất cả trang `archive` ở phía `client`,
  bao gồm `posts`, `pages`. Ta kiểm tra và chỉ giới hạn ở trang `archive-event` thôi
- `$query->is_main_query`: thêm điều kiện này vào để tránh thay đổi cấu trúc `custom query`
  - Trong trường hợp `query` này là 1 `custom query`, ta không thay đổi gì cả
  - Trong trường hợp `query` này là `default` query, dựa trên `url`, ta cấu hình lại
- Gọi phương thức `set` để thay đổi giá trị tương ứng theo các thuộc tính của `query`

```php
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
```

### 8.7. Past Events Page

Tạo 1 trang chỉ hiển thị các `event` đã qua trong quá khứ.

Vào `admin`, tạo 1 `page` mới, đặt tên `Past Events`

Lúc này, trang mới tạo có `URI` như sau: `http://fictional-university.local/past-events`.
Hiện tại, trang `page.php` đang được dùng để hiển thị. Tuy nhiên, ta không muốn hiển thị
trang `page`. Ta cần `custom` lại như sau:

Tạo 1 `file` mới trong thư mục `theme`

- Cấu trúc: `page-[slug]`
- Cụ thể: `page-past-events.php`
- Trang này chịu trách nhiệm cho việc hiển thị nội dung ứng với `page` có slug `past-events`

#### Vấn đề `pagination` không hoạt động

`Pagination` chỉ có sẵn để hoạt động đối với các `query` mặc định của wordpress.

Trong trường hợp này, ta tạo 1 `query` mới để lấy danh sách các `event` trong quá khứ, đây là
1 `custom query`, do đó cần phải chỉnh sửa để `pagination` có thể hoạt động.

#### Chỉnh sửa chức năng `pagination`

- Bước 1: Tại hàm `paginate_links`, ta truyền thêm tham số thay vì để mặc định
  - `total`: Tổng số trang để hiển thị (Tổng `event` / `posts_per_page`)
  - `$pageEvents->max_num_pages`: Lấy tổng số trang nhanh chóng, không cần phải tự viết phép chia như trên

```php
    echo paginate_links([
        'total' => $pageEvents->max_num_pages
    ]);
```

- Bước 2: Cập nhật `custom query`

Khi vào page thứ 2, `URL` có dạng `http://fictional-university.local/past-events/page/2/`

Ta cần lấy được tham số `2` và đưa vào `custom query` để lấy được danh sách `event` tương ứng với trang `2`

Để lấy được tham số và phân trang tương ứng theo số trang, ta cần 1 số hàm sau:

- `get_query_var`: Lấy giá trị của tham số tương ứng trên `url`, trong trường hợp này là
  tham số `paged` để lấy trang hiện tại.
  Nếu như tham số `paged` không có thì mặc định đang ở trang `1`
- `paged`: thuộc tính chỉ ra trang hiện tại ở `custom query` để lấy danh sách `event` tương ứng.

```php
    $currentPage = get_query_var('paged', 1);

    $pageEvents = new WP_Query([
      'paged' => $currentPage
    ]);
```

## 9. Program post type

### 9.1. Create relationship between content

#### Tạo mới `program` post type

Mở file `university-post-types.php` trong thư mục `mu-plugins` để tiến hành tạo mới 1 `custom post type`

```php
    register_post_type('program', [
        'show_in_rest' => true,
        'supports' => ['title', 'editor'],
        'rewrite' => ['slug' => 'programs'],
        'has_archive' => true,
        'public' => true,
        'labels' => [
            'name' => 'Programs',
            'add_new_item' => 'Add New Program',
            'edit_item' => 'Edit Program',
            'all_items' => 'All Programs',
            'singular_name' => 'Program'
        ],
        'menu_icon' => 'dashicons-awards'
    ]);
```

#### Tạo `custom field` để liên kết `event` với `program`

1 `event` có thể có 1 hoặc nhiều `program`

- Vào trang `Admin`, chọn mục `custom fields`
- Tạo mới 1 `field group`, đặt tên `Related Program`
- Tạo mới 1 `field` bên trong `group` này, đặt tên `Related Program(s)`: Hàm ý có thể
  tạo liên kết đến 1 hoặc nhiều `program`
- `Field type` chọn `Relationship`
- `Filter by post type` chọn `program`. Trong trường hợp này, `program` là đối tượng được mang
  đi để các đối tượng khác tạo liên kết đến.
- `Filters` chỉ giữ lại `Search`
- `Location`:
  - Show this `custom field` only if `Post Type` `is equal to` `event`
  - Trong trnờng hợp này, chỉ có duy nhất `event` có mối liên hệ với `program`,
    1 `event` có 1 hoặc nhiều `program` liên quan. Do đó ta chọn như thế này để đảm
    bảo điều đó.

#### Liên kết `event` đến `program` tương ứng

Vào `edit` 1 `event` bất kỳ, lúc này giao diện xuất hiện thêm khung cho phép chọn các
`program` liên quan tới `event` này.

Người dùng có thể chọn 1 hoặc nhiều `program`

### 9.2. Displaying Relationship on Frontend

Hiển thị các `program` có liên quan đến `event` hiện tại

Mở trang hiển thị chi tiết 1 `event`: `single-event.php`

Lấy danh sách các `program` có liên quan đến `event` này thông qua câu lệnh sau
Kết quả trả về:

- `array`: Mảng chứa các `WordPress Post Object`, với mỗi phần tử là 1 `program` có kiểu dữ liệu
  `WP_Post_Object`
- `null`: `event` hiện tại không có bấy kỳ `program` liên quan nào

```php
  $relatedPrograms = get_field('related_programs');
```

#### Hiển thị danh sách `program` tương ứng lên màn hình

Trong trường hợp này, ta chỉ hiển thị khi `event` này có các `program` liên quan.

- Lặp qua mảng các `event` liên quan
- `get_the_permalink()`: truyền vào đối tượng `WP_Post_Object` hoặc `ID` của đối tượng
- `get_the_title()`: truyền vào đối tượng `WP_Post_Object` hoặc `ID` của đối tượng

```php
  <?php if (!is_null($relatedPrograms)) : ?>

      <hr class="section-break">

      <h2 class="headline headline--medium">Related Program(s)</h2>
      <ul class="link-list min-list">
          <?php foreach ($relatedPrograms as $program) : ?>
              <li>
                  <a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a>
              </li>
          <?php endforeach; ?>
      </ul>

  <?php endif; ?>
```

#### Hiển thị danh sách `event` tương ứng lên màn hình

Trong trường hợp này, ta cần hiển thị danh sách các `event` tương ứng với `program` hiện tại

Mở trang `single-program.php` và thêm 1 số `code` để lấy danh sách `event` tương ứng

Tạo 1 `custom query` để lấy dữ liệu danh sách các `event` thuộc về `program` hiện tại

Trong trường hợp này, ta dùng 2 bộ lọc:

- `Filter` các `event` trong tương lai
- `Filter` các `event` có `field` tên `related_programs` chứa giá trị `ID` của `program` hiện tại.
- Lý do dùng `LIKE`
  - 1 `event` liên kết đến nhiều `program`, khi chọn xong, WordPress lưu dưới dạng 1 mảng chứa `ID`.
    VD: `[1, 5, 6]`, tức là `event` này liên quan đến 3 `program` lần lượt là `1, 5` và `6`.
  - Tuy nhiên, CSDL không thể lưu trữ dữ liệu dạng `array`, do đó `WordPress` tiến hành `Serialize` mảng thành
    1 chuỗi rồi lưu vào trường `related_programs`
  - Chuỗi này chứa thông tin về `ID` và các số khác có thể trùng với `ID`, chính vì vậy, `WordPress` bao `ID`
    bên trong cặp dấu nháy đôi `""`.
    VD: `"1"::::"5"::::"6"`.
    Do đó, ta phải dùng toán tử `LIKE` và tìm kiếm với cụm `" . $ID . "`

Sau khi có kết quả, dùng vòng lặp `while($relatedEvents->have_posts())` để lặp và in ra các `event` liên quan
của `program` hiện tại.

```php
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
```

## 10. Professors Post Type

### 10.1. Create new `Professor post type`

#### Tạo `professor post type`

Mở file `university-post-type` trong thư mục `mu-plugins` để tiến hành tạo mới 1 `post type`
cho `professor`

Trong trường hợp này, `professor` không có trang `archive`, do đó, chúng ta không cần
phải viết lại `slug`.

Cách để truy cập đến trang của `professor` là thông qua:

- các `program` mà `professor` dạy.
- các `campus` mà `professor` dạy.
- `search`

```php
    register_post_type('professor', [
        'show_in_rest' => true,
        'supports' => ['title', 'editor'],
        'public' => true,
        'labels' => [
            'name' => 'Professors',
            'add_new_item' => 'Add New Professor',
            'edit_item' => 'Edit Professor',
            'all_items' => 'All Professors',
            'singular_name' => 'Professor'
        ],
        'menu_icon' => 'dashicons-welcome-learn-more'
    ]);
```

#### Hiển thị `single-professor`

Tạo file `single-professor.php` để hiển thị thông tin chi tiết về 1 `professor`

### 10.2. Tạo liên kết giữa `professor` và `program`

1 `professor` có thể dạy 1 hoặc nhiều `program`

Chúng ta đã có `related_programs`, điều cần làm lúc này là chỉnh lại tại khung `location`

Lúc này, `related_programs` sẽ được hiển thị khi

- `post type` `is equal to` `event`
- **OR** `post type` `is equal to` `professor`

### 10.3. Hiển thị danh sách `program` tương ứng ở trang `single-professor.php`

```php
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
```

### 10.4. Hiển thị danh sách `professor` tương ứng ở trang `single-program.php`

```php
  $relatedProfessors = new WP_Query([
      'posts_per_page' => -1,
      'post_type' => 'professor',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_query' => [
          [
              'key' => 'related_programs',
              'compare' => 'LIKE',
              'value' => '"' . get_the_ID() . '"',
          ]
      ]
  ]);
```

### 10.5. `wp_reset_postdata()`

**wp_reset_postdata đặt giá trị `Global Post Object` về mặc định**

Một số phương thức dùng các `global variable`, do đó, khi `custom query`, 1 số biến `global` bị
thay đổi giá trị, dẫn đến câu truy vấn không còn chính xác nữa.

Trong trường hợp này,

- ta thực hiện `custom query` để truy vấn danh sách `professor` trước
- `get_the_ID()` lúc này trả về giá trị là `ID` của `professor`, không phải là `ID` của `program`
- Do đó, `custom query` để truy vấn danh sách `event` phía sau truy vấn nhầm `ID`

Cách khắc phục:

Sau khi thực hiện xong `custom query`, ta tiến hành gọi phương thức `wp_reset_postdata()` để
đặt các giá trị `global` về `default`.

### 10.6. Featured Images

#### Thêm `feature image` cho `professor`

Mặc định, `theme` không hỗ trợ (`support`) `featured image`.

Để có thể `enable` chức năng này:

- Mở file `functions.php`
- Thêm `support` cho thuộc tính `post-thumbnails`

  ```php
      add_theme_support('post-thumbnails');
  ```

  - Với các `post type` mặc định: `post`, `page`, chỉ làm như thế này là đủ
    để kích hoạt `feature-image`.
  - Với `custom post type`:

        - Di chuyển đến tập tin: `university-post-type` trong thư mục `mu-plugins`
        - Thêm phần tử `thumbnail` vào mảng `supports`

        ```php
              register_post_type('professor', [
                  'supports' => ['title', 'editor', 'thumbnail'],
              ]);
        ```

    Lúc này, khung chọn `feature image` đã xuất hiện khi `edit` 1 `professor` cụ thể

#### Hiển thị `feature image` lên màn hình

Dùng hàm có sẵn của `WordPress` để hiển thị ảnh `thumbnail` lên màn hình.

```php
  the_post_thumbnail();
```

Dùng hàm có sẵn `the_post_thumbnail_url` để lấy đường dẫn `src` của ảnh `thumbnail`

```php
  the_post_thumbnail_url();
```

#### Upload hình ảnh với các kích thước khác nhau

Mặc định, khi `upload` `thumbnail image`, WordPress mặc định tạo ra 1 số hình ảnh
với các kích thước khác nhau từ hình ảnh ban đầu.

Nếu muốn WordPress tạo thêm ảnh có kích thước tự chọn, ta có thể làm như sau:

- Mở file `functions.php`
- Gọi hàm `add_image_size` và truyền vào các đối số tương ứng:
  - `NickName`: Tên người dụng tự đặt cho kích thước ảnh mớI
  - `width`: Chiều dài hình
  - `height`: Chiều cao hình
  - `true`: WordPress sẽ tự `crop` hình vào trung tâm để có kích thước ảnh như đã
    truyền vào.

```php
    // Create new image size when upload new image thumbnail
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
```

Khi `upload` ảnh mới, `WordPress` sẽ tạo ra ảnh với các kích thước mặc định và
ảnh với các `size` mà ta vừa định nghĩa.

Tuy nhiên, với các ảnh đã được upload trước đó, `WordPress` sẽ không tự động bổ sung
hình ảnh với kích thước ta vừa định nghĩa.

#### Plugin để `resize` các hình ảnh trước đó với `size` mới định nghĩa

Tìm `plugin` tên là `Regenerate Thumbnails` của tác giả `Alex Mills` và cài đặt

Sau đó, vào `Admin`, chọn Menu `tools`, `regenerate thumbnails` để tạo lại.

### 10.7. Displaying Custom Image Sizes

Để sử dụng `custom image sizes`, ta chỉ cần truyền `nickname` tương ứng vào
hàm lấy `image`

```php
  the_post_thumbnail('professorPortrait');
  the_post_thumbnail_url('professorLandscape');
```

### 10.8. WordPress crop images

Mặc định, `WordPress` sẽ `crop` vào trung tâm của bức hình để có được kích thước
mà ta nhập vào.

Mặc định, khi chọn `true`, `WordPress` sẽ crop hình vào trung tâm

```php
    add_image_size('professorLandscape', 400, 260, true);
    add_image_size('professorPortrait', 480, 650, true);
```

Để có thể kiểm soát việc `crop` hình của `WordPress`, ta có thể truyền vào
1 mảng thay vì chỉ `true`

```php
    add_image_size('professorLandscape', 400, 260, ['top', 'left']);
```

#### Sử dụng `plugin` để crop hình dễ hơn

Mở trang `plugin` và tìm kiếm từ khoá `manual image crop tomasz`

Vào `edit` 1 `professor`, chọn hình ảnh, chức năng `crop image` xuất hiện,
`click` vào chức năng này và chọn, thay đổi các vùng chọn khác nhau để được bức
hình ưng ý. Sau đó chọn `crop`.

Quay lại `browser`, nhấn giữ `shift` + `click` nút `reload` trang để tiến hành
`hard reload`, loại bỏ `cache` của `browser`.

### 10.9. Making "Page Banner" Dynamic

WordPress mặc định chỉ cho phép duy nhất 1 ảnh làm `feature-image`.

Ở trang `single-professor`, ta đã có 1 ảnh `feature-image`, do đó, để đặt
`background banner`, ta cần 1 tính năng khác của `WordPress`

#### Thêm cột để lưu trữ thông tin

Để tuỳ chỉnh `page banner`, ta cần lưu thông tin của

- Banner background
- Banner subtitle

Vào trang `admin`, chọn `custom fields`.

Thêm 1 `field group` mới, đặt tên `page banner`, và thêm các cột tương ứng

- `Page Banner Background Image`
- `Page Banner Subtitle`

Tại mục `Location`, bởi vì tất cả trang đều có `Page Banner`, do đó ta muốn hiển thị
ở tất cả các trang, ta có thể dùng mẹo sau:

- Chọn `post type` `is equal to` `post`: Show trên `post`
- **OR**, chọn `post type` `is not equal to` `post`: Show trên các trang còn lại

#### Thêm kích thước ảnh mới để phù hợp với `Background Banner`

Mở file `functions.php` và thêm 1 kích thước ảnh mới

```php
    add_image_size('pageBanner', 1500, 350, true);
```

Sau đó, vào trang `admin`, edit 1 `professor` bất kỳ, chọn ảnh `Banner` và `update`

#### Hiển thị ảnh Banner

```php
  print_r(get_field('page_banner_background'));
```

## 11. Cleaner Code (Less Duplication)

### 11.1. Reduce Duplicate Code

Tạo 1 `function` để tự động hoá việc `render` phần tử `banner` ra màn hình

Mở file `functions.php` và tạo hàm sau

Hàm này nhận vào đối số là 1 `assoc array`, các phần tử của `array` này gồm có:

- `title`: Tiêu đề chính của `Banner`
- `subtitle`: Tiêu đề phụ của `Banner`
- `photo`: Ảnh nền background

```php
  <?php function pageBanner($args = [])
  {
      $title = $args['title'];
      $subtitle = $args['subtitle'];
      $photo = $args['photo'];

      // Default values

      if (!$title)
          $title = get_the_title();


      if (!$subtitle)
          $subtitle = get_field('page_banner_subtitle');

      if (!$photo) {
          if (get_field('page_banner_background_image'))
              $photo = get_field('page_banner_background_image')['sizes']['pageBanner'];
          else
              $photo = get_theme_file_uri('/images/ocean.jpg');
      }

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

```

### 11.2. Reduce Duplicate Code: `get_template_part()`

Một cách khác để tận dụng `code`

Trong website, phân code hiển thị `event` bị lặp lại rất nhiều, ta có thể tách
đoạn code này sang 1 file mới và `include` file này để dùng lại.

Các bước:

- Tách đoạn code hiển thị `event` ra 1 file tên `content-event.php` và đặt
  trong folder tên `template-parts`

- Sử dụng hàm `get_template_part()` và truyền vào các đối số tương ứng:

  - `slug`: Đường dẫn tới nơi chứa file `template`
  - `args`: Phần tên phía sau dấu `-`, dùng trong trường hợp cần chọn `dynamic`

Ở đoạn code dưới đây, file template tên là `content-event` và được đặt trong
thư mục `template-parts`

```php
while ($homePageEvents->have_posts()) {
    $homePageEvents->the_post();
    get_template_part('template-parts/content', 'event');
}

wp_reset_postdata();
```

### 11.3. Create a `function` VS `get_template_part()`

- `function`: Khi cần truyền các tham số để `customize`
- `get_template_part`: Khi đoạn code chỉ chứa các `html` hoặc `php` dùng chung,
  bị lặp đi lặp lại nhuều lần, không yêu cầu `customize`

## 12. Campus Post Type

### 12.1. Campus Post Type

```php
    register_post_type('campus', [
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'excerpt'],
        'rewrite' => ['slug' => 'campuses'],
        'has_archive' => true,
        'public' => true,
        'labels' => [
            'name' => 'Campus',
            'add_new_item' => 'Add New Campus',
            'edit_item' => 'Edit Campus',
            'all_items' => 'All Campuses',
            'singular_name' => 'Campus'
        ],
        'menu_icon' => 'dashicons-location-alt'
    ]);
```

### 12.2. Tạo mối liên hệ giữa `Campus` và `Program`

Một `program` có thể liên kết đến 1 hoặc nhiều `campus`

Các bước thực hiện có thể mô tả như sau:

- Vào trang `admin`
- Chọn menu `custom fields`
- Tạo `field group` mới và tạo `field` mới, đặt tên `Related Campus`
- Kiểu dữ liệu, chọn `Relationship`
- `Filter by`, chọn `campus`
- Show this field only if `post type` `is equal to` `program`: Chỉ show lựa chọn
  `campus` ở trang quản lý `program`

## 13. Live Search UI with Javascript

## 14. WordPress REST API (AJAX)

### 14.1. Loading WP Content with JS in Real-time

#### WordPress JSON

Truy cập vào địa chỉ `http://fictional-university.local/wp-json/wp/v2/posts`,
lúc này một mảng `json` sẽ được trả về với mỗi phần tử là 1 đối tượng `post`

Các tham số có thể đưa vào

- `?per_page`: Số lượng `post` trả về
- `/:id`: Trả về `post` ứng với `id`
- `?search`: Tìm kiếm theo `title`

### 14.2. Đưa 1 biến từ `server php` available `global` trong code `js` phía client

Mở file `functions.php`, và thêm vào đoạn code sau

Lúc này tại mã nguồn sẽ có 1 đối tượng `global` tên là `universityData`, bên trong
có 1 thuộc tính là `root_url`. Giá trị của thuộc tính này là địa chỉ `root` của
trang web hiện tại.

Điều này đảm bảo khi gọi `ajax`, ta luôn trỏ tới đúng địa chỉ `url` phía server.

```php
    wp_localize_script('university_main_js', 'universityData', [
        'root_url' => get_site_url()
    ]);
```

### 14.3. Auto focus input field không hoạt động

Khi mở form tìm kiếm lên, ta muốn tự động focus vào khung `input`, tuy nhiên không
được. Lý do vì `form` tìm kiếm mất `300s` để hoàn toàn hiển thị (Do phải render hiệu
ứng)

Do đó ta cần phải đợi đến khi `form` load hoàn toàn rồi mới tiến hành `focus`

```js
setTimeout(() => {
  this.searchInput.focus();
}, 301);
```

## 15. Customizing REST API

### 15.1. Customize the JSON data that WP Outputs

Thêm 1 `custom field` vào bộ `REST API` trả về từ `WordPress`

Trong lần này, ta thử thêm trường `author_name` vào dữ liệu phản hồi từ `wp-json/wp/v2/posts`

Ta sẽ làm điều đó trong file `functions.php`

Khai báo hàm `university_custom_rest` để thêm mới 1 `field`, và gắn vào `hook`
`reset_api_init`

Trong hàm này, ta tiến hành 1 số việc như sau:

- `post`: Thay đổi `response` của type `post` (Blog post)
- `authorName`: Tên của `field` ta vừa thêm vào `response`
- Dữ liệu của `field` này sẽ là kết quả trả về từ hàm `get_callback`
- `get_callback`: Truyền hàm để trả dữ liệu, trong trường hợp này, ta dùng `anonymous function`, hàm này trả về kết quả là tên tác giả của bài `post`

```php
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
```

### 15.2. Create new REST API Route (URL)

Một số `custom post type` sẽ không có `REST API` mặc định. Để thêm vào, ta
có thể làm như sau:

- Mở file `university-post-type.php`
- Tại dòng `code` khai báo `post type` mới, ta thêm vào thuộc tính
  `show_in_rest` và gán giá trị `true`

Vấn đề cần giải quyết, khi mở khung `search` và thêm từ khoá `biology`, ta muốn
trả về kết quả gồm

- Tên `program`
- Liên kết đến `program`
- Danh sách `professor` dạy `biology`
- Danh sách `campus` nơi mà `biology` được dạy
- Danh sách các `event` sắp tới có liên quan đến `biology`

Tuy nhiên, `logic search` của `WordPress` không được `nâng cao` như vậy. Chính vì lý
do đó, chúng ta muốn tự `build` 1 hệ thống `search` theo ý mình.

`Logic search` của `WordPress` chỉ tiến hành tìm kiếm với các `field` mặc định
như `title` hoặc `content`. WordPress sẽ không tự động search vào `custom field` hoặc
các `related_field`.

#### 4 Reaons Why We Are Creating Our Own New REST API URL

1. Custom search logic
2. Respond with less JSON data (load faster for visitors)
3. Send only 1 getJSON request instead of `6` in our JS
4. Perfect exercise for sharpening PHP skills

#### Các bước để tạo 1 custom REST API route

- Mở file `functions` và code tại đây, tuy nhiên do code khá nhiều, để dễ tổ chức
  và quản lý, ta tiến hành tạo 1 folder và 1 file mới chứa logic search.
  Sau đó dùng `require` để thêm `file` mới này vào `functions.php`

Tại file mới tên `search-route.php`, ta tiến hành làm 1 số công việc sau:

- `add_action`: Thêm 1 action mới
  - `hook`: `rest_api_init`
  - `function`: `universityRegisterSearch`

Tại hàm `universityRegisterSearch`, ta thêm code để tạo route mới và `logic search`

- `register_rest_route`:

  - args1: `namespace`:
    Nhìn vào `api route` mặc định: `http://fictional-university.local/wp-json/wp/v2/professor`,

    lúc này `wp` chính là `namespace` mặc định của `WordPress`.
    Ta không muốn dùng `namespace` này mà sẽ định nghĩa 1 `namespace` mới, tuy nhiên,
    `namespace` mới nên lưu ý đặt tên để không trùng với `namespace` của các `plugin`.
    Bên cạnh đó, chúng ta có thể thêm vào `v1` để xác định phiên bản hiện tại của `api`.
    Nếu có thay đổi lớn, chỉ cần chuyển lên `v2`.

  - args2: `route`:
    Nhìn vào `api route` mặc định, `professor` chính là `route`, `route` là phần
    cuối cùng của `url`

  - args3: `array`:
    - `methods`: `CRUD Operation`: ta có thể viết trực tiếp `GET` vào. Hoặc cách
      tối ưu hơn là `WP_REST_Server::READABLE`
    - `callback`: Truyền vào 1 hàm, hàm này sẽ chứa logic search và trả về dữ liệu
      tương ứng khi `user` gọi đến `route` này

Lúc này, khi ta truy cập đến `url`: `http://fictional-university.local/wp-json/university/v1/search` sẽ thấY được dữ liệu tương ứng được trả về từ hàm `callback` phía trên.

#### Create Our Own Raw JSON Data

Chúng ta chỉ cần trả về dữ liệu `PHP`, `WordPress` sẽ tự động chuyển đổi sang `JSON` tương ứng.

Trong trường hợp dưới đây, chúng ta sẽ trả về 1 mảng gồm các đối tượng, với
mỗi đối tượng là thông tin về:

- `title`: Tên `professor`
- `permalink`: Liên kết đến trang cá nhân của `professor`

```php
  function universitySearchResults()
  {
      $professors = new WP_Query([
          'post_type' => 'professor'
      ]);

      $professorResults = [];

      while ($professors->have_posts()) {
          $professors->the_post();

          array_push($professorResults, [
              'title' => get_the_title(),
              'permalink' => get_the_permalink()
          ]);
      }

      return $professorResults;
  }
```

#### WP_Query and Keyword Searches

Để tìm kiếm, ta cần phải có `keyword` được truyền lên từ `client`, để làm được
điều đó, ta cần truyền thêm tham số vào đường dẫn `url`.

Tham số này ta đặt tên `term`, là từ khoá để `search`

Tham số này được `WordPress` tự động truyền vào hàm `callback`, do đó, bên trong
hàm `callback` ta có thể dễ dàng truy cập để lấy được giá trị `term`

Bên cạnh đó, để tăng bảo mật, chúng ta có thể dùng hàm `sanitize_text_field` có sẵn
để tránh việc người dùng chèn mã độc và tham số `term`

Đường dẫn `URL` có dạng: `http://fictional-university.local/wp-json/university/v1/search?term=meowsalot`

Code của chúng ta sẽ như sau:

```php
  function universitySearchResults($data)
  {
      $clientKeyword = $data['term'];
      $clientKeyword = sanitize_text_field($clientKeyword);

      $professors = new WP_Query([
          'post_type' => 'professor',
          's' => $clientKeyword
      ]);

      $professorResults = [];

      while ($professors->have_posts()) {
          $professors->the_post();

          array_push($professorResults, [
              'title' => get_the_title(),
              'permalink' => get_the_permalink()
          ]);
      }

      return $professorResults;
  }
```

#### Working with Multiple Post Types

Hiện tại, `api` của chúng ta chỉ truy xuất dữ liệu từ `post type` `professor`.

Tuy nhiên, chúng ta muốn `search` ở nhiều `post type` khác nữa. Tại thuộc tính
`post type`, chúng ta chỉ cần đưa vào 1 mảng, bên trong chứa các `post type` lnên
quan.

Lúc này, code sẽ như sau:

```php
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
                      'permalink' => get_the_permalink()
                  ]);
                  break;

              case 'program':
                  array_push($results['programs'], [
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
                  array_push($results['events'], [
                      'title' => get_the_title(),
                      'permalink' => get_the_permalink()
                  ]);
                  break;

              default:
                  array_push($results['generalInfo'], [
                      'title' => get_the_title(),
                      'permalink' => get_the_permalink()
                  ]);
                  break;
          }
      }

      return $results;
  }
```
