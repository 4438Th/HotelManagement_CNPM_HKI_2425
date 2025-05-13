<?php
class ReplyModel extends BaseModel {
    protected $table = 'REPLY';
    protected $primaryKey = 'replyID';
    protected $foreignKeys = [
        'empAccountId' => 'EmployeeAccountModel', // Giả sử có model EmployeeAccountModel
        'cusAccountId' => 'CustomerAccountModel', // Giả sử có model CustomerAccountModel
    ];
    protected $fillable = [
        'replyID',
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
     * Lấy tất cả các phản hồi.
     *
     * @return array
     */
    public function getAllReplies()
    {
        return $this->getAll($this->table);
    }

    /**
     * Tìm một phản hồi theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findReplyById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Thêm một phản hồi mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertReply(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một phản hồi.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateReply(array $data, string $id)
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
     * Xóa một phản hồi theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteReply(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }

    /**
     * Lấy thông tin tài khoản nhân viên gửi phản hồi.
     *
     * @param string $replyId
     * @return array|null
     */
    public function getEmployeeAccount($replyId)
    {
        $sql = "SELECT ea.* FROM {$this->table} r
                JOIN EmployeeAccount ea ON r.empAccountId = ea.empAccountId
                WHERE r.{$this->primaryKey} = '{$replyId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thông tin tài khoản khách hàng gửi phản hồi.
     *
     * @param string $replyId
     * @return array|null
     */
    public function getCustomerAccount($replyId)
    {
        $sql = "SELECT ca.* FROM {$this->table} r
                JOIN CustomerAccount ca ON r.cusAccountId = ca.cusAccountId
                WHERE r.{$this->primaryKey} = '{$replyId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
}