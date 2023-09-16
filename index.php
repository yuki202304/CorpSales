<?php require('header.php'); ?>
<?php require('menu.php'); ?>
<?php
if(isset($_SESSION['login'])) { ?>
<h2>レポート</h2>
<hr>
<div class="main">
<?php
#個人成績グラフ
//日付
$year = date('Y');
$month = date('m');
$date11 = $year.'-'.$month;
$date1 = $date11."%";

if($month === 12) {
  $year22 = $year+1;
  $month22 = 01;
} else {
  $year22 = $year;
  $month22 = $month+1;
  $month22 = sprintf('%02d', $month22);
}
$date22 = $year22.'-'.$month22;
$date2 = $date22."%";

if($month22 === 12) {
  $year33 = $year22+1;
  $month33 = 01;
} else {
  $year33 = $year22;
  $month33 = $month22+1;
  $month33 = sprintf('%02d', $month33);
}
$date33 = $year33.'-'.$month33;
$date3 = $date33."%";

//確度
$id1 = 1;
$id2 = 2;
$id3 = 3;
//担当者
$name = $_SESSION['login']['name'];

try {
  $sqlA1 = $db->prepare('SELECT SUM(selling_price) AS total, e.employee_name FROM opportunity o 
  LEFT JOIN employee e ON o.employee_id = e.id WHERE o.expected_day LIKE ? AND o.possibility_id =? AND e.employee_name=? 
  GROUP BY o.employee_id ORDER BY total DESC');
  $sqlA1->bindParam(1, $date1, PDO::PARAM_STR);
  $sqlA1->bindParam(2, $id1, PDO::PARAM_INT);
  $sqlA1->bindParam(3, $name, PDO::PARAM_STR);
  $sqlA1->execute();

  $sqlA2 = $db->prepare('SELECT SUM(selling_price) AS total, e.employee_name FROM opportunity o 
  LEFT JOIN employee e ON o.employee_id = e.id WHERE o.expected_day LIKE ? AND o.possibility_id =? AND e.employee_name=? 
  GROUP BY o.employee_id ORDER BY total DESC');
  $sqlA2->bindParam(1, $date2, PDO::PARAM_STR);
  $sqlA2->bindParam(2, $id1, PDO::PARAM_INT);
  $sqlA2->bindParam(3, $name, PDO::PARAM_STR);
  $sqlA2->execute();

  $sqlA3 = $db->prepare('SELECT SUM(selling_price) AS total, e.employee_name FROM opportunity o 
  LEFT JOIN employee e ON o.employee_id = e.id WHERE o.expected_day LIKE ? AND o.possibility_id =? AND e.employee_name=? 
  GROUP BY o.employee_id ORDER BY total DESC');
  $sqlA3->bindParam(1, $date3, PDO::PARAM_STR);
  $sqlA3->bindParam(2, $id1, PDO::PARAM_INT);
  $sqlA3->bindParam(3, $name, PDO::PARAM_STR);
  $sqlA3->execute();

  $sqlB1 = $db->prepare('SELECT SUM(selling_price) AS total, e.employee_name FROM opportunity o 
  LEFT JOIN employee e ON o.employee_id = e.id WHERE o.expected_day LIKE ? AND o.possibility_id =? AND e.employee_name=? 
  GROUP BY o.employee_id ORDER BY total DESC');
  $sqlB1->bindParam(1, $date1, PDO::PARAM_STR);
  $sqlB1->bindParam(2, $id2, PDO::PARAM_INT);
  $sqlB1->bindParam(3, $name, PDO::PARAM_STR);
  $sqlB1->execute();

  $sqlB2 = $db->prepare('SELECT SUM(selling_price) AS total, e.employee_name FROM opportunity o 
  LEFT JOIN employee e ON o.employee_id = e.id WHERE o.expected_day LIKE ? AND o.possibility_id =? AND e.employee_name=? 
  GROUP BY o.employee_id ORDER BY total DESC');
  $sqlB2->bindParam(1, $date2, PDO::PARAM_STR);
  $sqlB2->bindParam(2, $id2, PDO::PARAM_INT);
  $sqlB2->bindParam(3, $name, PDO::PARAM_STR);
  $sqlB2->execute();

  $sqlB3 = $db->prepare('SELECT SUM(selling_price) AS total, e.employee_name FROM opportunity o 
  LEFT JOIN employee e ON o.employee_id = e.id WHERE o.expected_day LIKE ? AND o.possibility_id =? AND e.employee_name=? 
  GROUP BY o.employee_id ORDER BY total DESC');
  $sqlB3->bindParam(1, $date3, PDO::PARAM_STR);
  $sqlB3->bindParam(2, $id2, PDO::PARAM_INT);
  $sqlB3->bindParam(3, $name, PDO::PARAM_STR);
  $sqlB3->execute();

  $sqlC1 = $db->prepare('SELECT SUM(selling_price) AS total, e.employee_name FROM opportunity o 
  LEFT JOIN employee e ON o.employee_id = e.id WHERE o.expected_day LIKE ? AND o.possibility_id =? AND e.employee_name=? 
  GROUP BY o.employee_id ORDER BY total DESC');
  $sqlC1->bindParam(1, $date1, PDO::PARAM_STR);
  $sqlC1->bindParam(2, $id3, PDO::PARAM_INT);
  $sqlC1->bindParam(3, $name, PDO::PARAM_STR);
  $sqlC1->execute();

  $sqlC2 = $db->prepare('SELECT SUM(selling_price) AS total, e.employee_name FROM opportunity o 
  LEFT JOIN employee e ON o.employee_id = e.id WHERE o.expected_day LIKE ? AND o.possibility_id =? AND e.employee_name=? 
  GROUP BY o.employee_id ORDER BY total DESC');
  $sqlC2->bindParam(1, $date2, PDO::PARAM_STR);
  $sqlC2->bindParam(2, $id3, PDO::PARAM_INT);
  $sqlC2->bindParam(3, $name, PDO::PARAM_STR);
  $sqlC2->execute();

  $sqlC3 = $db->prepare('SELECT SUM(selling_price) AS total, e.employee_name FROM opportunity o 
  LEFT JOIN employee e ON o.employee_id = e.id WHERE o.expected_day LIKE ? AND o.possibility_id =? AND e.employee_name=? 
  GROUP BY o.employee_id ORDER BY total DESC');
  $sqlC3->bindParam(1, $date3, PDO::PARAM_STR);
  $sqlC3->bindParam(2, $id3, PDO::PARAM_INT);
  $sqlC3->bindParam(3, $name, PDO::PARAM_STR);
  $sqlC3->execute();

  $sql1 = $db->prepare('SELECT c.company_name, o.id, o.opportunity, o.selling_price, p.possibility FROM opportunity o 
  LEFT JOIN company c ON o.company_id = c.code LEFT JOIN employee e ON o.employee_id = e.id 
  LEFT JOIN possibility p ON o.possibility_id = p.id 
  WHERE o.expected_day LIKE ? AND o.possibility_id >= ? AND o.possibility_id <= ? AND e.employee_name=? 
  ORDER BY o.possibility_id ASC');
  $sql1->bindParam(1, $date1, PDO::PARAM_STR);
  $sql1->bindParam(2, $id1, PDO::PARAM_INT);
  $sql1->bindParam(3, $id3, PDO::PARAM_INT);
  $sql1->bindParam(4, $name, PDO::PARAM_STR);
  $sql1->execute();
  $count1 = $sql1 -> rowCount();

  $sql2 = $db->prepare('SELECT c.company_name, o.id, o.opportunity, o.selling_price, p.possibility FROM opportunity o 
  LEFT JOIN company c ON o.company_id = c.code LEFT JOIN employee e ON o.employee_id = e.id 
  LEFT JOIN possibility p ON o.possibility_id = p.id 
  WHERE o.expected_day LIKE ? AND o.possibility_id >= ? AND o.possibility_id <= ? AND e.employee_name=? 
  ORDER BY o.possibility_id ASC');
  $sql2->bindParam(1, $date2, PDO::PARAM_STR);
  $sql2->bindParam(2, $id1, PDO::PARAM_INT);
  $sql2->bindParam(3, $id3, PDO::PARAM_INT);
  $sql2->bindParam(4, $name, PDO::PARAM_STR);
  $sql2->execute();
  $count2 = $sql2 -> rowCount();

  $sql3 = $db->prepare('SELECT c.company_name, o.id, o.opportunity, o.selling_price, p.possibility FROM opportunity o 
  LEFT JOIN company c ON o.company_id = c.code LEFT JOIN employee e ON o.employee_id = e.id 
  LEFT JOIN possibility p ON o.possibility_id = p.id 
  WHERE o.expected_day LIKE ? AND o.possibility_id >= ? AND o.possibility_id <= ? AND e.employee_name=? 
  ORDER BY o.possibility_id ASC');
  $sql3->bindParam(1, $date3, PDO::PARAM_STR);
  $sql3->bindParam(2, $id1, PDO::PARAM_INT);
  $sql3->bindParam(3, $id3, PDO::PARAM_INT);
  $sql3->bindParam(4, $name, PDO::PARAM_STR);
  $sql3->execute();
  $count3 = $sql3 -> rowCount();

} catch(PDOException $e) {
  echo('エラーメッセージ：'.$e->getMessage());
}

//phpでのデータ
foreach ($sqlA1 as $xyz) {
  $A1[] = $xyz['total'];
}
foreach ($sqlA2 as $xyz) {
  $A2[] = $xyz['total'];
}
foreach ($sqlA3 as $xyz) {
  $A3[] = $xyz['total'];
}
foreach ($sqlB1 as $xyz) {
  $B1[] = $xyz['total'];
}
foreach ($sqlB2 as $xyz) {
  $B2[] = $xyz['total'];
}
foreach ($sqlB3 as $xyz) {
  $B3[] = $xyz['total'];
}
foreach ($sqlC1 as $xyz) {
  $C1[] = $xyz['total'];
}
foreach ($sqlC2 as $xyz) {
  $C2[] = $xyz['total'];
}
foreach ($sqlC3 as $xyz) {
  $C3[] = $xyz['total'];
}

//javascriptに渡す
$jdate1 = json_encode($date11);
$jdate2 = json_encode($date22);
$jdate3 = json_encode($date33);
$jA1 = json_encode($A1);
$jA2 = json_encode($A2);
$jA3 = json_encode($A3);
$jA1 = json_encode($A1);
$jA2 = json_encode($A2);
$jA3 = json_encode($A3);
$jB1 = json_encode($B1);
$jB2 = json_encode($B2);
$jB3 = json_encode($B3);
$jC1 = json_encode($C1);
$jC2 = json_encode($C2);
$jC3 = json_encode($C3);

#全体成績
try {
  $sql = $db->prepare('SELECT SUM(selling_price) AS total, e.employee_name FROM opportunity o 
  LEFT JOIN employee e ON o.employee_id = e.id WHERE o.expected_day LIKE ? AND o.possibility_id=? 
  GROUP BY o.employee_id ORDER BY total DESC');
  $sql->bindParam(1, $date1, PDO::PARAM_STR);
  $sql->bindParam(2, $id1, PDO::PARAM_INT);
  $sql->execute();
} catch(PDOException $e) {
  echo('エラーメッセージ：'.$e->getMessage());
}

?>
<div class="parent">
  <div class="child1">
    <h3>個人成績</h3>
    <div style="width:500px">
      <canvas id="mychart"></canvas>
    </div><br>
    
    <table>
    <?php
    if($count1!==0) { ?>
      <tr>
        <td colspan="2">受注年月：<?php echo $date11; ?></td>
      </tr>
      <?php
    }
      foreach($sql1 as $row) { ?>
      <tr>
        <td width=30><?php var_dump($row['possibility']); ?><?php echo mb_substr($row['possibility'], 0, 1); ?></td>
        <td width=190><?php echo $row['company_name']; ?></td>
        <td width=250><?php echo $row['opportunity']; ?></td>
        <td width=90><?php echo number_format($row['selling_price']).'円'; ?></td>
        <td><button type="button" onclick="location.href='opportunity.php?id=<?php echo $row['id']; ?>'">変更</button></td>
      </tr>
      <?php }
    if($count2!==0) { ?>
      <tr>
        <td colspan="5">-------------------------------------------------------------------------------------------</td>
      </tr>
      <tr>
        <td colspan="2">受注年月：<?php echo $date22; ?></td>
      </tr>
      <?php
    }
      foreach($sql2 as $row) { ?>
      <tr>
        <td><?php echo mb_substr($row['possibility'], 0, 1); ?></td>
        <td><?php echo $row['company_name']; ?></td>
        <td><?php echo $row['opportunity']; ?></td>
        <td><?php echo number_format($row['selling_price']).'円'; ?></td>
        <td><button type="button" onclick="location.href='opportunity.php?id=<?php echo $row['id']; ?>'">変更</button></td>
      
      </tr>
      <?php }
      if($count3!==0) {
      ?>
      <tr>
        <td colspan="5">-------------------------------------------------------------------------------------------</td>
      </tr>
      <tr>
        <td colspan="2">受注年月：<?php echo $date33; ?></td>
      </tr>
      <?php
      }
      foreach($sql3 as $row) { ?>
      <tr>
        <td><?php echo mb_substr($row['possibility'], 0, 1); ?></td>
        <td><?php echo $row['company_name']; ?></td>
        <td><?php echo $row['opportunity']; ?></td>
        <td><?php echo number_format($row['selling_price']).'円'; ?></td>
        <td><button type="button" onclick="location.href='opportunity.php?id=<?php echo $row['id']; ?>'">変更</button></td>
      </tr>
      <?php } ?>
    </table>
  </div>

  <div class="child2">
    <h3>今月全体成績</h3>
    <div style="width:500px">
      <canvas id="barChart"></canvas>
    </div>
    <br>
    <table>
      <tr>
        <td>順位</td>
        <td>名前</td>
        <td>売上金額</td>
        <td>達成率</td>
      </tr>
      <?php
      $i=1;
      foreach($sql as $row) {
        $x[] = $row['employee_name'];
        $y[] = $row['total'];
      ?>
      <tr>
        <td width=80><?php echo $i; ?>位</td>
        <td width=120><?php echo $row['employee_name']; ?></td>
        <td width=150><?php echo number_format($row['total']).'円'; ?></td>
        <?php $parsent = round($row['total']/3000000*100); ?>
        <td><?php echo $parsent.'%'; ?></td>
      </tr>
      <?php
      $i++;
      }
      //javascriptに渡す
      $jx = json_encode($x);
      $jy = json_encode($y);
      ?>
    </table>

  </div>
</div>
</div>
<script>
//個人成績
let date1 = JSON.parse('<?php echo $jdate1; ?>');
let date2 = JSON.parse('<?php echo $jdate2; ?>');
let date3 = JSON.parse('<?php echo $jdate3; ?>');
let A1 = JSON.parse('<?php echo $jA1; ?>');
let A2 = JSON.parse('<?php echo $jA2; ?>');
let A3 = JSON.parse('<?php echo $jA3; ?>');
let B1 = JSON.parse('<?php echo $jB1; ?>');
let B2 = JSON.parse('<?php echo $jB2; ?>');
let B3 = JSON.parse('<?php echo $jB3; ?>');
let C1 = JSON.parse('<?php echo $jC1; ?>');
let C2 = JSON.parse('<?php echo $jC2; ?>');
let C3 = JSON.parse('<?php echo $jC3; ?>');

var ctx = document.getElementById('mychart');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: [date1, date2, date3],
    datasets: [{
      label: '確度：A',
      data: [A1, A2, A3],
      backgroundColor: '#f88',
      stack: 'stack-1',
    }, {
      label: '確度：B',
      data: [B1, B2, B3],
      backgroundColor: '#484',
      stack: 'stack-1',
    },{
      label: '確度：C',
      data: [C1, C2, C3],
      backgroundColor: '#48f',
      stack: 'stack-1',
    }],
  },
});


//全体成績
let x = JSON.parse('<?php echo $jx; ?>');
let y = JSON.parse('<?php echo $jy; ?>');

// 棒グラフの設定
let barCtx = document.getElementById("barChart");
let barConfig = {
  type: 'bar',
  data: {
    labels: x,
    datasets: [
      {
        label: '今月売上',
        data: y,
        backgroundColor: ["#f88"],
        borderWidth: 1,
      }
    ],
  },
  
};
let barChart = new Chart(barCtx, barConfig) ;
</script>

<?php
} else {
?>
<h2>システム概要</h2>
<hr>
<div class="main">
<p>顧客管理、案件管理、行動管理ができる営業支援システムです。</p>
<p>＊企業の名称、住所、担当者等は全て架空のものです。</p>
<p>下記いずれかのログインID、パスワードからログインしてください。</p>
<table border=1>
  <tr>
    <th>ログインID</th>
    <th>パスワード</th>
  </tr>
  <tr>
    <td>1</td>
    <td>taro</td>
  </tr>
  <tr>
    <td>2</td>
    <td>takeshi</td>
  </tr>
  <tr>
    <td>3</td>
    <td>shingo</td>
  </tr>
  <tr>
    <td>4</td>
    <td>mariko</td>
  </tr>
  <tr>
    <td>5</td>
    <td>tsuyoshi</td>
  </tr>
  <tr>
    <td>6</td>
    <td>aiko</td>
  </tr>
  <tr>
    <td>7</td>
    <td>jiro</td>
  </tr>
  <tr>
    <td>8</td>
    <td>kazuki</td>
  </tr>
  <tr>
    <td>9</td>
    <td>mai</td>
  </tr>
  <tr>
    <td>10</td>
    <td>hiroshi</td>
  </tr>
</table>
</div>
<?php } ?>
<?php require('footer.php'); ?>
