<?php
require_once 'db_connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $reflection_id = $_POST['id'];
    $refl_talents = $_POST['refl_talents'];
    $refl_pitfalls = $_POST['refl_pitfalls'];
    $refl_talother = $_POST['refl_talother'];
    $refl_sprint = $_POST['refl_sprint'];
    $member_id = $_POST['member'];

    // Sanitize input
    $reflection_id = mysqli_real_escape_string($conn, $reflection_id);
    $refl_talents = mysqli_real_escape_string($conn, $refl_talents);
    $refl_pitfalls = mysqli_real_escape_string($conn, $refl_pitfalls);
    $refl_talother = mysqli_real_escape_string($conn, $refl_talother);
    $refl_sprint = mysqli_real_escape_string($conn, $refl_sprint);
    $member_id = mysqli_real_escape_string($conn, $member_id);

    // Update reflection details in the database
    $update_query = "UPDATE reflection SET refl_talents = '$refl_talents', refl_pitfalls = '$refl_pitfalls', refl_talother = '$refl_talother', refl_sprint = '$refl_sprint', memberId = '$member_id' WHERE id = $reflection_id";

    if ($conn->query($update_query) === TRUE) {
        // Reflection updated successfully
        // Redirect to the reflection list page or display a success message
        header('Location: index.php?pagina=reflection');
        exit();
    } else {
        // Handle update failure
        // Redirect or display an error message
        echo "Error updating reflection: " . $conn->error;
    }
}

// Fetch reflection details based on ID
if (isset($_GET['id'])) {
    $reflection_id = $_GET['id'];

    // Fetch reflection details based on ID
    $reflection_query = "SELECT * FROM reflection WHERE id = $reflection_id";
    $reflection_result = $conn->query($reflection_query);

    if ($reflection_result && $reflection_result->num_rows > 0) {
        $reflection_row = $reflection_result->fetch_assoc();
    } else {
        // Handle reflection not found
        // Redirect or display an error message
        header('Location: index.php?pagina=reflection');
        exit();
    }
} else {
    // Handle missing ID parameter
    // Redirect or display an error message
    header('Location: index.php?pagina=reflection');
    exit();
}

// Fetch members
$member_query = "SELECT * FROM members";
$member_result = $conn->query($member_query);
?>

<div class="container-fluid addRetro">
    <div class="row ">
        <div class='col-md-6'>
            <h2 class="addRetroHeader">Edit Reflection</h2>
            <form action="" method="post">
                <!-- Populate form fields with existing values -->
                <input type="hidden" name="id" value="<?php echo $reflection_id; ?>">
                <div class="form-group">
                    <label for="talents">Talents:</label>
                    <input type="text" name="refl_talents" id="talents" class="form-control"
                        value="<?php echo $reflection_row['refl_talents']; ?>">
                </div>
                <div class="form-group">
                    <label for="pitfalls">Pitfalls:</label>
                    <input type="text" name="refl_pitfalls" id="pitfalls" class="form-control"
                        value="<?php echo $reflection_row['refl_pitfalls']; ?>">
                </div>
                <div class="form-group">
                    <label for="talother">Talents Noted by others:</label>
                    <input type="text" name="refl_talother" id="talother" class="form-control"
                        value="<?php echo $reflection_row['refl_talother']; ?>">
                </div>
                <div class="form-group">
                    <label for="sprint">Sprint:</label>
                    <input type="text" name="refl_sprint" id="sprint" class="form-control"
                        value="<?php echo $reflection_row['refl_sprint']; ?>">
                </div>
                <div class="form-group">
                    <label for="member">Member:</label>
                    <select name="member" id="member" class="form-control">
                        <option value="">Select Member</option>
                        <?php
                        if ($member_result && $member_result->num_rows > 0) {
                            while ($member_row = $member_result->fetch_assoc()) {
                                $selected = ($member_row['id'] == $reflection_row['memberId']) ? 'selected' : '';
                                echo "<option value='" . $member_row['id'] . "' $selected>" . $member_row['mem_name'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="buttonsForm">
                    <a href="index.php?pagina=reflection" class="btn btn-secondary"
                        style='padding: 8px 12px; margin-right: 5px; border-radius: 5px; background-color: #fff; color: #2F4D63; border: 1.2px #2F4D63 solid; cursor: pointer;'>Back</a>
                    <button type="submit" class="btn btn-primary"
                        style='padding: 8px 12px; border-radius: 5px; background-color: #2F4D63; color: #fff; border: none; cursor: pointer;'>Save</button>
                </div>
            </form>
        </div>
        <div class='col-md-6 d-flex justify-content-center align-items-center'>
            <img src="img/undraw_informed_decision_p2lh.svg" style="max-width: 420px; height: auto;"
                alt="Reflection illustration">
        </div>
    </div>
</div>