<?php

class BookingModel extends BaseModel
{
    protected $table = 'BOOKING';
    protected $primaryKey = 'bookingID';
    protected $foreignKeys = [
        'bookingDetailID' => 'BookingDetailModel', // Giả sử có model BookingDetailModel
        'billID' => 'BillModel', // Giả sử có model BillModel
        'cusAccountId' => 'CusAccountModel', // Giả sử có model CusAccountModel
        'empAccountId' => 'EmpAccountModel', // Giả sử có model EmpAccountModel
    ];
    protected $fillable = [
        'bookingID',
        'bookingState',
        'bookingDetailID',
        'billID',
        'cusAccountId',
        'empAccountId',
    ];
    protected $hidden = [];
    protected $casts = [];

    /**
     * Lấy tất cả các đặt phòng.
     *
     * @return array
     */
    public function getAllBookings()
    {
        return $this->getAll($this->table);
    }

    /**
     * Tìm một đặt phòng theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findBookingById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Thêm một đặt phòng mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertBooking(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một đặt phòng.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateBooking(array $data, string $id)
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
     * Xóa một đặt phòng theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteBooking(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }

    /**
     * Lấy thông tin chi tiết đặt phòng.
     *
     * @param string $bookingId
     * @return array|null
     */
    public function getBookingDetail($bookingId)
    {
        $sql = "SELECT bd.* FROM {$this->table} b
                JOIN BookingDetail bd ON b.bookingDetailID = bd.bookingDetailID
                WHERE b.{$this->primaryKey} = '{$bookingId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thông tin hóa đơn.
     *
     * @param string $bookingId
     * @return array|null
     */
    public function getBill($bookingId)
    {
        $sql = "SELECT bi.* FROM {$this->table} b
                JOIN Bill bi ON b.billID = bi.billID
                WHERE b.{$this->primaryKey} = '{$bookingId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thông tin tài khoản khách hàng.
     *
     * @param string $bookingId
     * @return array|null
     */
    public function getCustomerAccount($bookingId)
    {
        $sql = "SELECT ca.* FROM {$this->table} b
                JOIN CusAccount ca ON b.cusAccountId = ca.cusAccountId
                WHERE b.{$this->primaryKey} = '{$bookingId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thông tin tài khoản nhân viên.
     *
     * @param string $bookingId
     * @return array|null
     */
    public function getEmployeeAccount($bookingId)
    {
        $sql = "SELECT ea.* FROM {$this->table} b
                JOIN EmpAccount ea ON b.empAccountId = ea.empAccountId
                WHERE b.{$this->primaryKey} = '{$bookingId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Các phương thức đặc thù khác cho model Booking có thể được thêm vào đây
    // Ví dụ: Lấy danh sách đặt phòng theo trạng thái, theo khách hàng, theo nhân viên, v.v.
    public function getBookingsByCustomer(string $cusAccountId)
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

    public function getBookingsByState(string $bookingState)
    {
        $sql = "SELECT * FROM {$this->table} WHERE bookingState = '{$bookingState}'";
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