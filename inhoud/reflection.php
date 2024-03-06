<?php
// Include your database connection file
require_once 'db_connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch reflections
$reflection_query = "SELECT r.*, m.mem_name FROM reflection r 
                        JOIN members m ON m.id = r.memberId";
$reflection_result = $conn->query($reflection_query);

// Display reflection table with a search bar and add reflection button
echo "<div class='container-fluid reflections'>";
echo "<div class='row headerAndSearchBar'>";
echo "<div class='col-md-6'>";
echo "<h2>Reflection List</h2>";
echo "</div>";

echo "<div class='col-md-6' style='display: flex; justify-content: flex-end; align-items: center;'>";
echo "<div class='search-container' style='margin-right: 10px;'>";
echo "<input type='text' id='searchInput' onkeyup='searchReflectionTable()' placeholder='Search'>";
echo "<i class='fas fa-search search-icon'></i>"; // Font Awesome search icon
echo "</div>";
echo "<button onclick='addReflection()' style='padding: 8px 12px; border-radius: 5px; background-color: #2F4D63; color: #fff; border: none; cursor: pointer;'>";
echo "<i class='fas fa-plus'></i> Add Reflection";
echo "</button>";
echo "</div>";
echo "</div>";

echo "<div class='table-responsive'>";
echo "<table id='reflectionTable' class='table' style='background-color: #F5F5F5;'>";
echo "<tr><th>Member</th><th>Talents</th><th>Pitfalls</th><th>Reflected by Others</th><th>Sprint</th></tr>";
if ($reflection_result && $reflection_result->num_rows > 0) {
    while ($reflection_row = $reflection_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $reflection_row['mem_name'] . "</td>";
        echo "<td>" . $reflection_row['refl_talents'] . "</td>";
        echo "<td>" . $reflection_row['refl_pitfalls'] . "</td>";
        echo "<td>" . $reflection_row['refl_talother'] . "</td>";
        echo "<td>" . $reflection_row['refl_sprint'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No reflection data available.</td></tr>";
}
echo "</table>";
echo "</div>";

// Count the total number of retrospectives
$total_reflections_query = "SELECT COUNT(*) AS total_reflections FROM reflection";
$total_reflections_result = $conn->query($total_reflections_query);
$total_reflections = ($total_reflections_result) ? $total_reflections_result->fetch_assoc()['total_reflections'] : 0;

// Calculate the range of displayed items
$start_range = ($total_reflections > 0) ? 1 : 0;
$end_range = ($reflection_result && $reflection_result->num_rows > 0) ? $start_range + $reflection_result->num_rows - 1 : 0;

// Display counter
echo "<div class='counter'>";
echo "$start_range to $end_range of $total_reflections items";
echo "</div>";

echo "</div>";

?>
<script src="js/script.js"></script>