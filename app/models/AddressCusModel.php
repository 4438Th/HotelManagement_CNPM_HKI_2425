<?php
class AddressCusModel extends BaseModel
{
    protected $table = 'CUS_ADDRESS';
    protected $primaryKey = 'addressID';
    protected $foreignKeys = [
        'customerID' => 'CustomerModel', 
    ];
    protected $fillable = [
        'addressID',
        'city',
        'district',
        'ward',
        'street',
        'customerID',
    ];
    protected $hidden = [];
    protected $casts = [];
    /**
     * Lấy tất cả các địa chỉ khách hàng.
     *
     * @return array
     */
    public function getAllAddresses()
    {
        return $this->getAll($this->table);
    }
    /**
     * Tìm một địa chỉ khách hàng theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findAddressById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
    /**
     * Thêm một địa chỉ khách hàng mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertAddress(array $data)
    {
        return $this->insert($this->table, $data);
    }
    /**
     * Cập nhật thông tin một địa chỉ khách hàng.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateAddress(array $data, string $id)
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
     * Xóa một địa chỉ khách hàng theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteAddress(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }
    /**
     * Lấy thông tin khách hàng của địa chỉ này.
     *
     * @param string $addressId
     * @return array|null
     */
    public function getCustomer($addressId)
    {
        $sql = "SELECT c.* FROM {$this->table} ca
                JOIN Customer c ON ca.customerID = c.customerID
                WHERE ca.{$this->primaryKey} = '{$addressId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }
}