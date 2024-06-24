<?php 
class Category{
    public $id_loaisp;
    public $name_loaisp;
    
    // Hàm khởi tạo
   public function __construct($id_loaisp, $name_loaisp) {
        $this->id_loaisp = $id_loaisp;
        $this->name_loaisp = $name_loaisp;
    }
    public static function getManufacturersByCategory($pdo, $categoryId) {
        $sql = "SELECT tbl_hangsx.id_hangsx, tbl_hangsx.name_hangsx, tbl_hangsx.ma_cha, tbl_loaisp.id_loaisp, tbl_loaisp.name_loaisp 
                FROM tbl_hangsx, tbl_loaisp 
                WHERE tbl_hangsx.ma_cha = tbl_loaisp.id_loaisp 
                AND tbl_loaisp.id_loaisp = :categoryId 
                ORDER BY tbl_hangsx.name_hangsx ASC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['categoryId' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>