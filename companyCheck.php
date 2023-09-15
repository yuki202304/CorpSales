<?php 
require('dbconnect.php');
require('common.php');
session_start();

//エラーカウント用変数
$i="";

//エラー内容リセット
unset($_SESSION['error_company']);

//受け取った値をセッションに格納
$_SESSION['company'] = [
'code'=>$_REQUEST['code'], 'name'=>$_REQUEST['name'], 'kana'=>$_REQUEST['kana'], 'post'=>$_REQUEST['post'], 
'address'=>$_REQUEST['address'], 'tel'=>$_REQUEST['tel'], 'industry'=>$_REQUEST['industry'], 
'employee'=>$_REQUEST['employee'], 'ceo'=>$_REQUEST['ceo'], 'capital'=>$_REQUEST['capital'], 
'number'=>$_REQUEST['number'], 'settlement'=>$_REQUEST['settlement'], 'website'=>$_REQUEST['website']
];

//法人番号重複チェック用SQL
try {
    $code = $db->prepare('SELECT * FROM company WHERE code=?');
    $code->bindParam(1, h($_REQUEST['code']), PDO::PARAM_INT);
    $code->execute();
    $code_count = $code -> rowCount();
    
    $employee = $db->prepare('SELECT * FROM employee WHERE employee_name=?');
    $employee->bindParam(1, h($_REQUEST['employee']), PDO::PARAM_INT);
    $employee->execute();
    $employee_count = $employee -> rowCount();
} catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
}

//自社担当者存在チェック用SQL
try {
    $sql = $db->prepare('SELECT * FROM employee WHERE employee=?');
    $sql->bindParam(1, h($_REQUEST['code']), PDO::PARAM_INT);
    $sql->execute();
    $count = $sql -> rowCount();
} catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
}

$error_message = 'が未入力です';
//受け取った値が空白の場合、エラー内容を格納
if($_REQUEST['code'] ==="") {
    $_SESSION['error_company']['code'] = '法人番号'.$error_message;
    $i++;
//数値チェック
} elseif(!preg_match('/^[0-9]+$/', $_REQUEST['code'])) {
    $_SESSION['error_company']['code'] = '数値で入力してください';
    $i++;
//法人番号重複エラー
} elseif($_SESSION['company_id']===NULL && $code_count !== 0) {
    $_SESSION['error_company']['code'] = '同じ法人番号が存在します';
    $i++;
}

if($_REQUEST['name'] === "") {
    $_SESSION['error_company']['name'] = '企業名'.$error_message;
    $i++;
}

if($_REQUEST['kana'] === "") {
    $_SESSION['error_company']['kana'] = 'カナ名'.$error_message;
    $i++;
}

if($_REQUEST['post'] === "") {
    $_SESSION['error_company']['post'] = '郵便番号'.$error_message;
    $i++;
//数値チェック
} elseif(!preg_match('/^[0-9]+$/', $_REQUEST['post'])) {
    $_SESSION['error_company']['post'] = '数値で入力してください';
    $i++;
}

if($_REQUEST['address'] === "") {
    $_SESSION['error_company']['address'] = '住所'.$error_message;
    $i++;
}

if($_REQUEST['tel'] === "") {
    $_SESSION['error_company']['tel'] = '電話番号'.$error_message;
    $i++;
}

if($_REQUEST['industry'] === "") {
    $_SESSION['error_company']['industry'] = '業種'.$error_message;
    $i++;
}

if($_REQUEST['employee'] === "") {
    $_SESSION['error_company']['employee'] = '自社担当者'.$error_message;
    $i++;
} elseif($employee_count===0) {
    $_SESSION['error_company']['employee'] = '自社担当者に誤りがあります';
    $i++;
}


//画面遷移
if($i==="") {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/companyConfirm.php');
} else {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/company.php');
}

?>
