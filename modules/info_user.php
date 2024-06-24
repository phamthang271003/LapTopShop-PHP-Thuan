<?php
require_once "class/User.php";
require_once "class/Database.php";
$pdo = Database::getInstance()->getConnection();
if (isset($_SESSION['username'])) {
    $userData = $_SESSION['username'];

    $user = new User(
        $userData['id_user'], 
        $userData['fullName'], 
        $userData['username'], 
        $userData['password'], 
        $userData['phone'], 
        $userData['email'], 
        $userData['gioitinh'], 
        $userData['address'], 
        $userData['dateCreate'], 
        $userData['role'], 
        $userData['code']
    );

    if (isset($_POST['edit'])) {
        $fullName = $_POST["fullName"];
        $email = $_POST["email"];
        $phone = $_POST["phone"];
        $address = $_POST["address"];
        $gioitinh = $_POST["gioitinh"];

        // Add form validation here if necessary

        $result = $user->updateInfo($pdo, $fullName, $email, $phone, $address, $gioitinh);
        echo "<script>alert('$result');location.href='index.php';</script>";
    }
}
?>



<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="menu-account">
                <h3><span>Tài khoản</span></h3>
                <ul>
                    <li><a href="index.php?view=info_user"><i class="fa fa-user-circle-o"></i>Thông tin tài khoản</a></li>
                    <li><a href="index.php?view=ttdh"><i class="fa fa-key"></i>Lịch sử mua hàng</a></li>
                    <li><a href="index.php?view=changepass"><i class="fa fa-key"></i>Quên mật khẩu</a></li>
                </ul>
            </div>                    
        </div>
        <div class="col-md-9">
            <div class="register-content clearfix ng-scope">
                <h1 class="title"><span>Thông tin tài khoản</span></h1>
                <div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-12 col-xs-offset-0 col-sm-offset-0">
                    <form class="form-horizontal" method="post">
                        <div class="form-group">
                            <label for="Code" class="col-sm-3 control-label">Tài khoản<span class="warning">(*)</span></label>
                            <div class="col-sm-9">
                                <input class="form-control" name="username" id="username" disabled value="<?php echo $_SESSION['username']['username'] ?>" required="true" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Email" class="col-sm-3 control-label">Email<span class="warning">(*)</span></label>
                            <div class="col-sm-9">
                                <input class="form-control" name="email" id="email" value="<?php echo $_SESSION['username']['email'] ?>" required="true" type="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Name" class="col-sm-3 control-label">Họ tên<span class="warning">(*)</span></label>
                            <div class="col-sm-9">
                                <input class="form-control" value="<?php echo $_SESSION['username']['fullName'] ?>" required="true" type="text" name="fullName" id="fullName">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Điện thoại</label>
                            <div class="col-sm-9">
                                <input class="form-control" pattern="(\\+84|0)\\d{9,10}" value="<?php echo $_SESSION['username']['phone'] ?>" type="number" name="phone" id="phone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Giới tính</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="gioitinh">
                                    <option value="1" <?php if($_SESSION['username']['gioitinh']==1){echo "selected";} ?>>Nam</option>
                                    <option value="0" <?php if($_SESSION['username']['gioitinh']==0){echo "selected";} ?>>Nữ</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Địa chỉ</label>
                            <div class="col-sm-9">
                                <input class="form-control" value="<?php echo $_SESSION['username']['address'] ?>" type="text" name="address" id="address">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-default" name="edit" id="edit">Cập nhật</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
