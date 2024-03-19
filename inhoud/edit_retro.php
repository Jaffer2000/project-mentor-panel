<?php
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $retro_id = $_POST['id'];
    $ret_keep = $_POST['ret_keep'];
    $ret_problem = $_POST['ret_problem'];
    $ret_try = $_POST['ret_try'];
    $ret_sprint = $_POST['ret_sprint'];
    $company_id = $_POST['company'];

    // Sanitize input
    $retro_id = mysqli_real_escape_string($conn, $retro_id);
    $ret_keep = mysqli_real_escape_string($conn, $ret_keep);
    $ret_problem = mysqli_real_escape_string($conn, $ret_problem);
    $ret_try = mysqli_real_escape_string($conn, $ret_try);
    $ret_sprint = mysqli_real_escape_string($conn, $ret_sprint);
    $company_id = mysqli_real_escape_string($conn, $company_id);

    // Update retro details in the database
    $update_query = "UPDATE retrospective SET ret_keep = '$ret_keep', ret_problem = '$ret_problem', ret_try = '$ret_try', ret_sprint = '$ret_sprint', companyId = '$company_id' WHERE id = $retro_id";

    if ($conn->query($update_query) === TRUE) {
        // Retrospective updated successfully
        // Redirect to the retro list page or display a success message
        header('Location: index.php?pagina=retrospectives');
        exit();
    } else {
        // Handle update failure
        // Redirect or display an error message
        echo "Error updating retrospective: " . $conn->error;
    }
}

// Fetch retro details based on ID
if (isset($_GET['id'])) {
    $retro_id = $_GET['id'];

    // Fetch retro details based on ID
    $retro_query = "SELECT * FROM retrospective WHERE id = $retro_id";
    $retro_result = $conn->query($retro_query);

    if ($retro_result && $retro_result->num_rows > 0) {
        $retro_row = $retro_result->fetch_assoc();
    } else {
        // Handle retro not found
        // Redirect or display an error message
        header('Location: index.php?pagina=retrospectives');
        exit();
    }
} else {
    // Handle missing ID parameter
    // Redirect or display an error message
    header('Location: index.php?pagina=retrospectives');
    exit();
}

// Fetch companies
$company_query = "SELECT * FROM company";
$company_result = $conn->query($company_query);
?>

<div class="container-fluid addRetro">
    <div class="row ">
        <div class='col-md-6'>
            <h2 class="addRetroHeader">Edit Retrospective</h2>
            <form action="" method="post">
                <!-- Populate form fields with existing values -->
                <input type="hidden" name="id" value="<?php echo $retro_id; ?>">
                <div class="form-group">
                    <label for="keep">Keep:</label>
                    <input type="text" name="ret_keep" id="keep" class="form-control"
                        value="<?php echo $retro_row['ret_keep']; ?>">
                </div>
                <div class="form-group">
                    <label for="problem">Problem:</label>
                    <input type="text" name="ret_problem" id="problem" class="form-control"
                        value="<?php echo $retro_row['ret_problem']; ?>">
                </div>
                <div class="form-group">
                    <label for="try">Try:</label>
                    <input type="text" name="ret_try" id="try" class="form-control"
                        value="<?php echo $retro_row['ret_try']; ?>">
                </div>
                <div class="form-group">
                    <label for="sprint">Sprint:</label>
                    <input type="text" name="ret_sprint" id="sprint" class="form-control"
                        value="<?php echo $retro_row['ret_sprint']; ?>">
                </div>
                <div class="form-group">
                    <label for="company">Company:</label>
                    <select name="company" id="company" class="form-control">
                        <option value="">Select Company</option>
                        <?php
                        if ($company_result && $company_result->num_rows > 0) {
                            while ($company_row = $company_result->fetch_assoc()) {
                                $selected = ($company_row['id'] == $retro_row['companyId']) ? 'selected' : '';
                                echo "<option value='" . $company_row['id'] . "' $selected>" . $company_row['comp_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="buttonsForm">
                    <a href="index.php?pagina=retrospectives" class="btn btn-secondary"
                        style='padding: 8px 12px; margin-right: 5px; border-radius: 5px; background-color: #fff; color: #2F4D63; border: 1.2px #2F4D63 solid; cursor: pointer;'>Back</a>
                    <button type="submit" class="btn btn-primary"
                        style='padding: 8px 12px; border-radius: 5px; background-color: #2F4D63; color: #fff; border: none; cursor: pointer;'>Save</button>
                </div>
            </form>
        </div>
        <div class='col-md-6 d-flex justify-content-center align-items-center'>
            <img src="img/undraw_undraw_undraw_notebook_ask4_w99c_1d85.svg" style="max-width: 400px; height: auto;"
                alt="Retro illustration">
        </div>
    </div>
</div>