<?php
// Include your database connection file
require_once 'db_connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch companies
$member_query = "SELECT * FROM members";
$member_result = $conn->query($member_query);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $memberId = $_POST['id'];
    $pitfalls = $_POST['pitfalls'];
    $note = $_POST['note'];
    $talents = $_POST['talents'];
    $sprint = $_POST['sprint'];
    
    // Insert retrospective into database
    $insert_query = "INSERT INTO reflection (memberId, refl_pitfalls, refl_talother, refl_talents, refl_sprint) 
    VALUES ('$memberId', '$pitfalls', '$note', '$talents', '$sprint')";
    
    if ($conn->query($insert_query) === TRUE) {
    // Redirect to retrospectives page
    header('Location: index.php?pagina=reflection');
    exit();

    } else {

    echo "Error: " . $insert_query . "<br>" . $conn->error;

    }
}
?>

<div class="container-fluid addRetro">
    <div class="row">
        <div class='col-md-6'>
            <h2 class="addRetroHeader">Add Reflection</h2>
            <form action="" method="post">
                <div class="form-group">
                    <label for="keep">Talents:</label>
                    <textarea name="talents" id="talents" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="problem">Pitfalls:</label>
                    <textarea name="pitfalls" id="pitfalls" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="try">Talents Noted by others:</label>
                    <textarea name="note" id="note" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="sprint">Sprint:</label>
                    <input type="text" name="sprint" id="sprint" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="company">Member:</label>
                    <select name="id" id="company" class="form-control" required>
                        <option value="">Select Member</option>
                        <?php
                    if ($member_result && $member_result->num_rows > 0) {
                        while ($member_row = $member_result->fetch_assoc()) {
                            echo "<option value='" . $member_row['id'] . "'>" . $member_row['mem_name'] . "</option>";
                        }
                    }
                    ?>
                    </select>
                </div>
                <div class="buttonsForm">
                    <a href="index.php?pagina=reflection" class="btn btn-secondary"
                        style='padding: 8px 12px; margin-right: 5px; border-radius: 5px; background-color: #fff; color: #2F4D63; border: 1.2px #2F4D63 solid; cursor: pointer;'>Back</a>
                    <button type="submit" class="btn btn-primary"
                        style='padding: 8px 12px; border-radius: 5px; background-color: #2F4D63; color: #fff; border: none; cursor: pointer;'>Add
                        Refelection</button>
                </div>
            </form>
        </div>
        <div class='col-md-6 d-flex justify-content-center align-items-center'>
            <img src="img/undraw_team_spirit_re_yl1v.svg" style="max-width: 420px; height: auto;"
                alt="Retro illustration">
        </div>
    </div>
</div>