<?php require('header.php'); ?>
<?php require('menu.php'); ?>
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


//ページネーション用情報
if (!isset($_REQUEST['page'])) {
    $now = 1;
    $pageno = 10 * ($now - 1);
} else {
    $now = $_REQUEST['page'];
    $pageno = 10 * ($now - 1);
}
?>

<h2>企業一覧</h2>
<form action="" methid="post">
企業検索
<input type="text" name="search_name">
<button type="submit" name="action" value="search">検索</button>
<button type="submit" name="action" value="list">全件表示</button>
</form>
<hr>
<h3><?php echo $hname; ?></h3>
<div class="body">
<table>
  <tr>
      <th width=120>法人番号</th>
      <th width=230>企業名</th>
      <th width=400>住所</th>
      <th width=120>電話番号</th>
      <th width=110>自社担当者</th>
  </tr>
  <tr><td></td></tr>

<form action="companyInsert.php" method="post">
<?php
//検索押下時
if($_REQUEST['action']==='search') {
  $sql=$db->prepare('SELECT * FROM company c LEFT JOIN employee e ON e.id = c.employee_id WHERE c.code=? OR c.company_name LIKE ? OR c.address LIKE ? OR c.tel=? OR e.employee_name=?');
  $sql->bindParam(1, $_REQUEST['search_name'], PDO::PARAM_INT);
  $search_name = "%".$_REQUEST['search_name']."%";
  $sql->bindParam(2, $search_name, PDO::PARAM_STR);
  $sql->bindParam(3, $search_name, PDO::PARAM_INT);
  $sql->bindParam(4, $_REQUEST['search_name'], PDO::PARAM_STR);
  $sql->bindParam(5, $_REQUEST['search_name'], PDO::PARAM_STR);
  $sql->execute();
  //ページネーション用の情報
  $counts = $db->prepare('SELECT COUNT(*) as cnt FROM company c LEFT JOIN employee e ON e.id = c.employee_id WHERE c.code=? OR c.company_name LIKE ? OR c.address LIKE ? OR c.tel=? OR e.employee_name=?');
  $counts->bindParam(1, $_REQUEST['search_name'], PDO::PARAM_INT);
  $search_name = "%".$_REQUEST['search_name']."%";
  $counts->bindParam(2, $search_name, PDO::PARAM_STR);
  $counts->bindParam(3, $search_name, PDO::PARAM_INT);
  $counts->bindParam(4, $_REQUEST['search_name'], PDO::PARAM_STR);
  $counts->bindParam(5, $_REQUEST['search_name'], PDO::PARAM_STR);
  $counts->execute();
  $count = $counts->fetch();
  $count = $count['cnt'];
    
  foreach($sql as $row) { ?>
    <tr>
      <td><a href="https://www.houjin-bangou.nta.go.jp/henkorireki-johoto.html?selHouzinNo=<?php echo $row['code'] ?>">
      <?php echo $row['code'] ?></a></td>
      <td><?php echo $row['company_name'] ?></td>
      <td><?php echo $row['address'] ?></td>
      <td><?php echo $row['tel'] ?></td>
      <td><?php echo $row['employee_name'] ?></td>
      <td><button type="button" onclick="location.href='history-detail.php?id=<?php echo $row['code']; ?>'">詳細</button>
      </td>
    </tr>
  <?php } ?>
  <?php
//初期表示
} else {
  try {
    $sql = $db->prepare('SELECT * FROM company c LEFT JOIN employee e ON e.id = c.employee_id GROUP BY c.code LIMIT ?, 10');
    $pageno = 10 * ($now - 1);
    $sql->bindParam(1, $pageno, PDO::PARAM_INT);
    $sql->execute();
  } catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
  }
  //ページネーション用のSQL
  $counts = $db->query('SELECT COUNT(*) as cnt FROM company c LEFT JOIN employee e ON e.id = c.employee_id');
  $count = $counts->fetch();
  $count = $count['cnt']; //ページネーション用の情報
?>
  <?php foreach($sql as $row) { ?>
    <tr>
      <td><a href="https://www.houjin-bangou.nta.go.jp/henkorireki-johoto.html?selHouzinNo=<?php echo $row['code']; ?>"><?php echo $row['code'] ?></a></td>
      <td><?php echo $row['company_name'] ?></td>
      <td><?php echo $row['address'] ?></td>
      <td><?php echo $row['tel'] ?></td>
      <td><?php echo $row['employee_name'] ?></td>
      <td><button type="button" onclick="location.href='history-detail.php?id=<?php echo $row['code']; ?>'">詳細</button>
      </td>
    </tr>
  <?php }} ?>
</table>
</form>
</div>
<?php
define('MAX', '10');
$maxpage = ceil($count / MAX);

// もし7件以上の商品がある場合、ページネーション表示
if (($count > 10)) :
?>
  <div class="pagenation fs-b opacity">
  <?php if ($now > 1) : ?>
    <a href="history.php?page=<?php echo ($now - 1); ?>"><<< </a>
  <?php endif; ?>
  <?php for ($i = 1; $i <= $maxpage; $i++) : ?>
    <a class="<?php echo ($i == $now ? 'colorchange' : ''); ?>" href="history.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
  <?php endfor; ?>
  <?php if ($now < $maxpage) : ?>
    <a href="history.php?page=<?php echo ($now + 1); ?>">>></a>
  <?php endif; ?>
  </div>
<?php endif; ?>

<?php require('footer.php'); ?>