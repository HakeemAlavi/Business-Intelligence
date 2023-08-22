<!-- Data for KPI1a: Top 5 selling products of the year-->
<?php
// Include the database configuration file
include 'dbconfig.php';

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Call the dataanalysistechniquesprocedure to get the data
$sql = "CALL `dataanalysistechniquesprocedure`();";
$result = $conn->query($sql);

// Initialize arrays to store data for the bar graph
$year = array();
$techniques = array();
$methodologies = array();

// Fetch data and store it in the arrays
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $year[] = $row['Year'];
        $techniques[] = $row['Techniques'];
        $methodologies[] = $row['Methodologies'];
    }
}

// Close the database connection
$conn->close();
?>

<?php
// Include the database configuration file
include 'dbconfig.php';

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Call the decisionmakingprocedure to get the data
$sql = "CALL `decisionmakingprocedure`();";
$result = $conn->query($sql);

// Initialize arrays to store data for the line graph
$years = array();
$decisionMaking = array();
$innovativePractices = array();

// Fetch data and store it in the arrays
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $years[] = $row['Year'];
        $decisionMaking[] = $row['DecisionMaking'];
        $innovativePractices[] = $row['InnovativePractices'];
    }
}

// Close the database connection
$conn->close();
?>

<!-- Data for KPI 1b: Year-on-Year Monthly Sales Revenue-->

<div class="col-md-6 my-1">
  <div class="card">
  <div class="card-body">
    
      KPI1a (leading): Number of new data analysis techniques and methodologies explored and implemented
<br><br>
      Target: Aim to explore and implement at least three new data analysis techniques or methodologies per quarter<br>
      
    
  </div>
  <div class="card-body"><canvas id="KPI1a"></canvas></div>
</div>
</div>
<div class="col-md-6 my-1">
  <div class="card">
  <div class="card-body">
    
      KPI1b (lagging): Improvement in data-driven decision-making capabilities and adoption of innovative practices<br><br>
      Target: Increase the adoption of data-driven decision-making practices by 20% within the next six months <br>
      
    
  </div>
  <div class="card-body"><canvas id="KPI1b"></canvas></div>
</div>
</div>
<!-- You can use the following website to pick RGBA values: https://rgbacolorpicker.com/ -->
<script>
  
/* KPI1a */
const kpi1a = document.getElementById('KPI1a');
new Chart(kpi1a, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($year); ?>,
        datasets: [{
            label: 'Techniques',
            data: <?php echo json_encode($techniques); ?>,
            backgroundColor: 'rgba(238, 36, 56, 0.7)'
        }, {
            label: 'Methodologies',
            data: <?php echo json_encode($methodologies); ?>,
            backgroundColor: 'rgba(53, 32, 240, 0.65)'
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Count'
                }
            },
            x: {
                title: {
                    display: true,
                    text: 'Year'
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

      /* KPI1b */
      const years = <?php echo json_encode($years); ?>;
        const decisionMakingData = <?php echo json_encode($decisionMaking); ?>;
        const innovativePracticesData = <?php echo json_encode($innovativePractices); ?>;

        new Chart("KPI1b", {
            type: 'line',
            data: {
                labels: years,
                datasets: [{
                    label: 'Decision Making',
                    data: decisionMakingData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1,
                    fill: true
                },
                {
                    label: 'Innovative Practices',
                    data: innovativePracticesData,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderWidth: 1,
                    fill: true
                }]
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
                            text: 'Year'
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