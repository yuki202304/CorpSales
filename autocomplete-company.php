<?php
require('dbconnect.php');
try {
  $sql= $db->prepare('SELECT * FROM company');
  $sql->execute();
} catch (PDOException $e) {
  echo 'DB接続エラー： ' . $e->getMessage();
}

foreach($sql as $row) {
  $list[] = $row['company_name'];
}

// 現在入力中の文字を取得
$term = (isset($_GET['term']) && is_string($_GET['term'])) ? $_GET['term'] : '';
 
// 部分一致で検索
foreach($list as $word){
    if(mb_stripos( $word, $term) !== FALSE){
        $words[] = $word;
    }   
}
 
header("Content-Type: application/json; charset=utf-8");
echo json_encode($words);
?>