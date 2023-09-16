<?php require('header.php'); ?>
<?php require('menu.php'); ?>

<?php
echo $_SESSION['message'];
unset($_SESSION['message']);
try {
    $sql = $db->query('SELECT * FROM industry');
    $sql->execute();
} catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
}?>

<?php
$sql=$db->prepare('SELECT * FROM company c LEFT JOIN industry i ON c.industry_id = i.id 
LEFT JOIN employee e ON e.id = c.employee_id WHERE code=?');
$sql->bindParam(1, $_REQUEST['id'], PDO::PARAM_INT);
$sql->execute();
foreach($sql as $row) {
  $code = $row['code'];
  $company_name = $row['company_name'];
  $kana = $row['kana'];
  $post = $row['post'];
  $address = $row['address'];
  $tel = $row['tel'];
  $industry_name = $row['industry_name'];
  $employee_name = $row['employee_name'];
  $ceo = $row['ceo'];
  $capital = $row['capital'];
  $number = $row['number'];
  $settlement = $row['settlement'];
  $website = $row['website'];
}
?>
<h2><?php echo $company_name; ?></h2>
<hr>
<div class="wrapper">
  <ul class="tab">
    <li><a href="#company">企業詳細</a></li>
    <li><a href="#customer">担当者詳細</a></li>
    <li><a href="#opportunity">案件詳細</a></li>
  </ul>

  <!--company-->
  <div id="company" class="area">
  <table>
    <tr>
      <td class="center"><span class="font">法人番号</span></td>
      <td><?php echo $code; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">企業名</span></td>
      <td><?php echo $company_name; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">カナ名</span></td>
      <td><?php echo $kana;?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">郵便番号</span></td>
      <td><?php echo $post; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">住所</span></td>
      <td><?php echo $address; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">電話番号</span></td>
      <td><?php echo $tel; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">業種</span></td>
      <td><?php echo $industry_name; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">自社担当者</span></td>
      <td><?php echo $employee_name; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">代表者名</span></td>
      <td><?php echo $ceo; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">資本金</span></td>
      <td><?php echo $capital; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">従業員数</span></td>
      <td><?php echo $number; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">決算月</span></td>
      <td><?php echo $settlement; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">ホームページURL</span></td>
      <td><?php echo $website; ?></td>
    </tr>
    <tr>
      <td></td>
      <td><button type="button" onclick="location.href='company.php?id=<?php echo $code; ?>'">変更</button></td>
    </tr>
  </table>
  </div>
  <!--/company-->

  <!--customer-->
  <div id="customer" class="area">
  <?php
  $sql=$db->prepare('SELECT cu.id, cu.customer_name, cu.customer_kana, cu.department, cu.position, cu.tel AS TEL, cu.mail, cu.notes FROM customer cu LEFT JOIN company co ON cu.company_id = co.code WHERE cu.company_id=?');
  $sql->bindParam(1, $_REQUEST['id'], PDO::PARAM_INT);
  $sql->execute();
  $count = $sql -> rowCount();
  foreach($sql as $row) {
    $customer_id = $row['id'];
    $customer_name = $row['customer_name'];
    $customer_kana = $row['customer_kana'];
    $department = $row['department'];
    $position = $row['position'];
    $tel = $row['TEL'];
    $mail = $row['mail'];
    $notes = $row['notes'];
  
  if($count!==0) {
  ?>
  <table>
    <tr>
      <td class="center"><span class="font">取引先担当者</span></td>
      <td><?php echo $customer_name; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">担当者名カナ</span></td>
      <td><?php echo $customer_kana; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">部署</span></td>
      <td><?php echo $department;?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">役職</span></td>
      <td><?php echo $position; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">電話番号</span></td>
      <td><?php echo $tel; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">メールアドレス</span></td>
      <td><?php echo $mail; ?></td>
    </tr>
    <tr>
      <td class="center"><span class="font">備考</span></td>
      <td><?php echo $notes; ?></td>
    </tr>
    <tr>
      <td></td>
      <td><button type="button" onclick="location.href='customer.php?id=<?php echo $customer_id; ?>'">変更</button></td>
    </tr>
    <tr>
      <td></td>
    </tr>
  </table>
  <?php
  } else {
    ?>
    <p>登録がありません。</p>
  <?php } 
  }?>

  <!--/customer--></div>
  
  <!--opportunity-->
  <div id="opportunity" class="area">
  <?php
  $sql=$db->prepare('SELECT o.id AS opportunity_id, o.opportunity, o.selling_price, o.purchase_price, e.employee_name, 
  o.occur_day, o.expected_day, ph.phase, po.possibility FROM opportunity o LEFT JOIN phase ph ON o.phase_id = ph.id
  LEFT JOIN possibility po ON o.possibility_id = po.id LEFT JOIN employee e ON o.employee_id = e.id WHERE o.company_id=?');
  $sql->bindParam(1, $_REQUEST['id'], PDO::PARAM_INT);
  $sql->execute();
  $count = $sql -> rowCount();
  //案件の登録がある場合、表示
  if($count!==0) {
    foreach($sql as $row) {
      $opportunity_id = $row['opportunity_id'];
      $opportunity = $row['opportunity'];
      $selling_price = $row['selling_price'];
      $purchase_price = $row['purchase_price'];
      $employee = $row['employee_name'];
      $occur_day = str_replace('-', '/', $row['occur_day']);
      $expected_day = str_replace('-', '/', $row['expected_day']);
      $phase = $row['phase'];
      $possibility = $row['possibility'];
    ?>
      <table>
        <tr>
          <td class="center"><span class="font">案件名</span></td>
          <td><?php echo $opportunity; ?></td>
        </tr>
        <tr>
          <td class="center"><span class="font">売価</span></td>
          <td><?php echo number_format($selling_price).'円'; ?></td>
        </tr>
        <tr>
          <td class="center"><span class="font">仕入</span></td>
          <td><?php echo number_format($purchase_price).'円';?></td>
        </tr>
        <tr>
          <td class="center"><span class="font">自社担当者</span></td>
          <td><?php echo $employee;?></td>
        </tr>
        <tr>
          <td class="center"><span class="font">案件発生日</span></td>
          <td><?php echo $occur_day; ?></td>
        </tr>
        <tr>
          <td class="center"><span class="font">受注予定日</span></td>
          <td><?php echo $expected_day; ?></td>
        </tr>
        <tr>
          <td class="center"><span class="font">フェーズ</span></td>
          <td><?php echo $phase; ?></td>
        </tr>
        <tr>
          <td class="center"><span class="font">確度</span></td>
          <td><?php echo $possibility; ?></td>
        </tr>
        <tr>
          <td></td>
          <td><button type="button" onclick="location.href='opportunity.php?id=<?php echo $opportunity_id; ?>'">変更</button></td>
        </tr>
        <tr>
          <td></td>
        </tr>
      </table>

      <?php
      //日報sql
      $report_sql=$db->prepare('SELECT r.id AS report_id, m.method, p.purpose, cu.customer_name, r.memo, e.employee_name, 
      r.date, r.hour, r.min, r.timer FROM report r LEFT JOIN method m ON r.method_id = m.id 
      LEFT JOIN purpose p ON r.purpose_id = p.id LEFT JOIN customer cu ON r.customer_id = cu.id 
      LEFT JOIN employee e ON r.employee_id = e.id WHERE r.opportunity_id=?');
      $report_sql->bindParam(1, $opportunity_id, PDO::PARAM_INT);
      $report_sql->execute(); ?>
      <ul class="accordion-area">
        <?php   
        foreach($report_sql as $row) {
          $report_id = $row['report_id'];
          $method = $row['method'];
          $purpose = $row['purpose'];
          $customer_name = $row['customer_name'];
          $memo = $row['memo'];
          $employee_name = $row['employee_name'];
          $date = str_replace('-', '/', $row['date']);
          $hour = $row['hour'];
          $min = $row['min'];
          $timer = $row['timer']; ?>

        <li>
        <section>
          <h3 class="title"><?php echo $date.'　'.$purpose.'　　取引先担当者：'.$customer_name.'／自社担当者：'.$employee_name; ?></h3>
          <div class="box">
          <table>
            <tr>
              <td class="center" width=100><span class="font">営業手法</span></td>
              <td><?php echo $method; ?></td>
            </tr>
            <tr>
              <td class="center"><span class="font">内容</span></td>
              <td><?php echo $memo; ?></td>
            </tr>
            <tr>
              <td class="center"><span class="font">時刻</span></td>
              <?php $min = sprintf('%02d', $_SESSION['report']['min'])?>
              <td><?php echo $hour.'：'.$min; ?></td>
            </tr>
            <tr>
              <td class="center"><span class="font">所要時間(分)</span></td>
              <td><?php echo $timer.'分'; ?></td>
            </tr>
            <tr>
              <td><button type="button" onclick="location.href='report.php?id=<?php echo $report_id; ?>'">変更</button></td>
            </tr>
          </table>
          </div>
        </section>
        </li>
        <?php
        } 
        ?>
      </ul>
    <?php
    }
  //案件の登録がない場合
  } else { ?>
    <p>案件の登録がありません。</p>
  <?php } ?>
  <!--/opportunity--></div>
<!--wrapper--></div>
<?php require('footer-detail.php'); ?>
