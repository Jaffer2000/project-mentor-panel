<?php
// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Prepare the query
$query = "SELECT * FROM company";

// Execute the query
$result = $conn->query($query);

// Check if the query was successful
if ($result && $result->num_rows > 0) {
    // Fetch the data from the result set
    while ($row = $result->fetch_assoc()) {
        
            
    }
} else {
    echo "Der is geen data gevonden!";
}

    // Close the result set
    $result->close();
?>

<div class="container">
    <!-- Zoekbalk + bedrijfsnaam -->
    <div class="row">
        <div class="col-sm-6">
            <?php

                $companyname = "Bedrijfsnaam";

                echo"<h1>$companyname</h1>";
            
            ?>


        </div>

        <div class="col-sm-6">
           
            <div class="search-bar">
                <input type="text" class="search-input" placeholder="">
                <div class="search-icon">&#128269;</div>
            </div>


        </div>
    </div>

    <!-- Bedrijfsoverzicht + socials -->
    <div class="row rowpaddingtopcompanies">
        <div class="col-sm-6">
            <?php

                $productowner = "product eigenaar";
                $teammembers = "Test 1, Test 2, Test 3, Test4";
                $group = "SD/MV 3";



                echo"<p class=\"companyoverview\">Company Overview: </p>";
                echo"<br><p>Product owner: $productowner</p>";
                echo"<br><p>Team members: $teammembers</p>";
                echo"<br><p>Group: $group</p>";
            
            ?>
        </div>

        <div class="col-sm-6">

            <?php

                $social1 = "instagram";
                $social2 = "facebook";
                $social3 = "tik tok";

                echo"<p class=\"companyoverview\">Socials: </p>";
                echo"<a href=\"$social1\"> $social1</a> <br><br>";
                echo"<a href=\"$social2\">$social2</a> <br><br>";
                echo"<a href=\"$social3\">$social3</a>";

            ?>

        </div>
    </div>
</div>