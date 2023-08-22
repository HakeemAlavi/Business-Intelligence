<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KPI Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <!-- The bootstrap 5 tutorial is available here: https://www.w3schools.com/bootstrap5/index.php 
    and here:https://getbootstrap.com/docs/5.0/getting-started/introduction/ -->
    <!-- The Chart JS manual is available here: https://www.chartjs.org/docs/latest/charts/area.html -->
    <div class="row">
      <div class="col-md-2 bg-light bg-gradient">
        <h1>Business-Facing Analytics Dashboard</h1><br>
        <div style="color:#354E9D">
          <strong>BBT4106 and BBT4206: Business Intelligence Project (and BI1 Take-Away CAT 2)<br /></strong>
          <strong><br />Name: Hakeem Alavi<br /></strong>
          <strong>Student ID: 134775<br /></strong>
        </div>
        <br />
        <strong>Kaplan and Norton’s Balanced Scorecard</strong>
          <ul>
            <li>Financial Perspective (KPI1a and KPI1b)</li>
            <li>Customer Perspective (KPI2a and KPI2b)</li>
            <li>Internal Business Processes Perspective (KPI3a and KPI3b)</li>
            <li>Innovation and Learning Perspective (KPI4a and KPI4b)</li>
          </ul>
      </div>
      <div class="col-md-10 row">

<!-- Metric 1 -->
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

// Initialize variables to store the data
$firstEntry = 0;
$lastEntry = 0;

// Fetch data and store it in variables
if ($result->num_rows > 0) {
    $firstEntryRow = $result->fetch_assoc();
    $firstEntry = $firstEntryRow['DecisionMaking'];

    while ($row = $result->fetch_assoc()) {
        $lastEntry = $row['DecisionMaking'];
    }
}

// Calculate the percentage change
$percentageChange = (($lastEntry - $firstEntry) / $firstEntry) * 100;

// Close the database connection
$conn->close();
?>

<!-- Metric 2 -->
<?php
// Include the database configuration file
include 'dbconfig.php';

// Create connection
$conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Call the integrationaccuracyprocedure to get the data
$sql = "CALL `intergrationaccuracyprocedure`();";
$result = $conn->query($sql);

// Initialize variables to store the data
$firstEntry = 0;
$lastEntry = 0;

// Fetch data and store it in variables
if ($result->num_rows > 0) {
    $firstEntryRow = $result->fetch_assoc();
    $firstEntry = $firstEntryRow['DataDiscrepancies'];

    while ($row = $result->fetch_assoc()) {
        $lastEntry = $row['DataDiscrepancies'];
    }
}

// Calculate the percentage change
$percentageChange2 = (($lastEntry - $firstEntry) / $firstEntry) * 100;

// Close the database connection
$conn->close();
?>

<!-- Metric 3 -->
<?php
// Include the database configuration file
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

// Initialize variables to store the data
$firstEntry = 0;
$lastEntry = 0;

// Fetch data and store it in variables
if ($result->num_rows > 0) {
    $firstEntryRow = $result->fetch_assoc();
    $firstEntry = $firstEntryRow['UserEngagement'];

    while ($row = $result->fetch_assoc()) {
        $lastEntry = $row['UserEngagement'];
    }
}

// Calculate the percentage change
$percentageChange = (($lastEntry - $firstEntry) / $firstEntry) * 100;

// Close the database connection
$conn->close();
?>

<!-- Metric 4 -->
<?php
// Include the database configuration file
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

// Initialize variables to store the data
$firstEntry = 0;
$lastEntry = 0;

// Fetch data and store it in variables
if ($result->num_rows > 0) {
    $firstEntryRow = $result->fetch_assoc();
    $firstEntry = $firstEntryRow['HostingExpenses'];

    while ($row = $result->fetch_assoc()) {
        $lastEntry = $row['HostingExpenses'];
    }
}

// Calculate the percentage change
$percentageChange = (($lastEntry - $firstEntry) / $firstEntry) * 100;

// Close the database connection
$conn->close();
?>

  <!-- Start of Key Metrics -->
  <?php
  function humanize_number($input){
    $input = number_format($input);
    $input_count = substr_count($input, ',');
    if($input_count != '0'){
        if($input_count == '1'){
            return substr($input, 0, -4).'K';
        } else if($input_count == '2'){
            return substr($input, 0, -8).'M';
        } else if($input_count == '3'){
            return substr($input, 0,  -12).'B';
        } else {
            return;
        }
    } else {
        return $input;
    }
  }
  ?>
  <?php
  include 'dbconfig.php';

  // Create connection
  $conn = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  $sql = "SELECT SUM(`payments`.`amount`) AS salesRevenue FROM `payments` WHERE YEAR(`payments`.`paymentDate`) = '2005';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $salesRevenue = $row['salesRevenue'];
    }
  } else {
    echo "0 results";
  }
  $conn->close();
  ?>
  <div class="col-md-3 my-1">
        <div class="card">
            <div class="card-body text-center">
              <strong>Adoption of Data-driven Decision-making<br>(From 2022)</strong><hr>
              <h1>
              <?php
echo number_format($percentageChange, 2) . "%";
?>
              </h1>
            </div>
        </div>
  </div>
  <div class="col-md-3 my-1">
        <div class="card">
            <div class="card-body text-center">
              <strong>Increase of Data Discrepancies<br>(From Month 1)</strong><hr>
              <h1>
                <?php
                echo number_format($percentageChange2, 2) . "%";
                 ?>
              </h1>
            </div>
        </div>
  </div>
  <div class="col-md-3 my-1">
        <div class="card">
            <div class="card-body text-center">
              <strong>Increase in User Engagement<br>(From Month 1)</strong><hr>
              <h1>
                <?php
                echo number_format($percentageChange, 2) . "%";

                ?>
              </h1>
            </div>
        </div>
  </div>
  <div class="col-md-3 my-1">
        <div class="card">
            <div class="card-body text-center">
              <strong>Increase in Hosting Expenses<br>(From Month 1)</strong><hr>
              <h1>
                <?php
                echo number_format($percentageChange, 2) . "%";
                ?>
              </h1>
            </div>
        </div>
  </div>
  <!-- End of Key Metrics -->

    <!-- Start of KPI DIVs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php include 'kpi1.php'; ?> 
    <?php include 'kpi2.php'; ?>
    <?php include 'kpi3.php'; ?>
    <?php include 'kpi4.php'; ?>
    <!-- End of KPI DIVs -->
  </body>
</html>