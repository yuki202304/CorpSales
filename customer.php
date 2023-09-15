<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>担当者登録</h2>
<hr>
<?php
echo '<p>'.$_SESSION['message'].'</p>';
unset($_SESSION['message']);
?>
<div class="body">
<?php
//企業セッションリセット
unset($_SESSION['company']);
unset($_SESSION['company_id']);
//案件セッションのリセット
unset($_SESSION['opportunity']);
unset($_SESSION['opportuniry_id']);
//日報セッションのリセット
unset($_SESSION['report']);
unset($_SESSION['report_id']);
//企業エラーのリセット
unset($_SESSION['error_company']);
//案件エラーのリセット
unset($_SESSION['error_opportunity']);
//日報エラーのリセット
unset($_SESSION['error_report']);

//idを受け取った場合
if($_REQUEST['id']!=="") {
  $_SESSION['customer_id'] = $_REQUEST['id'];
  try {
    $sql = $db->prepare('SELECT cu.company_id, co.company_name, cu.customer_name, cu.customer_kana, cu.department, 
    cu.position, cu.tel, cu.mail, cu.notes FROM customer cu LEFT JOIN company co ON cu.company_id = co.code WHERE cu.id=?');
    $sql->bindParam(1, h($_REQUEST['id']), PDO::PARAM_INT);
    $sql->execute();
  } catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
  }
  foreach($sql as $row) {
    $company_id = $row['company_id'];
    $company_name = $row['company_name'];
    $customer_name = $row['customer_name'];
    $customer_kana = $row['customer_kana'];
    $department = $row['department'];
    $position = $row['position'];
    $tel = $row['tel'];
    $mail = $row['mail'];
    $notes = $row['notes'];
  }
}
?>
<form action="customerCheck.php" method="post">
<table>
  <tr>
    <td>＊は入力必須項目です</td>
  </tr>
  <tr>
    <td class="center"><span class="font">関連先企業(＊)</span></td>
    <td><input type="text" id="company" name="company" placeholder="○○株式会社" value="<?php if($_REQUEST['id']!==NULL) {
            echo $company_name;
            } else {
            echo $_SESSION['customer']['company'];
            } ?>" <?php if($_SESSION['customer_id']!==NULL) {
              echo 'readonly';
          } ?>/>
    <?php echo '<font color="RED">'.$_SESSION['error_customer']['company'].'</font>'; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">取引先担当者(＊)</span></td>
    <td><input type="text" name="customer" placeholder="広島太郎" value="<?php if($_REQUEST['id']!==NULL) {
            echo $customer_name;
            } else {
            echo $_SESSION['customer']['customer'];
            } ?>">
    <?php echo '<font color="RED">'.$_SESSION['error_customer']['customer'].'</font>'; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">担当者名カナ</span></td>
    <td><input type="text" name="customer_kana" placeholder="ヤマダタロウ" value="<?php if($_REQUEST['id']!==NULL) {
            echo $customer_kana;
            } else {
            echo $_SESSION['customer']['customer_kana'];
            } ?>"></td>
  </tr>
  <tr>
    <td class="center"><span class="font">部署</span></td>
    <td><input type="text" name="department" placeholder="総務部" value="<?php if($_REQUEST['id']!==NULL) {
            echo $department;
            } else {
            echo $_SESSION['customer']['department'];
            } ?>"></td>
  </tr>
  <tr>
    <td class="center"><span class="font">役職</span></td>
    <td><input type="text" name="position" placeholder="部長" value="<?php if($_REQUEST['id']!==NULL) {
            echo $position;
            } else {
            echo $_SESSION['customer']['position'];
            } ?>"></td>
  </tr>
  <tr>
    <td class="center"><span class="font">電話番号</span></td>
    <td><input type="text" name="tel" placeholder="090○○○○○○○○" value="<?php if($_REQUEST['id']!==NULL) {
            echo $tel;
            } else {
            echo $_SESSION['customer']['tel'];
            } ?>"></td>
  </tr>
  <tr>
    <td class="center"><span class="font">メールアドレス</span></td>
    <td><input type="text" name="mail" placeholder="yamada@○○.co.jp" value="<?php if($_REQUEST['id']!==NULL) {
            echo $mail;
            } else {
            echo $_SESSION['customer']['mail'];
            } ?>"></td>
  </tr>
  <tr>
    <td class="center"><span class="font">備考</span></td>
    <td><textarea name="notes" cols="40" rows="5"><?php if($_REQUEST['id']!==NULL) {
            echo $notes;
            } else {
            echo $_SESSION['customer']['notes'];
            } ?></textarea></td>
  </tr>
</table>
<input type="submit" value="登録">
<?php
    //リクエストIDがあるまたは編集セッション用IDがある場合
    if($_REQUEST['id']!==NULL || $_SESSION['customer_id']===NULL) { ?>
        <button type="button" onclick="location.href='history-detail.php?id=<?php echo $company_id; ?>'">戻る</button>
    <?php
    } else { ?>
        <button type="button" onclick="location.href='history.php'">トップ</button>
    <?php } ?>
</form>
</div>
<?php require('footer.php'); ?>