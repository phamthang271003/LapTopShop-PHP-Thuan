<?php
require_once "../class/Database.php";
require_once "../class/Product.php";
$pdo = Database::getInstance()->getConnection();
$id = $_GET["id"];
$row_edit = Product::getProductById($pdo, $id);

if (isset($_POST["Edit"])) {
    $name_prod = $_POST["name"];
    $prod_type = $_POST["prod_type"];
    $manufacturer = $_POST["manufacturer"];
    $thongso = $_POST["thongso"];
    $mota = $_POST["mota"];
    $noibat = $_POST["noibat"];
    $dateCreate = date("Y-m-d H:i:s");
    $price = $_POST["giasp"];
    $status1 = $_POST['status'];
    $sale = $_POST["sale"];

    // Process image uploads
    $anh1 = uploadImage('img1');
    $anh2 = uploadImage('img2');
    $anh3 = uploadImage('img3');

    $updated = Product::updateProduct($pdo, $id, $name_prod, $prod_type, $manufacturer, $noibat, $thongso, $mota, $anh1, $anh2, $anh3, $status1, $sale, $price);


    if ($updated) {
      $row_edit = Product::getProductById($pdo, $id);
        echo ("<script>alert('Cập nhật sản phẩm thành công');</script>");
    } else {
        echo ("<script>alert('Cập nhật sản phẩm thất bại');</script>");
        
    }
}

function uploadImage($inputName)
{
    if (isset($_FILES[$inputName]["name"])) {
        if ($_FILES[$inputName]["type"] == "image/jpeg" || $_FILES[$inputName]["type"] == "image/png") {
            $imageName = "upload/" . $_FILES[$inputName]["name"];
            move_uploaded_file($_FILES[$inputName]['tmp_name'], "../upload/imgproduct/upload/" . $_FILES[$inputName]["name"]);
            return $imageName;
        }
    }
    return null;
}

?>
<section class="wrapper">
  <div class="panel-heading">
    Sửa sản phẩm
  </div>
  <form action="" class="form-horizontal form-material" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label class="col-md-8">Tên sản phẩm</label>
      <div class="col-md-8">
        <input class="form-control form-control-line" type="text" name="name" id="name" value="<?php echo $row_edit["name_sp"]; ?>">
      </div>
      <label class="col-md-8">Loại sản phẩm </label>
      <div class="col-md-8">
        <select name="prod_type" id="prod_type" class="form-control form-control-line">
          <option value="">--Chọn loại sản phẩm--</option>
          <?php
          $sqlSelect = "SELECT * FROM tbl_loaisp";
          $stmt = $pdo->query($sqlSelect);
          while ($rowP = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = ($row_edit && $row_edit["id_loaisp"] == $rowP["id_loaisp"]) ? "selected" : "";
          ?>
            <option <?php echo $selected; ?> value="<?php echo $rowP["id_loaisp"] ?>"><?php echo $rowP["name_loaisp"] ?></option>
          <?php
          }
          ?>
        </select>
      </div>
      <label class="col-md-8">Hãng sản xuất </label>
      <div class="col-md-8">
        <select name="manufacturer" id="manufacturer" class="form-control form-control-line">
          <option value="">--Chọn hãng sản xuất--</option>
          <?php
          $sqlSelect = "SELECT * FROM tbl_hangsx";
          $stmt = $pdo->query($sqlSelect);
          while ($rowP = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $selected = ($row_edit && $row_edit["id_hangsx"] == $rowP["id_hangsx"]) ? "selected" : "";
          ?>
            <option <?php echo $selected; ?> value="<?php echo $rowP["id_hangsx"] ?>"><?php echo $rowP["name_hangsx"] ?></option>
          <?php
          }
          ?>
        </select>
      </div>
      <label class="col-md-8">Thông tin nổi bật</label>
      <div class="col-md-8">
        <textarea id="froala-editor" name="noibat"><?php echo $row_edit["noibat"] ?></textarea>
      </div>
      <label class="col-md-8">Thông số sản phẩm</label>
      <div class="col-md-8">
        <textarea id="froala-editor" name="thongso"><?php echo $row_edit["thongso_sp"] ?></textarea>
      </div>

      <label class="col-md-8">Mô tả sản phẩm</label>
      <div class="col-md-8">
        <textarea id="froala-editor" name="mota" value=""><?php echo $row_edit["mota_sp"] ?></textarea>
      </div>
      <label class="col-md-8">Ảnh sản phẩm</label>
      <div class="col-md-8">
        Ảnh 1: <img src="../upload/imgproduct/<?php echo $row_edit["img1"]; ?>" width="80" height="80"> <input class="form-control form-control-line" type="file" name="img1" id="img1"><br>
        Ảnh 2: <img src="../upload/imgproduct/<?php echo $row_edit["img2"]; ?>" width="80" height="80"> <input class="form-control form-control-line" type="file" name="img2" id="img2"><br>
        Ảnh 3: <img src="../upload/imgproduct/<?php echo $row_edit["img3"]; ?>" width="80" height="80"> <input class="form-control form-control-line" type="file" name="img3" id="img3">
      </div>
      <label class="col-md-8">Giảm giá(%)</label>
      <div class="col-md-8" style="display: inline;">
        <input class="form-control form-control-line" placeholder="0" type="number" name="sale" id="sale" min="0" max="99" value="<?php echo $row_edit["sale"];  ?>">
      </div>
      <label class="col-md-8">Giá</label>
      <div class="col-md-8" style="display: inline;">
        <input class="form-control form-control-line" placeholder="0" type="number" name="giasp" id="giasp" value="<?php echo $row_edit["gia_sp"];  ?>">
      </div>
      <label class="col-md-8">Tình trạng</label>
      <div class="col-md-8" style="display: inline;">
        <input type="radio" <?php if ($row_edit['status'] == 0) {
                              echo 'checked';
                            } ?> name="status" id="status" value="0"> Hết hàng
        <input type="radio" <?php if ($row_edit['status'] == 1) {
                              echo 'checked';
                            } ?> name="status" id="status" value="1"> Còn hàng
      </div>
      <div class="col-md-8" align="center">
        <button type="submit" name="Edit" id="Edit">Cập nhật</button>
      </div>
    </div>
  </form>
  <br><br><br><br><br>
</section>