<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>案件登録</h2>
<hr>
<?php
echo '<p>'.$_SESSION['message'].'</p>';
unset($_SESSION['message']);

//企業セッションリセット
unset($_SESSION['company']);
unset($_SESSION['company_id']);
//担当者セッションのリセット
unset($_SESSION['customer']);
unset($_SESSION['customer_id']);
//日報セッションのリセット
unset($_SESSION['report']);
unset($_SESSION['report_id']);
//企業エラーのリセット
unset($_SESSION['error_company']);
//担当者エラーのリセット
unset($_SESSION['error_customer']);
//日報エラーのリセット
unset($_SESSION['error_report']);

//idを受け取った場合
if($_REQUEST['id']!=="") {
    $_SESSION['opportunity_id'] = $_REQUEST['id'];
    try {
        $sql = $db->prepare('SELECT * FROM opportunity o LEFT JOIN company c ON o.company_id = c.code WHERE o.id=?');
        $sql->bindParam(1, h($_REQUEST['id']), PDO::PARAM_INT);
        $sql->execute();
    } catch(PDOException $e) {
        echo('エラーメッセージ：'.$e->getMessage());
    }
    foreach($sql as $row) {
        $company_id = $row['company_id'];
        $company_name = $row['company_name'];
        $opportunity = $row['opportunity'];
        $selling_price = $row['selling_price'];
        $purchase_price = $row['purchase_price'];
        $occur_day = str_replace('-', '/', $row['occur_day']);
        $expected_day = str_replace('-', '/', $row['expected_day']);
        $phase_id = $row['phase_id'];
        $possibility_id = $row['possibility_id'];
    }}

try {
    $phase = $db->query('SELECT * FROM phase');
    $phase->execute();
    $possibility = $db->query('SELECT * FROM possibility');
    $possibility->execute();
} catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
}
?>
<div class="body">
<form action="opportunityCheck.php" method="post">
<table>
    <tr>
        <td class="center"><span class="font">関連先企業</span></td>
        <td><input type="text" id="company" name="company" placeholder="○○株式会社" value="<?php if($_REQUEST['id']!==NULL) {
            echo $company_name;
            } else {
            echo $_SESSION['opportunity']['company'];
            } ?>" <?php if($_SESSION['opportunity_id']!==NULL) {
                echo 'readonly';
            } ?>/>
        <?php echo '<font color="RED">'.$_SESSION['error_opportunity']['company'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">案件名</span></td>
        <td><input type="text" name="name" placeholder="<?php echo date('Ymd').'_○○○○'; ?>" value="<?php if($_REQUEST['id']!==NULL) {
            echo $opportunity;
            } else {
            echo $_SESSION['opportunity']['name'];
            } ?>">
        <?php echo '<font color="RED">'.$_SESSION['error_opportunity']['name'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">売価</span></td>
        <td><input type="text" name="sell" placeholder="1000000" value="<?php if($_REQUEST['id']!==NULL) {
            echo $selling_price;
            } else {
            echo $_SESSION['opportunity']['sell'];
            } ?>">
        <?php echo '<font color="RED">'.$_SESSION['error_opportunity']['sell'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">仕入</span></td>
        <td><input type="text" name="purchase" placeholder="500000" value="<?php if($_REQUEST['id']!==NULL) {
            echo $purchase_price;
            } else {
            echo $_SESSION['opportunity']['purchase'];
            } ?>">
            <?php echo '<font color="RED">'.$_SESSION['error_opportunity']['purchase'].'</font>'; ?></td>
    </tr>
    <tr>
    <td class="center"><span class="font">自社担当者</span></td>
    <td><input type="text" id="employee" name="employee" value="<?php if($_SESSION['opprtunity']['employee']==="") {
                echo $_SESSION['opportunity']['employee'];
            } else {
                echo $_SESSION['login']['name']; 
            } ?>"><?php echo '<font color="RED">'.$_SESSION['error_opportunity']['employee'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">案件発生日</span></td>
        <td><input type="text" name="start" placeholder="<?php echo date('Y/m/d'); ?>" value="<?php if($_REQUEST['id']!==NULL) {
            echo $occur_day;
            } else {
            echo $_SESSION['opportunity']['start'];
            } ?>">
        <?php echo '<font color="RED">'.$_SESSION['error_opportunity']['start'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">受注予定日</span></td>
        <td><input type="text" name="end" placeholder="<?php echo date('Y/m/d'); ?>" value="<?php if($_REQUEST['id']!==NULL) {
            echo $expected_day;
            } else {
            echo $_SESSION['opportunity']['end'];
            } ?>">
        <?php echo '<font color="RED">'.$_SESSION['error_opportunity']['end'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">フェーズ</span></td>
        <td><select name="phase">
            <?php foreach($phase as $row) { ?>
                <option value="<?php echo $row['id'] ?>"<?php if($phase_id===$row['id']) {
                    echo 'selected';
                }elseif($_SESSION['opportunity']['phase']===$row['id']) {
                    echo 'selected';
                } ?>>
                <?php echo $row['phase'] ?></option>
            <?php } ?></select></td>
    </tr>
    <tr>
        <td class="center"><span class="font">確度</span></td>
        <td><select name="possibility">
            <?php foreach($possibility as $row) { ?>
                <option value="<?php echo $row['id'] ?>"<?php if($possibility_id===$row['id']) {
                    echo 'selected';
                }elseif($_SESSION['opportunity']['possibility']===$row['id']) {
                    echo 'selected';
                } ?>>
                <?php echo $row['possibility'] ?></option>
            <?php } ?></select></td>
    </tr>
</table>
<input type="submit" value="確定">
<?php 
if($_SESSION['opportunity_id']!==NULL) { ?>
    <input type="button" onclick="location.href='history-detail.php?id=<?php echo $company_id; ?>'" value="戻る">
<?php } ?>
</form>
</div>
<?php require('footer.php'); ?>