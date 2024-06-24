<?php

class User {
    public $id_user;
    public $fullName;
    public $username;
    public $password;
    public $phone;
    public $email;
    public $gioitinh;
    public $address;
    public $dateCreate;
    public $role;
    public $code;

    // Constructor
    public function __construct($id_user, $fullName, $username, $password, $phone, $email, $gioitinh, $address, $dateCreate, $role, $code) {
        $this->id_user = $id_user;
        $this->fullName = $fullName;
        $this->username = $username;
        $this->password = $password;
        $this->phone = $phone;
        $this->email = $email;
        $this->gioitinh = $gioitinh;
        $this->address = $address;
        $this->dateCreate = $dateCreate;
        $this->role = $role;
        $this->code = $code;
    }
    public static function authenticate($pdo,$username, $password) {
        $sql = "SELECT * FROM tbl_user WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        
        if($stmt->execute(['username' => $username])){
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        if (!$user) {
            return "Tên đăng nhập này không tồn tại. Vui lòng kiểm tra lại.";
        }

        if ($password != $user["password"]) {
            return "Mật khẩu không đúng. Vui lòng nhập lại.";
        }

        return $user;
    }
    public function changePassword($pdo, $oldPassword, $newPassword, $confirmPassword) {
        if ($this->password != md5($oldPassword)) {
            return "Mật khẩu hiện tại không đúng.";
        }
    
        if ($newPassword != $confirmPassword) {
            return "Mật khẩu mới không trùng khớp.";
        }
    
        if (md5($newPassword) == $this->password) {
            return "Mật khẩu mới phải khác mật khẩu hiện tại.";
        }
    
        $sqlUpdate = "UPDATE tbl_user SET password = :newPassword WHERE id_user = :id";
        $stmt = $pdo->prepare($sqlUpdate);
        $stmt->bindValue(':newPassword', md5($newPassword), PDO::PARAM_STR);
        $stmt->bindValue(':id', $this->id_user, PDO::PARAM_INT);
        $stmt->execute();
    
        return "Đổi mật khẩu thành công.";
    }
    public function updateInfo($pdo, $fullName, $email, $phone, $address, $gioitinh) {
        $sqlUpdate = "UPDATE tbl_user SET fullName = :fullName, phone = :phone, email = :email, gioitinh = :gioitinh, address = :address WHERE id_user = :id";
        $stmt = $pdo->prepare($sqlUpdate);
        $stmt->execute([
            'fullName' => $fullName,
            'phone' => $phone,
            'email' => $email,
            'gioitinh' => $gioitinh,
            'address' => $address,
            'id' => $this->id_user
        ]);

        $_SESSION['username']['fullName'] = $fullName;
        $_SESSION['username']['phone'] = $phone;
        $_SESSION['username']['email'] = $email;
        $_SESSION['username']['gioitinh'] = $gioitinh;
        $_SESSION['username']['address'] = $address;

        return "Cập nhật thông tin thành công.";
    }

    public static function register($pdo, $username, $fullName, $email, $password, $phone, $address, $gioitinh) {
        $sqlCheckUsername = "SELECT * FROM tbl_user WHERE username = :username";
        $stmt = $pdo->prepare($sqlCheckUsername);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $numUserName = $stmt->rowCount();


        $sqlCheckEmail = "SELECT * FROM tbl_user WHERE email = :email";
        $stmt = $pdo->prepare($sqlCheckEmail);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $numEmail = $stmt->rowCount();


        if ($numUserName > 0) {
            return "Tên đăng nhập đã tồn tại.";
        } elseif ($numEmail > 0) {
            return "Email đã được sử dụng.";
        }


        $date_regis = date('Y-m-d H:i:s');
        $role = 0;
        $hashedPassword = md5($password); // Not recommended, use stronger hashing algorithm

        $sqlInsert = "INSERT INTO tbl_user(`fullName`, `username`, `password`, `phone`, `email`, `gioitinh`, `address`, `dateCreate`, `role`) 
                      VALUES (:fullName, :username, :password, :phone, :email, :gioitinh, :address, :date_regis, :role)";
        $stmt = $pdo->prepare($sqlInsert);
        $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':gioitinh', $gioitinh, PDO::PARAM_INT);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':date_regis', $date_regis, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "Đăng ký thành công.";
        } else {
            return "Đã xảy ra lỗi trong quá trình đăng ký.";
        }
    }

    public static function addUser($pdo, $fullName, $username, $password, $phone, $email, $gioitinh, $address, $role) {
        $sqlCheckUsername = "SELECT * FROM tbl_user WHERE username = :username";
        $stmt = $pdo->prepare($sqlCheckUsername);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $numUserName = $stmt->rowCount();
    
        $sqlCheckEmail = "SELECT * FROM tbl_user WHERE email = :email";
        $stmt = $pdo->prepare($sqlCheckEmail);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $numEmail = $stmt->rowCount();
    
        // Check if username or email already exists
        if ($numUserName > 0) {
            return "Tên đăng nhập đã tồn tại.";
        } elseif ($numEmail > 0) {
            return "Email đã được sử dụng.";
        }
    
        $date_regis = date('Y-m-d H:i:s');
    
        $hashedPassword = md5($password); // Not recommended, use stronger hashing algorithm
    
        $sqlInsert = "INSERT INTO tbl_user(`fullName`, `username`, `password`, `phone`, `email`, `gioitinh`, `address`, `dateCreate`, `role`) 
                      VALUES (:fullName, :username, :password, :phone, :email, :gioitinh, :address, :date_regis, :role)";
        $stmt = $pdo->prepare($sqlInsert);
        $stmt->bindParam(':fullName', $fullName, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':gioitinh', $gioitinh, PDO::PARAM_INT);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':date_regis', $date_regis, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            return "Thêm người dùng thành công.";
        } else {
            return "Đã xảy ra lỗi trong quá trình thêm người dùng.";
        }
    }
    

    
}
