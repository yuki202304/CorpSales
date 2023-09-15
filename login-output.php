<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>ログイン画面</h2>
<hr>
<div class="body">
<?php
try {
  $sql = $db->prepare('SELECT * FROM employee WHERE id=? AND password=?');
  $sql->bindParam(1, h($_REQUEST['login_id']), PDO::PARAM_STR);
  $sql->bindParam(2, h($_REQUEST['login_pass']), PDO::PARAM_STR);
  $sql->execute();
  //セッションに名前を格納
  foreach($sql as $row) {
      $_SESSION['login'] = [
          'id'=>$row['id'], 'name'=>$row['employee_name'], 'password'=>$row['password'], 
          'department'=>$row['department_id']];
  }
} catch(PDOException $e) {
  echo('エラーメッセージ：'.$e->getMessage());
}

if (isset($_SESSION['login'])) {
    echo 'ログインしました。', $_SESSION['login']['name'], 'さん。<br><br>'; ?>
    <button type="button" onclick="location.href='index.php'">トップへ</button>
<?php 
} else {
    $_SESSION['input_error'] = 'ログイン名またはパスワードが違います。<br>';
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/login-input.php');
}
?>
</div>
<?php require('footer.php'); ?>