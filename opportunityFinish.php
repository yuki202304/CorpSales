<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>案件登録</h2>
<hr>
<?php
echo '<p>'.$_SESSION['message'].'</p>';

if($_SESSION['opportunity']===NULL) { ?>
  <div class="body">
    <input type="button" onclick="location.href='history.php'" value="TOPへ">
    <input type="button" onclick="location.href='opportunity.php'" value="案件登録へ">
  </div>
<?php
} else {
  try {
    $phase_sql = $db->prepare('SELECT * FROM phase WHERE id=?');
    $phase_sql->bindParam(1, h($_SESSION['opportunity']['phase']), PDO::PARAM_INT);
    $phase_sql->execute();
    $possibility_sql = $db->prepare('SELECT * FROM possibility WHERE id=?');
    $possibility_sql->bindParam(1, h($_SESSION['opportunity']['possibility']), PDO::PARAM_INT);
    $possibility_sql->execute();
  } catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
  }
  foreach($phase_sql as $row) {
    $phase = $row['phase'];
  }
  foreach($possibility_sql as $row) {
    $possibility = $row['possibility'];
  }

  ?>
  <div class="body">
  <table>
    <tr>
      <td class="center"><span class="font">関連先企業</span></td>
      <td><?php echo $_SESSION['opportunity']['company']; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">案件名</span></td>
      <td><?php echo $_SESSION['opportunity']['name']; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">売価</span></td>
      <td><?php echo number_format($_SESSION['opportunity']['sell']); ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">仕入</span></td>
      <td><?php echo number_format($_SESSION['opportunity']['purchase']); ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">自社担当者</span></td>
      <td><?php echo $_SESSION['opportunity']['employee']; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">案件発生日</span></td>
      <td><?php echo $_SESSION['opportunity']['start']; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">受注予定日</span></td>
      <td><?php echo $_SESSION['opportunity']['end']; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">フェーズ</span></td>
      <td><?php echo $phase; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">確度</span></td>
      <td><?php echo $possibility; ?></textarea></td>
    </tr>
  </table>
  <input type="button" onclick="location.href='history.php'" value="TOPへ">
  <input type="button" onclick="location.href='opportunity.php'" value="案件登録へ">
  </div>
  <?php 
  unset($_SESSION['opportunity']);
  unset($_SESSION['opportunity_id']);
  unset($_SESSION['message']);
}
  ?>
<?php require('footer.php'); ?>