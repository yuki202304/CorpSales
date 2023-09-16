<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>行動登録</h2>
<hr>
<?php
if($_SESSION['report_id']===NULL) { ?>
  <p>下記内容で登録しました。</p>
<?php
} else { ?>
  <p>下記内容で更新しました。</p>
<?php }

if($_SESSION['report']!==NULL) {
  try {
    $method_sql = $db->prepare('SELECT * FROM method WHERE id=?');
    $method_sql->bindParam(1, h($_SESSION['report']['method_id']), PDO::PARAM_INT);
    $method_sql->execute();
    $purpose_sql = $db->prepare('SELECT * FROM purpose WHERE id=?');
    $purpose_sql->bindParam(1, h($_SESSION['report']['purpose_id']), PDO::PARAM_INT);
    $purpose_sql->execute();
  } catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
  }
  foreach($method_sql as $row) {
    $method = $row['method'];
  }
  foreach($purpose_sql as $row) {
    $purpose = $row['purpose'];
  }
  $company = $_SESSION['report']['company'];
  $opportunity = $_SESSION['report']['opportunity'];
  $customer = $_SESSION['report']['customer'];
  $memo = $_SESSION['report']['memo'];
  $employee = $_SESSION['report']['employee'];
  $start = $_SESSION['report']['start'];
  $min = $_SESSION['report']['min'];
  $min = sprintf('%02d', $min);
  $hour = $_SESSION['report']['hour'];
  $timer = $_SESSION['report']['timer'];
}

?>
<div class="body">
<table>
  <tr>
    <td class="center" width=100><span class="font">営業手法</span></td>
    <td><?php echo $method; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">目的</span></td>
    <td><?php echo $purpose; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">関連先企業</span></td>
    <td><?php echo $company; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">関連先案件</span></td>
    <td><?php echo $opportunity; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">取引先担当者</span></td>
    <td><?php echo $customer; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">内容</span></td>
    <td><?php echo $memo; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">自社担当者</span></td>
    <td><?php echo $employee; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">日付</span></td>
    <td><?php echo $start; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">時刻</span></td>
    <?php ?>
    <td><?php echo $hour.'：'.$min; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">所要時間(分)</span></td>
    <td><?php echo $timer.'分'; ?></td>
  </tr>
</table>
<input type="button" onclick="location.href='history.php'" value="企業一覧へ">
<input type="button" onclick="location.href='report.php'" value="行動登録へ">
</div>
<?php 
unset($_SESSION['report']);
unset($_SESSION['report_id']); ?>
<?php require('footer.php'); ?>