<?php
class VoucherModel extends BaseModel
{
    protected $table = 'VOUCHER';
    protected $primaryKey = 'ID_VC';
    protected $fillable = [
        'Ngay_Tao_VC',
        'Han_Su_Dung',
        'Ten_VC',
        'Loai_VC',
        'Don_Vi_Tinh',
        'Gia_Tri',
        'ID_NV'
    ];
    protected $casts = [
        'ID_VC' => 'string',
        'Ngay_Tao_VC' => 'datetime',
        'Han_Su_Dung' => 'datetime',
        'Ten_VC' => 'string',
        'Loai_VC' => 'int',
        'Don_Vi_Tinh' => 'int',
        'Gia_Tri' => 'float',
        'ID_NV' => 'string'
    ];
    // Lấy thông tin nhân viên tạo voucher (FK ID_NV)
    public function getNhanVien($idNhanVien)
    {
    $sql = "SELECT * FROM NHANVIEN WHERE ID_NV = ?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("s", $idNhanVien); 
    $stmt->execute();
    $result = $stmt->get_result();
    return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
}
