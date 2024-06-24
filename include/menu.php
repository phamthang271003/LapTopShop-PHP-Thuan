<?php 
require_once "class/Database.php";
require_once "class/Category.php"; // Include the Category class file

// Database connection
$pdo = Database::getInstance()->getConnection();

// Get manufacturers for each category using the static method from Category class
$manufacturersDell = Category::getManufacturersByCategory($pdo, 1);
$manufacturersLenovo = Category::getManufacturersByCategory($pdo, 2);
$manufacturersMSI = Category::getManufacturersByCategory($pdo, 3);
?>

<section class="hearder-conten clearfix" style="margin-top: 2px;">
    <nav class="navbar navbar-default" role="navigation" style="width: 100%;">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand hidden-md hidden-lg" href="#">Menu</a>
        </div>

        <div class="collapse navbar-collapse" id="main-menu">
            <ul class="nav navbar-nav"> 
                <li class="dropdown">
                    <a href="./" class="link1"><i class="fa fa-home" aria-hidden="true"></i> TRANG CHỦ</a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-mobile" aria-hidden="true"></i>  DELL<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($manufacturersDell as $manufacturer) { ?>
                            <li style="margin-top: 2px;"><a style="color: #333333;"  href="index.php?view=product&id=<?php echo $manufacturer['id_loaisp']; ?>&id_hang=<?php echo $manufacturer['id_hangsx']; ?>"><i class="icon-chevron-right"></i><?php echo $manufacturer['name_hangsx']; ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-tablet" aria-hidden="true"></i>  LENOVO<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($manufacturersLenovo as $manufacturer) { ?>
                            <li style="margin-top: 2px;"><a style="color: #333333;"  href="index.php?view=product&id=<?php echo $manufacturer['id_loaisp']; ?>&id_hang=<?php echo $manufacturer['id_hangsx']; ?>"><i class="icon-chevron-right"></i><?php echo $manufacturer['name_hangsx']; ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-laptop" aria-hidden="true"></i> MSI<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($manufacturersMSI as $manufacturer) { ?>
                            <li style="margin-top: 2px;"><a style="color: #333333;"  href="index.php?view=product&id=<?php echo $manufacturer['id_loaisp']; ?>&id_hang=<?php echo $manufacturer['id_hangsx']; ?>"><i class="icon-chevron-right"></i><?php echo $manufacturer['name_hangsx']; ?></a></li>
                        <?php } ?>
                    </ul>
                </li>
                <li><a href="?view=bangtin"><i class="fa fa-newspaper-o" aria-hidden="true"></i>  TIN TỨC</a></li>
                <li><a href="index.php?view=map"> <i class="fa fa-map" aria-hidden="true"></i>  BẢN ĐỒ</a></li>
                <li><a href="?view=contact"><i class="fa fa-newspaper-o" aria-hidden="true"></i>  LIÊN HỆ</a></li>
                <li><a href="?view=about"><i class="fa fa-newspaper-o" aria-hidden="true"></i>Giới thiệu</a></li>
                <li>
                    <form class="navbar-form navbar-left" action="index.php?view=searchproduct" role="search" enctype="mutipart/from-data" method="POST">
                        <div class="form-group">
                            <input type="text" name="seachtext" class="form-control" placeholder="Bạn kiếm sản phẩm gì?" required="">
                        </div>
                        <button type="submit" name="ok" value="seach" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
                    </form>
                </li>
            </ul>
        </div> 
    </nav>
</section>
