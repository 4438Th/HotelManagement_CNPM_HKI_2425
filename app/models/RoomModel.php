<?php
class RoomModel extends BaseModel
{
    protected $table = 'ROOM';
    protected $primaryKey = 'roomID';
    protected $foreignKeys = [
        'empAccountId' => 'EmployeeAccountModel',
    ];
    protected $fillable = [
        'roomID',
        'building',
        'floor',
        'room', 
        'capacity',
        'type',
        'price',
        'state',
        'empAccountId',
    ];
    protected $hidden = [];
    protected $casts = [
        'floor' => 'integer',
        'room' => 'integer',
        'capacity' => 'integer',
        'price' => 'float',
    ];

    /**
     * Lấy tất cả các phòng.
     *
     * @return array
     */
    public function getAllRooms()
    {
        return $this->getAll($this->table);
    }

    /**
     * Tìm một phòng theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findRoomById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Thêm một phòng mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertRoom(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một phòng.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateRoom(array $data, string $id)
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
     * Xóa một phòng theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteRoom(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }

    /**
     * Lấy thông tin nhân viên quản lý phòng.
     *
     * @param string $roomId
     * @return array|null
     */
    public function getEmployeeAccount($roomId)
    {
        $sql = "SELECT ea.* FROM {$this->table} r
                JOIN EmployeeAccount ea ON r.empAccountId = ea.empAccountId
                WHERE r.{$this->primaryKey} = '{$roomId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
}
?>
