<?php 
require_once "../class/Database.php";
$pdo = Database::getInstance()->getConnection();
// Số lượng bản ghi trên mỗi trang
$limit = 20;

// Truy vấn để đếm tổng số bản ghi
$total_records_query = $pdo->query('SELECT COUNT(oder) AS total FROM tbl_oder');
$row = $total_records_query->fetch(PDO::FETCH_ASSOC);
$total_records = $row['total'];

// Tính số trang và vị trí bắt đầu
$total_page = ceil($total_records / $limit);
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
if ($current_page > $total_page) {
    $current_page = $total_page;
} else if ($current_page < 1) {
    $current_page = 1;
}
$start = ($current_page - 1) * $limit;

// Truy vấn dữ liệu cho trang hiện tại
$sqlSelect = "SELECT * FROM tbl_oder ORDER BY dateOder DESC LIMIT $start, $limit";
$result = $pdo->query($sqlSelect);
?>
<section class="wrapper" style="margin-left: -10px; width: auto; height: auto;">
  <div class="" style="height: auto;width: auto;">
   <div class="panel panel-default">
    <div class="panel-heading">
     Danh sách đơn hàng
   </div>
   <div>
    <table width="1741" class=" table-hover" style="width: inherit;">
      <tr>
        <th width="28">#</th>
        <th width="188">Khách hàng</th>
        <th width="119">Email</th>
        <th width="165">Phone</th>
        <th width="209">Address</th>
        <th width="188">Ngày đặt</th>
        <th width="199">PTVC</th>
        <th width="159">PTTT</th>
        <th width="175">Tổng tiền</th>
        <th width="130">Status</th>
      </tr>
      <?php  
      $i=0;
      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $i++;
        $dateOder = date_create($row['dateOder']);
        ?>
        <tr>
          <td><?= $i ?></td>
          <td align="center"><?= $row["fullName"]?></td>
          <td style="overflow: scroll;"><?= $row["email"]?></td>
          <td><?= $row["phone"]?></td>
          <td style="overflow: hidden;"><?= $row["address"]?></td>
          <td><?= date_format($dateOder, "H:i:s d/m/Y"); ?></td>
          <td>
            <?php 
            if($row["ptvc"]==1){
              echo "Giao hàng tận nhà";
            }else{
              echo "Nhận tại cửa hàng";
            }
            ?>
          </td>
          <td>
            <?php 
            if($row["pttt"]==1){
              echo "Tiền mặt";
            }else{
              echo "Chuyển khoản";
            }
            ?>
          </td>
          <td><?php echo number_format($row['tongTien'])." vnđ";?></td>
          <td>
            <?php if($row["status"]==1){
              echo "Đặt hàng";
            }else{
              echo "Đã Xong";
            }?>
          </td>
          <td width="133">
            <a href="admin.php?module=chitietdonhang&id=<?php echo $row["oder"] ?>">Chi tiết ĐH</a>
            <?php if($row['status']==1){ ?>
            <a href="admin.php?module=hoantatdonhang&id=<?php echo $row["oder"] ?>" onclick="return confirm('Bạn có chắc đơn hàng đã được hoàn tất chưa?')">Hoàn tất</a>
            <?php } ?>
          </td>
        </tr>
        <?php } ?>
      </table>
      <div class="pagination">
        <?php 
        // Hiển thị phân trang
        if ($current_page > 1 && $total_page > 1){
            echo '<a href="admin.php?module=quanlydonhang&page='.($current_page-1).'">Prev</a> | ';
        }
 
        for ($i = 1; $i <= $total_page; $i++){
            if ($i == $current_page){
                echo '<span>'.$i.'</span> | ';
            }
            else{
                echo '<a href="admin.php?module=quanlydonhang&page='.$i.'">'.$i.'</a> | ';
            }
        }
 
        if ($current_page < $total_page && $total_page > 1){
            echo '<a href="admin.php?module=quanlydonhang&page='.($current_page+1).'">Next</a> | ';
        }
        ?>
      </div>
    </div>
  </div>
</div>
</section>
