<?php 
$pdo = Database::getInstance()->getConnection();
if(isset($_POST["addTT"])){
  $name = $_POST["name"];
  $tomtat = $_POST["tomtat"];
  $noidung = $_POST["noidung"];
  $tukhoa = $_POST["tukhoa"];
  $dateCreate = date("Y-m-d H:i:s");
  $anh1 = "";

  if (isset($_FILES["img1"]["name"])) {
    if ($_FILES["img1"]["type"] == "image/jpeg" || $_FILES["img1"]["type"] == "image/png") {
      $anh1 = "upload/".$_FILES["img1"]["name"];
      move_uploaded_file($_FILES['img1']['tmp_name'], "../upload/imgtin/upload/".$_FILES["img1"]["name"]); 
    }
  }

  $sql_tt = "INSERT INTO tbl_tin(tieuDe,img,tomtat,noidung,tukhoa, ngayviet) VALUES (:name, :img1, :tomtat, :noidung, :tukhoa, :dateCreate)";
  $stmt = $pdo->prepare($sql_tt);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':img1', $anh1);
  $stmt->bindParam(':tomtat', $tomtat);
  $stmt->bindParam(':noidung', $noidung);
  $stmt->bindParam(':tukhoa', $tukhoa);
  $stmt->bindParam(':dateCreate', $dateCreate);

  if ($stmt->execute()) {
    echo ("<script>alert('Đăng bài thành công'); location.href='?module=quanlytintuc';</script>");
  } else {
    echo ("<script>alert('Đăng bài không thành công');</script>");
  }
}
?>
<section class="wrapper">
  <div class="panel-heading">
    Viết bài tin tức
  </div>
  <form action="" class="form-horizontal form-material" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label class="col-md-8">Tiêu đề</label>
      <div class="col-md-8">
        <input class="form-control form-control-line" placeholder="Nhập tiêu đề bài viết" type="text" name="name" id="name" value="">
      </div>
      <label class="col-md-8">Ảnh bài viết</label>
      <div class="col-md-8">
        <input class="form-control form-control-line" type="file" name="img1" id="img1" value="">
      </div>
      <label class="col-md-8">Tóm tắt bài viết</label>
      <div class="col-md-8">
        <textarea id="froala-editor1"  rows="3" cols="100" name="tomtat"></textarea>
      </div>
      <label class="col-md-8">Nội dung bài viết</label>
      <div class="col-md-8">
        <textarea id="froala-editor2"  rows="3" cols="100" name="noidung"></textarea>
      </div>
      <label class="col-md-8">Từ khóa bài viết</label>
      <div class="col-md-8">
        <textarea id="froala-editor3"  rows="3" cols="100" name="tukhoa"></textarea>
      </div> 
      <div class="col-md-8" align="center"><br><br>
        <button  style="align-items: center;" type="submit" name="addTT" id="addTT">Đăng tin</button>
      </div>
    </div>
  </form>
  <br><br><br><br><br>
</section>
