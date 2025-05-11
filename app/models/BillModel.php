<?php
class BillModel extends BaseModel
{
    protected $table = 'HOADON';
    protected $primaryKey = 'ID_HD';
    protected $fillable = [
        'Ngay_Tao_HD',
        'Ngay_Het_Han_HD',
        'Trang_Thai_HD',
        'ID_DDP',
        'ID_NV'
    ];
    protected $casts = [
        'ID_HD' => 'string',
        'Ngay_Tao_HD' => 'datetime',
        'Ngay_Het_Han_HD' => 'datetime',
        'Trang_Thai_HD' => 'bool',
        'ID_DDP' => 'string',
        'ID_NV' => 'string'
    ];
    // Hàm lấy hóa đơn theo ID
    public function getById($id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
    // Hàm lấy tất cả hóa đơn theo nhân viên
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
