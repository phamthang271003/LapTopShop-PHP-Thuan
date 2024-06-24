<?php  
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $sqlDetail = "SELECT * FROM tbl_sp WHERE id_sp = :id";
    $stmt = $pdo->prepare($sqlDetail);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!isset($_SESSION["cart"])){
        $cart[$id] = $data;
        $cart[$id]['productQuanlity'] = 1;
    }else{
        $cart = $_SESSION["cart"];
        if(array_key_exists($id , $cart)){
            $cart[$id]['productQuanlity'] += 1;
        }else{
            $cart[$id] = $data;
            $cart[$id]['productQuanlity'] = 1;
        }
    }

    $_SESSION["cart"] = $cart;
}
?>
