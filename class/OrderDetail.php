<?php 
class OrderDetail {
    public $id;
    public $oder_id;
    public $id_sp;
    public $name_sp;
    public $sl;
    public $gia_sp;
    public $dateOder;
    public $tong_tien;

    // Constructor
    public function __construct($id, $oder_id, $id_sp, $name_sp, $sl, $gia_sp, $dateOder, $tong_tien) {
        $this->id = $id;
        $this->oder_id = $oder_id;
        $this->id_sp = $id_sp;
        $this->name_sp = $name_sp;
        $this->sl = $sl;
        $this->gia_sp = $gia_sp;
        $this->dateOder = $dateOder;
        $this->tong_tien = $tong_tien;
    }
    public static function getOrderDetailsByOrderId($pdo, $orderId) {
        $sqlSelect = "SELECT * FROM tbl_oderdetail WHERE oder_id = :id";
        $stmt = $pdo->prepare($sqlSelect);
        $stmt->bindValue(':id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
