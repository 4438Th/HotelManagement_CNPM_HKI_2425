# Hotel Management Project

## CẤU TRÚC THƯ MỤC

### 1. `database/`
- Chứa các tệp liên quan đến cấu hình và quản lý cơ sở dữ liệu.
- **Ví dụ**: `db_config.php` dùng để định nghĩa thông tin kết nối cơ sở dữ liệu.

### 2. `public/`
- Chứa các tài nguyên công khai mà trình duyệt có thể truy cập trực tiếp.
- **Các thành phần**:
  - `index.html`: Tệp HTML chính, điểm vào của ứng dụng.
  - `css/`: Chứa các tệp CSS để định nghĩa giao diện `User`.
  - `image/`: Chứa các hình ảnh được sử dụng trong giao diện.
  - `js/`: Chứa các tệp JavaScript để xử lý logic phía client.

### 3. `src/`
- Chứa mã nguồn chính của dự án, được tổ chức theo mô hình MVC.
- **Các thành phần**:
  - `controllers/`: Chứa các tệp xử lý logic điều khiển (controller).
  - `includes/`: Chứa các tệp dùng chung, như các hàm tiện ích hoặc cấu hình.
  - `models/`: Chứa các tệp định nghĩa logic dữ liệu (model).
  - `views/`: Chứa các tệp giao diện (view).
    - `layout/`: Chứa các tệp bố cục chung, như header, footer, hoặc các thành phần giao diện dùng chung.
    - `page/`: Chứa các tệp HTML cụ thể cho từng trang.

## LUỒNG LÀM VIỆC CỦA MVC:
**`User` gửi yêu cầu (Request):**
- `User` thực hiện một hành động, ví dụ: nhấn nút, gửi biểu mẫu, hoặc truy cập một URL.
- Yêu cầu này được gửi đến `Controller` thông qua trình duyệt hoặc giao diện `User`.

**Controller xử lý yêu cầu:**
`Controller` nhận yêu cầu từ `User`.
- Nó phân tích yêu cầu (ví dụ: URL, dữ liệu biểu mẫu) và quyết định hành động cần thực hiện.
- Nếu cần, `Controller` sẽ tương tác với `Model` để lấy hoặc cập nhật dữ liệu.

**Model xử lý dữ liệu:**
- `Model` chịu trách nhiệm quản lý dữ liệu và logic nghiệp vụ.
- Nó có thể truy vấn cơ sở dữ liệu, xử lý dữ liệu, hoặc thực hiện các tính toán.
- Sau khi xử lý, `Model` trả dữ liệu về cho `Controller`.

**Controller gửi dữ liệu đến View:**
- `Controller` nhận dữ liệu từ `Model` và chuyển nó đến `View`.
- `Controller` quyết định sử dụng giao diện nào `View` để hiển thị dữ liệu.

**View hiển thị dữ liệu:**
- `View` nhận dữ liệu từ `Controller` và hiển thị nó cho `User`.
- `View` chỉ tập trung vào việc hiển thị, không xử lý logic nghiệp vụ.

**User nhận phản hồi (Response):**
- Giao diện được hiển thị trên trình duyệt hoặc ứng dụng, và `User` có thể tiếp tục tương tác.
