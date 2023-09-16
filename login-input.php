<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>ログイン</h2>
<hr>
<div class="body">
<?php
//企業セッションリセット
unset($_SESSION['company']);
unset($_SESSION['company_id']);
//担当者セッションのリセット
unset($_SESSION['customer']);
//案件セッションのリセット
unset($_SESSION['opportunity']);
//日報セッションのリセット
unset($_SESSION['report']);
//企業エラーのリセット
unset($_SESSION['error_company']);
//担当者エラーのリセット
unset($_SESSION['error_customer']);
//案件エラーのリセット
unset($_SESSION['error_opportunity']);
//日報エラーのリセット
unset($_SESSION['error_report']);

echo '<font color="crimson">'.$_SESSION['input_error'].'</font>';
unset($_SESSION['input_error']);
?>
<form action="login-output.php" method="post">
ログインID：<input type="text" name="login_id"><br>
パスワード：<input type="password" name="login_pass"><br>
<button type="submit" name="action" value="login">ログイン</button>
</form>
</div>

<?php require('footer.php'); ?>
