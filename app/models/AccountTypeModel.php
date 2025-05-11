<?php
class AccountTypeModel extends BaseModel
{
    protected $table = 'LOAITAIKHOAN';
    protected $primaryKey = 'ID_Chu_TK';
    protected $fillable = ['ID_Chu_TK', 'Loai_TK'];

    // Lấy loại tài khoản dựa trên ID_Chu_TK
    public function getAccountType($idChuTK)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $idChuTK);
        $stmt->execute();
        $result = $stmt->get_result();
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
}
