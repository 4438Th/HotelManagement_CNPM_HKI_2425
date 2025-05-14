<?php
class NoticeModel extends BaseModel {
    protected $table = 'NOTICE';
    protected $primaryKey = 'noticeID';
    protected $foreignKeys = [
        'empAccountId' => 'EmployeeAccountModel', // Giả sử có model EmployeeAccountModel
        'cusAccountId' => 'CustomerAccountModel', // Giả sử có model CustomerAccountModel
    ];
    protected $fillable = [
        'noticeID',
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
     * Lấy tất cả các thông báo.
     *
     * @return array
     */
    public function getAllNotices()
    {
        return $this->getAll($this->table);
    }

    /**
     * Tìm một thông báo theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findNoticeById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Thêm một thông báo mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertNotice(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một thông báo.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateNotice(array $data, string $id)
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
     * Xóa một thông báo theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteNotice(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }

    /**
     * Lấy thông tin tài khoản nhân viên tạo thông báo.
     *
     * @param string $noticeId
     * @return array|null
     */
    public function getEmployeeAccount($noticeId)
    {
        $sql = "SELECT ea.* FROM {$this->table} n
                JOIN EmployeeAccount ea ON n.empAccountId = ea.empAccountId
                WHERE n.{$this->primaryKey} = '{$noticeId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thông tin tài khoản khách hàng liên quan đến thông báo (nếu có).
     *
     * @param string $noticeId
     * @return array|null
     */
    public function getCustomerAccount($noticeId)
    {
        $sql = "SELECT ca.* FROM {$this->table} n
                LEFT JOIN CustomerAccount ca ON n.cusAccountId = ca.cusAccountId
                WHERE n.{$this->primaryKey} = '{$noticeId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
}