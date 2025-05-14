<?php
class CusAccountModel extends BaseModel
{
    protected $table = 'CUS_ACCOUNT';
    protected $primaryKey = 'cusAccountId';
    protected $foreignKeys = [
        'customerID' => 'CustomerModel', // Giả sử có model CustomerModel
    ];
    protected $fillable = [
        'cusAccountId',
        'userName',
        'pwd',
        'customerID',
    ];
    protected $hidden = ['pwd']; // Ẩn mật khẩu để tránh lộ thông tin
    protected $casts = [];
    /**
     * Lấy tất cả tài khoản khách hàng.
     *
     * @return array
     */
    public function getAllCustomerAccounts()
    {
        return $this->getAll($this->table);
    }
    /**
     * Tìm một tài khoản khách hàng theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findCustomerAccountById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
    /**
     * Thêm một tài khoản khách hàng mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertCustomerAccount(array $data)
    {
        return $this->insert($this->table, $data);
    }
    /**
     * Cập nhật thông tin một tài khoản khách hàng.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateCustomerAccount(array $data, string $id)
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
     * Xóa một tài khoản khách hàng theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteCustomerAccount(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }
    /**
     * Lấy thông tin khách hàng của tài khoản này.
     *
     * @param string $accountId
     * @return array|null
     */
    public function getCustomer($accountId)
    {
        $sql = "SELECT c.* FROM {$this->table} ca
                JOIN Customer c ON ca.customerID = c.customerID
                WHERE ca.{$this->primaryKey} = '{$accountId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
    /**
     * Tìm tài khoản khách hàng theo tên người dùng.
     *
     * @param string $username
     * @return array|null
     */
    public function findCustomerAccountByUsername(string $username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE userName = '{$username}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
    // Các phương thức đặc thù khác cho model CusAccount có thể được thêm vào đây
    // Ví dụ: Xác thực đăng nhập.
    public function verifyPassword(string $username, string $password)
    {
        $account = $this->findCustomerAccountByUsername($username);
        if ($account && $account['pwd'] === $password) { // **LƯU Ý QUAN TRỌNG:** Trong thực tế, bạn nên sử dụng hàm băm (ví dụ: password_hash và password_verify) để bảo mật mật khẩu.
            return $account;
        }
        return null;
    }
}
?>