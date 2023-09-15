<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>企業登録</h2>
<hr>
<?php
echo '<p>'.$_SESSION['message'].'</p>';
unset($_SESSION['message']); ?>
<div class="body">
<?php
//担当者セッションのリセット
unset($_SESSION['customer']);
unset($_SESSION['customer_id']);
//案件セッションのリセット
unset($_SESSION['opportunity']);
unset($_SESSION['opportunity_id']);
//日報セッションのリセット
unset($_SESSION['report']);
unset($_SESSION['report_id']);
//担当者エラーのリセット
unset($_SESSION['error_customer']);
//案件エラーのリセット
unset($_SESSION['error_opportunity']);
//日報エラーのリセット
unset($_SESSION['error_report']);


try {
    $industry_sql = $db->query('SELECT * FROM industry');
    $industry_sql->execute();
} catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
}

//idを受け取った場合
if($_REQUEST['id']!==NULL) {
    $_SESSION['company_id'] = $_REQUEST['id'];
    try {
        $sql = $db->prepare('SELECT * FROM company c LEFT JOIN employee e ON c.employee_id = e.id WHERE code=?');
        $sql->bindParam(1, h($_REQUEST['id']), PDO::PARAM_INT);
        $sql->execute();
    } catch(PDOException $e) {
        echo('エラーメッセージ：'.$e->getMessage());
    }
    foreach($sql as $row) {
        $code = $row['code'];
        $company_name = $row['company_name'];
        $kana = $row['kana'];
        $post = $row['post'];
        $address = $row['address'];
        $tel = $row['tel'];
        $industry_id = $row['industry_id'];
        $employee_name = $row['employee_name'];
        $ceo = $row['ceo'];
        $capital = $row['capital'];
        $number = $row['number'];
        $settlement = $row['settlement'];
        $website = $row['website'];
    }}
