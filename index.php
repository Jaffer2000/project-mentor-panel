<!DOCTYPE html>
<html lang="en">
<?php
// Check if the session has not been started
if (session_status() == PHP_SESSION_NONE) {
    // Start the session
    session_start();
}

// Check if the user is not logged in
if (!isset($_SESSION['user_id']) && !isset($_GET['pagina']) && $_GET['pagina'] !== 'login') {
    // Redirect to the login page
    header('Location: index.php?pagina=login');
    exit();
}

// Set the page variable
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : "dashboard";

?>

<head>
    <title>Mini Companies</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--Booststrap 4-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!--Chart.js-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!--Own css-->
    <link href="css/styles.css" rel="stylesheet">

    <!--Icons-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href='https://unpkg.com/css.gg@2.0.0/icons/css/phone.css' rel='stylesheet'>

    <!--Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

</head>

<body>
    <!-- Header -->
    <?php 
    if ($pagina !== 'login') {
        include("header.php");
    }
    ?>
    <div class="content">
        <!--pagina inhoud-->
        <?php include "inhoud/$pagina.php"; ?>
    </div>

</body>

</html>