</main>
</script>
<script>
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

</body>
</html>
