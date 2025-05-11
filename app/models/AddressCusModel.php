<?php
class AddressCusModel extends BaseModel
{
    protected $table = 'DIACHI_KH';
    protected $primaryKey = 'ID_DC';
    protected $fillable = ['Tinh_TP', 'Quan', 'Phuong', 'Duong', 'ID_NV'];
    protected $casts = [
        'ID_DC' => 'string',
        'Tinh_TP' => 'string',
        'Quan' => 'string',
        'Phuong' => 'string',
        'Duong' => 'string',
        'ID_NV' => 'string'
    ];
    // Lấy thông tin nhân viên sở hữu địa chỉ (FK ID_NV)
    public function getNhanVien($idNhanVien)
    {
    $sql = "SELECT * FROM NHANVIEN WHERE ID_NV = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $idNhanVien);
    $stmt->execute();
    $result = $stmt->get_result();
    return $this->getRelated('NHANVIEN', 'ID_NV', $idNhanVien);
    }
}