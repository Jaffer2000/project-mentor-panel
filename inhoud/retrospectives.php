<?php
// Include your database connection file
require_once 'db_connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch retrospectives
$retrospective_query = "SELECT * FROM retrospective";
$retrospective_result = $conn->query($retrospective_query);

// Display retrospective table
echo "<div class='container-fluid retrospectives'>";
echo "<h1>Retrospective List</h1>";
echo "<div class='table-responsive'>";
echo "<table class='table' style='background-color: #F5F5F5;'>";
echo "<tr><th>Keep</th><th>Problem</th><th>Try</th><th>Sprint</th></tr>";
if ($retrospective_result && $retrospective_result->num_rows > 0) {
    while ($retrospective_row = $retrospective_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $retrospective_row['ret_keep'] . "</td>";
        echo "<td>" . $retrospective_row['ret_problem'] . "</td>";
        echo "<td>" . $retrospective_row['ret_try'] . "</td>";
        echo "<td>" . $retrospective_row['ret_sprint'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No retrospective data available.</td></tr>";
}
echo "</table>";
echo "</div>";
echo "</div>";