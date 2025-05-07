# Hotel Management

## A: Cấu trúc dự án

### 1. **Cấu trúc thư mục**

#### **Thư mục gốc**
- `.htaccess`: Tệp cấu hình cho Apache, dùng để định tuyến URL.
- `config.php`: Tệp cấu hình cơ sở dữ liệu, chứa lớp `Database` xây dựng theo mẫu `Singleton` để quản lý kết nối cơ sở dữ liệu.
- `README.md`: Tệp tài liệu mô tả dự án.

#### **Thư mục `app`**
- **`controllers/`**: Chứa các tệp điều khiển (Controller), nơi xử lý logic ứng dụng.
- **`models/`**: Chứa các tệp mô hình (Model), nơi xử lý dữ liệu và tương tác với cơ sở dữ liệu.
- **`views/`**: Chứa các tệp giao diện (View), nơi hiển thị dữ liệu cho người dùng.
  - **`layout/`**: Chứa các tệp bố cục chung (header, footer, v.v.).
  - **`page/`**: Chứa các tệp giao diện cụ thể.

#### **Thư mục `core`**
- **`Controller.php`**: Có thể là lớp cơ sở cho các Controller.
- **`Model.php`**: Có thể là lớp cơ sở cho các Model.
- **`Router.php`**: Có thể là lớp định tuyến, xử lý URL và ánh xạ chúng tới các Controller.

#### **Thư mục `public`**
- **`index.html`**: Tệp HTML chính, có thể là điểm vào của ứng dụng.
- **`css/`**: Chứa tệp CSS để định kiểu giao diện.
  - `style.css`: Tệp CSS chính.
- **`image/`**: Chứa hình ảnh tĩnh.
- **`js/`**: Chứa các tệp JavaScript.

## B: Quy tắc đặt tên

### 0. **Chú thích**
- `PascalCase`: viết hoa chữ đầu tiên của từ (`RoomController`, `BookingController`)
- `snake_case`: viết thường, phân tách các từ bằng dấu gạch dưới _ (`booking_success`)
- `camelCase`: viết hoa chữ đầu tiên của từ thứ 2 trở đi (`createUser`, `bookingList`)

### 1. **Tên Controller**
- `Tên file` viết dạng PascalCase + Controller.php (`RoomController.php`)
- `Tên class` trùng với tên file (`RoomController`)
<!--
    class RoomController {
        public function index() {}
} -->
- Tên phương thức (`action`): viết thường
<!-- 
    public function detail($id) {}
    public function createBooking() {}
 -->
### 2. **Tên Model**
- `Tên file` viết dạng PascalCase + Model.php (`UserModel.php`)
- `Tên class` trùng với tên file
### 3. **Tên View**
- `Tên thư mục` giống tên controller tương ứng, viết thường, dạng số nhiều 
    (UserController -> users
    RoomController -> rooms)
- `Tên file` "nên" giống với tên `method` trong  Controller tương ứng
- `VD: ` trong `UserController` có `method` `add()` thì tên file `view` tương ứng là `add.php`
### 4. **Tên biến,hàm**
- `Tên biến`: camelCase, danh từ rõ nghĩa, 
    thể hiện ý nghĩa của dữ liệu trong biến `userId`, `userList`
- `Tên hàm`: camelCase, động từ/cụm động từ mô tả hành động `addUser()`, `getUserById()` 
### 4. **Param**
- https://www.thehotel.vn/`index.php`?`controller`=`value`&`action`=`value`
- `index.php` là đầu vào chính của trang web, tất cả `request` từ người dùng sẽ được 
    `.htaccess` xử lí và điều hướng đến đây, sau đó sẽ gọi các `Controller` phù hợp để giải quyết các yêu cầu cụ thể
- Là các giá trị điền vào URL 
- controller: qui định `Controller` sẽ gọi, `value` là tên của Controller cần gọi
- action: qui định `method` sẽ gọi, trường hợp không có thì mặc định sẽ gọi `index()`
- VD: https://www.thehotel.vn/index.php?controller=user&action=add