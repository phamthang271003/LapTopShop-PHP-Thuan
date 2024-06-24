<?php 
$pdo = Database::getInstance()->getConnection();
if (isset($_GET["id"])) {
    $id = $_GET['id'];
    $sqlDel = "DELETE FROM tbl_user WHERE id_user = :id";
    $stmt = $pdo->prepare($sqlDel);
    $stmt->execute([':id' => $id]);
    header("location:admin.php?module=listUser");
} 
?>
