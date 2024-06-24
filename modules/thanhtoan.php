<?php


require_once "class/Database.php"; // Assuming Database.php contains PDO connection setup
$pdo = Database::getInstance()->getConnection(); // Establishing PDO connection

$total = 0;
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <script src="/app/services/orderServices.js"></script>
            <script src="/app/controllers/orderController.js"></script>
            <div class="payment-content ng-scope" ng-controller="orderController" ng-init="initCheckoutController()">
                <h1 class="title"><span>Thanh toán</span></h1>
                <div class="steps clearfix" style="padding-bottom: 30px;">
                    <ul class="clearfix">
                        <li class="cart active col-md-2 col-xs-4 col-sm-4 col-md-offset-3 col-sm-offset-0 col-xs-offset-0"><span><i class="glyphicon glyphicon-shopping-cart"></i></span><span>Giỏ hàng</span><span class="step-number"><a>1</a></span></li>
                        <li class="payment col-md-2 col-xs-4 col-sm-4"><span><i class="glyphicon glyphicon-usd"></i></span><span>Thanh toán</span><span class="step-number"><a>2</a></span></li>
                        <li class="finish col-md-2 col-xs-4 col-sm-4"><span><i class="glyphicon glyphicon-ok"></i></span><span>Hoàn tất</span><span class="step-number"><a>3</a></span></li>
                    </ul>
                </div>
                <div class="payment-title text-center hidden">
                    <h3>
                        GIAO HÀNG TOÀN QUỐC - THANH TOÁN KHI NHẬN HÀNG - 15 NGÀY ĐỔI TRẢ MIỄN PHÍ
                    </h3>
                    <div>
                        Nếu gặp khó khăn trong việc đặt hàng xin hãy gọi<b class="hotline"> 0979139451 </b>
                        để được hỗ trợ tốt nhất.
                    </div>
                </div>
                <form class="payment-block clearfix ng-invalid ng-invalid-required ng-valid-email ng-dirty ng-valid-parse" id="checkout-container" method="POST">
                    <div class="col-md-4 col-sm-12 col-xs-12 payment-step step2">
                        <h4>1. Địa chỉ thanh toán và giao hàng</h4>
                        <div class="step-preview clearfix">
                            <h2 class="title">Thông tin thanh toán</h2>
                            <?php
                            if (!isset($_SESSION["username"])) {
                            ?>
                                <div class="user-login"><a href="index.php?view=createid">Đăng ký tài khoản mua hàng</a></div>
                            <?php } else { ?>
                                <div class="user-login"><span>Bạn đang mua hàng bằng tài khoản: <i><?php echo htmlspecialchars($_SESSION["username"]["username"], ENT_QUOTES, 'UTF-8'); ?></i></span></div>
                            <?php } ?>
                            <div class="form-group">
                                <input class="form-control" id="fullname" name="fullname" placeholder="Họ &amp; Tên" required="" value="<?php echo isset($_SESSION["username"]) ? htmlspecialchars($_SESSION["username"]["fullName"], ENT_QUOTES, 'UTF-8') : ''; ?>" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="phone" name="phone" placeholder="Số điện thoại" value="<?php echo isset($_SESSION["username"]) ? htmlspecialchars($_SESSION["username"]["phone"], ENT_QUOTES, 'UTF-8') : ''; ?>" required="" type="text">
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="email" name="email" placeholder="Email" value="<?php echo isset($_SESSION["username"]) ? htmlspecialchars($_SESSION["username"]["email"], ENT_QUOTES, 'UTF-8') : ''; ?>" required="" type="email">
                            </div>

                            <div class="form-group">
                                <i style="color: red; font-size: 11px;">Nhập địa chỉ chi tiết để chúng tôi có thể giao hàng tận nơi cho bạn</i>
                                <div class="form-group"><input id="address" name="address" class="form-control" placeholder="Số nhà- Xã/Phường - Quận Huyện - Tỉnh TP" required="" type="text"></div>
                            </div>
                            <textarea class="form-control" rows="4" id="cmt" name="cmt" placeholder="Ghi chú đơn hàng"></textarea>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12 col-xs-12 payment-step step3">
                        <h4>2. Thanh toán và vận chuyển</h4>
                        <div class="step-preview clearfix">
                            <h2 class="title">Vận chuyển</h2>
                            <div class="form-group ">
                                <select class="form-control" name="ptvc">
                                    <option value="1" name="" selected="selected">Giao hàng tận nhà</option>
                                    <option value="2">Nhận hàng tại cửa hàng</option>
                                </select>
                            </div>
                            <h2 class="title">Thanh toán</h2>
                            <div class="form-group">
                                <select class="form-control" name="pttt">
                                    <option value="1" selected="selected">Thanh toán tiền mặt</option>
                                    <option value="2">Chuyển khoản ngân hàng</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-12 col-xs-12 payment-step step1">
                        <h4>3. Thông tin đơn hàng</h4>
                        <div class="step-preview">
                            <div class="cart-info">
                                <div class="cart-items">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Ảnh</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (isset($_SESSION["cart"]) && $_SESSION["cart"]) {
                                                    $i = 0;
                                                    foreach ($_SESSION["cart"] as $key => $value) {
                                                        $i++;
                                                ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td style="max-width: 150px; overflow: hidden; text-overflow: ellipsis;"><?php echo htmlspecialchars($value["name_sp"], ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td>
                                                                <img src="upload/imgproduct/<?php echo htmlspecialchars($value["img1"], ENT_QUOTES, 'UTF-8'); ?>" width="70" alt="">
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $price = $value['gia_sp'];
                                                                $sale = $value['sale'];
                                                                $price_sale = $price - $price * $sale / 100;
                                                                echo number_format($price_sale);
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $value["productQuanlity"]; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                $thanhtien = $value["productQuanlity"] * $price_sale;
                                                                echo number_format($thanhtien, 0, ",", ".");
                                                                $total += $thanhtien;
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                <?php } else { ?>
                                                    <tr>
                                                        <td colspan="6">
                                                            <h4>Không có sản phẩm nào</h4>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="total-price">
                                    <p>Thành tiền: <span class="ng-binding"><?php echo number_format($total); ?> VNĐ</span></p>
                                </div>
                                <div class="shiping-price">
                                    <p>Phí vận chuyển: <span class="ng-binding"><?php $phivc = 30000;
                                                                                echo number_format($phivc); ?> VNĐ</span></p>
                                </div>
                                <div class="total-payment">
                                    <p>Thanh toán: <span class="ng-binding"><?php $totals = $total + $phivc;
                                                                            echo number_format($totals); ?> VNĐ</span></p>
                                </div>
                                <div class="button-submit">
                                    <button class="btn btn-primary" name="oder" type="submit">Đặt hàng</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
  
if (isset($_SESSION['cart']) && isset($_POST["oder"])) {
    $fullname = htmlspecialchars($_POST["fullname"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST["email"], ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($_POST["phone"], ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars($_POST["address"], ENT_QUOTES, 'UTF-8');
    $cmt = htmlspecialchars($_POST["cmt"], ENT_QUOTES, 'UTF-8');
    $date_oder = date('Y-m-d H:i:s');
    $ptvc = isset($_POST['ptvc']) ? (int)$_POST['ptvc'] : 1;
    $pttt = isset($_POST['pttt']) ? (int)$_POST['pttt'] : 1;

    $sqlInsert = "INSERT INTO tbl_oder (fullname, email, phone, address, dateOder, ptvc, pttt, tongTien, status) 
                  VALUES (:fullname, :email, :phone, :address, :date_oder, :ptvc, :pttt, :totals, 1)";
    $stmt = $pdo->prepare($sqlInsert);
    $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':date_oder', $date_oder, PDO::PARAM_STR);
    $stmt->bindParam(':ptvc', $ptvc, PDO::PARAM_INT);
    $stmt->bindParam(':pttt', $pttt, PDO::PARAM_INT);
    $stmt->bindParam(':totals', $totals, PDO::PARAM_INT);
    $stmt->execute();

    $last_id = $pdo->lastInsertId();

    foreach ($_SESSION["cart"] as $key => $value) {
        $item[] = $key;
    }
    $str = implode(",", $item);
    $sql_cart = "SELECT * FROM tbl_sp WHERE id_sp IN ($str)";
    $stmt_cart = $pdo->prepare($sql_cart);
    $stmt_cart->execute();

    while ($row = $stmt_cart->fetch(PDO::FETCH_ASSOC)) {
        $price = $row['gia_sp'];
        $sale = intval($row['sale']);
        $price_sale = $price - $price * $sale / 100;
        $quantity = $_SESSION["cart"][$row['id_sp']]["productQuanlity"];
        $total_price = $quantity * $price_sale;

        $sqlInsertDetail = "INSERT INTO tbl_oderdetail (oder_id, id_sp, name_sp, sl, gia_sp, dateOder, tong_tien) 
                            VALUES (:last_id, :id_sp, :name_sp, :quantity, :price_sale, :date_oder, :total_price)";
        $stmt_detail = $pdo->prepare($sqlInsertDetail);
        $stmt_detail->bindParam(':last_id', $last_id, PDO::PARAM_INT);
        $stmt_detail->bindParam(':id_sp', $row['id_sp'], PDO::PARAM_INT);
        $stmt_detail->bindParam(':name_sp', $row['name_sp'], PDO::PARAM_STR);
        $stmt_detail->bindParam(':quantity', $quantity, PDO::PARAM_INT);
        $stmt_detail->bindParam(':price_sale', $price_sale, PDO::PARAM_INT);
        $stmt_detail->bindParam(':date_oder', $date_oder, PDO::PARAM_STR);
        $stmt_detail->bindParam(':total_price', $total_price, PDO::PARAM_INT);
        $stmt_detail->execute();
    }

    // Email Sending Logic
    

  
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/PHPMailer.php';
    
    $nFrom = "ThietBiMay.vn";
    $mFrom = "Phamtranquangthang30@gmail.com";  // Your email address
    $mPass = "mjgkgndioryphmlm";  // Your email password
    $link = "http://localhost:81/Laptop24h/index.php";
    $j = 1;
    $body = "Bạn đã mua hàng tại <a href='http://localhost/thietbimay/index.php' target='_blank'>Thiết bị máy</a><br>
    <h5>Đơn hàng của bạn: $fullname đã đặt hàng </h5>
    <table style='border:1px solid black;'>
        <thead>
            <tr>
                <th>#</th>
                <th>Tên sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>";
    
    foreach ($_SESSION["cart"] as $value) {
        $price = $value['gia_sp'];
        $sale = intval($value['sale']);
        $price_sale = $price - $price * $sale / 100;
        $quantity = $value["productQuanlity"];
        $total_price = $quantity * $price_sale;
        $body .= "<tr>
                <td>$j</td>
                <td>" . htmlspecialchars($value['name_sp'], ENT_QUOTES, 'UTF-8') . "</td>
                <td style='text-align:center;'>" . number_format($price_sale) . "</td>
                <td style='text-align:center;'>$quantity</td>
                <td style='text-align:right;'>" . number_format($total_price) . "</td>
            </tr>";
        $j++;
    }
    $body .= "<tr><td colspan='4'>Phí vận chuyển: </td>
                <td style='text-align:right;'>" . number_format(30000) . "</td>";
    $body .= "<tr><td colspan='4'>Tổng tiền: </td>
                <td> " . number_format($totals) . ' VNĐ' . "</td></tr>
        </tbody>
    </table>";
    
    $mail = new PHPMailer(true);
    
    try {
        $mail->IsSMTP();

        $mail->CharSet = "utf-8";
        $mail->SMTPDebug = 0;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Username = $mFrom;
        $mail->Password = $mPass;
        $mail->SetFrom($mFrom, $nFrom);
        $mail->AddReplyTo('phamtranquangthang30@gmail.com', 'ThietBiMay.vn');
        $mail->Subject = 'Order Confirmation';
        $mail->MsgHTML($body);
        $mail->AddAddress($email, htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8'));
        $mail->Send();
        echo "<script>alert('Đơn hàng bạn đã đặt thành công! Bạn có thể check lại tại email của mình');window.location.href='index.php';</script>";
        unset($_SESSION['cart']);
    } catch (Exception $ex) {
        echo "<script>alert('Đặt hàng thành công, nhưng không thể gửi email.');</script>";
    }   
    
    // if ($mail->Send()) {
    //     echo "<script>alert('Đơn hàng bạn đã đặt thành công! Bạn có thể check lại tại email của mình');window.location.href='index.php';</script>";
    //     unset($_SESSION['cart']);

    // } else {
    //     echo "<script>alert('Đặt hàng thành công, nhưng không thể gửi email.');</script>";
    // }
}
?>

