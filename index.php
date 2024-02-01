<!DOCTYPE html>
<html lang="en">
<?php
// Check if the session has not been started
if (session_status() == PHP_SESSION_NONE) {
    // Start the session
    session_start();
}

if (isset($_GET["pagina"])) {
    $pagina = $_GET["pagina"];
} else {
    // Check if the user is not logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to the login page
        $pagina = "login";
    } else {
        // User is logged in, set the default page to "dashboard"
        $pagina = "dashboard";
    }
}

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
<?php include ("header.php"); ?>
    

    <div class="content">
        <!--pagina inhoud-->
        <?php include "inhoud/$pagina.php"; ?>
    </div>
    

</body>

</html>