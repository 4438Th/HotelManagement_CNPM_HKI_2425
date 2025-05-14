<?php

class BookingDetailModel extends BaseModel
{
    protected $table = 'BOOKINGDETAIL';
    protected $primaryKey = 'bookingDetailID';
    protected $foreignKeys = [
        'orderID' => 'OrderModel', // Giả sử có model OrderModel
        'roomID' => 'RoomModel', // Giả sử có model RoomModel
        'voucherID' => 'VoucherModel', // Giả sử có model VoucherModel
    ];
    protected $fillable = [
        'bookingDetailID',
        'createdAt',
        'checkin',
        'checkout',
        'quantity',
        'paymentMethod',
        'discount',
        'total',
        'orderID',
        'roomID',
        'voucherID',
    ];
    protected $hidden = [];
    protected $casts = [
        'createdAt' => 'datetime',
        'checkin' => 'datetime',
        'checkout' => 'datetime',
        'quantity' => 'integer',
        'discount' => 'float',
        'total' => 'float',
    ];

    /**
     * Lấy tất cả chi tiết đặt phòng.
     *
     * @return array
     */
    public function getAllBookingDetails()
    {
        return $this->getAll($this->table);
    }

    /**
     * Tìm một chi tiết đặt phòng theo ID.
     *
     * @param string $id
     * @return array|null
     */
    public function findBookingDetailById(string $id)
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = '{$id}' LIMIT 1";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Thêm một chi tiết đặt phòng mới.
     *
     * @param array $data
     * @return bool
     */
    public function insertBookingDetail(array $data)
    {
        return $this->insert($this->table, $data);
    }

    /**
     * Cập nhật thông tin một chi tiết đặt phòng.
     *
     * @param array $data
     * @param string $id
     * @return bool
     */
    public function updateBookingDetail(array $data, string $id)
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
     * Xóa một chi tiết đặt phòng theo ID.
     *
     * @param string $id
     * @return bool
     */
    public function deleteBookingDetail(string $id)
    {
        $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = '{$id}'";
        return $this->conn->query($sql);
    }

    /**
     * Lấy thông tin đơn hàng.
     *
     * @param string $bookingDetailId
     * @return array|null
     */
    public function getOrder($bookingDetailId)
    {
        $sql = "SELECT o.* FROM {$this->table} bd
                JOIN `ORDER` o ON bd.orderID = o.orderID
                WHERE bd.{$this->primaryKey} = '{$bookingDetailId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thông tin phòng.
     *
     * @param string $bookingDetailId
     * @return array|null
     */
    public function getRoom($bookingDetailId)
    {
        $sql = "SELECT r.* FROM {$this->table} bd
                JOIN ROOM r ON bd.roomID = r.roomID
                WHERE bd.{$this->primaryKey} = '{$bookingDetailId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    /**
     * Lấy thông tin voucher.
     *
     * @param string $bookingDetailId
     * @return array|null
     */
    public function getVoucher($bookingDetailId)
    {
        $sql = "SELECT v.* FROM {$this->table} bd
                JOIN VOUCHER v ON bd.voucherID = v.voucherID
                WHERE bd.{$this->primaryKey} = '{$bookingDetailId}'";
        $result = $this->conn->query($sql);
        return ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
    }

    // Các phương thức đặc thù khác cho model BookingDetail có thể được thêm vào đây
    // Ví dụ: Lấy danh sách chi tiết đặt phòng theo khoảng thời gian, theo phòng, v.v.
    public function getBookingDetailsByRoom(string $roomId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE roomID = '{$roomId}'";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getBookingDetailsBetweenDates(string $startDate, string $endDate)
    {
        $sql = "SELECT * FROM {$this->table} WHERE checkin >= '{$startDate}' AND checkout <= '{$endDate}'";
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