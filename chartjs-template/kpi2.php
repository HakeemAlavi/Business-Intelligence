<div class="col-md-6 my-1">
    <div class="card">
    <div class="card-body">KPI2a (leading): Reduction in data processing and dashboard development time
      <br><br>
      Target: Decrease the average data processing and dashboard development time by 15% within the next quarter
    </div>

    <?php
        // Include the database configuration file
        include 'dbconfig.php';

        // Create a connection
        $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Call the stored procedure `dashdevtimeprocedure`
        $sql = "CALL `dashdevtimeprocedure`();";
        $result = $conn->query($sql);

        // Fetch the data and prepare it for visualization
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Close the connection
        $conn->close();
    ?>

<?php
// Include database configuration
include 'dbconfig.php';

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Call the intergrationaccuracyprocedure to get the data
$sql = "CALL `intergrationaccuracyprocedure`();";
$result = $conn->query($sql);

// Initialize arrays to store data for the line graph
$project = array();
$integrationAccuracy = array();
$dataDiscrepancies = array();
$delays = array();

// Fetch data and store it in the arrays
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $project[] = $row['Project'];
        $integrationAccuracy[] = $row['IntegrationAccuracy'];
        $dataDiscrepancies[] = $row['DataDiscrepancies'];
        $delays[] = $row['Delays'];
    }
}

// Close the database connection
$conn->close();
?>

    
    <div class="card-body"><canvas id="KPI2a"></canvas></div>
</div>
</div>
<div class="col-md-6 my-1">
    <div class="card">
    <div class="card-body">KPI2b (lagging): Improvement in data integration accuracy and efficiency, reflected in reduced data discrepancies and delays
    <br><br>
      Target: Achieve a 25% reduction in data discrepancies and delays related to data integration within the next six months
    </div>
    <div class="card-body"><canvas id="KPI2b"></canvas></div>
</div>
</div>
<script>
      /* KPI2a */
      const kpi2a = document.getElementById('KPI2a');
        new Chart(kpi2a, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($data, 'Project')); ?>,
                datasets: [{
                    label: 'Data Processing Time (hours)',
                    data: <?php echo json_encode(array_column($data, 'DataProcessingTime')); ?>,
                    borderColor: 'rgba(238, 36, 56, 0.7)',
                    backgroundColor: 'rgba(238, 36, 56, 0.7)',
                    fill: false,
                    borderWidth: 2
                }, {
                    label: 'Dashboard Development Time (days)',
                    data: <?php echo json_encode(array_column($data, 'DashboardDevelopmentDays')); ?>,
                    borderColor: 'rgba(53, 32, 240, 0.65)',
                    backgroundColor: 'rgba(53, 32, 240, 0.65)',
                    fill: false,
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Time (hours/days)'
                        }
                    },
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Project'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        intersect: true
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true
                        }
                    }
                },
                interaction: {
                    mode: 'point'
                }
            }
        });



      /* KPI2b */
      const kpi2b = document.getElementById('KPI2b');
new Chart(kpi2b, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($project); ?>,
        datasets: [
            {
                label: 'Integration Accuracy',
                data: <?php echo json_encode($integrationAccuracy); ?>,
                borderColor: 'rgba(238, 36, 56, 0.7)',
                backgroundColor: 'rgba(238, 36, 56, 0.1)',
                borderWidth: 2,
                fill: {
                    target: 'origin',
                    above: 'rgba(238, 36, 56, 0.1)',
                    below: 'rgba(238, 36, 56, 0.7)',
                }
            },
            {
                label: 'Data Discrepancies',
                data: <?php echo json_encode($dataDiscrepancies); ?>,
                borderColor: 'rgba(9, 50, 219, 0.7)',
                backgroundColor: 'rgba(9, 50, 219, 0.1)',
                borderWidth: 2,
                fill: {
                    target: 'origin',
                    above: 'rgba(9, 50, 219, 0.1)',
                    below: 'rgba(9, 50, 219, 0.7)',
                }
            },
            {
                label: 'Delays',
                data: <?php echo json_encode($delays); ?>,
                borderColor: 'rgba(85, 235, 90, 0.7)',
                backgroundColor: 'rgba(85, 235, 90, 0.1)',
                borderWidth: 2,
                fill: {
                    target: 'origin',
                    above: 'rgba(85, 235, 90, 0.1)',
                    below: 'rgba(85, 235, 90, 0.7)',
                }
            }
        ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Percentage'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Project'
                }
            }
        },
        plugins: {
            tooltip: {
                intersect: false
            },
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>