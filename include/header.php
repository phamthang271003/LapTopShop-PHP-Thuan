<?php  
require_once "class/Database.php";
require_once "class/Category.php";
$pdo = Database::getInstance()->getConnection();
$checked = false;
// Kiểm tra xem người dùng có chọn click Login hay không
if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = md5($_POST["password"]);
    if(isset($_POST["checked"])){
        // Tạo ra cookie có tên và giá trị
        setcookie("username", $username);
        setcookie("password", $password);
    }
    if(isset($_COOKIE["username"]) && isset($_COOKIE["username"])){
        // Gán giá trị của cookie đã lưu vào 2 biến tương ứng
        $userName = $_COOKIE["username"];
        $password = $_COOKIE["password"];
        $checked = true;
    }

    $sql = "SELECT * FROM tbl_user WHERE username = :username";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['username' => $username]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$userData) {
        echo "<script>alert('Tài khoản không tồn tại!');</script>";
    } else {
        if ($password != $userData["password"]) {
            echo "<script>alert('Tài khoản hoặc mật khẩu chưa đúng! Vui lòng thử lại');</script>";
        } else {
            echo "<script>alert('Xin chào: $username'); window.location.href='index.php';</script>";
            $_SESSION["username"] = $userData;
            if ($userData['role'] == 1 || $userData['role'] == 2) {
                $_SESSION["role"] = $userData["role"];
            }
            // header("location:index.php");
        }
    }
}
?>

<div class="header">
    <nav class="navbar navbar-default" role="navigation" >
        <div class="collapse navbar-collapse navbar-ex1-collapse header_top">
            <ul class="nav navbar-nav navbar-right">
                <li class="dorpdown"><a href="#"><span class="glyphicon glyphicon-gift"></span>Khuyến mãi</a></li>
                <li class="dorpdown"><a href="index.php?view=thanhtoan"><span class="glyphicon glyphicon-shopping-cart"></span>Giỏ hàng</a></li>
                <li class="dorpdown"><a href="index.php?view=cartlist"><span class="glyphicon glyphicon-shopping-cart"></span>Kiểm tra đơn hàng</a></li>
                <li class="dorpdown"><a href="#"><span class="glyphicon glyphicon-phone-alt"></span>Hỗ trợ khách hàng</a></li>
                <?php 
                if(!isset($_SESSION["username"])){
                    ?>
                    <li style="margin-top: -2px;"><a data-toggle="modal" href='#modal-id' class="glyphicon glyphicon-user">Đăng nhập</a>
                        <div class="modal fade" id="modal-id">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <center><h4 class="">Đăng Nhập</h4></center>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="username" name="username"  onchange="" placeholder="Nhập Username" required="">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required="">
                                            </div><br>
                                            <div>
                                                <input type="checkbox" name="checked" id="checked"> Nhớ mật khẩu?<a style="float: right;" href="index.php?view=fogetpass">Quên mật khẩu?</a> 
                                            </div>
                                            <center><button type="submit" class="btn btn-primary" id="login" name="login">Đăng nhập</button></center><br>
                                            <button type="submit" id="cancel_edit" class="btn btn-primary">Hủy</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="dorpdown"><a href="index.php?view=createid"><span class="glyphicon glyphicon-user"></span>Đăng ký</a></li>
                    <?php }else{
                        ?>
                        <li class="dorpdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user">Chào:<?php echo $_SESSION["username"]["username"] ?></span></a>
                            
                        <ul class="dropdown-menu">
                            <li><a href="index.php?view=info_user&id=<?php echo $_SESSION['username']['id_user'] ?>"><span class="glyphicon glyphicon-cog"></span>Thông tin cá nhân</a></li>
                            <?php if(isset($_SESSION['role'])) { ?>
                                <li><a href="admin/admin.php"><span class="glyphicon glyphicon-wrench"></span>Vào trang Admin</a></li>
                            <?php } ?>
                            <li><a href="index.php?view=logout"><span class="glyphicon glyphicon-off">Thoát</span></a></li>
                        </ul>
                        </li>
                        <?php
                    } ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </div> <!-- header --> 
    <section class="header-content clearfix" style="margin-top: 30px;">
        
    </section>
