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

$category_query = "SELECT * FROM category";
$category_result = $conn->query($category_query);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $companyId = $_POST['company'];
    $keep = $_POST['keep'];
    $problem = $_POST['problem'];
    $try = $_POST['try'];
    $sprint = $_POST['sprint'];

    // Insert Score into database
    $insert_query = "INSERT INTO score (companyId, ret_keep, ret_problem, ret_try, ret_sprint) 
   VALUES ('$companyId', '$keep', '$problem', '$try', '$sprint')";

    if ($conn->query($insert_query) === TRUE) {
        // Redirect to Scores page
        header('Location: index.php?pagina=Scores');
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
                    <input name="keep" id="keep" class="form-control" required></input>
                </div>
                <div class="form-group">
                    <label for="DateCaptured">Date Captured:</label>
                    <input type="date" name="problem" id="problem" class="form-control" required></input>
                </div>
                <div class="form-group">
                    <label for="try">Catagory:</label>
                    <select name="company" id="company" class="form-control" required>
                        <option value="">Select Catagory</option>
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
                    <label for="sprint">Score activity:</label>
                    <input type="text" name="sprint" id="sprint" class="form-control" required>
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
                    <textarea name="problem" id="problem" class="form-control" required></textarea>
                </div>
                <div class="buttonsForm">
                    <a href="index.php?pagina=Scores" class="btn btn-secondary" style='padding: 8px 12px; margin-right: 5px; border-radius: 5px; background-color: #fff; color: #2F4D63; border: 1.2px #2F4D63 solid; cursor: pointer;'>Back</a>
                    <button type="submit" class="btn btn-primary" style='padding: 8px 12px; border-radius: 5px; background-color: #2F4D63; color: #fff; border: none; cursor: pointer;'>Add
                        Score</button>
                </div>
            </form>
        </div>
        <div class='col-md-6 d-flex justify-content-center align-items-center'>
            <img src="img/undraw_undraw_undraw_notebook_ask4_w99c_1d85" style="max-width: 70%; height: auto;" <img src="img/undraw_undraw_undraw_notebook_ask4_w99c_1d85" style="max-width: 350px; height: auto;" alt="Retro illustration">
        </div>
    </div>
</div>

<script>