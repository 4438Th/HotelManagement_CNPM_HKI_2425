<?php
class EMPPhoneModel extends BaseModel {
  
    protected $table = 'EMp_PHONE';
    protected $primaryKey = 'phone';
    protected $foreignKeys = [
        'employeeID' => 'EmployeeModel', // Giả sử có model CustomerModel
    ];
    protected $fillable = [
        'phone',
        'employeeID',
    ];
    protected $hidden = [];
    protected $casts = [];

    /**
     * Lấy tất cả số điện thoại khách hàng.
     *
     * @return array
     */
    public function getAllPhones()
    {
        return $this->getAll($this->table);
    }

    /**
     * Tìm một số điện thoại khách hàng theo số điện thoại.
     *
     * @param string $phone
     * @return array|null
     */
    public function findPhoneByPhone(string $phone)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$phone}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Thêm một số điện thoại nhan vien mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertPhone(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một số điện thoại nhan vien(chủ yếu là employeeID).
     *
     * @param array $data
     * @param string $phone
     * @return bool
     */
    public function updatePhone(array $data, string $phone)
    {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "$key = '" . $this->conn->real_escape_string($value) . "'";
        }
        $updateStr = implode(",", $updates);
        $sql = "UPDATE {$this->table} SET {$updateStr} WHERE {$this->primaryKey} = '{$phone}'";
        return $this->conn->query($sql);
    }

    /**
     * Xóa một số điện thoại nhan vien theo số điện thoại.
     *
     * @param string $phone
     * @return bool
     */
    public function deletePhone(string $phone)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$phone}'";
        return $this->conn->query($sql);
    }

    /**
     * Lấy thông tinnhan vien của số điện thoại này.
     *
     * @param string $phone
     * @return array|null
     */
    public function getEmployee($phone)
    {
        $sql = "SELECT c.* FROM {$this->table} cp
                JOIN Employee c ON cp.employeeID = c.employeeID
                WHERE cp.{$this->primaryKey} = '{$phone}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Các phương thức đặc thù khác cho model EMPPhone có thể được thêm vào đây
    // Ví dụ: Lấy danh sách số điện thoại của một nhan vien cụ thể.
    public function getPhonesByEmployeeId(string $employeeId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE employeeID = '{$employeeId}'";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }
}