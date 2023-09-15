<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>ログアウト</h2>
<hr>
<div class="body">
<p>ログアウトしました。</p>
<button type="button" onclick="location.href='login-input.php'">ログイン</button>
<?php unset($_SESSION['login']); ?>
</div>
<?php require('footer.php'); ?>