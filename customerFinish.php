<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>担当者登録</h2>
<hr>
<?php
echo $_SESSION['message'];

if($_SESSION['message']===NULL) { ?>
  <div class="body">
    <input type="button" onclick="location.href='history.php'" value="TOPへ">
    <input type="button" onclick="location.href='customer.php'" value="担当者登録へ">
  </div>
<?php
} else {
?>
<div class="body">
<table>
  <tr>
    <td class="center"><span class="font">関連先企業</span></td>
    <td><?php echo $_SESSION['customer']['company']; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">取引先担当者</span></td>
    <td><?php echo $_SESSION['customer']['customer']; ?></td>
  </tr>
  <?php
  if($_SESSION['customer']['customer_kana']!=="") { ?>
  <tr>
    <td class="center"><span class="font">担当者名カナ</span></td>
    <td><?php echo $_SESSION['customer']['customer_kana']; ?></td>
  </tr>
  <?php } ?>
  <?php
  if($_SESSION['customer']['department']!=="") { ?>
  <tr>
    <td class="center"><span class="font">部署</span></td>
    <td><?php echo $_SESSION['customer']['department']; ?></td>
  </tr>
  <?php } ?>
  <?php
  if($_SESSION['customer']['position']!=="") { ?>
  <tr>
    <td class="center"><span class="font">役職</span></td>
    <td><?php echo $_SESSION['customer']['position']; ?></td>
  </tr>
  <?php } ?>
  <?php
  if($_SESSION['customer']['tel']!=="") { ?>
  <tr>
    <td class="center"><span class="font">電話番号</span></td>
    <td><?php echo $_SESSION['customer']['tel']; ?></td>
  </tr>
  <?php } ?>
  <?php
  if($_SESSION['customer']['mail']!=="") { ?>
  <tr>
    <td class="center"><span class="font">メールアドレス</span></td>
    <td><?php echo $_SESSION['customer']['mail']; ?></td>
  </tr>
  <?php } ?>
  <?php
  if($_SESSION['customer']['notes']!=="") { ?>
  <tr>
    <td class="center"><span class="font">備考</span></td>
    <td><?php echo $_SESSION['customer']['notes']; ?></textarea></td>
  </tr>
  <?php } ?>
</table>
<input type="button" onclick="location.href='history.php'" value="TOPへ">
<input type="button" onclick="location.href='customer.php'" value="担当者登録へ">
<?php }
unset($_SESSION['customer']);
unset($_SESSION['customer_id']);
unset($_SESSION['message']);
?>
</div>
<?php require('footer.php'); ?>