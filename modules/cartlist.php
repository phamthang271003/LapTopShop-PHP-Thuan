<?php 
require_once "class/Database.php";
//require_once "class/ShoppingCart.php";
$pdo = Database::getInstance()->getConnection();
//$shoppingCart = new ShoppingCart();

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <script src="/app/services/orderServices.js"></script>
            <script src="/app/controllers/orderController.js"></script>
            <div class="payment-content ng-scope" ng-controller="orderController" ng-init="initCheckoutController()">
                <h1 class="title"><span>Giỏ hàng</span></h1>
                <div class="table-responsive">
                    <table class="table table-bordered">
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
                                if(isset($_SESSION["cart"]) && $_SESSION["cart"]){
                                    $i=0;
                                    $total = 0;
                                    foreach ($_SESSION["cart"] as $key => $value) {
                                        $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value["name_sp"];?></td>
                                <td>
                                    <img src="upload/imgproduct/<?php echo $value["img1"] ?>" width="100" alt="">
                                </td>
                                <td>
                                    <?php ;
                                    $price=$value['gia_sp'];
                                    $sale=$value['sale'];
                                    $price_sale = $price - $price*($sale/100);
                                    echo number_format("$price_sale",0,",",".");?> VNĐ
                                </td>
                                <td>
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control" name="sl_<?php echo $key ?>" id="sl_<?php echo $key ?>"  value="<?php echo $value["productQuanlity"] ?>" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-success" type="button" onclick="updateCart(<?php echo $key ?>)">
                                                <span class="glyphicon glyphicon-refresh"></span>Cập nhật 
                                            </button>
                                            <button class="btn btn-danger" type="button" onclick="deleteCart(<?php echo $key ?>)">
                                                <span class="glyphicon glyphicon-trash"></span>Xóa
                                            </button>
                                        </span>
                                    </div>
                                </td>
                                <td>
                                   <?php $thanhtien= $value["productQuanlity"] * $price_sale; 
                                    echo number_format("$thanhtien",0,",",".");
                                        $total +=$value["productQuanlity"] * $price_sale;
                                    ?> VNĐ
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="5">Tổng tiền</td>
                                <td><?php echo number_format("$total",0,",",".");  ?> VNĐ</td>
                            </tr>
                            <?php  
                                }else{
                                    ?>
                            <tr>
                                <td colspan="6"><h4>Không có sản phẩm nào</h4></td>
                            </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <a href="index.php" class="btn btn-primary">Tiếp tục mua hàng</a>
                    <a href="index.php?view=thanhtoan" class="btn btn-primary" style="margin-left: 30px;">Mua ngay</a>
                </div>
                <div class="payment-title text-center">
                    <h3>
                        GIAO HÀNG TOÀN QUỐC - THANH TOÁN KHI NHẬN HÀNG - 15 NGÀY ĐỔI TRẢ MIỄN PHÍ
                    </h3>
                    <div>
                        Nếu gặp khó khăn trong việc đặt hàng xin hãy gọi<b class="hotline"> 0979139451 </b>
                        để được hỗ trợ tốt nhất.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
