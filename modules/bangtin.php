<?php 
require_once "class/News.php";
require_once "class/Database.php";
$pdo = Database::getInstance()->getConnection();
$newsList = News::getAllNewsFromDatabase($pdo);
?>

<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="clearfix">
                <h1 class="title"><span>Danh sách tin</span></h1>
                <?php foreach ($newsList as $news) { ?>
                    <div class="news-item panel panel-default">
                        <div class="panel-body">
                            <div class="media">
                                <a class="pull-left" href="index.php?view=xemtin&id=<?php echo $news->id_tin; ?>">
                                    <img class="media-object img-responsive" style="width: 200px; height: 150px;" src="<?php echo "upload/imgtin/".$news->img; ?>" alt="">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="index.php?view=xemtin&id=<?php echo $news->id_tin; ?>">
                                            <?php echo $news->tieuDe; ?>
                                        </a>
                                    </h4>
                                    <p><?php echo $news->tomtat; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-3">
            <img class="img-responsive" src="upload/imgwb/1.jpg" alt="">
        </div>
    </div>
</div>

<style>
    .news-item {
        margin-bottom: 20px;
    }
    .title {
        margin-bottom: 30px;
        font-size: 24px;
        font-weight: bold;
    }
</style>
