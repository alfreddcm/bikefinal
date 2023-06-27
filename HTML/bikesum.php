<!DOCTYPE html>
<html>
<head>
    <title>Bike Status Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <link rel="stylesheet" href="style.css" class="rel">
    <style>
        .containerg {
            border-radius:5px;
            background-color:white;
            width: 49%;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="containerg">
        <canvas id="myChart"></canvas>
    </div>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require('connection.php');

    $sql0 = "SELECT stat, COUNT(*) as count FROM bikeinfo GROUP BY stat";
    $result0 = $conn->query($sql);
    $bikeCounts = $result->fetch_all(MYSQLI_ASSOC);

    // Extract the counts for each status
    $borrowedCount = 0;
    $availableCount = 0;
    $repairCount = 0;

    foreach ($bikeCounts as $bike) {
        switch ($bike['stat']) {
            case 'borrowed':
                $borrowedCount = $bike['count'];
                break;
            case 'available':
                $availableCount = $bike['count'];
                break;
            case 'repair':
                $repairCount = $bike['count'];
                break;
        }
    }

    ?>

    <script>
        var borrowedCount = <?php echo $borrowedCount; ?>;
        var availableCount = <?php echo $availableCount; ?>;
        var repairCount = <?php echo $repairCount; ?>;

        // Create the chart
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Borrowed', 'Available', 'Repair'],
                datasets: [{
                    label: 'Bike Status',
                    data: [borrowedCount, availableCount, repairCount],
                    backgroundColor: [
                        'red',
                        'green',
                        'pink'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                plugins: {
                    datalabels: {
                        formatter: function(value, context) {
                            return context.chart.data.labels[context.dataIndex];
                        },
                        color: 'black',
                        font: {
                            weight: 'bold'
                        },
                        anchor: 'end',
                        align: 'start',
                        offset: 10
                    }
                }
            }
        });
    </script>
  <center><a href="dashboard.php">back</a></center>
</body>
</html>
