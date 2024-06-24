<?php 
require_once "class/Database.php";

// Database connection using PDO
$pdo = Database::getInstance()->getConnection();

$email = isset($_GET['email']) ? $_GET['email'] : '';
$code = isset($_GET['code']) ? $_GET['code'] : '';

if($email == '') {
    $_SESSION['error'] = "Không tồn tại email";
    header("Location: index.php");
    exit;
}

if($code == '') {
    $_SESSION['error'] = "Không tồn tại code";
    header("Location: index.php");
    exit;
}

$sql_check = "SELECT * FROM tbl_user WHERE email = :email AND code = :code";
$stmt = $pdo->prepare($sql_check);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':code', $code, PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = "Không tồn tại email hoặc code như trên";
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = [];
    $password = md5($_POST['password']);
    $repassword = md5($_POST['repassword']);

    if ($password == '' || $repassword == '') {
        $error['password'] = "Mời bạn nhập password";
    }

    if ($password != $repassword) {
        echo "<script>alert('Mật khẩu không trùng khớp');</script>";
    } else {
        if (empty($error)) {
            $sql_update = "UPDATE tbl_user SET password = :password, code = '' WHERE email = :email";
            $stmt = $pdo->prepare($sql_update);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            echo "<script>alert('Mật khẩu đã đổi thành công');</script>";
            echo "<script>setTimeout(function() { window.location.href = 'http://localhost/thietbimay/index.php'; }, 2000);</script>"; // Chuyển hướng sau 2 giây
            exit;
        }
        
        
        
    }
}
?>

<div class="tabs-category clearfix">
    <div class="tab-content clearfix container">
        <div class="tabs-title">
            <div id="" class="tab-title">
                <h3>
                    <span>Đặt lại mật khẩu</span>
                </h3>
            </div>
        </div>
    </div>
</div>
<div class="container female">
    <div class="row pTB">
        <form action="" method="post">
            <span>Mật khẩu mới:</span><input style="margin-top: 10px; margin-left: 42px;" type="password" name="password" required=""><br>
            <span>Nhập lại mật khẩu:</span><input style="margin-top: 10px; margin-left: 15px;" type="password" required="" name="repassword"><br>
            <button type="submit" name="oke" style="margin-top: 15px; margin-left:120px;">Ok</button>
        </form>
    </div>
</div>
