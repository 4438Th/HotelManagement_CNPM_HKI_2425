<?php

class VoucherWalletModel extends BaseModel
{
    protected $table = 'VOUCHERWALLET';
    protected $primaryKey = ['vwID', 'cusAccountId']; // Bảng này có khóa chính kép
    protected $fillable = [
        'vwID',
        'quantity',
        'cusAccountId',
    ];
    protected $hidden = [];
    protected $casts = [
        'quantity' => 'integer',
    ];

    /**
     * Lấy tất cả các ví voucher.
     *
     * @return array
     */
    public function getAllVoucherWallets()
    {
        return $this->getAll($this->table);
    }

    /**
     * Tìm một ví voucher theo ID ví và ID tài khoản khách hàng.
     *
     * @param string $vwId
     * @param string $cusAccountId
     * @return array|null
     */
    public function findVoucherWalletByIds(string $vwId, string $cusAccountId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE vwID = '{$vwId}' AND cusAccountId = '{$cusAccountId}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Thêm một ví voucher mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertVoucherWallet(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một ví voucher.
     *
     * @param array $data
     * @param string $vwId
     * @param string $cusAccountId
     * @return bool
     */
    public function updateVoucherWallet(array $data, string $vwId, string $cusAccountId)
    {
        $updates = [];
        foreach ($data as $key => $value) {
            $updates[] = "$key = '" . $this->conn->real_escape_string($value) . "'";
        }
        $updateStr = implode(",", $updates);
        $sql = "UPDATE {$this->table} SET {$updateStr} WHERE vwID = '{$vwId}' AND cusAccountId = '{$cusAccountId}'";
        return $this->conn->query($sql);
    }

    /**
     * Xóa một ví voucher theo ID ví và ID tài khoản khách hàng.
     *
     * @param string $vwId
     * @param string $cusAccountId
     * @return bool
     */
    public function deleteVoucherWallet(string $vwId, string $cusAccountId)
    {
        $sql = "DELETE FROM {$this->table} WHERE vwID = '{$vwId}' AND cusAccountId = '{$cusAccountId}'";
        return $this->conn->query($sql);
    }

    /**
     * Lấy thông tin voucher của ví này.
     *
     * @param string $vwId
     * @return array|null
     */
    public function getVoucher($vwId)
    {
        $sql = "SELECT v.* FROM {$this->table} vw
                JOIN VOUCHER v ON vw.vwID = v.vwID
                WHERE vw.vwID = '{$vwId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thông tin tài khoản khách hàng của ví này.
     *
     * @param string $cusAccountId
     * @return array|null
     */
    public function getCustomerAccount($cusAccountId)
    {
        $sql = "SELECT ca.* FROM {$this->table} vw
                JOIN CustomerAccount ca ON vw.cusAccountId = ca.cusAccountId
                WHERE vw.cusAccountId = '{$cusAccountId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Các phương thức đặc thù khác cho model VoucherWallet có thể được thêm vào đây
    // Ví dụ: Lấy danh sách ví voucher của một khách hàng cụ thể.
    public function getVoucherWalletsByCustomerId(string $cusAccountId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE cusAccountId = '{$cusAccountId}'";
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
?>