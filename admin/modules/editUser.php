<?php 
require_once "../class/Database.php";
$pdo = Database::getInstance()->getConnection();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $qr = "SELECT * FROM tbl_user WHERE id_user = :id";
    $stmt = $pdo->prepare($qr);
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();

    if (isset($_POST['editUser'])) {
        $fullName = $_POST['fullName'];
        $phone = $_POST['phone'];
        $gioitinh = $_POST['gioitinh'];
        $address = $_POST['address'];
        $role = $_POST['role'];

        $sqlUp = "UPDATE tbl_user SET fullName=:fullName, phone=:phone, gioitinh=:gioitinh, address=:address, role=:role WHERE id_user = :id";
        $stmt = $pdo->prepare($sqlUp);
        $stmt->execute([
            ':fullName' => $fullName,
            ':phone' => $phone,
            ':gioitinh' => $gioitinh,
            ':address' => $address,
            ':role' => $role,
            ':id' => $id
        ]);

        echo "<script>alert('Cập nhật thành công');location.href='?module=listUser';</script>";
    }
}
?>

<section class="wrapper">
    <div class="panel-heading">
        Sửa thông tin User
    </div>
    <form action="" class="form-horizontal form-material" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-md-8">Full Name</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" type="text" name="fullName" id="fullName" value="<?php echo $row['fullName'] ?>">
            </div>
            <label class="col-md-8">Username</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" disabled type="text" name="username" id="username" value="<?php echo $row['username'] ?>">
            </div>
            <label class="col-md-8">Password</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" disabled type="Password" name="password" id="password" value="<?php echo $row['password'] ?>">
            </div>
            <label class="col-md-8">Phone</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" type="number" name="phone" id="phone" pattern="(\\+84|0)\\d{9,10}" value="<?php echo $row['phone'] ?>">
            </div>
            <label class="col-md-8">Email</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" disabled type="email" name="email" id="email" value="<?php echo $row['email'] ?>">
            </div>
            <label class="col-md-8">Giới tính</label>
            <div class="col-md-8">
                <select class="form-control" name="gioitinh">
                    <option value="1" <?php if($row['gioitinh']==1){echo 'selected';} ?>>Nam</option>
                    <option value="0" <?php if($row['gioitinh']==0){echo 'selected';} ?>>Nữ</option>
                </select>
            </div>
            <label class="col-md-8">Địa chỉ</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" type="text" name="address" id="address" value="<?php echo $row['address'];?>">
            </div>
            <label class="col-md-8">Role</label>
            <div class="col-md-8">
                <select class="form-control" name="role">
                    <?php if ($_SESSION['username']['role']==1) { ?>
                        <option value="1" <?php if($row['role']==1){ echo "selected";}?>>Supper Admin</option>
                        <option value="2" <?php if($row['role']==2){ echo "selected";}?>>Sub Admin</option>
                        <option value="0" <?php if($row['role']==0){ echo "selected";}?>>Guest</option>
                    <?php } else { ?>
                        <option value="2" <?php if($row['role']==2){ echo "selected";}?>>Sub Admin</option>
                        <option value="0" <?php if($row['role']==0){ echo "selected";}?>>Guest</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-8" align="center">
            <button type="submit" name="editUser" id="editUser">Update</but
