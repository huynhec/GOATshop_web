<?php
require_once '../model/ChiTietTrangThaiModel.php';
$cttt = new ChiTietTrangThaiModel();

$chiTietTrangThai__Get_Sum_Chart = $cttt->ChiTietTrangThai__Get_Sum_Chart();
?>

<div class="main-add">
    <canvas id="pieChart"></canvas>
</div>


<script src="../assets/vendor/chart-js-v4.4.1.js"></script>
<script>
    // Pie Chart

    var tentt = <?php echo json_encode(array_column($chiTietTrangThai__Get_Sum_Chart, 'tentt')); ?>;
    var sumtt = <?php echo json_encode(array_column($chiTietTrangThai__Get_Sum_Chart, 'sumtt')); ?>;

    var pieChartColors = ['#FF6384', '#36A2EB', '#FFCE56', '#4CAF50', '#FF5733'];


    var pieChartCanvas = document.getElementById("pieChart").getContext('2d');
    var pieChartData = {
        labels: tentt,
        datasets: [{
            data: sumtt,
            backgroundColor: pieChartColors,
            borderColor: 'white',
            borderWidth: 2
        }]
    };
    var pieChartOptions = {
        responsive: true,
        legend: {
            position: 'right'
        }
    };
    var myPieChart = new Chart(pieChartCanvas, {
        type: 'pie',
        data: pieChartData,
        options: pieChartOptions
    });
</script>