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
