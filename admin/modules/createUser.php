<?php
session_start();

// Bước 1: Kết nối đến cơ sở dữ liệu
require_once "../class/Database.php";
require_once "../class/User.php"; // Thêm class User vào

$pdo = Database::getInstance()->getConnection();

// Bước 2: Xử lý dữ liệu khi người dùng gửi biểu mẫu
if (isset($_POST['addUser'])) {
    // Thu thập dữ liệu từ biểu mẫu
    $fullName = $_POST['fullName'];
    $username = $_POST['username'];
    $password = $_POST["password"];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $gioitinh = $_POST['gioitinh'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    // Thực hiện gọi hàm thêm người dùng từ class User
    $result = User::addUser($pdo, $fullName, $username, $password, $phone, $email, $gioitinh, $address, $role);

    // Hiển thị thông báo và chuyển hướng sau khi thêm người dùng
    echo "<script>alert('$result');location.href='?module=listUser';</script>";
}
?>

<section class="wrapper">
    <div class="panel-heading">
        Thêm người dùng mới
    </div>
    <form action="" class="form-horizontal form-material" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label class="col-md-8">Full Name</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" type="text" name="fullName" id="fullName">
            </div>
            <label class="col-md-8">Username</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" type="text" name="username" id="username">
            </div>
            <label class="col-md-8">Password</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" type="Password" name="password" id="password">
            </div>
            <label class="col-md-8">Phone</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" type="number" name="phone" id="phone" pattern="(\\+84|0)\\d{9,10}">
            </div>
            <label class="col-md-8">Email</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" type="email" name="email" id="email">
            </div>
            <label class="col-md-8">Giới tính</label>
            <div class="col-md-8">
                <select class="form-control" name="gioitinh">
                    <option value="1">Nam</option>
                    <option value="0">Nữ</option>
                </select>
            </div>
            <label class="col-md-8">Địa chỉ</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" type="text" name="address" id="address">
            </div>
            <label class="col-md-8">Role</label>
            <div class="col-md-8">
                <select class="form-control" name="role">
                    <option value="1">Supper Admin</option>
                    <option value="2">Sub Admin</option>
                    <option value="0">Guest</option>
                </select>
            </div>
        </div>
        <div class="col-md-8" align="center">
            <button type="submit" name="addUser" id="addUser">Thêm</button>
        </div>
    </form>
</section>