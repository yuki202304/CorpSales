<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>ログアウト</h2>
<hr>
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

?>
<div class="body">
<p><?php echo $_SESSION['login']['name'], 'さん。ログアウトしますか？'; ?></p>
<button type="button" onclick="location.href='logout-output.php'">ログアウト</button>
<button type="button" onclick="location.href='index.php'">トップへ</button>
</div>
<?php require('footer.php'); ?>
