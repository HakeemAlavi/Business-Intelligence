<div class="col-md-6 my-1">
    <div class="card">
    <div class="card-body">KPI4a (leading): Reduction in the size of the web application
    <br><br>
      Target: Reduce the size of the web application codebase by 20% within the next six months
    </div>

    <?php
  // Include database configuration
  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Call the webappsizeprocedure to get the data
  $sql = "CALL `webappsizeprocedure`();";
  $result = $conn->query($sql);

  // Initialize arrays to store data for the line graph
  $version = array();
  $codebaseSize = array();

  // Fetch data and store it in the arrays
  if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          $version[] = $row['Version'];
          $codebaseSize[] = $row['CodebaseSize'];
      }
  }

  // Close the database connection
  $conn->close();
  ?>

<?php
            include 'dbconfig.php';

            // Create connection
            $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Call the hostingexpensesprocedure to get the data
            $sql = "CALL `hostingexpensesprocedure`();";
            $result = $conn->query($sql);

            // Initialize arrays to store data for the bar graph
            $months = array();
            $expenses = array();

            // Fetch data and store it in the arrays
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $months[] = "Month " . $row['Month'];
                    $expenses[] = $row['HostingExpenses'];
                }
            }

            // Close the database connection
            $conn->close();
        ?>

    <div class="card-body"><canvas id="KPI4a"></canvas></div>
    </div>
</div>
<div class="col-md-6 my-1">
    <div class="card">
    <div class="card-body">KPI4b (lagging): Reduction in cost of hosting
    <br><br>
      Target: Decrease the hosting expenses by 15% within the next year
    </div>
    <div class="card-body"><canvas id="KPI4b"></canvas></div>
</div>
</div>
<script>
      /* KPI4a */
      const versionData = <?php echo json_encode($version); ?>;
    const codebaseSizeData = <?php echo json_encode($codebaseSize); ?>;

    // Create a Chart.js line chart
    const kpi4a = new Chart(document.getElementById('KPI4a'), {
      type: 'line',
      data: {
        labels: versionData,
        datasets: [{
          label: 'Codebase Size',
          data: codebaseSizeData,
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
              text: 'Codebase Size'
            }
          },
          x: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Version'
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

      /* KPI4b */
      const kpi4b = document.getElementById('KPI4b').getContext('2d');
        new Chart(kpi4b, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Hosting Expenses',
                    data: <?php echo json_encode($expenses); ?>,
                    backgroundColor: 'rgba(238, 36, 56, 0.7)'
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Expenses'
                        }
                    },
                    x: {
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