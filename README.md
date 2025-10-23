# :project website bán hàng

## : Thông Tin Sinh Viên

- Họ và tên: Nguyễn Bá Huy
- Mã sinh viên: 23010806
- Lớp: K17_CNTT-8
- Môn học: Thiết kế Web nâng cao (COUR01.TH2)

## : Giới thiệu về Project

**Project xây dựng một website quản lý và bán quần áo **

- tiện lợi   
- Đáng tin cậy  

### : Chức năng chính

#### : Chức năng của Admin:

- : Quản lý sản phẩm (thêm, sửa, xóa sản phẩm)
- : Quản lý người dùng (xem, sửa, xóa người dùng)
- : Quản lý đơn hàng (xem, sửa, hủy, đơn hàng)

#### : Chức năng của Người dùng (User):

- : lọc sản phẩm theo giá
- : Thêm sản phẩm vào giỏ hàng, cập nhật/xóa sản phẩm trong giỏ
- : Đặt hàng, thanh toán đơn hàng
- : Cập nhật thông tin cá nhân

---

## : Công Nghệ Sử Dụng

- : PHP (Laravel)
- : MySQL (Aiven Cloud) 
- : Blade Template
- : HTML, CSS
- : Bootstrap

---

## : Cài Đặt

1. Clone Repository
```sh
git clone https://github.com/16yuji/nike12.git
cd nike12
```

2. Cài Đặt Dependencies PHP
```sh
composer install
npm install
npm run build
```

3. Cấu Hình Environment
```sh
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

4. Khởi Động Development Server
```sh
php artisan serve
```

---
## Tài Khoản Đăng Nhập Mẫu

**1. Tài khoản Admin**  
- **Email:**  admin@example.com
- **Mật khẩu:** admin123

**2. Tài khoản User**  
- **Email:** 1@gmail.com
- **Mật khẩu:** 123456789

**Hoặc:**  
- Bạn có thể tự đăng ký một tài khoản mới bằng chức năng Đăng ký trên trang chủ.
