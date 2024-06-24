<?php
$pdo = Database::getInstance()->getConnection(); 
if (isset($_GET["id_tin"])) {
    $id_tin = $_GET['id_tin'];
    $sqlDel = "DELETE FROM tbl_tin WHERE id_tin = :id_tin";
    $stmt = $pdo->prepare($sqlDel);
    $stmt->execute([':id_tin' => $id_tin]);
    header("location:admin.php?module=quanlytintuc");
} 
?>
