<?php
// Include your database connection file
require_once 'db_connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch retrospectives
$retrospective_query = "SELECT r.*, c.comp_name FROM retrospective r 
                        JOIN company c ON r.companyId = c.id";
$retrospective_result = $conn->query($retrospective_query);

// Display retrospective table with a search bar and add retrospective button
echo "<div class='container-fluid retrospectives'>";
echo "<div class='row headerAndSearchBar'>";
echo "<div class='col-md-6'>";
echo "<h2>Retrospective List</h2>";
echo "</div>";

echo "<div class='col-md-6' style='display: flex; justify-content: flex-end; align-items: center;'>";
echo "<div class='search-container' style='margin-right: 10px;'>";
echo "<input type='text' id='searchInput' onkeyup='searchRetroTable()' placeholder='Search'>";
echo "<i class='fas fa-search search-icon'></i>"; // Font Awesome search icon
echo "</div>";
echo "<button onclick='addRetrospective()' style='padding: 8px 12px; border-radius: 5px; background-color: #2F4D63; color: #fff; border: none; cursor: pointer;'>";
echo "<i class='fas fa-plus'></i> Add Retrospective";
echo "</button>";
echo "</div>";
echo "</div>";

echo "<div class='table-responsive'>";
echo "<table id='retroTable' class='table' style='background-color: #F5F5F5;'>";
echo "<tr><th>Company Name</th><th>Keep</th><th>Problem</th><th>Try</th><th>Sprint</th></tr>";
if ($retrospective_result && $retrospective_result->num_rows > 0) {
    while ($retrospective_row = $retrospective_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $retrospective_row['comp_name'] . "</td>";
        echo "<td>" . $retrospective_row['ret_keep'] . "</td>";
        echo "<td>" . $retrospective_row['ret_problem'] . "</td>";
        echo "<td>" . $retrospective_row['ret_try'] . "</td>";
        echo "<td>" . $retrospective_row['ret_sprint'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No retrospective data available.</td></tr>";
}
echo "</table>";
echo "</div>";

// Count the total number of retrospectives
$total_retrospectives_query = "SELECT COUNT(*) AS total_retrospectives FROM retrospective";
$total_retrospectives_result = $conn->query($total_retrospectives_query);
$total_retrospectives = ($total_retrospectives_result) ? $total_retrospectives_result->fetch_assoc()['total_retrospectives'] : 0;

// Calculate the range of displayed items
$start_range = ($total_retrospectives > 0) ? 1 : 0;
$end_range = ($retrospective_result && $retrospective_result->num_rows > 0) ? $start_range + $retrospective_result->num_rows - 1 : 0;

// Display counter
echo "<div class='counter'>";
echo "$start_range to $end_range of $total_retrospectives items";
echo "</div>";

echo "</div>";

?>
<script src="js/script.js"></script>