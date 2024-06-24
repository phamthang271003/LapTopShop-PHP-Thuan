<?php

class Product
{
    public $id_sp;
    public $name_sp;
    public $id_loaisp;
    public $id_hangsx;
    public $noibat;
    public $thongso_sp;
    public $mota_sp;
    public $img1;
    public $img2;
    public $img3;
    public $status;
    public $dateCreate;
    public $sale;
    public $gia_sp;

    // Constructor method
    public function __construct($id_sp = 0, $name_sp = "", $id_loaisp = 0, $id_hangsx = 0, $noibat = "", $thongso_sp = "", $mota_sp = "", $img1 = "", $img2 = "", $img3 = "", $status = null, $dateCreate = null, $sale = null, $gia_sp = null)
    {
        $this->id_sp = $id_sp;
        $this->name_sp = $name_sp;
        $this->id_loaisp = $id_loaisp;
        $this->id_hangsx = $id_hangsx;
        $this->noibat = $noibat;
        $this->thongso_sp = $thongso_sp;
        $this->mota_sp = $mota_sp;
        $this->img1 = $img1;
        $this->img2 = $img2;
        $this->img3 = $img3;
        $this->status = $status;
        $this->dateCreate = $dateCreate;
        $this->sale = $sale;
        $this->gia_sp = $gia_sp;
    }
    // Phương thức để lấy danh sách sản phẩm
    public static function listProducts($pdo, $current_page, $limit)
    {
        $start = ($current_page - 1) * $limit;
        $sql_product = "SELECT * FROM tbl_sp LIMIT $start, $limit";
        $stmt = $pdo->prepare($sql_product);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_CLASS);;
        }
    }


    // Phương thức để lấy sản phẩm theo danh mục và hãng sản xuất
    public static function getProductsByCategory($pdo, $categoryId, $manufacturerId, $orderBy, $orderDir) {
        $sql = "SELECT *, (gia_sp - (gia_sp * sale / 100)) AS discounted_price FROM tbl_sp WHERE id_loaisp = :categoryId";
        $params = ['categoryId' => $categoryId];
    
        if (!empty($manufacturerId)) {
            $sql .= " AND id_hangsx = :manufacturerId";
            $params['manufacturerId'] = $manufacturerId;
        }
    
        if ($orderBy == 'discounted_price') {
            $sql .= " ORDER BY discounted_price $orderDir";
        } else {
            $sql .= " ORDER BY $orderBy $orderDir";
        }
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
    
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    
    



    // Phương thức để lấy thông tin sản phẩm bằng ID
    public static function getProductById($pdo, $id)
    {
        $get_id = "SELECT * FROM tbl_sp WHERE id_sp = :id";
        $stmt = $pdo->prepare($get_id);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $stmt->fetch($stmt->setFetchMode(PDO::FETCH_CLASS, "Product"));
        }
    }
    public static function searchProducts($pdo, $searchText)
    {
        $sql_query = "SELECT * FROM tbl_sp WHERE name_sp LIKE :search";
        $stmt = $pdo->prepare($sql_query);
        $stmt->bindValue(':search', '%' . $searchText . '%', PDO::PARAM_STR);
        if ($stmt->execute()) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    //Admin
    public static function listProductAdmin()
    {
        $pdo = Database::getInstance()->getConnection();
        $sqlSelect = "SELECT tbl_sp.*, tbl_loaisp.name_loaisp, tbl_hangsx.name_hangsx FROM tbl_hangsx, tbl_loaisp, tbl_sp WHERE tbl_loaisp.id_loaisp = tbl_sp.id_loaisp AND tbl_sp.id_hangsx = tbl_hangsx.id_hangsx GROUP BY tbl_sp.id_sp";
        $stmt = $pdo->query($sqlSelect);

        $productData = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productData[] = $row;
        }

        return $productData;
    }
    //Thêm sản phẩm 
    public static function addNewProduct($name_prod, $prod_type, $manufacturer, $noibat, $thongso, $mota, $status1, $anh1, $anh2, $anh3, $dateCreate, $sale, $price)
    {
        $pdo = Database::getInstance()->getConnection();

        try {
            $pdo->beginTransaction();

            $sql_product = "INSERT INTO tbl_sp(name_sp,id_loaisp,id_hangsx,noibat, thongso_sp, mota_sp,status,img1,img2,img3,dateCreate,sale,gia_sp) VALUES (:name_prod, :prod_type, :manufacturer, :noibat, :thongso, :mota, :status1, :anh1, :anh2, :anh3, :dateCreate, :sale, :price)";

            $stmt = $pdo->prepare($sql_product);
            $stmt->bindParam(':name_prod', $name_prod);
            $stmt->bindParam(':prod_type', $prod_type);
            $stmt->bindParam(':manufacturer', $manufacturer);
            $stmt->bindParam(':noibat', $noibat);
            $stmt->bindParam(':thongso', $thongso);
            $stmt->bindParam(':mota', $mota);
            $stmt->bindParam(':status1', $status1);
            $stmt->bindParam(':anh1', $anh1);
            $stmt->bindParam(':anh2', $anh2);
            $stmt->bindParam(':anh3', $anh3);
            $stmt->bindParam(':dateCreate', $dateCreate);
            $stmt->bindParam(':sale', $sale);
            $stmt->bindParam(':price', $price);

            $stmt->execute();

            $pdo->commit();

            return true; // Successfully added the product
        } catch (PDOException $e) {
            // Rollback in case of error
            $pdo->rollback();
            return false; // Failed to add the product
        }
    }
    public static function updateProduct($pdo, $id, $name_prod, $prod_type, $manufacturer, $noibat, $thongso, $mota, $anh1, $anh2, $anh3, $status1, $sale, $price)
    {
        try {
            $pdo->beginTransaction();

            // Build the SQL update statement based on which images are provided
            $updateParams = [
                ':name' => $name_prod,
                ':prod_type' => $prod_type,
                ':manufacturer' => $manufacturer,
                ':noibat' => $noibat,
                ':thongso' => $thongso,
                ':mota' => $mota,
                ':status1' => $status1,
                ':sale' => $sale,
                ':price' => $price,
                ':id' => $id
            ];

            // Add image parameters only if they are provided
            if ($anh1 !== null) $updateParams[':anh1'] = $anh1;
            if ($anh2 !== null) $updateParams[':anh2'] = $anh2;
            if ($anh3 !== null) $updateParams[':anh3'] = $anh3;

            // Build the SQL update query based on provided image parameters
            $updateQuery = "UPDATE tbl_sp SET name_sp=:name, id_loaisp=:prod_type, id_hangsx=:manufacturer, noibat=:noibat, thongso_sp=:thongso, mota_sp=:mota, status=:status1, sale=:sale, gia_sp=:price";
            if ($anh1 !== null) $updateQuery .= ", img1=:anh1";
            if ($anh2 !== null) $updateQuery .= ", img2=:anh2";
            if ($anh3 !== null) $updateQuery .= ", img3=:anh3";
            $updateQuery .= " WHERE id_sp = :id";

            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute($updateParams);

            $pdo->commit();

            return true; // Successfully updated the product
        } catch (PDOException $e) {
            // Rollback in case of error
            $pdo->rollback();
            return false; // Failed to update the product
        }
    }
    public static function deleteProductById($pdo, $id)
    {
        try {
            $sqlDel = "DELETE FROM tbl_sp WHERE id_sp = :id";
            $stmt = $pdo->prepare($sqlDel);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
