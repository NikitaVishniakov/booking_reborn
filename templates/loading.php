<?php
/**
 * Created by PhpStorm.
 * Users: vishniakov
 * Date: 07.07.17
 * Time: 20:57
 */
?>
<div id="main-container" class="main-container">
    <div class="loading-container">
        <table class="table month-loading">
            <caption>Процент загрузки отеля по месяцам</caption>
            <?php foreach ($formated_loading as $month_name => $month_percents):?>
                <tr>
                    <td><span class="month"><?=$month_name?></span></td>
                    <td><span class="month-percentage"><?=$month_percents?></span>%</td>
                </tr>
            <?php endforeach; ?>
        </table>
        <canvas id="total-loading" width="600" height="400"></canvas>
    </div>
    <div class="loading-container">
        <canvas id="total-loading" width="600" height="400"></canvas>

    </div>
</div>
<script src="/node_modules/chart.js/dist/Chart.js"></script>
<script>


    function adaptiveCanvas() {
        var width = document.getElementById('main-container').offsetWidth;
        if(width > 700){
            width *= 0.45;
        }
        var height = width * 2 / 3;
        return [width, height];
    }
    function getArray(name) {
        var arr = [];
        var elements = document.querySelectorAll(name);
        for (var i = 0; i < elements.length; i++) {
            arr.push(elements[i].innerHTML);
        }
        return arr;
    }
    var months = getArray('.month');
    var percents = getArray('.month-percentage');
    var canvas = document.getElementById('total-loading')
    var width = adaptiveCanvas()[0];
    var height = adaptiveCanvas()[1];
    canvas.width  = width; // in pixels
    canvas.height = height; // in pixels
//    import Chart from 'chart.js';
    var ctx = document.getElementById("total-loading");
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: months,
            datasets: [{
                label: '% Загрузки отеля',
                data: percents,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)',
                    'rgba(255,99,132,1)'

                ],
                borderWidth: 1
            }]
        },
//        xAxisID: 0,
        options: {
            responsive: false,
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
        }
    });
</script>
<?php
    include "footer.php";
?>
