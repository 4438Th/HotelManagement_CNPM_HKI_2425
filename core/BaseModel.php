<?php
class BaseModel
{
    protected $conn;
    protected $primaryKey = '';
    protected $foreignKeys = '';
    protected $table = '';
    protected $fillable = [];
    protected $hidden = [];
    protected $casts = [];

    // Tạo kết nối
    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "QuanLyKhachSan");

        if ($this->conn->connect_error) {
            die("Kết nối thất bại: " . $this->conn->connect_error);
        }
    }
    // Đóng kết nối
    public function __destruct()
    {
        $this->conn->close();
    }
    // Ẩn các thuộc tính
    public function hideAttributes(array $attributes)
    {
        foreach ($this->hidden as $hiddenField) {
            if (isset($attributes[$hiddenField])) {
                unset($attributes[$hiddenField]);
            }
        }
        return $attributes;
    }
    // Phương thức chuyển đổi kiểu dữ liệu
    public function castAttributes(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (isset($this->casts[$key])) {
                settype($attributes[$key], $this->casts[$key]);
            }
        }
        return $attributes;
    }
    // Lấy toàn bộ bản ghi
    public function getAll($table)
    {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql);

        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Tìm 1 bản ghi theo ID
    public function findById($table, $id)
    {
        $sql = "SELECT * FROM $table WHERE id = $id LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Thêm bản ghi mới
    public function insert($table, $data)
    {
        $columns = implode(",", array_keys($data));
        $values = "'" . implode("','", array_values($data)) . "'";
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        return $this->conn->query($sql);
    }

    // Cập nhật bản ghi
    public function update($table, $data, $id)
    {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "$key = '$value'";
        }
        $updateStr = implode(",", $updates);
        $sql = "UPDATE $table SET $updateStr WHERE id = $id";
        return $this->conn->query($sql);
    }

    // Xóa bản ghi
    public function delete($table, $id)
    {
        $sql = "DELETE FROM $table WHERE id = $id";
        return $this->conn->query($sql);
    }
}
