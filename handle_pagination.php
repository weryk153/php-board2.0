<?php
  include_once('conn.php');
  $page_limit = 20; // 每頁顯示筆數
  $sql = "SELECT * FROM k_comments WHERE parent_id = 0 ORDER BY created_at DESC";
  $result = $conn->query($sql);
  $data_num = $result->num_rows;
  $pages = ceil($data_num / $page_limit);  // 總頁數
  
  if (!isset($_GET['page'])){
    $pageIndex = 1; // 設定起始頁數
  } else {
    $pageIndex = intval($_GET['page']) > $pages ? intval($pages) : intval($_GET['page']); // 抓現在的頁數
  }
  $data_start = ($pageIndex - 1) * $page_limit; 
  $page_prev = $pageIndex - 1;
  $page_next = $pageIndex + 1;
?>