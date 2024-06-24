<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/PHPMailer.php';
require_once "class/Database.php";

// Database connection using PDO
$pdo = Database::getInstance()->getConnection();

if (isset($_POST["getpass"])) {
    $email = $_POST['email'];

    // Prepare and execute the query
    $query = "SELECT * FROM tbl_user WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $sql_row = $stmt->fetch();

    if ($sql_row) {
        // Update password
        $code = substr(md5(rand(1,9999)), 0, 8);
        $update_query = "UPDATE tbl_user SET code = :code WHERE email = :email";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $update_stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $update_stmt->execute();

        // Send email
        $nFrom = "ThietBiMay.vn"; // Mail sender name
        $mFrom = "Phamtranquangthang30@gmail.com"; // Sender email address
        $mPass = "mjgk gndi oryp hmlm"; // Sender email password
        $mail = new PHPMailer();
        $link = "http://localhost/thietbimay/index.php?view=getpass&code=$code";
        $body = "Bạn quên mật khẩu vui lòng click vào link bên dưới để lấy lại mật khẩu!<a href='http://localhost/thietbimay/index.php?view=getpass&email=$email&code=$code'>Click vào đây</a>"; // Email body
        $title = 'Lấy lại mật khẩu trang web thegioialo'; // Email subject

        $mail->IsSMTP();
        $mail->CharSet = "utf-8";
        $mail->SMTPDebug = 0; // Disable SMTP debug information
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->SMTPSecure = "ssl"; // Set the prefix to the server
        $mail->Host = "smtp.gmail.com"; // SMTP server
        $mail->Port = 465; // SMTP port

        // Mail configurations
        $mail->Username = $mFrom; // Sender email
        $mail->Password = $mPass; // Sender email password
        $mail->SetFrom($mFrom, $nFrom);
        $mail->AddReplyTo('phamtranquangthang30@gmail.com', 'Đẹp Trai Từ Bé'); // Reply-to email
        $mail->Subject = $title; // Email subject
        $mail->MsgHTML($body); // Email body
        $mail->AddAddress($email, $sql_row["username"]); // Recipient email

        // Send the email
        if(!$mail->Send()) {
            echo "<script>alert('Server đang quá tải vui lòng bạn thử lại sau.');</script>";
        } else {
            echo "<script>alert('Mail đã được gửi vui lòng check email của bạn.');window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Email không tồn tại!');window.location.href='index.php?view=fogetpass';</script>";
    }
}
?>

<div class="tabs-category clearfix">
    <div class="tab-content clearfix container">
        <div class="tabs-title">
            <div id="" class="tab-title">
                <h3>
                    <span>Quên mật khẩu</span>
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="container female">
    <div class="row pTB">
        <form action="" method="post">
            <span>Email đăng ký:</span><input style="margin-top: 10px; margin-left: 15px;" type="email" name="email"><br>
            <button type="submit" name="getpass" style="margin-top: 15px; margin-left: 120px;">Gửi</button>
        </form>
    </div>
</div>
