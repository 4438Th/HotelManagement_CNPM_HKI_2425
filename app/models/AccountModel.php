<?php
class AccountModel extends BaseModel
{
    protected $table = 'TAIKHOAN';
    protected $primaryKey = 'ID_TK';
    protected $fillable = ['Ten_TK', 'Mat_Khau', 'ID_Chu_TK'];
    protected $hidden = ['Mat_Khau'];
    protected $casts = [
        'ID_TK' => 'string',
        'Ten_TK' => 'string',
        'ID_Chu_TK' => 'int'
    ];
    // Lấy thông tin chủ tài khoản (KHACHHANG hoặc NHANVIEN)
    public function getOwner($idChuTK)
    {
        $accountTypeModel = new AccountTypeModel();
        $accountType = $accountTypeModel->getAccountType($idChuTK);

        if ($accountType) {
            $loaiChuTK = $accountType['Loai_TK'];
            if ($loaiChuTK === 'KHACHHANG') {
                return $this->getRelated('KHACHHANG', 'ID_KH', $idChuTK);
            } elseif ($loaiChuTK === 'NHANVIEN') {
                return $this->getRelated('NHANVIEN', 'ID_NV', $idChuTK);
            }
        }
        return null;
    }
    
}
