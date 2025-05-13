<?php

class EmpAccountModel extends BaseModel
{
    protected $table = 'EMP_ACCOUNT';
    protected $primaryKey = 'empAccountId';
    protected $foreignKeys = [
        'employeeID' => 'EmployeeModel', // Giả sử có model EmployeeModel
    ];
    protected $fillable = [
        'empAccountId',
        'userName',
        'pwd',
        'accountType',
        'employeeID',
    ];
    protected $hidden = ['pwd']; // Ẩn mật khẩu để tránh lộ thông tin
    protected $casts = [];
    /**
     * Lấy tất cả tài khoản nhân viên.
     *
     * @return array
     */
    public function getAllEmployeeAccounts()
    {
        return $this->getAll($this->table);
    }
    /**
     * Tìm một tài khoản nhân viên theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findEmployeeAccountById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
    /**
     * Thêm một tài khoản nhân viên mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertEmployeeAccount(array $data)
    {
        return $this->insert($this->table, $data);
    }
    /**
     * Cập nhật thông tin một tài khoản nhân viên.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateEmployeeAccount(array $data, string $id)
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
     * Xóa một tài khoản nhân viên theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteEmployeeAccount(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }
    /**
     * Lấy thông tin nhân viên của tài khoản này.
     *
     * @param string $accountId
     * @return array|null
     */
    public function getEmployee($accountId)
    {
        $sql = "SELECT e.* FROM {$this->table} ea
                JOIN Employee e ON ea.employeeID = e.employeeID
                WHERE ea.{$this->primaryKey} = '{$accountId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
    /**
     * Tìm tài khoản nhân viên theo tên người dùng.
     *
     * @param string $username
     * @return array|null
     */
    public function findEmployeeAccountByUsername(string $username)
    {
        $sql = "SELECT * FROM {$this->table} WHERE userName = '{$username}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Xác thực mật khẩu nhân viên.
     *
     * @param string $username
     * @param string $password
     * @return array|null
     */
    public function verifyPassword(string $username, string $password)
    {
        $account = $this->findEmployeeAccountByUsername($username);
        if ($account && $account['pwd'] === $password) { // **LƯU Ý QUAN TRỌNG:** Trong thực tế, bạn nên sử dụng hàm băm (ví dụ: password_hash và password_verify) để bảo mật mật khẩu.
            return $account;
        }
        return null;
    }
    // Các phương thức đặc thù khác cho model EmpAccount có thể được thêm vào đây
    // Ví dụ: Lấy danh sách tài khoản theo loại tài khoản.
    public function getAccountsByType(string $accountType)
    {
        $sql = "SELECT * FROM {$this->table} WHERE accountType = '{$accountType}'";
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
?>