<?php
require_once "../class/Database.php";
$pdo = Database::getInstance()->getConnection();

if (isset($_POST["updateTT"])) {
    // Sanitize user inputs
    $id_tin = intval($_POST["id_tin"]);
    $name = htmlspecialchars($_POST["name"]);
    $tomtat = htmlspecialchars($_POST["tomtat"]);
    $noidung = htmlspecialchars($_POST["noidung"]);
    $tukhoa = htmlspecialchars($_POST["tukhoa"]);
    $dateUpdate = date("Y-m-d H:i:s");
    $anh1 = "";

    if (isset($_FILES["img1"]["name"]) && $_FILES["img1"]["name"] != "") {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $fileType = $_FILES["img1"]["type"];
        $fileSize = $_FILES["img1"]["size"];

        if (in_array($fileType, $allowedTypes) && $fileSize <= 5000000) { // Allow up to 5MB file size
            $uniqueFileName = uniqid() . "_" . basename($_FILES["img1"]["name"]);
            $targetFilePath = "../upload/imgtin/upload/" . $uniqueFileName;
            $anh1 = "upload/" . $uniqueFileName;

            if (!move_uploaded_file($_FILES['img1']['tmp_name'], $targetFilePath)) {
                echo ("<script>alert('File upload failed');</script>");
                $anh1 = ""; // Reset $anh1 on failure
            }
        } else {
            echo ("<script>alert('Invalid file type or size');</script>");
            $anh1 = ""; // Reset $anh1 on invalid file
        }
    } else {
        // Keep the existing image if no new image is uploaded
        $sql_img = "SELECT img FROM tbl_tin WHERE id_tin = :id_tin";
        $stmt_img = $pdo->prepare($sql_img);
        $stmt_img->bindParam(':id_tin', $id_tin);
        $stmt_img->execute();
        $anh1 = $stmt_img->fetchColumn();
    }

    $sql_tt = "UPDATE tbl_tin SET tieuDe = :name, img = :img1, tomtat = :tomtat, noidung = :noidung, tukhoa = :tukhoa, ngayviet = :dateUpdate WHERE id_tin = :id_tin";
    $stmt = $pdo->prepare($sql_tt);
    $stmt->bindParam(':id_tin', $id_tin);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':img1', $anh1);
    $stmt->bindParam(':tomtat', $tomtat);
    $stmt->bindParam(':noidung', $noidung);
    $stmt->bindParam(':tukhoa', $tukhoa);
    $stmt->bindParam(':dateUpdate', $dateUpdate);

    try {
        if ($stmt->execute()) {
            echo ("<script>alert('Cập nhật bài thành công'); location.href='?module=quanlytintuc';</script>");
        } else {
            echo ("<script>alert('Cập nhật bài không thành công');</script>");
        }
    } catch (Exception $e) {
        echo ("<script>alert('Cập nhật bài không thành công: " . $e->getMessage() . "');</script>");
    }
}

$article = null;
if (isset($_GET['id_tin'])) {
    $id_tin = intval($_GET['id_tin']);
    $sql = "SELECT * FROM tbl_tin WHERE id_tin = :id_tin";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_tin', $id_tin);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<section class="wrapper">
    <div class="panel-heading">
        <?php echo isset($article) ? "Cập nhật bài tin tức" : "Viết bài tin tức"; ?>
    </div>
    <form action="" class="form-horizontal form-material" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_tin" value="<?php echo isset($article) ? $article['id_tin'] : ''; ?>">
        <div class="form-group">
            <label class="col-md-8">Tiêu đề</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" placeholder="Nhập tiêu đề bài viết" type="text" name="name" id="name" value="<?php echo isset($article) ? htmlspecialchars($article['tieuDe']) : ''; ?>">
            </div>
            <label class="col-md-8">Ảnh bài viết</label>
            <div class="col-md-8">
                <input class="form-control form-control-line" type="file" name="img1" id="img1">
                <?php if (isset($article) && !empty($article['img'])): ?>
                    <img src="../upload/imgtin/<?php echo htmlspecialchars($article['img']); ?>" alt="Current Image" width="100">
                <?php endif; ?>
            </div>
            <label class="col-md-8">Tóm tắt bài viết</label>
            <div class="col-md-8">
                <textarea id="froala-editor1" name="tomtat"><?php echo isset($article) ? htmlspecialchars($article['tomtat']) : ''; ?></textarea>
            </div>
            <label class="col-md-8">Nội dung bài viết</label>
            <div class="col-md-8">
                <textarea id="froala-editor2" name="noidung"><?php echo isset($article) ? htmlspecialchars($article['noidung']) : ''; ?></textarea>
            </div>
            <label class="col-md-8">Từ khóa bài viết</label>
            <div class="col-md-8">
                <textarea id="froala-editor3" name="tukhoa"><?php echo isset($article) ? htmlspecialchars($article['tukhoa']) : ''; ?></textarea>
            </div> 
            <div class="col-md-8" align="center"><br><br>
                <button style="align-items: center;" type="submit" name="updateTT" id="updateTT"><?php echo isset($article) ? "Cập nhật tin" : "Đăng tin"; ?></button>
            </div>
        </div>
    </form>
    <br><br><br><br><br>
</section>
