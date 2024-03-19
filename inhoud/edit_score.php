<?php
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $score_id = $_POST['id'];
    $score_points = $_POST['score_points'];
    $score_date = $_POST['score_date'];
    $category_id = $_POST['category'];
    $score_activity = $_POST['score_activity'];
    $company_id = $_POST['company'];
    $score_comments = $_POST['score_comments'];

    // Sanitize input
    $score_id = mysqli_real_escape_string($conn, $score_id);
    $score_points = mysqli_real_escape_string($conn, $score_points);
    $score_date = mysqli_real_escape_string($conn, $score_date);
    $category_id = mysqli_real_escape_string($conn, $category_id);
    $score_activity = mysqli_real_escape_string($conn, $score_activity);
    $company_id = mysqli_real_escape_string($conn, $company_id);
    $score_comments = mysqli_real_escape_string($conn, $score_comments);

    // Update score details in the database
    $update_query = "UPDATE score SET score_points = '$score_points', score_date = '$score_date', categoryId = '$category_id', companyId = '$company_id', score_activity = '$score_activity', score_comments = '$score_comments' WHERE id = $score_id";

    if ($conn->query($update_query) === TRUE) {
        // Score updated successfully
        // Redirect to the score list page or display a success message
        header('Location: index.php?pagina=scoring');
        exit();
    } else {
        // Handle update failure
        // Redirect or display an error message
        echo "Error updating score: " . $conn->error;
    }
}

// Fetch score details based on ID
if (isset($_GET['id'])) {
    $score_id = $_GET['id'];

    // Fetch score details based on ID
    $score_query = "SELECT * FROM score WHERE id = $score_id";
    $score_result = $conn->query($score_query);

    if ($score_result && $score_result->num_rows > 0) {
        $score_row = $score_result->fetch_assoc();
    } else {
        // Handle score not found
        // Redirect or display an error message
        header('Location: index.php?pagina=scoring');
        exit();
    }
} else {
    // Handle missing ID parameter
    // Redirect or display an error message
    header('Location: index.php?pagina=scoring');
    exit();
}

// Fetch categories
$category_query = "SELECT * FROM category";
$category_result = $conn->query($category_query);

// Fetch companies
$company_query = "SELECT * FROM company";
$company_result = $conn->query($company_query);
?>

<div class="container-fluid addRetro">
    <div class="row ">
        <div class='col-md-6'>
            <h2 class="addRetroHeader">Edit Score</h2>
            <form action="" method="post">
                <!-- Populate form fields with existing values -->
                <input type="hidden" name="id" value="<?php echo $score_id; ?>">
                <div class="form-group">
                    <label for="points">Points:</label>
                    <input name="score_points" id="points" class="form-control"
                        value="<?php echo $score_row['score_points']; ?>">
                </div>
                <div class="form-group">
                    <label for="date">Date Captured:</label>
                    <input type="date" name="score_date" id="date" class="form-control"
                        value="<?php echo $score_row['score_date']; ?>">
                </div>
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Select Category</option>
                        <?php
                        if ($category_result && $category_result->num_rows > 0) {
                            while ($category_row = $category_result->fetch_assoc()) {
                                $selected = ($category_row['id'] == $score_row['categoryId']) ? 'selected' : '';
                                echo "<option value='" . $category_row['id'] . "' $selected>" . $category_row['cat_type'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="activity">Score activity:</label>
                    <input type="text" name="score_activity" id="activity" class="form-control"
                        value="<?php echo $score_row['score_activity']; ?>">
                </div>
                <div class="form-group">
                    <label for="company">Company:</label>
                    <select name="company" id="company" class="form-control">
                        <option value="">Select Company</option>
                        <?php
                        if ($company_result && $company_result->num_rows > 0) {
                            while ($company_row = $company_result->fetch_assoc()) {
                                $selected = ($company_row['id'] == $score_row['companyId']) ? 'selected' : '';
                                echo "<option value='" . $company_row['id'] . "' $selected>" . $company_row['comp_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comment">Comments:</label>
                    <textarea name="score_comments" id="comment" class="form-control"
                        required><?php echo $score_row['score_comments']; ?></textarea>
                </div>
                <div class="buttonsForm">
                    <a href="index.php?pagina=scoring" class="btn btn-secondary"
                        style='padding: 8px 12px; margin-right: 5px; border-radius: 5px; background-color: #fff; color: #2F4D63; border: 1.2px #2F4D63 solid; cursor: pointer;'>Back</a>
                    <button type="submit" class="btn btn-primary"
                        style='padding: 8px 12px; border-radius: 5px; background-color: #2F4D63; color: #fff; border: none; cursor: pointer;'>Save</button>
                </div>
            </form>
        </div>
        <div class='col-md-6 d-flex justify-content-center align-items-center'>
            <img src="img/scoreimg.jpg" style="max-width: 70%; height: auto;" alt="Score list">
        </div>
    </div>
</div>