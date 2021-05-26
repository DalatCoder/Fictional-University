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
