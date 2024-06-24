<?php 
require_once "class/News.php";
require_once "class/Database.php";
$pdo = Database::getInstance()->getConnection();
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $news = News::getNewsById($id, $pdo);
} 
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="news-detail panel panel-default">
                <div class="panel-body">
                    <?php if ($news) { ?>
                        <h2 class="news-title"><?php echo $news->tieuDe; ?></h2>
                        <p class="news-content"><?php echo nl2br($news->noidung); ?></p>
                    <?php } else { ?>
                        <p>Không tìm thấy tin tức.</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .news-detail {
        margin-top: 30px;
    }
    .news-title {
        margin-bottom: 20px;
        font-size: 28px;
        font-weight: bold;
        color: #333;
    }
    .news-content {
        font-size: 16px;
        line-height: 1.6;
        color: #555;
    }
    .news-content p {
        margin-bottom: 15px;
    }
</style>
