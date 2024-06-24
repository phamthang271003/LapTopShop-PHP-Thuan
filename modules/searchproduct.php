<?php 
require_once "class/Product.php";
require_once "class/Database.php";
$pdo = Database::getInstance()->getConnection();

if (isset($_POST['seachtext'])) {
    $searchText = $_POST['seachtext'];
    $searchResults = Product::searchProducts($pdo, $searchText);
} 
?>

<div class="tabs-category clearfix">
    <div class="tab-content clearfix container">
        <div class="tabs-title">
            <div id="" class="tab-title">
                <h3>
                    <span>DANH SÁCH SẢN PHẨM TÌM THẤY</span>
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="container female">
    <div class="row pTB">
        <?php 
        if (!empty($searchResults) != 0) {
            foreach ($searchResults as $product) {
        ?>
                 <div class="col-md-3 col-sm-6">
                    <div class="products">
                        <?php if ($product["sale"] != 0) { ?>
                            <div class="offer"><?php echo $product["sale"] . "%"; ?></div>
                        <?php } ?>

                        <div class="thumbnail"><a href="index.php?view=info_product&id=<?php echo $product['id_sp']; ?>"><img src="<?php echo "upload/imgproduct/" . $product["img1"]; ?>" alt="Product Name"></a></div>
                        <div class="productname"><?php echo $product['name_sp']; ?></div>
                        <h4 class="price">
                            <?php 
                                $price = $product["gia_sp"];    
                                $sale = $product["sale"];
                                $price_sale = $price - $price * $sale / 100;
                                echo number_format($price_sale, 0, ",", ".");
                                echo " VNĐ .";
                            ?>
                        </h4>
                        <div class="button_group">
                            <button class="button" type="button" onclick="addCart(<?php echo $product["id_sp"]; ?>)">
                                <span class="glyphicon glyphicon-shopping-cart"></span>Thêm vào giỏ hàng</button>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<script>alert('Không tìm thấy sản phẩm bạn cần tìm'); window.location.href='index.php';</script>";
        }
        ?>
    </div>
</div>
