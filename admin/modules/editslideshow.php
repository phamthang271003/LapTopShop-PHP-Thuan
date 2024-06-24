<?php 
require_once "../class/Database.php";
$pdo = Database::getInstance()->getConnection();
$id = 1;
$Sel_edit = "SELECT * FROM tbl_slideshow WHERE id = :id";
$stmt = $pdo->prepare($Sel_edit);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$row_edit = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<section class="wrapper">
  <div class="panel-heading">
    Sửa Slideshow
  </div>
  <form action="" class="form-horizontal form-material" method="post" enctype="multipart/form-data">
    <label class="col-md-8">Ảnh Slide</label>
    <div class="col-md-8">
      Ảnh 1: <img src="../upload/<?php echo $row_edit["img1"];?>" width="250" height="150"> <input class="form-control form-control-line" type="file" name="img1" id="img1"><br>
      Ảnh 2: <img src="../upload/<?php echo $row_edit["img2"];?>" width="250" height="150"> <input class="form-control form-control-line" type="file" name="img2" id="img2" ><br>
      Ảnh 3: <img src="../upload/<?php echo $row_edit["img3"];?>" width="250" height="150"> <input class="form-control form-control-line" type="file" name="img3" id="img3" ><br>
      Ảnh 4: <img src="../upload/<?php echo $row_edit["img4"];?>" width="250" height="150"> <input class="form-control form-control-line" type="file" name="img4" id="img4" >
    </div>
    <div class="col-md-8" align="center">
      <button type="submit" name="sua" id="sua">Cập nhật</button>
    </div>
  </form>
  <br><br><br><br><br>
</section>

<?php 
if (isset($_POST["sua"])) {
  $anh1 = $row_edit['img1'];
  $anh2 = $row_edit['img2'];
  $anh3 = $row_edit['img3'];
  $anh4 = $row_edit['img4'];

  if (isset($_FILES["img1"]["name"]) && $_FILES["img1"]["error"] == 0) {
    if ($_FILES["img1"]["type"] == "image/jpeg" || $_FILES["img1"]["type"] == "image/png" || $_FILES["img1"]["type"] == "image/gif") {
      $anh1 = "slideshow/".$_FILES["img1"]["name"];
      move_uploaded_file($_FILES['img1']['tmp_name'], "../upload/".$anh1);
    }
  }

  if (isset($_FILES["img2"]["name"]) && $_FILES["img2"]["error"] == 0) {
    if ($_FILES["img2"]["type"] == "image/jpeg" || $_FILES["img2"]["type"] == "image/png" || $_FILES["img2"]["type"] == "image/gif") {
      $anh2 = "slideshow/".$_FILES["img2"]["name"];
      move_uploaded_file($_FILES['img2']['tmp_name'], "../upload/".$anh2);
    }
  }

  if (isset($_FILES["img3"]["name"]) && $_FILES["img3"]["error"] == 0) {
    if ($_FILES["img3"]["type"] == "image/jpeg" || $_FILES["img3"]["type"] == "image/png" || $_FILES["img3"]["type"] == "image/gif") {
      $anh3 = "slideshow/".$_FILES["img3"]["name"];
      move_uploaded_file($_FILES['img3']['tmp_name'], "../upload/".$anh3);
    }
  }

  if (isset($_FILES["img4"]["name"]) && $_FILES["img4"]["error"] == 0) {
    if ($_FILES["img4"]["type"] == "image/jpeg" || $_FILES["img4"]["type"] == "image/png" || $_FILES["img4"]["type"] == "image/gif") {
      $anh4 = "slideshow/".$_FILES["img4"]["name"];
      move_uploaded_file($_FILES['img4']['tmp_name'], "../upload/".$anh4);
    }
  }

  $Update = "UPDATE tbl_slideshow SET `img1` = :anh1, `img2` = :anh2, `img3` = :anh3, `img4` = :anh4 WHERE id = :id";
  $stmt = $pdo->prepare($Update);
  $stmt->bindParam(':anh1', $anh1);
  $stmt->bindParam(':anh2', $anh2);
  $stmt->bindParam(':anh3', $anh3);
  $stmt->bindParam(':anh4', $anh4);
  $stmt->bindParam(':id', $id, PDO::PARAM_INT);

  if ($stmt->execute()) {
    echo "<script>alert('Update thành công!'); window.location.href='admin.php?module=editslideshow'</script>";
  } else {
    echo "<script>alert('Có lỗi xảy ra khi cập nhật!');</script>";
  }
}
?>
