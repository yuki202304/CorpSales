<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<h2>日報入力</h2>
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
//案件セッションのリセット
unset($_SESSION['opportunity']);
unset($_SESSION['opportunity_id']);
//企業エラーのリセット
unset($_SESSION['error_company']);
//担当者エラーのリセット
unset($_SESSION['error_customer']);
//案件エラーのリセット
unset($_SESSION['error_opportunity']);

//登録ボタン押したとき
if($_REQUEST['action']==="send") {
  try {
    //取引先企業の存在確認
    $sql = $db->prepare('SELECT * FROM company WHERE company_name=?');
    $sql->bindParam(1, h($_REQUEST['company']), PDO::PARAM_STR);
    $sql->execute();
    $count = $sql -> rowCount();
    foreach($sql as $row) {
      $company_id = $row['code'];
    }

    $opportunity_id = $_REQUEST['opportunity_id'];//案件ID
    $customer_id = $_REQUEST['customer_id'];//取引先担当者ID

    $opportunity = $_REQUEST['opportunity'];//案件名
    $customer = $_REQUEST['customer'];//取引先担当者

    //案件IDから案件名への変換
    if($_REQUEST['opportunity_id']!==NULL) {
      $opportunity_sql = $db->prepare('SELECT * FROM opportunity WHERE id=?');
      $opportunity_sql->bindParam(1, h($_REQUEST['opportunity_id']), PDO::PARAM_INT);
      $opportunity_sql->execute();
      foreach($opportunity_sql as $row) {
        $opportunity = $row['opportunity'];
      }
    }

    //案件名から案件IDへの変換
    if($_REQUEST['opportunity']!==NULL) {
      $opportunity_sql = $db->prepare('SELECT * FROM opportunity WHERE opportunity=?');
      $opportunity_sql->bindParam(1, h($_REQUEST['opportunity']), PDO::PARAM_STR);
      $opportunity_sql->execute();
      foreach($opportunity_sql as $row) {
        $opportunity_id = $row['id'];
      }
    }

    //取引先担当者IDから取引先担当者名への変換
    if($_REQUEST['customer_id']!==NULL) {
      $customer_sql = $db->prepare('SELECT * FROM customer WHERE id=?');
      $customer_sql->bindParam(1, h($_REQUEST['customer_id']), PDO::PARAM_INT);
      $customer_sql->execute();
      foreach($customer_sql as $row) {
        $customer = $row['customer_name'];
      }
    }
    
    //取引先担当者名から取引先担当者IDへの変換
    if($_REQUEST['customer']!==NULL) {
      $customer_sql = $db->prepare('SELECT * FROM customer WHERE customer_name=?');
      $customer_sql->bindParam(1, h($_REQUEST['customer']), PDO::PARAM_STR);
      $customer_sql->execute();
      foreach($customer_sql as $row) {
        $customer_id = $row['id'];
      }
    }

    //自社担当者の存在確認
    $employee_sql = $db->prepare('SELECT * FROM employee WHERE employee_name=?');
    $employee_sql->bindParam(1, h($_REQUEST['employee']), PDO::PARAM_STR);
    $employee_sql->execute();
    $employee_count = $employee_sql -> rowCount();
    foreach($employee_sql as $row) {
      $employee_id = $row['id'];
    }

  $_SESSION['report'] = [
    'method_id' => $_REQUEST['method'], 'purpose_id' => $_REQUEST['purpose'], 
    'company' => $_REQUEST['company'], 'company_id' => $company_id, 'opportunity_id' => $opportunity_id, 
    'opportunity' => $opportunity, 'customer_id' => $customer_id, 'customer' => $customer, 
    'memo' => $_REQUEST['memo'], 'employee' => $_REQUEST['employee'], 'employee_id' => $employee_id, 
    'start' => $_REQUEST['start'], 'hour' => $_REQUEST['hour'], 'min' => $_REQUEST['min'], 'timer' => $_REQUEST['timer']];
  } catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
  }

  unset($_SESSION['error_report']);

  $i="";
  $error_message = 'が未入力です';
  //未入力項目のチェック
  if($_REQUEST['company']==="") {
    $_SESSION['error_report']['company'] = '関連先企業'.$error_message;
    $i++;
  } elseif($count===0) {
    $_SESSION['error_report']['company'] = '関連先企業が存在しません';
    $i++;
  }

  if($_REQUEST['opportunity']==="") {
    $_SESSION['error_report']['opportunity'] = '関連先案件'.$error_message;
    $i++;
  }

  if($_REQUEST['customer']==="") {
    $_SESSION['error_report']['customer'] = '取引先担当者'.$error_message;
    $i++;
  }

  if($_REQUEST['memo']==="") {
    $_SESSION['error_report']['memo'] = '内容'.$error_message;
    $i++; 
  }

  if($_REQUEST['employee']==="") {
    $_SESSION['error_report']['employee'] = '自社担当者'.$error_message;
    $i++;
  } elseif($employee_count===0) {
    $_SESSION['error_report']['employee'] = '自社担当者の登録がありません';
    $i++;
  }

  if($_REQUEST['start']==="") {
    $_SESSION['error_report']['start'] = '日付が未入力'.$error_message;
    $i++;
  }

  if($_REQUEST['hour']==="") {
    $_SESSION['error_report']['hour'] = '時間(時)'.$error_message;
    $i++;
  }

  if($_REQUEST['min']==="m") {
    $_SESSION['error_report']['min'] = '時間(分)'.$error_message;
    $i++;
  }

  if($_REQUEST['timer']==="") {
    $_SESSION['error_report']['timer'] = '所要時間'.$error_message;
    $i++;
  //数字入力チェック
  } elseif(!is_numeric($_REQUEST['timer'])) {
    $_SESSION['error_report']['timer'] = '所要時間は数値で指定してください';
    $i++;
  //ゼロ未満入力チェック
  } elseif($_REQUEST['timer']<=0) {
    $_SESSION['error_report']['timer'] = '所要時間は1以上を指定してください';
    $i++;
  }
  //エラーあれば戻る
  if($i!=="") {
    header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/report.php');
  } else {
    //日付の/を-に置き換える
    $replace = str_replace('/', '-', $_REQUEST['start']);
    if($_SESSION['report_id']===NULL) {
      $sql = $db->prepare('INSERT INTO report SET method_id=?, purpose_id=?, company_id=?, opportunity_id=?, 
      customer_id=?, memo=?, employee_id=?, date=?, hour=?, min=?, timer=?');
      $sql->bindParam(1, h($_REQUEST['method']), PDO::PARAM_INT);
      $sql->bindParam(2, h($_REQUEST['purpose']), PDO::PARAM_INT);
      $sql->bindParam(3, h($company_id), PDO::PARAM_INT);
      $sql->bindParam(4, h($opportunity_id), PDO::PARAM_INT);
      $sql->bindParam(5, h($customer_id), PDO::PARAM_INT);
      $sql->bindParam(6, h($_REQUEST['memo']), PDO::PARAM_STR);
      $sql->bindParam(7, h($employee_id), PDO::PARAM_INT);
      $sql->bindParam(8, $replace, PDO::PARAM_STR);
      $sql->bindParam(9, h($_REQUEST['hour']), PDO::PARAM_INT);
      $sql->bindParam(10, h($_REQUEST['min']), PDO::PARAM_INT);
      $sql->bindParam(11, h($_REQUEST['timer']), PDO::PARAM_INT);
      if ($sql->execute()) {
        header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/reportFinish.php');
      } else { ?>
        <p>登録中にエラーが発生しました。</p>
      <?php
      }
    } else {
      $sql = $db->prepare('UPDATE report SET method_id=?, purpose_id=?, company_id=?, opportunity_id=?, 
      customer_id=?, memo=?, employee_id=?, date=?, hour=?, min=?, timer=? WHERE id=?');
      $sql->bindParam(1, h($_REQUEST['method']), PDO::PARAM_INT);
      $sql->bindParam(2, h($_REQUEST['purpose']), PDO::PARAM_INT);
      $sql->bindParam(3, h($company_id), PDO::PARAM_INT);
      $sql->bindParam(4, h($opportunity_id), PDO::PARAM_INT);
      $sql->bindParam(5, h($customer_id), PDO::PARAM_INT);
      $sql->bindParam(6, h($_REQUEST['memo']), PDO::PARAM_STR);
      $sql->bindParam(7, h($employee_id), PDO::PARAM_INT);
      $sql->bindParam(8, $replace, PDO::PARAM_STR);
      $sql->bindParam(9, h($_REQUEST['hour']), PDO::PARAM_INT);
      $sql->bindParam(10, h($_REQUEST['min']), PDO::PARAM_INT);
      $sql->bindParam(11, h($_REQUEST['timer']), PDO::PARAM_INT);
      $sql->bindParam(12, h($_SESSION['report_id']), PDO::PARAM_INT);
      if ($sql->execute()) {
        header('Location: http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/reportFinish.php');
      } else { ?>
        <p>更新中にエラーが発生しました。</p>
      <?php
      }
    }
  }
}

//検索ボタン押下時
if($_REQUEST['action']==="search") {
  $_SESSION['report']['company'] = $_REQUEST['company'];
}

//idを受け取った場合
if($_REQUEST['id']!==NULL) {
  $_SESSION['report_id'] = $_REQUEST['id'];
  try {
    $sql = $db->prepare('SELECT * FROM report r LEFT JOIN company co ON r.company_id = co.code 
    LEFT JOIN customer cu ON r.customer_id = cu.id LEFT JOIN employee e ON r.employee_id = e.id 
    LEFT JOIN opportunity o ON r.opportunity_id = o.id WHERE r.id=?');
    $sql->bindParam(1, h($_REQUEST['id']), PDO::PARAM_INT);
    $sql->execute();
  } catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
  }
  foreach($sql as $row) {
    $method_id = $row['method_id'];
    $purpose_id = $row['purpose_id'];
    $company_name = $row['company_name'];
    $opportunity = $row['opportunity'];
    $customer_name = $row['customer_name'];
    $memo = $row['memo'];
    $employee_name = $row['employee_name'];
    $date = str_replace('-', '/', $row['date']);
    $hour = $row['hour'];
    $min = $row['min'];
    $timer = $row['timer'];
  }
}

try {
  //営業手法
  $method = $db->query('SELECT * FROM method');
  $method->execute();
  //目的
  $purpose = $db->query('SELECT * FROM purpose');
  $purpose->execute();
} catch(PDOException $e) {
    echo('エラーメッセージ：'.$e->getMessage());
}
?>
<div class="body">
<form action="" method="post">
<span class="p-country-name" style="display:none;">Japan</span>
<table>
  <tr>
    <td class="center"><span class="font">営業手法</span></td>
    <td>
      <select name="method">
      <?php foreach($method as $row) {?>
                    <option value="<?php echo $row['id']; ?>"<?php if($method_id===$row['id']) {
                      echo 'selected';
                    } elseif($_SESSION['report']['method_id']===$row['id']) {
                      echo 'selected';
                    }?>><?php echo $row['method'];?>
                    </option><?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="center"><span class="font">目的</span></td>
    <td>
      <select name="purpose">
      <?php foreach($purpose as $row) {?>
        <?php $list[] = $row['purpose']; ?>
                    <option value="<?php echo $row['id']; ?>"<?php if($purpose_id===$row['id']) {
                      echo 'selected';
                    } elseif($_SESSION['report']['purpose']===$row['id']) {
                      echo 'selected';
                    }?>><?php echo $row['purpose'];?>
                    </option><?php } ?>
      </select>
    </td>
  </tr>
  <tr>
    <td class="center"><span class="font">関連先企業</span></td>
    <td><input type="text" id="company" name="company" placeholder="○○株式会社" value="<?php if($_REQUEST['id']!==NULL) {
            echo $company_name;
            } else {
            echo $_SESSION['report']['company'];
            } ?>"/>　<button type="submit" name="action" value="search">案件・担当者検索</button>
            <?php echo '<font color="RED">'.$_SESSION['error_report']['company'].'</font>'; ?></td>
  </tr>
  <tr>
  <tr>
    <td class="center"><span class="font">関連先案件</span></td>
    <td><?php 
        //検索ボタン押下時
        if($_REQUEST['action']==="search") { ?>
          <select name="opportunity_id">
            <option value="">選択してください</option>
            <?php
            $company_sql = $db->prepare('SELECT * FROM company WHERE company_name=?');
            $company_sql->bindParam(1, $_REQUEST['company'], PDO::PARAM_INT);
            $company_sql->execute();
            foreach($company_sql as $row) {
              $company_code = $row['code'];
            }
            $opportunity_sql = $db->prepare('SELECT * FROM opportunity WHERE company_id=?');
            $opportunity_sql->bindParam(1, $company_code, PDO::PARAM_INT);
            $opportunity_sql->execute();
            foreach($opportunity_sql as $row) { ?>
              <option value="<?php echo $row['id']; ?>"><?php echo $row['opportunity']; ?></option>
            <?php }
          } else { ?>
            <input type="text" name="opportunity" value="<?php if($_REQUEST['id']!==NULL) {
              echo $opportunity;
            } else {
              echo $_SESSION['report']['opportunity'];
            } ?>" readonly>
          <?php }
             ?>
    </select><?php echo '<font color="RED">'.$_SESSION['error_report']['opportunity'].'</font>'; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">取引先担当者</span></td>
    <td><?php 
        //検索ボタン押下時
        if($_REQUEST['action']==="search") { ?>
          <select name="customer_id">
            <option value="">選択してください</option>
            <?php
            $company_sql = $db->prepare('SELECT * FROM company WHERE company_name=?');
            $company_sql->bindParam(1, $_REQUEST['company'], PDO::PARAM_INT);
            $company_sql->execute();
            foreach($company_sql as $row) {
              $company_code = $row['code'];
            }
            $customer_sql = $db->prepare('SELECT * FROM customer WHERE company_id=?');
            $customer_sql->bindParam(1, $company_code, PDO::PARAM_INT);
            $customer_sql->execute();
            foreach($customer_sql as $row) { ?>
              <option value="<?php echo $row['id']; ?>"><?php echo $row['customer_name']; ?></option>
            <?php }
          } else {?>
            <input type="text" name="customer" value="<?php if($_REQUEST['id']!==NULL) {
              echo $customer_name;
            } else {
              echo $_SESSION['report']['customer'];
            }?>" readonly>
          <?php }
             ?>
    </select><?php echo '<font color="RED">'.$_SESSION['error_report']['customer'].'</font>'; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">内容</span></td>
    <td><textarea name="memo" id="" cols="30" rows="6"><?php if($_REQUEST['id']!==NULL) {
            echo $memo;
            } else {
            echo $_SESSION['report']['memo'];
            } ?></textarea><?php echo '<font color="RED">'.$_SESSION['error_report']['memo'].'</font>'; ?>
    </td>
  </tr>
  <tr>
    <td class="center"><span class="font">自社担当者</span></td>
    <td><input type="text" id="employee" name="employee" placeholder="広島太郎" value="<?php if($_SESSION['report']['employee']==="") {
                echo $_SESSION['report']['employee'];
            } else {
                echo $_SESSION['login']['name']; 
            } ?>"><?php echo '<font color="RED">'.$_SESSION['error_report']['employee'].'</font>'; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">日付</span></td>
    <td><input type="text" placeholder="<?php echo date('Y/m/d'); ?>"<?php if($_REQUEST['id']===NULL) {
      echo 'class="from"'; }?> name="start" value="<?php if($_REQUEST['id']!==NULL) {
          echo $date;
        } else {
          echo $_SESSION['report']['start'];
        } ?>"><?php echo '<font color="RED">'.$_SESSION['error_report']['start'].'</font>'; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">時刻</span></td>
    <td><select name="hour">
      <option value="">時間(時)を選択</option>
      <?php for ($i = 8; $i <= 20; $i++): ?>
        <option value="<?php echo $i ?>"
        <?php if((int)$hour===$i) {
                echo 'selected';
              }elseif($i === (int)$_SESSION['report']['hour']) {
                echo 'selected';
              } ?>><?php echo $i ?></option>
      <?php endfor; ?></select><?php echo '<font color="RED">'.$_SESSION['error_report']['hour'].'</font>'; ?></td>
  </tr>
  <tr>
    <td></td>
    <td>
      <select name="min">
      <option value="m">時間(分)を選択</option>
      <?php for ($j = 0; $j <= 50; $j=$j+10): ?>
        <option value="<?php echo $j ?>"
        <?php if($min===(string)$j) {
                echo 'selected';
              }elseif((string)$j === $_SESSION['report']['min']) {
                echo 'selected';
              } ?>><?php echo $j ?></option>
      <?php endfor; ?></select><?php echo '<font color="RED">'.$_SESSION['error_report']['min'].'</font>'; ?></td>
  </tr>
  <tr>
    <td class="center"><span class="font">所要時間(分)</span></td>
    <td><input type="text" name="timer" placeholder="60" value="<?php if($_REQUEST['id']!==NULL) {
          echo $timer;
        } else {
          echo $_SESSION['report']['timer'];
        } ?>"><?php echo '<font color="RED">'.$_SESSION['error_report']['timer'].'</font>'; ?></td>
  </tr>
</table>
<button type="submit" name="action" value="send">登録</button>
</form>
</div>

<?php

?>
<?php require('footer.php'); ?>