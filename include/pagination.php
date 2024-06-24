<!-- Hàm phân trang -->
<?php 
function setupPagination($pdo, &$current_page, &$limit, &$total_page, &$start) {
    // Calculate total records
    $total_records_query = $pdo->query('SELECT count(id_sp) as total FROM tbl_sp');
    $total_records_row = $total_records_query->fetch(PDO::FETCH_ASSOC);
    $total_records = $total_records_row['total'];

    // Pagination setup
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 12;
    $total_page = ceil($total_records / $limit);
    if ($current_page > $total_page){
        $current_page = $total_page;
    } else if ($current_page < 1){
        $current_page = 1;
    }
    $start = ($current_page - 1) * $limit;
}
?>