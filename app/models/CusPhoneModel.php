<?php
class CusPhoneModel extends BaseModel
{
    protected $table = 'CUS_PHONE';
    protected $primaryKey = 'phone';
    protected $foreignKeys = [
        'customerID' => 'CustomerModel', // Giả sử có model CustomerModel
    ];
    protected $fillable = [
        'phone',
        'customerID',
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
     * Thêm một số điện thoại khách hàng mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertPhone(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một số điện thoại khách hàng (chủ yếu là customerID).
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
     * Xóa một số điện thoại khách hàng theo số điện thoại.
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
     * Lấy thông tin khách hàng của số điện thoại này.
     *
     * @param string $phone
     * @return array|null
     */
    public function getCustomer($phone)
    {
        $sql = "SELECT c.* FROM {$this->table} cp
                JOIN Customer c ON cp.customerID = c.customerID
                WHERE cp.{$this->primaryKey} = '{$phone}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Các phương thức đặc thù khác cho model CusPhone có thể được thêm vào đây
    // Ví dụ: Lấy danh sách số điện thoại của một khách hàng cụ thể.
    public function getPhonesByCustomerId(string $customerId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE customerID = '{$customerId}'";
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