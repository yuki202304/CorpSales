<?php 
require('dbconnect.php');
require('common.php');
session_start();

//エラーカウント用変数
$i="";

//エラー内容リセット
unset($_SESSION['error_opportunity']);

//取引先企業の存在確認
try {
    $sql = $db->prepare('SELECT * FROM company WHERE company_name=?');
    $sql->bindParam(1, h($_REQUEST['company']), PDO::PARAM_STR);
    $sql->execute();
    $count = $sql -> rowCount();
} catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
}
foreach($sql as $row) {
    $company_id = $row['code'];
}

//自社担当者の存在確認
try {
    $employee_sql = $db->prepare('SELECT * FROM employee WHERE employee_name=?');
    $employee_sql->bindParam(1, h($_REQUEST['employee']), PDO::PARAM_STR);
    $employee_sql->execute();
    $employee_count = $employee_sql -> rowCount();
} catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
}
foreach($employee_sql as $row) {
    $employee_id = $row['id'];
}

//受け取った値をセッションに格納
$_SESSION['opportunity'] = [
    'company' => $_REQUEST['company'], 'company_id' => $company_id, 'name' => $_REQUEST['name'], 'sell' => $_REQUEST['sell'], 
    'purchase' => $_REQUEST['purchase'], 'employee' => $_REQUEST['employee'], 'employee_id' => $employee_id, 
    'start' =>  $_REQUEST['start'], 'end' => $_REQUEST['end'], 'phase' => $_REQUEST['phase'], 
    'possibility' => $_REQUEST['possibility']]; 

//受け取った値が空白の場合、エラー内容を格納
$error_message = 'が未入力です';

if($_REQUEST['company'] ==="") {
    $_SESSION['error_opportunity']['company'] = '関連先企業'.$error_message;
    $i++;
} elseif($count === 0) {
    $_SESSION['error_opportunity']['company'] = '関連先企業が存在しません';
    $i++;
}

if($_REQUEST['name'] ==="") {
    $_SESSION['error_opportunity']['name'] = '案件名'.$error_message;
    $i++;
}

if($_REQUEST['sell'] === "") {
    $_SESSION['error_opportunity']['sell'] = '売価'.$error_message;
    $i++;
}

if($_REQUEST['purchase'] === "") {
    $_SESSION['error_opportunity']['purchase'] = '仕入'.$error_message;
    $i++;
}

if($_REQUEST['employee'] === "") {
    $_SESSION['error_opportunity']['employee'] = '自社担当者'.$error_message;
    $i++;
} elseif($employee_count === 0) {
    $_SESSION['error_opportunity']['employee'] = '自社担当者が存在しません';
    $i++;
}

if($_REQUEST['start'] === "") {
    $_SESSION['error_opportunity']['start'] = '案件発生日'.$error_message;
    $i++;
}

if($_REQUEST['end'] === "") {
    $_SESSION['error_opportunity']['end'] = '受注予定日'.$error_message;
    $i++;
}

if($_REQUEST['start'] > $_REQUEST['end']) {
    $_SESSION['error_opportunity']['start'] = '案件発生日を受注予定日より早い日付にしてください';
    $i++;
}

//画面遷移
if($i!=="") {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/opportunity.php');
} else {
    if($_SESSION['opportunity_id']===NULL) {
        $sql = $db->prepare('INSERT INTO opportunity SET opportunity=?, selling_price=?, purchase_price=?, 
        employee_id=?, occur_day=?, expected_day=?, phase_id=?, possibility_id=?, company_id=?');
        $sql->bindParam(1, h($_SESSION['opportunity']['name']), PDO::PARAM_STR);
        $sql->bindParam(2, h($_SESSION['opportunity']['sell']), PDO::PARAM_STR);
        $sql->bindParam(3, h($_SESSION['opportunity']['purchase']), PDO::PARAM_STR);
        $sql->bindParam(4, h($_SESSION['opportunity']['employee_id']), PDO::PARAM_INT);
        $sql->bindParam(5, h($_SESSION['opportunity']['start']), PDO::PARAM_STR);
        $sql->bindParam(6, h($_SESSION['opportunity']['end']), PDO::PARAM_STR);
        $sql->bindParam(7, h($_SESSION['opportunity']['phase']), PDO::PARAM_INT);
        $sql->bindParam(8, h($_SESSION['opportunity']['possibility']), PDO::PARAM_INT);
        $sql->bindParam(9, h($_SESSION['opportunity']['company_id']), PDO::PARAM_INT);
        if ($sql->execute()) {
            $_SESSION['message'] = '下記内容で登録しました。';
            header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/opportunityFinish.php');
        } else {
            $_SESSION['message'] = '登録中にエラーが発生しました。';
            header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/opportunity.php');
        }
      
      //コードがなければ追加
      } else {
        $sql = $db->prepare('UPDATE opportunity SET opportunity=?, selling_price=?, purchase_price=?,
        employee_id=?, occur_day=?, expected_day=?, phase_id=?, possibility_id=?, company_id=? WHERE id=?');
        $sql->bindParam(1, h($_SESSION['opportunity']['name']), PDO::PARAM_STR);
        $sql->bindParam(2, h($_SESSION['opportunity']['sell']), PDO::PARAM_STR);
        $sql->bindParam(3, h($_SESSION['opportunity']['purchase']), PDO::PARAM_STR);
        $sql->bindParam(4, h($_SESSION['opportunity']['employee_id']), PDO::PARAM_INT);
        $sql->bindParam(5, h($_SESSION['opportunity']['start']), PDO::PARAM_STR);
        $sql->bindParam(6, h($_SESSION['opportunity']['end']), PDO::PARAM_STR);
        $sql->bindParam(7, h($_SESSION['opportunity']['phase']), PDO::PARAM_INT);
        $sql->bindParam(8, h($_SESSION['opportunity']['possibility']), PDO::PARAM_INT);
        $sql->bindParam(9, h($_SESSION['opportunity']['company_id']), PDO::PARAM_INT);
        $sql->bindParam(10, h($_SESSION['opportunity_id']), PDO::PARAM_INT);
        if ($sql->execute()) {
            $_SESSION['message'] = '下記内容で更新しました。';
            header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/opportunityFinish.php');
        } else {
            $_SESSION['message'] = '更新中にエラーが発生しました。';
            header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/opportunity.php');
        }
      }
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/opportunityFinish.php');
}

?>
