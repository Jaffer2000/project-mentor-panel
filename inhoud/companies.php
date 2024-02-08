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
        
        $id = $row['id'];
        $companyname = $row['comp_name'];
        $productowner = $row['comp_po'];
        $coach = $row['comp_coach'];
        $teammembers = $row['comp_members'];
        $link = $row['comp_link'];
        $social1 = $row['comp_social1'];
        $social2 = $row['comp_social2'];
        $social3 = $row['comp_social3'];
        $group = $row['company_group'];
            
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

                echo"<p class=\"companyoverview\">Company Overview: </p>";
                echo"<br><p>Product owner: $productowner</p>";
                echo"<br><p>Team members: $teammembers</p>";
                echo"<br><p>Group: $group</p>";
            
            ?>
        </div>

        <div class="col-sm-6">

            <?php

                echo"<p class=\"companyoverview\">Socials: </p>";
                echo"<a href=\"$social1\"> $social1</a> <br><br>";
                echo"<a href=\"$social2\">$social2</a> <br><br>";
                echo"<a href=\"$social3\">$social3</a>";

            ?>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <table>
    <tbody>
        <tr>
            <td colspan="10">Categorie type</td>
            <td colspan="10">Scoring summary</td>
        </tr>
        <tr>
            <td >Product name</td>
            <td>Description of product</td>
            <td>Customer benefits</td>
            <td>Sprint MVP</td>
        </tr>
        <tr>
            <td>Sprint</td>
            <td>Keep</td>
            <td>Problem</td>
            <td>Try</td>
        </tr>
        <tr>
            <td>Member Name</td>
            <td>Talents</td>
            <td>Pitfalls</td>
            <td>Reflected by other</td>
            <td>Sprint</td>
        </tr>
    </tbody>
</table>

        </div>
    </div>


</div>