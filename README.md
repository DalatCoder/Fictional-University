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

### 5. Pages

#### 5.1. Interior Page Template

- `site_url()`: Trả về đường dẫn root của trang web
- `after_theme_setup` hooks: Dùng để setup `<title>`

#### 5.2. Parent & Children Pages

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
