<?php
// Include your database connection file
require_once 'db_connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch companies
$score_query = "SELECT * FROM score";
$score_result = $conn->query($score_query);

if (isset($_POST)) {
    // Taking all 5 values from the form data(input)
    $score_points = $_REQUEST['points'];
    $score_date = $_REQUEST['date'];
    $category_id = $_REQUEST['category'];
    $score_activity = $_REQUEST['activity'];
    $company_id = $_REQUEST['company'];
    $score_comments = $_REQUEST['comment'];

    // Performing insert query execution
    // here our table name is score
    $sql = "INSERT INTO score (score_points, score_date, companyId, categoryId, score_activity, score_comments)
    VALUES ('$score_points','$score_date','$company_id','$category_id','$score_activity','$score_comments')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to scoring page
        header('Location: index.php?pagina=scoring');
        exit();
    }
}
?>