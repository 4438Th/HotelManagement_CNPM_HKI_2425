<?php
class VoucherModel extends BaseModel
{
    protected $table = 'VOUCHER';
    protected $primaryKey = 'voucherID';
    protected $fillable = [
        'createAt',
        'expired',
        'name',
        'type',
        'unit',
        'value ',
        'vwID',
        'empAccountID'
    ];
    protected $casts = [
        'voucherID' => 'string',
        'createAt' => 'datetime',
        'expired' => 'datetime',
        'name' => 'string',
        'type' => 'int',
        'unit' => 'int',
        'Gia_Tri' => 'float',
        'vwID'=>'string',
        'empAccountID' => 'string'
    ];
    //Lay thong tin VC
    public function getAllVouchers()
    {
        return $this->getAll($this->table);
    }
    //Tim VC
    public function findVoucherById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
    //Them
    public function insertVoucher(array $data)
    {
        return $this->insert($this->table, $data);
    }
    //Sua
    public function updateVoucher(array $data, string $id)
    {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "$key = '" . $this->conn->real_escape_string($value) . "'";
        }
        $updateStr = implode(",", $updates);
        $sql = "UPDATE {$this->table} SET {$updateStr} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }
    //Xoa
    public function deleteVoucher(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }
    // Lấy thông tin nhân viên tạo voucher (FK ID_NV)
    public function getEmployeeAccount($voucherId)
    {
        $sql = "SELECT ea.* FROM {$this->table} v
                JOIN EmployeeAccount ea ON v.empAccountId = ea.empAccountId
                WHERE v.{$this->primaryKey} = '{$voucherId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
}
