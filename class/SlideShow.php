<?php

class SlideShow {
    public $id;
    public $img1;
    public $img2;
    public $img3;
    public $img4;

    // Constructor method
    public function __construct($id = 0, $img1 = "", $img2 = "", $img3 = "", $img4 = "") {
        $this->id = $id;
        $this->img1 = $img1;
        $this->img2 = $img2;
        $this->img3 = $img3;
        $this->img4 = $img4;
    }
    public static function fetchSlideshowImages($pdo) {
        $sql_img = "SELECT * FROM tbl_slideshow";
        $stmt = $pdo->prepare($sql_img);
        if($stmt ->execute()){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
 
    }
}
