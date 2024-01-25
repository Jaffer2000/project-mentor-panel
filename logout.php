<?php
session_start(); // Start a new session or resume the existing session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header('Location: index.php');
exit();
?>