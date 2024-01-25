<?php
// Include database connection file
include('db_connection.php');

session_start(); // Start a new session or resume the existing session

// Set the plain password
$plain_password = 'test123';

// Hash the password
$hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

// Update the user's record with the hashed password
$username = 'jaffer';
$update_query = "UPDATE users SET password_hash = ? WHERE username = ?";

// Use prepared statement
$stmt = mysqli_prepare($conn, $update_query);
mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $username);

// Execute the query
if (mysqli_stmt_execute($stmt)) {
    echo "Password updated successfully!";
} else {
    echo "Error updating password: " . mysqli_stmt_error($stmt);
}

// Close the statement
mysqli_stmt_close($stmt);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists in the database
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $user = mysqli_fetch_assoc($result);

        // Verify the password using password_verify
        if ($user && password_verify($password, $user['password_hash'])) {
            // Successful login
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            header('Location: ?pagina=dashboard'); // Redirect to the dashboard page
            exit();
        } else {
            // Invalid username or password
            $_SESSION['login_error'] = 'Invalid username or password';
            header('Location: index.php'); // Redirect back to the login page
            exit();
        }
    } else {
        // Database error
        $_SESSION['login_error'] = 'Database error';
        header('Location: index.php'); // Redirect back to the login page
        exit();
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // Redirect to the login page if accessed directly without form submission
    header('Location: index.php');
    exit();
}
?>