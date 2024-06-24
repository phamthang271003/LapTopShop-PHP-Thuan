<?php 
class News {
    public $id_tin;
    public $tieuDe;
    public $img;
    public $tomtat;
    public $noidung;
    public $tukhoa;
    public $ngayviet;

    // Hàm khởi tạo
    public function __construct($id_tin, $tieuDe, $img, $tomtat, $noidung, $tukhoa, $ngayviet) {
        $this->id_tin = $id_tin;
        $this->tieuDe = $tieuDe;
        $this->img = $img;
        $this->tomtat = $tomtat;
        $this->noidung = $noidung;
        $this->tukhoa = $tukhoa;
        $this->ngayviet = $ngayviet;
    }
    public static function getAllNewsFromDatabase($pdo) {
        $sql = "SELECT * FROM tbl_tin ORDER BY id_tin DESC";
        $stmt = $pdo->query($sql);
        $newsList = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $newsList[] = new News($row['id_tin'], $row['tieuDe'], $row['img'], $row['tomtat'], $row['noidung'], $row['tukhoa'], $row['ngayviet']);
        }
        return $newsList;
    }
    public static function getNewsById($id,$pdo) {
        $sql = "SELECT * FROM tbl_tin WHERE id_tin = :id"; 
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null; // Return null if no news article found with the given ID
        }
        return new News($row['id_tin'], $row['tieuDe'], $row['img'], $row['tomtat'], $row['noidung'], $row['tukhoa'], $row['ngayviet']);
    }
}

?>