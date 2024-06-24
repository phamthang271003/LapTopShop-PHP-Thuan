<?php
require_once "class/Product.php";
require_once "class/Database.php";
$pdo = Database::getInstance()->getConnection();
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    // Gọi phương thức để lấy thông tin sản phẩm từ class Product
    $product = Product::getProductById($pdo, $id);
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="box-sale-policy ng-scope" ng-controller="moduleController" ng-init="initSalePolicyController('Shop')">
                <h3><span>Chính sách bán hàng</span></h3>
                <div class="sale-policy-block">
                    <ul>
                        <li>Giao hàng TOÀN QUỐC</li>
                        <li>Thanh toán khi nhận hàng</li>
                        <li>Đổi trả trong <span>15 ngày</span></li>
                        <li>Hoàn ngay tiền mặt</li>
                        <li>Chất lượng đảm bảo</li>
                        <li>Miễn phí vận chuyển:<span>Đơn hàng từ 3 món trở lên</span></li>
                    </ul>
                </div>
                <div class="buy-guide">
                    <h3>Hướng Dẫn Mua Hàng</h3>
                    <ul>
                        <li>Mua hàng trực tiếp tại website <b class="ng-binding"> thegioialo.vn</b></li>
                        <li>Gọi điện thoại <strong class="ng-binding">0979139451</strong> để mua hàng</li>
                        <li>Mua tại Trung tâm CSKH:<br><strong class="ng-binding">Hà Nội</strong> <a href="index.php?view=map" rel="nofollow" target="_blank">Xem Bản Đồ</a></li>
                    </ul>
                    <div><img width="100%" src="upload/imgwb/1.jpg" alt=""></div>
                </div>
            </div>
        </div>
        <!-- right -->
        <div class="col-md-9">
            <link href="/Scripts/smoothproducts/smoothproducts.css" rel="stylesheet" type="text/css">
            <script src="/Scripts/smoothproducts/smoothproducts.js" type="text/javascript"></script>
            <script src="/app/services/productServices.js"></script>
            <script src="/app/controllers/productController.js"></script>
            <!--Begin-->
            <div class="product-block clearfix">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12 product-image clearfix">
                        <div class="carousel slide article-slide" id="article-photo-carousel">
                            <!-- Wrapper for slides -->
                            <div class="carousel-inner cont-slider z2">
                                <?php if (!empty($product)) : ?>
                                    <div class="item active">
                                        <img style="height: 380px; width: 320px" alt="" title="" src="upload/imgproduct/<?php echo $product->img1 ?>">
                                    </div>
                                    <div class="item">
                                        <img style="height: 380px; width: 320px" alt="" title="" src="upload/imgproduct/<?php echo $product->img2 ?>">
                                    </div>
                                    <div class="item">
                                        <img style="height: 380px; width: 320px" alt="" title="" src="upload/imgproduct/<?php echo $product->img3 ?>">
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Indicators -->
                            <ol class="carousel-indicators" style="padding-top: -50px;">
                                <?php if (!empty($product)) : ?>
                                    <li data-slide-to="0" data-target="#article-photo-carousel" class="active">
                                        <img style="width: 40px; height: 50px;" alt="" src="upload/imgproduct/<?php echo $product->img1 ?>">
                                    </li>
                                    <li data-slide-to="1" data-target="#article-photo-carousel">
                                        <img style="width: 40px; height: 50px;" alt="" src="upload/imgproduct/<?php echo $product->img2 ?>">
                                    </li>
                                    <li data-slide-to="2" data-target="#article-photo-carousel">
                                        <img style="width: 40px; height: 50px;" alt="" src="upload/imgproduct/<?php echo $product->img3 ?>">
                                    </li>
                                <?php endif; ?>
                            </ol>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 clearfix">
                        <?php if (!empty($product)) : ?>
                            <h2 class="ng-binding" style="font-size: 24px;font-weight: bold;color: #000000;text-transform: uppercase;margin-bottom: 15px;"><?php echo $product->name_sp ?></h2>
                            <div class="price ng-scope">
                                <?php if ($product->sale) : ?>
                                    <div>
                                        Giá cũ: <span class="price-old ng-binding"><?php echo number_format($product->gia_sp, 0, ",", ".") ?> vnđ</span><br>
                                        Giảm giá: <span style="color: red;"><?php echo $product->sale ?>%</span><br>
                                        Giá khuyến mãi: <span class="price-new ng-binding"><?php echo number_format(($product->gia_sp - $product->gia_sp * $product->sale / 100), 0, ",", ".") ?> vnđ</span>
                                    </div>
                                <?php else : ?>
                                    Giá: <span class="price-new ng-binding"><?php echo number_format($product->gia_sp, 0, ",", ".") ?> vnđ</span>
                                <?php endif; ?>
                            </div>
                            <div class="des ng-binding">
                                <p><?php echo $product->noibat ?></p>
                                <p style="color: red;"><?php echo $product->status ? "Còn hàng" : "Tạm thời hết hàng" ?></p>
                            </div>
                            <div class="quantity clearfix">
                                <label>Số lượng:</label>
                                <div class="quantity-input">
                                    <input value="1" class="text ng-pristine ng-untouched ng-valid" ng-model="InputQuantity" ng-init="InputQuantity=1" type="number">
                                </div>
                            </div>
                            <div class="button ng-scope">
                                <a href="javascript:void(0)" class="btn btn-primary" onclick="addCart(<?php echo $product->id_sp ?>)">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>Thêm giỏ hàng
                                </a>
                                <a href="index.php?view=thanhtoan" onclick="addCart(<?php echo $product->id_sp ?>)" class="btn btn-primary">
                                    <i class="glyphicon glyphicon-ok"></i>Mua ngay
                                </a>
                            </div>
                            <div class="call">
                                <p class="title">Để lại số điện thoại, chúng tôi sẽ tư vấn ngay sau từ 5 › 10 phút</p>
                                <div class="input">
                                    <div class="input-group">
                                        <input class="form-control ng-pristine ng-untouched ng-valid" ng-model="CustomerPhone" onblur="if(this.value=='')this.value='Nhập số điện thoại...'" onfocus="if(this.value=='Nhập số điện thoại...')this.value=''" value="Nhập số điện thoại..." type="text">
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" type="button" ng-click="callMe()"><i class="fa fa-phone"></i> Gọi lại cho tôi</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="product-tabs" style="padding-top: 20px;">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#thongso">Chi tiết thông số</a></li>
                    <li><a data-toggle="tab" href="#mota">Giới thiệu sản phẩm</a></li>
                </ul>
                <div class="tab-content">
                    <div id="thongso" class="tab-pane fade in active">
                        <?php if (!empty($product)) echo $product->thongso_sp ?>
                    </div>
                    <div id="mota" class="tab-pane fade">
                        <?php if (!empty($product)) echo $product->mota_sp ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
