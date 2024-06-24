<?php  
if(isset($_POST["add"])){
    $fullName = $_POST["fullName"];
    $userName = $_POST["userName"];
    $mk = ($_POST["password"]) ? md5($_POST["password"]) : "";
    $email = $_POST["email"];
    $birthday = date("Y-m-d", strtotime($_POST["birthday"]));
    $gioitinh = $_POST["gender"];
    $address = $_POST["address"];
    $province = $_POST["province"];
    $role = isset($_POST["role"]) ? 1 : 0; // Kiểm tra nếu checkbox role được chọn thì gán giá trị 1, ngược lại gán giá trị 0
    $dateCreate = date("Y-m-d H:i:s");
    $fileName = "";

    if(isset($_FILES["avata"]["name"])){
        if($_FILES["avata"]["type"] == "image/jpeg"){
            $fileTem = $_FILES["avata"]["tmp_name"];
            move_uploaded_file($fileTem , "../../upload/".$_FILES["avata"]["name"]);
            $fileName = "upload/".$_FILES["avata"]["name"];
        }
    }

    if($_POST["id"] == 0){
        $sqlInsert = "INSERT INTO tbl_user";
        $sqlInsert .= "(fullName, username, password, email, birthday, gioitinh, id_tinhtp, address, avatar, dateCreate, role)";
        $sqlInsert .= " VALUES (:fullName, :userName, :mk, :email, :birthday, :gioitinh, :province, :address, :fileName, :dateCreate, :role)";
        $stmt = $pdo->prepare($sqlInsert);
        $stmt->execute([
            ':fullName' => $fullName,
            ':userName' => $userName,
            ':mk' => $mk,
            ':email' => $email,
            ':birthday' => $birthday,
            ':gioitinh' => $gioitinh,
            ':province' => $province,
            ':address' => $address,
            ':fileName' => $fileName,
            ':dateCreate' => $dateCreate,
            ':role' => $role
        ]);
    }else{
        // Update
        $sqlUpdate = "UPDATE tbl_user SET fullName=:fullName, userName=:userName, password=:mk, email=:email, birthday=:birthday, gioitinh=:gioitinh, id_tinhtp=:province, address=:address, avatar=:fileName, role=:role WHERE id=:id";
        $stmt = $pdo->prepare($sqlUpdate);
        $stmt->execute([
            ':fullName' => $fullName,
            ':userName' => $userName,
            ':mk' => $mk,
            ':email' => $email,
            ':birthday' => $birthday,
            ':gioitinh' => $gioitinh,
            ':province' => $province,
            ':address' => $address,
            ':fileName' => $fileName,
            ':role' => $role,
            ':id' => $_POST['id']
        ]);
    }
    header("location:index.php?module=listuser");
    die;
}

// Lấy dữ liệu ra form sửa
$row = false;
$id = 0;
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $sqlSel = "SELECT * FROM tbl_admin WHERE id_ad = :id";
    $stmt = $pdo->prepare($sqlSel);
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();
}
?>
<section class="wrapper">
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thêm mới User
            </div>
            <form action="" class="form-horizontal form-material" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="col-md-8">Full Name</label>
                    <div class="col-md-8">
                        <input class="form-control form-control-line" placeholder="input user name" type="text" name="fullName" id="fullName" value="">
                    </div>
                    <label class="col-md-8">User Name</label>
                    <div class="col-md-8">
                        <input class="form-control form-control-line" placeholder="input user name" type="text" name="userName" id="userName" value="">
                    </div>
                    <label class="col-md-8">Password</label>
                    <div class="col-md-8">
                        <input class="form-control form-control-line" placeholder="input user name" type="password" name="password" id="password" value="">
                    </div>
                    <label class="col-md-8">Avata</label>
                    <div class="col-md-8">
                        <input class="form-control form-control-line" type="file" name="avata" id="avata">
                    </div>
                    <label class="col-md-8">Email</label>
                    <div class="col-md-8">
                        <input class="form-control form-control-line" placeholder="input user name" type="text" name="email" id="email" value="">
                    </div>
                    <label class="col-md-8">Birthday</label>
                    <div class="col-md-8">
                        <input class="form-control form-control-line" placeholder="input user name" type="date" name="birthday" id="birthday" value="">
                    </div>
                    <label class="col-md-8">Giới tính</label>
                    <div class="col-md-8">
                        <?php 
                            $gioitinh = array("1" => "Nam", "0" => "Nữ");
                        ?>
                        <select name="gender" id="gender" class="form-control form-control-line">
                            <option value="">--Chọn Giới Tính--</option>
                            <?php 
                                foreach ($gioitinh  as $key => $value) {
                                    $selected  = "";
                                    if($row && $row["gioitinh"] == $key){
                                        $selected = "selected";
                                    }
                                    echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <label class="col-md-8">Thành phố</label>
                    <div class="col-md-8">
                        <select name="province" id="province" class="form-control form-control-line">
                            <option value="">--Chọn Tỉnh Thành--</option>
                                <?php  
                                    $sqlSelect = "SELECT tbl_tinhtp.matp, tbl_tinhtp.name FROM tbl_tinhtp";
                                    $stmt = $pdo->prepare($sqlSelect);
                                    $stmt->execute();
                                    while ($rowP = $stmt->fetch()) {
                                        $selected="";
                                        if($row && $row["id_tinhtp"]==$rowP["matp"]){
                                            $selected="selected";
                                        }
                                ?>
                                    <option <?php echo $selected; ?> value="<?php echo $rowP["matp"] ?>"><?php echo $rowP["name"] ?></option>
                                <?php 
                                    }
                                ?>
                        </select>
                    </div>
                    <label class="col-md-8">Địa chỉ</label>
                    <div class="col-md-8">
                        <input class="form-control form-control-line" placeholder="input user name" type="text" name="address" id="address" value="">
                    </div>
                    <label class="col-md-8">Role</label>
                    <div class="col-md-8">
                        Admin:<input type="checkbox" name="role" id="role" style="width: 40px;">
                    </div>
                    <div class="col-md-8">
                        <input type="submit" name="add" id="add" value="Thêm">
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
