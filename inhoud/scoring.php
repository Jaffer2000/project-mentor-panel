<?php
// Include your database connection file
require_once 'db_connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch scores with category and company information
$score_query = "SELECT s.score_points, s.score_date, s.companyId, s.score_activity, s.score_comments, s.categoryId, c.cat_type, co.comp_name
                FROM score s
                LEFT JOIN category c ON s.categoryId = c.id
                LEFT JOIN company co ON s.companyId = co.id";
$score_result = $conn->query($score_query);

// Display score table
echo "<div class='container-fluid scores'>";
echo "<h1>Score List</h1>";
echo "<div class='table-responsive'>";
echo "<table class='table' style='background-color: #F5F5F5;'>";
echo "<tr><th>Points</th><th>Date</th><th>Company</th><th>For</th><th>Comments</th><th>Category</th></tr>";
if ($score_result && $score_result->num_rows > 0) {
    while ($score_row = $score_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $score_row['score_points'] . "</td>";
        echo "<td>" . $score_row['score_date'] . "</td>";
        echo "<td>" . $score_row['comp_name'] . "</td>"; // Display comp_name instead of companyId
        echo "<td>" . $score_row['score_activity'] . "</td>";
        echo "<td>" . $score_row['score_comments'] . "</td>";
        echo "<td>" . $score_row['cat_type'] . "</td>"; // Display cat_type instead of categoryId
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No score data available.</td></tr>";
}
echo "</table>";
echo "</div>";
echo "</div>";
?>
