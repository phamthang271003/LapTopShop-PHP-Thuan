<?php
require_once "../class/Database.php";
$pdo = Database::getInstance()->getConnection();
$sqlSelect = "SELECT * FROM tbl_tin ORDER BY id_tin DESC";
$result = $pdo->query($sqlSelect);
?>
<section class="wrapper">
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh sách sản phẩm
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th width="80">Tiêu đề</th>
                            <th>Ảnh</th>
                            <th>Tóm tắt</th>
                            <th>Acction</th>
                        </tr>
                    </thead>
                    <?php
                    $i = 0;
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        $i++;
                    ?>
                        <tr height="100">
                            <td><?= $i ?></td>
                            <td><?= htmlspecialchars($row["tieuDe"]) ?></td>
                            <td><img src="../upload/imgtin/<?php echo htmlspecialchars($row["img"]); ?>" width="150" height="150"></td>
                            <td><?= htmlspecialchars($row["tomtat"]) ?></td>
                            <td>
                                <a href="admin.php?module=edittin&id_tin=<?php echo $row["id_tin"] ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                <a style="float: right;" href="admin.php?module=deltin&id_tin=<?php echo $row["id_tin"] ?>" onclick="return confirm('Bạn có thật sự muốn xóa không')"><i class="fa fa-times" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</section>
