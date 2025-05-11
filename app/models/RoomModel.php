<?php
class RoomModel extends BaseModel
{
    protected $table = 'PHONG';
    protected $primaryKey = 'ID_PHONG';
    protected $fillable = [
        'Toa_Nha',
        'So_Tang',
        'So_Phong',
        'Suc_Chua',
        'Loai_Phong',
        'Gia_Phong',
        'Trang_Thai_Phong',
        'ID_NV'
    ];
    protected $casts = [
        'ID_PHONG' => 'string',
        'Toa_Nha' => 'string',
        'So_Tang' => 'int',
        'So_Phong' => 'int',
        'Suc_Chua' => 'int',
        'Loai_Phong' => 'int',
        'Gia_Phong' => 'float',
        'Trang_Thai_Phong' => 'bool',
        'ID_NV' => 'string'
    ];
    // Lấy thông tin phòng theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Lấy danh sách phòng theo nhân viên
    public function getByEmployee($idNhanVien)
    {
        $sql = "SELECT * FROM {$this->table} WHERE ID_NV = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $idNhanVien);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>
