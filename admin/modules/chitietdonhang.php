<?php 
require_once "../class/Database.php";
$pdo = Database::getInstance()->getConnection();
$id = $_GET['id'];
$sqlSelect = "SELECT * FROM tbl_oderdetail WHERE oder_id=:id";
$stmt = $pdo->prepare($sqlSelect);
$stmt->execute([':id' => $id]);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$rs = count($rows);
$totals = 0;
$addedExtra = false;
?>
<section class="wrapper" style="margin-left: -10px; width: auto; height: auto;">
  <div class="" style="height: auto;width: auto;">
   <div class="panel panel-default">
    <div class="panel-heading">
     Chi tiết đơn hàng
   </div>
   <div>
    <table width="1435" class="table table-hover" style="width: inherit;">
      <tr>
        <th width="61">#</th>
        <th width="415">Tên sản phẩm</th>
        <th width="218">Hình ảnh</th>
        <th width="184">Số lượng</th>
        <th width="246">Giá đã sale</th>
        <th width="283">Thành tiền</th>
      </tr>
      <?php  
      $i = 0;
      if($rs != 0){
        foreach ($rows as $row) {
          $i++;
      ?>
        <tr>
          <td><?= $i ?></td>
          <td>
            <?= $row["name_sp"]?>
          </td>
          <td style="align-items: center;">
            <img style="margin-left: -30px;" src="upload/imgproduct/<?php echo $row["img1"] ?>" width="70" alt="" />
          </td>
          <td>
            <?= $row["sl"]?>
          </td>
          <td style="overflow: hidden;">
            <?php 
            $price = $row['gia_sp'];
            echo number_format($price); 
            ?>
          </td>
          <td>
            <?php 
            $thanhtien = $row['tong_tien'];
            echo number_format($thanhtien); 
            if (!$addedExtra) {
              $totals += $thanhtien + 30000;
              $addedExtra = true;
          } else {
              $totals += $thanhtien;
          }
             ?>
          </td>
        </tr>
      <?php 
        }
      ?>
        <tr>
          <td colspan="5">Tổng tiền</td>
          <td><?php echo number_format($totals); ?></td>
        </tr>
      <?php 
        } else {
          echo "<tr><td colspan='6'>Lỗi nhập liệu!</td></tr>";
        } ?>
        
      </table>
     
    </div>
  </div>
</div>
<input type="button" id="print_button" value="Print This Page" onclick="window.print() "/>
</section>
