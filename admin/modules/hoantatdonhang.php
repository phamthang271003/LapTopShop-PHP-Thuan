<?php 
$pdo = Database::getInstance()->getConnection();
if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$sqlUp = "UPDATE `tbl_oder` SET `status`=0 WHERE oder=:id";
	$stmt = $pdo->prepare($sqlUp);
	$stmt->execute([':id' => $id]);
	header("location:admin.php?module=quanlydonhang");
}
?>