?>
<form class="h-adr" action="companyCheck.php" method="post">
    <span class="p-country-name" style="display:none;">Japan</span>
    <table>
    <tr>
        <td>＊は入力必須項目です</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td class="center"><span class="font">法人番号(＊)</span></td>
        <td><input type="text" name="code" placeholder="1234567890000" value="<?php if($_REQUEST['id']!==NULL) {
            echo $code;
            } else {
                echo $_SESSION['company']['code'];
            }?>" <?php if($_SESSION['company_id']!==NULL) {
                echo 'readonly';
            } ?>></td>
        <td><?php echo '<font color="crimson">'.$_SESSION['error_company']['code'].'</font>'; ?></td>
    </tr>
    <tr>
        <td colspan="2"><a href="https://www.houjin-bangou.nta.go.jp" target="_blank">法人番号検索はこちらから</a></td>
        <td></td>
    </tr>
    <tr>
        <td class="center"><span class="font">企業名(＊)</span></td>
        <td><input type="text" name="name" placeholder="○○株式会社" value="<?php if($_REQUEST['id']!==NULL) {
            echo $company_name;
            } else {
            echo $_SESSION['company']['name'];
            } ?>"></td>
        <td><?php echo '<font color="crimson">'.$_SESSION['error_company']['name'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">カナ名(＊)</span></td>
        <td><input type="text" name="kana" placeholder="マルマル" value="<?php if($_REQUEST['id']!==NULL) {
            echo $kana;
            } else {
            echo $_SESSION['company']['kana'];
            } ?>"></td>
        <td><?php echo '<font color="crimson">'.$_SESSION['error_company']['kana'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">郵便番号(＊)</span></td>
        <td><input type="text" name="post" placeholder="1000001" class="p-postal-code" size="8" maxlength="8" 
        value="<?php if($_REQUEST['id']!==NULL) {
            echo $post;
            } else {
            echo $_SESSION['company']['post'];
            } ?>"></td>
        <td><?php echo '<font color="crimson">'.$_SESSION['error_company']['post'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">住所(＊)</span></td>
        <td><input type="text" name="address" placeholder="東京都千代田区千代田○○" class="p-region p-locality p-street-address p-extended-address" size="27" 
        value="<?php if($_REQUEST['id']!==NULL) {
            echo $address;
            } else {
            echo $_SESSION['company']['address'];
            } ?>" /></td>
        <td><?php echo '<font color="crimson">'.$_SESSION['error_company']['address'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">電話番号(＊)</span></td>
        <td><input type="text" name="tel" placeholder="0312345678" value="<?php if($_REQUEST['id']!==NULL) {
            echo $tel;
            } else {
            echo $_SESSION['company']['tel'];
            } ?>"></td>
        <td><?php echo '<font color="crimson">'.$_SESSION['error_company']['tel'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">業種(＊)</span></td>
        <td><select name="industry">
                <option value="">こちらから選択してください</option>
                <?php foreach($industry_sql as $row) {?>
                    <option value="<?php echo $row['id']; ?>"<?php if($industry_id===$row['id']) {
                        echo 'selected';
                    }elseif($_SESSION['company']['industry']===$row['id']) {
                        echo 'selected';
                    } ?>>
                    <?php echo $row['industry_name'];?>
                    </option>
                <?php }?> 
            </select></td>
        <td><?php echo '<font color="crimson">'.$_SESSION['error_company']['industry'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">自社担当者(＊)</span></td>
        <td><input type="text" id="employee" name="employee" value="<?php if($_REQUEST['id']!==NULL) {
            echo $employee_name;
        }elseif($_SESSION['company']['employee']==="") {
            echo $_SESSION['company']['employee'];
        } else {
            echo $_SESSION['login']['name']; 
        } ?>"></td>
        <td><?php echo '<font color="crimson">'.$_SESSION['error_company']['employee'].'</font>'; ?></td>
    </tr>
    <tr>
        <td class="center"><span class="font">代表者名</span></td>
        <td><input type="text" name="ceo" placeholder="広島太郎" value="<?php if($_REQUEST['id']!==NULL) {
            echo $ceo;
            } else {
            echo $_SESSION['company']['ceo'];
            } ?>"></td>
        <td></td>
    </tr>
    <tr>
        <td class="center"><span class="font">資本金</span></td>
        <td><input type="text" name="capital" placeholder="5000万円" value="<?php if($_REQUEST['id']!==NULL) {
            echo $capital;
            } else {
            echo $_SESSION['company']['capital'];
            } ?>"></td>
        <td></td>
    </tr>
    <tr>
        <td class="center"><span class="font">従業員数</span></td>
        <td><input type="text" name="number" placeholder="50人" value="<?php if($_REQUEST['id']!==NULL) {
            echo $number;
            } else {
            echo $_SESSION['company']['number'];
            } ?>"></td>
        <td></td>
    </tr>
    <tr>
        <td class="center"><span class="font">決算月</span></td>
        <td><input type="text" name="settlement" placeholder="3月" value="<?php if($_REQUEST['id']!==NULL) {
            echo $settlement;
            } else {
            echo $_SESSION['company']['settlement'];
            } ?>"></td>
        <td></td>
    </tr>
    <tr>
        <td class="center"><span class="font">ホームページURL</span></td>
        <td><input type="text" name="website" placeholder="https://www.○○.co.jp" value="<?php if($_REQUEST['id']!==NULL) {
            echo $website;
            } else {
            echo $_SESSION['company']['website'];
            } ?>"></td>
        <td></td>
    </tr>
    </table>
    <input type="submit" value="登録">
    <?php
    //リクエストIDがあるまたは編集セッション用IDがある場合
    if($_REQUEST['id']!==NULL || $_SESSION['company_id']===NULL) { ?>
        <button type="button" onclick="location.href='history-detail.php?id=<?php echo $_REQUEST['id']; ?>'">戻る</button>
    <?php
    } else { ?>
        <button type="button" onclick="location.href='history.php'">トップ</button>
    <?php } ?>
</form>
</div>
<?php require('footer.php'); ?>