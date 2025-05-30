<?php
// Include your database connection file
require_once 'db_connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch companies
$company_query = "SELECT * FROM company";
$company_result = $conn->query($company_query);

// Fetch categories
$category_query = "SELECT * FROM category";
$category_result = $conn->query($category_query);

// Fetch scores
$score_query = "SELECT * FROM score";
$score_result = $conn->query($score_query);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $score_points = $_POST['points'];
    $score_date = $_POST['date'];
    $category_id = $_POST['category'];
    $score_activity = $_POST['activity'];
    $company_id = $_POST['company'];
    $score_comments = $_POST['comment'];

    // Performing insert query execution
    $insert_query = "INSERT INTO score (score_points, score_date, companyId, categoryId, score_activity, score_comments)
    VALUES ('$score_points','$score_date','$company_id','$category_id','$score_activity','$score_comments')";

    if ($conn->query($insert_query) === TRUE) {
        // Redirect to scoring page
        header('Location: index.php?pagina=scoring');
        exit();
    } else {

    echo "Error: " . $insert_query . "<br>" . $conn->error;
    
    }
}
?>

<div class="container-fluid addRetro">
    <div class="row ">
        <div class='col-md-6'>
            <h2 class="addRetroHeader">Add Score</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="Points">Points:</label>
                    <input name="points" id="points" class="form-control" required step="0.01"></input>
                </div>
                <div class="form-group">
                    <label for="DateCaptured">Date Captured:</label>
                    <input type="date" name="date" id="date" class="form-control" required></input>
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php
                        if ($category_result && $category_result->num_rows > 0) {
                            while ($company_row = $category_result->fetch_assoc()) {
                                echo "<option value='" . $company_row['id'] . "'>" . $company_row['cat_type'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="activity">Score activity:</label>
                    <input type="text" name="activity" id="activity" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="company">Company:</label>
                    <select name="company" id="company" class="form-control" required>
                        <option value="">Select Company</option>
                        <?php
                        if ($company_result && $company_result->num_rows > 0) {
                            while ($company_row = $company_result->fetch_assoc()) {
                                echo "<option value='" . $company_row['id'] . "'>" . $company_row['comp_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="problem">Comments:</label>
                    <textarea name="comment" id="Comment" class="form-control" required></textarea>
                </div>
                <div class="buttonsForm">
                    <a href="index.php?pagina=scoring" class="btn btn-secondary"
                        style='padding: 8px 12px; margin-right: 5px; border-radius: 5px; background-color: #fff; color: #2F4D63; border: 1.2px #2F4D63 solid; cursor: pointer;'>Back</a>
                    <button type="submit" class="btn btn-primary"
                        style='padding: 8px 12px; border-radius: 5px; background-color: #2F4D63; color: #fff; border: none; cursor: pointer;'>Add
                        Score</button>
                </div>
            </form>
        </div>
        <div class='col-md-6 d-flex justify-content-center align-items-center'>
            <img src="img/scoreimg.jpg" style="max-width: 70%; height: auto;" alt="Score list">
        </div>
    </div>
</div>

<script src="js/script.js"></script>