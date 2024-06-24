<?php 
require_once "../class/Database.php";
$pdo = Database::getInstance()->getConnection();
if (isset($_SESSION['username'])) {
    $password=$_SESSION['username']['password'];
    $id=$_SESSION['username']['id_user'];
    if (isset($_POST['changepass'])) {
        $passold=md5($_POST['passold']);
        $passnew=md5($_POST['passnew']);
        $repass=md5($_POST['repass']);
        if($password!=$passold){
            echo "<script>alert('Mật khẩu không đúng. Vui lòng nhập lại');location.href='?module=changpass';</script>";
        }elseif ($passnew!=$repass) {
            echo "<script>alert('Mật khẩu mới không trùng khớp. Vui lòng nhập lại');location.href='?module=changpass';</script>";
        }elseif ($passnew==$passold) {
            echo "<script>alert('Mật khẩu mới không thể giống mật khẩu cũ. Vui lòng nhập lại');location.href='?module=changpass';</script>";
        }
        else {
            $sqlUpdate="UPDATE `tbl_user` SET `password`='$passnew' WHERE id_user=:id";
            $stmt = $pdo->prepare($sqlUpdate);
            $stmt->execute(array(':id' => $id));
            echo "<script>alert('Đổi mật khẩu thành công');location.href='admin.php';</script>";
        }
    }
}
?>
<section class="wrapper">
    <div class="row">
        <div class="col-md-9">
            <div class="register-content clearfix ng-scope">
                <h1 class="title"><span>Đổi mật khẩu</span></h1>
                <div class="col-md-8 col-md-offset-2 col-xs-12 col-sm-12 col-xs-offset-0 col-sm-offset-0">
                    <form class="form-horizontal" method="post">
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
    <br><br><br><br><br>
</section>
