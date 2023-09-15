<?php 
require('dbconnect.php');
require('common.php');
session_start();

//エラーカウント用変数
$i="";

//エラー内容リセット
unset($_SESSION['error_customer']);

//関連先企業存在チェック用SQL
try {
    $sql = $db->prepare('SELECT * FROM company WHERE company_name=?');
    $sql->bindParam(1, h($_REQUEST['company']), PDO::PARAM_STR);
    $sql->execute();
    $count = $sql -> rowCount();
} catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
}
//データ追加用に変数生成
foreach($sql as $row) {
    $company_id = $row['code'];
}

//受け取った値をセッションに格納
$_SESSION['customer'] = [
'company'=>$_REQUEST['company'], 'company_id'=>$company_id, 'customer'=>$_REQUEST['customer'], 
'customer_kana'=>$_REQUEST['customer_kana'], 'department'=>$_REQUEST['department'], 'position'=>$_REQUEST['position'], 'tel'=>$_REQUEST['tel'], 'mail'=>$_REQUEST['mail'], 'notes'=>$_REQUEST['notes']];

$error_message = 'が未入力です';
//受け取った値が空白の場合、エラー内容を格納
if($_REQUEST['company'] === "") {
    $_SESSION['error_customer']['company'] = '関連先企業名'.$error_message;
    $i++;
//企業が存在しなければエラー
} elseif($count === 0) {
    $_SESSION['error_customer']['company'] = '関連先企業の登録がありません';
    $i++;
}

if($_REQUEST['customer'] === "") {
  $_SESSION['error_customer']['customer'] = '取引先担当者'.$error_message;
  $i++;
}

//エラーあれば戻る
if($i!=="") {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/customer.php');
//エラーなければデータベース追加、編集
} else {
    if($_SESSION['customer_id']===NULL) {
        $sql = $db->prepare('INSERT INTO customer SET company_id=?, customer_name=?, customer_kana=?, 
        department=?, position=?, tel=?, mail=?, notes=?');
        $sql->bindParam(1, h($_SESSION['customer']['company_id']), PDO::PARAM_INT);
        $sql->bindParam(2, h($_SESSION['customer']['customer']), PDO::PARAM_STR);
        $sql->bindParam(3, h($_SESSION['customer']['customer_kana']), PDO::PARAM_STR);
        $sql->bindParam(4, h($_SESSION['customer']['department']), PDO::PARAM_STR);
        $sql->bindParam(5, h($_SESSION['customer']['position']), PDO::PARAM_STR);
        $sql->bindParam(6, h($_SESSION['customer']['tel']), PDO::PARAM_STR);
        $sql->bindParam(7, h($_SESSION['customer']['mail']), PDO::PARAM_STR);
        $sql->bindParam(8, h($_SESSION['customer']['notes']), PDO::PARAM_STR);
        if ($sql->execute()) {
            $_SESSION['message'] = '下記内容で登録しました。';
            header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/customerFinish.php');
        } else {
            $_SESSION['message'] = '登録中にエラーが発生しました。';
            header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/customer.php');
        }
    } else {
        $sql = $db->prepare('UPDATE customer SET company_id=?, customer_name=?, customer_kana=?, 
        department=?, position=?, tel=?, mail=?, notes=? WHERE id=?');
        $sql->bindParam(1, h($_SESSION['customer']['company_id']), PDO::PARAM_INT);
        $sql->bindParam(2, h($_SESSION['customer']['customer']), PDO::PARAM_STR);
        $sql->bindParam(3, h($_SESSION['customer']['customer_kana']), PDO::PARAM_STR);
        $sql->bindParam(4, h($_SESSION['customer']['department']), PDO::PARAM_STR);
        $sql->bindParam(5, h($_SESSION['customer']['position']), PDO::PARAM_STR);
        $sql->bindParam(6, h($_SESSION['customer']['tel']), PDO::PARAM_STR);
        $sql->bindParam(7, h($_SESSION['customer']['mail']), PDO::PARAM_STR);
        $sql->bindParam(8, h($_SESSION['customer']['notes']), PDO::PARAM_STR);
        $sql->bindParam(9, h($_SESSION['customer_id']), PDO::PARAM_INT);
        if ($sql->execute()) {
            $_SESSION['message'] = '下記内容で更新しました。';
            header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/customerFinish.php');
        } else {
            $_SESSION['message'] = '更新中にエラーが発生しました。';
            header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/customer.php');
        }
    }
}
?>
