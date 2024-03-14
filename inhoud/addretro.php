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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $companyId = $_POST['company'];
    $keep = $_POST['keep'];
    $problem = $_POST['problem'];
    $try = $_POST['try'];
    $sprint = $_POST['sprint'];

    // Insert retrospective into database
    $insert_query = "INSERT INTO retrospective (companyId, ret_keep, ret_problem, ret_try, ret_sprint) 
   VALUES ('$companyId', '$keep', '$problem', '$try', '$sprint')";

    if ($conn->query($insert_query) === TRUE) {
        // Redirect to retrospectives page
        header('Location: index.php?pagina=retrospectives');
        exit();
    } else {

        echo "Error: " . $insert_query . "<br>" . $conn->error;
    }
}
?>

<div class="container-fluid addRetro">
    <div class="row">
        <div class='col-md-6'>
            <h2 class="addRetroHeader">Add Retrospective</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="keep">Keep:</label>
                    <textarea name="keep" id="keep" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="problem">Problem:</label>
                    <textarea name="problem" id="problem" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="try">Try:</label>
                    <textarea name="try" id="try" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="sprint">Sprint:</label>
                    <input type="number" name="sprint" id="sprint" class="form-control" required>
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
                <div class="buttonsForm">
                    <a href="index.php?pagina=retrospectives" class="btn btn-secondary" style='padding: 8px 12px; margin-right: 5px; border-radius: 5px; background-color: #fff; color: #2F4D63; border: 1.2px #2F4D63 solid; cursor: pointer;'>Back</a>
                    <button type="submit" class="btn btn-primary" style='padding: 8px 12px; border-radius: 5px; background-color: #2F4D63; color: #fff; border: none; cursor: pointer;'>Add
                        Retrospective</button>
                </div>
            </form>
        </div>
        <div class='col-md-6 d-flex justify-content-center align-items-center'>
            <img src="img/undraw_undraw_undraw_notebook_ask4_w99c_1d85.svg" style="max-width: 400px; height: auto;" alt="Retro illustration">
        </div>
    </div>
</div>


