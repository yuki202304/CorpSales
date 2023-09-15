<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>企業登録</h2>
<hr>
<?php
if($_SESSION['company_id']===NULL) {
    echo '<p>登録内容をご確認後、よろしければ確定ボタンを押してください。</p>';

} else {
    echo '<p>変更内容をご確認後、よろしければ確定ボタンを押してください。</p>';
}
?>
<div class="body">
<table>
    <tr>
        <td><span class="font">法人番号</span></td>
        <td><?php echo $_SESSION['company']['code'] ?></td>
    </tr>
    <tr>
        <td><span class="font">企業名</span></td>
        <td><?php echo $_SESSION['company']['name']; ?></td>
    </tr>
    <tr>
        <td><span class="font">カナ名</span></td>
        <td><?php echo $_SESSION['company']['kana']; ?></td>
    </tr>
    <tr>
        <td><span class="font">郵便番号</span></td>
        <td><?php echo $_SESSION['company']['post']; ?></td>
    </tr>
    <tr>
        <td><span class="font">住所</span></td>
        <td><?php echo $_SESSION['company']['address']; ?></td>
    </tr>
    <tr>
        <td><span class="font">電話番号</span></td>
        <td><?php echo $_SESSION['company']['tel']; ?></td>
    </tr>
    <tr>
    <?php
    try {
        $sql = $db->prepare('SELECT * FROM industry WHERE id=?');
        $sql->bindParam(1, h($_SESSION['company']['industry']), PDO::PARAM_INT);
        $sql->execute();
    } catch(PDOException $e) {
        echo('エラーメッセージ：'.$e->getMessage());
    }
    foreach($sql as $row) {
        $industry = $row['industry_name'];
    }
    ?>
        <td><span class="font">業種</span></td>
        <td><?php echo $industry; ?></td>
    </tr>
    <tr>
        <td><span class="font">自社担当者</span></td>
        <td><?php echo $_SESSION['company']['employee']; ?></td>
    </tr>
    <?php if($_SESSION['company']['ceo']!=="") { ?>
    <tr>
        <td><span class="font">代表者名</span></td>
        <td><?php echo $_SESSION['company']['ceo']; ?></td>
    </tr>
    <?php } ?>
    <?php if($_SESSION['company']['capital']!=="") { ?>
    <tr>
        <td><span class="font">資本金</span></td>
        <td><?php echo $_SESSION['company']['capital']; ?></td>
    </tr>
    <?php } ?>
    <?php if($_SESSION['company']['number']!=="") { ?>
    <tr>
        <td><span class="font">従業員数</span></td>
        <td><?php echo $_SESSION['company']['number']; ?></td>
    </tr>
    <?php } ?>
    <?php if($_SESSION['company']['settlement']!=="") { ?>
    <tr>
        <td><span class="font">決算月</span></td>
        <td><?php echo $_SESSION['company']['settlement']; ?></td>
    </tr>
    <?php } ?> 
    <?php if($_SESSION['company']['website']!=="") { ?>
    <tr>
        <td><span class="font">ホームページURL</span></td>
        <td><?php echo $_SESSION['company']['website']; ?></td>
    </tr>
    <?php } ?>
</table>
<input type="button" onclick="location.href='companyInsert.php'" value="確定">
<input type="button" onclick="location.href='company.php'" value="前の画面に戻る">
</div>
<?php require('footer.php'); ?>