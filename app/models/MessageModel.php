<?php
class MessageModel extends BaseModel {
    protected $table = 'MESSAGE';
    protected $primaryKey = 'messageID';
    protected $foreignKeys = [
        'empAccountId' => 'EmployeeAccountModel', // Giả sử có model EmployeeAccountModel
        'cusAccountId' => 'CustomerAccountModel', // Giả sử có model CustomerAccountModel
    ];
    protected $fillable = [
        'messageID',
        'createdAt',
        'content',
        'empAccountId',
        'cusAccountId',
    ];
    protected $hidden = [];
    protected $casts = [
        'createdAt' => 'datetime',
    ];

    /**
     * Lấy tất cả các tin nhắn.
     *
     * @return array
     */
    public function getAllMessages()
    {
        return $this->getAll($this->table);
    }

    /**
     * Tìm một tin nhắn theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findMessageById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Thêm một tin nhắn mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertMessage(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một tin nhắn.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateMessage(array $data, string $id)
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
     * Xóa một tin nhắn theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteMessage(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }

    /**
     * Lấy thông tin tài khoản nhân viên gửi tin nhắn.
     *
     * @param string $messageId
     * @return array|null
     */
    public function getEmployeeAccount($messageId)
    {
        $sql = "SELECT ea.* FROM {$this->table} m
                JOIN EmployeeAccount ea ON m.empAccountId = ea.empAccountId
                WHERE m.{$this->primaryKey} = '{$messageId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thông tin tài khoản khách hàng nhận tin nhắn.
     *
     * @param string $messageId
     * @return array|null
     */
    public function getCustomerAccount($messageId)
    {
        $sql = "SELECT ca.* FROM {$this->table} m
                JOIN CustomerAccount ca ON m.cusAccountId = ca.cusAccountId
                WHERE m.{$this->primaryKey} = '{$messageId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
}