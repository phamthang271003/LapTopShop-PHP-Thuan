<?php 
require_once "class/User.php";
require_once "class/Database.php";
$pdo = Database::getInstance()->getConnection();
if (isset($_SESSION['username'])) {
    // Assuming $_SESSION['username'] holds user details
    $user = new User($_SESSION['username']['id_user'], $_SESSION['username']['fullName'], $_SESSION['username']['username'], $_SESSION['username']['password'], $_SESSION['username']['phone'], $_SESSION['username']['email'], $_SESSION['username']['gioitinh'], $_SESSION['username']['address'], $_SESSION['username']['dateCreate'], $_SESSION['username']['role'], $_SESSION['username']['code']);

    if (isset($_POST['changepass'])) {
        $result = $user->changePassword($pdo,$_POST['passold'], $_POST['passnew'], $_POST['repass']);
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
                    <li><a href="index.php?view=changepass"><i class="fa fa-key"></i>Đổi mật khẩu</a></li>
                </ul>
            </div>                    
        </div>
        <div class="col-md-9">
            <div class="register-content clearfix ng-scope" ng-controller="accountController" ng-init="initRegisterController()">
                <h1 class="title"><span>Đổi mật khẩu</span></h1>
                <div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-12 col-xs-offset-0 col-sm-offset-0">
                    <form class="form-horizontal ng-pristine ng-invalid ng-invalid-required ng-valid-email" method="post">
                        <div class="form-group">
                            <label for="Code" class="col-sm-3 control-label">Mật khẩu hiện tại<span class="warning">(*)</span></label>
                            <div class="col-sm-9">
                                <input class="form-control" name="passold" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Code" class="col-sm-3 control-label">Mật khẩu mới<span class="warning">(*)</span></label>
                            <div class="col-sm-9">
                                <input class="form-control" name="passnew" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Code" class="col-sm-3 control-label">Nhập lại mật khẩu<span class="warning">(*)</span></label>
                            <div class="col-sm-9">
                                <input class="form-control" name="repass" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-default" name="changepass" id="changepass">Đổi mật khẩu</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
