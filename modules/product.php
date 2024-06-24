<?php
require_once "class/Product.php";
require_once "class/Database.php";
$pdo = Database::getInstance()->getConnection();

$id = isset($_GET["id"]) ? $_GET["id"] : 0;
$manufacturerId = isset($_GET["id_hang"]) ? $_GET["id_hang"] : 0;
$orderBy = isset($_GET["orderBy"]) ? $_GET["orderBy"] : 'name_sp';
$orderDir = isset($_GET["orderDir"]) ? $_GET["orderDir"] : 'ASC';

// If no sorting options are provided, set default sorting by product name ascending
if (empty($_GET["orderBy"]) && empty($_GET["orderDir"])) {
    $orderBy = 'name_sp';
    $orderDir = 'ASC';
}

$listproduct_category = Product::getProductsByCategory($pdo, $id, $manufacturerId, $orderBy, $orderDir);
?>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <h3>Danh mục</h3>
            <form method="GET" action="index.php">
                <input type="hidden" name="view" value="product">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="id_hang" value="<?php echo htmlspecialchars($manufacturerId); ?>">

                <div class="form-group">
                    <label for="orderBy">Sắp xếp theo:</label>
                    <select name="orderBy" id="orderBy" class="form-control">
                        <option value="name_sp" <?php echo (isset($_GET['orderBy']) && $_GET['orderBy'] == 'name_sp') ? 'selected' : ''; ?>>Tên sản phẩm</option>
                        <option value="discounted_price" <?php echo (isset($_GET['orderBy']) && $_GET['orderBy'] == 'discounted_price') ? 'selected' : ''; ?>>Giá đã giảm</option>
                        <option value="dateCreate" <?php echo (isset($_GET['orderBy']) && $_GET['orderBy'] == 'dateCreate') ? 'selected' : ''; ?>>Ngày tạo</option>
                    </select>
                </div>


                <div class="form-group">
                    <label for="orderDir">Thứ tự:</label>
                    <select name="orderDir" id="orderDir" class="form-control">
                        <option value="ASC" <?php echo (isset($_GET['orderDir']) && $_GET['orderDir'] == 'ASC') ? 'selected' : ''; ?>>Tăng dần</option>
                        <option value="DESC" <?php echo (isset($_GET['orderDir']) && $_GET['orderDir'] == 'DESC') ? 'selected' : ''; ?>>Giảm dần</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Lọc</button>
            </form>
        </div>

        <div class="col-md-9">
            <h3>Danh sách sản phẩm</h3>
            <div class="row">
                <?php
                if ($listproduct_category) {
                    foreach ($listproduct_category as $product) {
                        if (is_object($product)) {
                ?>
                            <div class="col-md-4 col-sm-6">
                                <div class="products">
                                    <?php if ($product->sale != 0) { ?>
                                        <div class="offer"><?php echo $product->sale . "%"; ?></div>
                                    <?php } ?>
                                    <div class="thumbnail">
                                        <a href="index.php?view=info_product&id=<?php echo $product->id_sp ?>">
                                            <img style="width: 225px; height: 225px;" src="<?php echo "upload/imgproduct/" . $product->img1; ?>" alt="Product Name">
                                        </a>
                                    </div>
                                    <div class="productname"><?php echo $product->name_sp; ?></div>
                                    <h4 class="price">
                                        <?php
                                        $price = $product->gia_sp;
                                        $sale = $product->sale;
                                        $price_sale = $price - $price * $sale / 100;
                                        echo number_format($price_sale, 0, ",", ".") . " VNĐ.";
                                        ?>
                                    </h4>
                                    <div class="button_group">
                                        <button class="button" type="button" onclick="addCart(<?php echo $product->id_sp; ?>)">
                                            <span class="glyphicon glyphicon-shopping-cart"></span>Thêm vào giỏ hàng
                                        </button>
                                    </div>
                                </div>
                            </div>
                <?php
                        } else {
                            echo "Invalid product data!";
                        }
                    }
                } else {
                    echo "<div class='col-md-12'>Không tìm thấy sản phẩm nào!</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>