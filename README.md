# Hotel Management Project

## Mô tả dự án
Dự án này là một hệ thống quản lý khách sạn được xây dựng theo mô hình MVC (Model-View-Controller). Dưới đây là mô tả chức năng của các thư mục trong dự án.

## Cấu trúc thư mục

### 1. `database/`
- Chứa các tệp liên quan đến cấu hình và quản lý cơ sở dữ liệu.
- **Ví dụ**: `db_config.php` dùng để định nghĩa thông tin kết nối cơ sở dữ liệu.

### 2. `public/`
- Chứa các tài nguyên công khai mà trình duyệt có thể truy cập trực tiếp.
- **Các thành phần chính**:
  - `index.html`: Tệp HTML chính, điểm vào của ứng dụng.
  - `css/`: Chứa các tệp CSS để định nghĩa giao diện người dùng.
  - `image/`: Chứa các hình ảnh được sử dụng trong giao diện.
  - `js/`: Chứa các tệp JavaScript để xử lý logic phía client.

### 3. `src/`
- Chứa mã nguồn chính của dự án, được tổ chức theo mô hình MVC.
- **Các thư mục con**:
  - `controllers/`: Chứa các tệp xử lý logic điều khiển (controller).
  - `includes/`: Chứa các tệp dùng chung, như các hàm tiện ích hoặc cấu hình.
  - `models/`: Chứa các tệp định nghĩa logic dữ liệu (model).
  - `views/`: Chứa các tệp giao diện (view).
    - `layout/`: Chứa các tệp bố cục chung, như header, footer, hoặc các thành phần giao diện dùng chung.
    - `page/`: Chứa các tệp HTML cụ thể cho từng trang.

### 4. `README.md`
- Tệp này cung cấp thông tin mô tả dự án, hướng dẫn cài đặt và sử dụng.

---

## Hướng dẫn sử dụng
1. Cấu hình cơ sở dữ liệu trong `database/db_config.php`.
2. Đưa các tài nguyên công khai vào thư mục `public/`.
3. Xây dựng logic trong các thư mục `src/controllers`, `src/models`, và `src/views`.