<?php 
require_once "../class/Database.php";
require_once "../class/Product.php";
$pdo = Database::getInstance()->getConnection();
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $deleted = Product::deleteProductById($pdo, $id);
    if ($deleted) {
        header("location:admin.php?module=manage_product");
    } else {
        // Show error message
    }
  
} 
?>
