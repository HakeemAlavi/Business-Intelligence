<div class="col-md-6 my-1">
    <div class="card">
    <div class="card-body">KPI3a (leading): User satisfaction surveys and feedback on dashboard usability and relevance
    <br><br>
      Target: Maintain a satisfaction rating of 8 out of 10 or higher based on user surveys
    </div>

    <?php
// Include the database configuration file
include 'dbconfig.php';

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Call the dashboardsatisfactionprocedure to get the data
$sql = "CALL `dashboardsatisfactionprocedure`();";
$result = $conn->query($sql);

// Initialize an array to store the data
$data = array();

// Fetch data and store it in the array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close the database connection
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

    // Call the userengagementprocedure to get the data
    $sql = "CALL `userengagementprocedure`();";
    $result = $conn->query($sql);

    // Initialize arrays to store data for the line chart
    $months = array();
    $userEngagement = array();
    $userUsage = array();
    $positiveFeedback = array();

    // Fetch data and store it in the arrays
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $months[] = $row['Month'];
            $userEngagement[] = $row['UserEngagement'];
            $userUsage[] = $row['UserUsage'];
            $positiveFeedback[] = $row['PositiveFeedback'];
        }
    }

    // Close the database connection
    $conn->close();
    ?>

    <div class="card-body"><canvas id="KPI3a"></canvas></div>
    </div>
</div>
<div class="col-md-6 my-1">
    <div class="card">
    <div class="card-body">KPI3b (lagging): Increase in user engagement and usage of the dashboards, as well as positive feedback from clients and admins
    <br><br>
      Target: Achieve a 20% increase in user engagement and positive feedback within the next year
</div>
    <div class="card-body"><canvas id="KPI3b"></canvas></div>
    </div>
</div>
<script>

      /* KPI3a */
      const kpi3a = document.getElementById('KPI3a');

        const data = <?php echo json_encode($data); ?>;
        const users = data.map(entry => entry.User);
        const satisfactionRatings = data.map(entry => entry.SatisfactionRating);

        new Chart(kpi3a, {
            type: 'bar',
            data: {
                labels: users,
                datasets: [{
                    label: 'Satisfaction Rating',
                    data: satisfactionRatings,
                    backgroundColor: 'rgba(238, 36, 56, 0.7)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Satisfaction Rating'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'User'
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        intersect: true
                    },
                    legend: {
                        display: false
                    }
                }
            }
        });

      /* KPI3b */
      const kpi3b = document.getElementById('KPI3b');

        new Chart(kpi3b, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'User Engagement',
                    data: <?php echo json_encode($userEngagement); ?>,
                    borderColor: 'rgba(238, 36, 56, 0.7)',
                    backgroundColor: 'rgba(238, 36, 56, 0.7)',
                    fill: false,
                    borderWidth: 2
                }, {
                    label: 'User Usage',
                    data: <?php echo json_encode($userUsage); ?>,
                    borderColor: 'rgba(53, 32, 240, 0.65)',
                    backgroundColor: 'rgba(53, 32, 240, 0.65)',
                    fill: false,
                    borderWidth: 2
                }, {
                    label: 'Positive Feedback',
                    data: <?php echo json_encode($positiveFeedback); ?>,
                    borderColor: 'rgba(19, 190, 20, 0.65)',
                    backgroundColor: 'rgba(19, 190, 20, 0.65)',
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
                            text: 'Percentage / Count'
                        }
                    },
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Month'
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
</script>