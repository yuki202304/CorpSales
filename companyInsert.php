<?php 
require('dbconnect.php');
require('common.php');
session_start();

try {
    $employee_sql = $db->prepare('SELECT * FROM employee WHERE employee_name=?');
    $employee_sql->bindParam(1, h($_SESSION['company']['employee']), PDO::PARAM_STR);
    $employee_sql->execute();
} catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
}
foreach($employee_sql as $row) {
    $employee_id = $row['id'];
}

//新規追加
if($_SESSION['company_id']===NULL) {
    $sql = $db->prepare('INSERT INTO company SET code=?, company_name=?, kana=?, post=?, address=?, tel=?, 
    industry_id=?, employee_id=?, ceo=?, capital=?, number=?, settlement=?, website=?');
    $sql->bindParam(1, $_SESSION['company']['code'], PDO::PARAM_STR);
    $sql->bindParam(2, $_SESSION['company']['name'], PDO::PARAM_STR);
    $sql->bindParam(3, $_SESSION['company']['kana'], PDO::PARAM_STR);
    $sql->bindParam(4, $_SESSION['company']['post'], PDO::PARAM_STR);
    $sql->bindParam(5, $_SESSION['company']['address'], PDO::PARAM_STR);
    $sql->bindParam(6, $_SESSION['company']['tel'], PDO::PARAM_STR);
    $sql->bindParam(7, $_SESSION['company']['industry'], PDO::PARAM_STR);
    $sql->bindParam(8, $employee_id, PDO::PARAM_INT);
    $sql->bindParam(9, $_SESSION['company']['ceo'], PDO::PARAM_STR);
    $sql->bindParam(10, $_SESSION['company']['capital'], PDO::PARAM_STR);
    $sql->bindParam(11, $_SESSION['company']['number'], PDO::PARAM_STR);
    $sql->bindParam(12, $_SESSION['company']['settlement'], PDO::PARAM_STR);
    $sql->bindParam(13, $_SESSION['company']['website'], PDO::PARAM_STR);
    if ($sql->execute()) {
        $_SESSION['message'] = '登録が完了しました。';
    } else {
        $_SESSION['message'] = '登録中にエラーが発生しました。';
    }

    //セッション内容のリセット
    unset($_SESSION['company']);
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/company.php');
//更新
} else {
    $sql = $db->prepare('UPDATE company SET company_name=?, kana=?, post=?, address=?, tel=?,
    industry_id=?, employee_id=?, ceo=?, capital=?, number=?, settlement=?, website=? WHERE code=?');
    $sql->bindParam(1, ($_SESSION['company']['name']), PDO::PARAM_STR);
    $sql->bindParam(2, ($_SESSION['company']['kana']), PDO::PARAM_STR);
    $sql->bindParam(3, ($_SESSION['company']['post']), PDO::PARAM_INT);
    $sql->bindParam(4, ($_SESSION['company']['address']), PDO::PARAM_STR);
    $sql->bindParam(5, ($_SESSION['company']['tel']), PDO::PARAM_STR);
    $sql->bindParam(6, ($_SESSION['company']['industry']), PDO::PARAM_STR);
    $sql->bindParam(7, $employee_id, PDO::PARAM_INT);
    $sql->bindParam(8, ($_SESSION['company']['ceo']), PDO::PARAM_STR);
    $sql->bindParam(9, ($_SESSION['company']['capital']), PDO::PARAM_STR);
    $sql->bindParam(10, ($_SESSION['company']['number']), PDO::PARAM_STR);
    $sql->bindParam(11, ($_SESSION['company']['settlement']), PDO::PARAM_STR);
    $sql->bindParam(12, ($_SESSION['company']['website']), PDO::PARAM_STR);
    $sql->bindParam(13, ($_SESSION['company']['code']), PDO::PARAM_STR);
    if ($sql->execute()) {
        $_SESSION['message'] = '更新が完了しました。';
    } else {
        $_SESSION['message'] = '更新中にエラーが発生しました。';
    }
    //セッション内容のリセット
    unset($_SESSION['company']);
    unset($_SESSION['company_id']);
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/company.php');
}
?>