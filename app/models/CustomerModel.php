<?php
class CustomerModel extends BaseModel
{
   protected $table = 'CUSTOMER';
    protected $primaryKey = 'customerID';
    protected $fillable = [
        'customerID',
        'firstName',
        'lastName',
    ];
    protected $hidden = [];
    protected $casts = [];

    /**
     * Lấy tất cả khách hàng.
     *
     * @return array
     */
    public function getAllCustomers()
    {
        return $this->getAll($this->table);
    }

    /**
     * Tìm một khách hàng theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findCustomerById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Thêm một khách hàng mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertCustomer(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một khách hàng.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateCustomer(array $data, string $id)
    {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "$key = '" . $this->conn->real_escape_string($value) . "'";
        }
        $updateStr = implode(",", $updates);
        $sql = "UPDATE {$this->table} SET {$updateStr} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }

    /**
     * Xóa một khách hàng theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteCustomer(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }

    // Các phương thức đặc thù khác cho model Customer có thể được thêm vào đây
    // Ví dụ: Lấy danh sách khách hàng theo tên, tìm kiếm khách hàng, v.v.
    public function getCustomersByName(string $firstName, string $lastName = '')
    {
        $sql = "SELECT * FROM {$this->table} WHERE firstName LIKE '%{$firstName}%'";
        if (!empty($lastName)) {
            $sql .= " AND lastName LIKE '%{$lastName}%'";
        }
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
