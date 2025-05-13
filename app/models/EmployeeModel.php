<?php
class EmployeeModel extends BaseModel 
{
    protected $table = 'EMPLOYEE';
    protected $primaryKey = 'employeeID';
    protected $fillable = [
        'employeeID',
        'firstName',
        'lastName',
        'position',
    ];
    protected $hidden = [];
    protected $casts = [];

    /**
     * Lấy tất cả nhân viên.
     *
     * @return array
     */
    public function getAllEmployees()
    {
        return $this->getAll($this->table);
    }

    /**
     * Tìm một nhân viên theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findEmployeeById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Thêm một nhân viên mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertEmployee(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một nhân viên.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateEmployee(array $data, string $id)
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
     * Xóa một nhân viên theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteEmployee(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }

    // Các phương thức đặc thù khác cho model Employee có thể được thêm vào đây
    // Ví dụ: Lấy danh sách nhân viên theo vị trí, tìm kiếm nhân viên theo tên, v.v.
    public function getEmployeesByPosition(string $position)
    {
        $sql = "SELECT * FROM {$this->table} WHERE position LIKE '%{$position}%'";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function searchEmployeesByName(string $name)
    {
        $sql = "SELECT * FROM {$this->table} WHERE firstName LIKE '%{$name}%' OR lastName LIKE '%{$name}%'";
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
