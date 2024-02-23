<?php
// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Define the prependProtocolIfMissing function
function prependProtocolIfMissing($url) {
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "https://" . $url;
    }
    return $url;
}

// Fetch companies
$query = "SELECT * FROM company";
$result = $conn->query($query);

// Check if the query was successful
if ($result && $result->num_rows > 0) {
    // Display dropdown menu for selecting a company
    echo "<div class='container-fluid company'>";
    echo "<div class='row companyNameAndDropdown'>";
    echo "<div class='col-md-6'>";
    // Output the company name
    if (isset($_GET['company_id'])) {
        $selected_company_id = $_GET['company_id'];
        $selected_company_query = "SELECT comp_name FROM company WHERE id = $selected_company_id";
        $selected_company_result = $conn->query($selected_company_query);
        if ($selected_company_result && $selected_company_result->num_rows > 0) {
            $selected_company_row = $selected_company_result->fetch_assoc();
            $companyname = $selected_company_row['comp_name'];
            echo "<h1>$companyname</h1>";
        }
    } else {
        $first_company_query = "SELECT comp_name FROM company LIMIT 1";
        $first_company_result = $conn->query($first_company_query);
        if ($first_company_result && $first_company_result->num_rows > 0) {
            $first_company_row = $first_company_result->fetch_assoc();
            $companyname = $first_company_row['comp_name'];
            echo "<h1>$companyname</h1>";
        }
    }
    echo "</div>";
    echo "<div class='col-md-6'>";
    echo "<select id='company' name='company' class='form-control'>";
    while ($row = $result->fetch_assoc()) {
        $company_id = $row['id'];
        $companyname = $row['comp_name'];
        $selected = isset($_GET['company_id']) && $_GET['company_id'] == $company_id ? 'selected' : '';
        echo "<option value='$company_id' $selected>$companyname</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "</div>";

    // JavaScript to handle the change event of the dropdown menu
    echo "<script>
    document.getElementById('company').addEventListener('change', function() {
        var companyId = this.value;
        // Redirect to the index.php page with the company ID as a query parameter
        window.location.href = 'http://localhost/innovatie/index.php?pagina=companies&company_id=' + companyId;
    });
</script>
";

    // Check if a specific company is selected
    if (isset($_GET['company_id'])) {
        $selected_company_id = $_GET['company_id'];
    } else {
        // If no specific company is selected, fetch details of the first company
        $first_company_query = "SELECT * FROM company LIMIT 1";
        $first_company_result = $conn->query($first_company_query);

        if ($first_company_result && $first_company_result->num_rows > 0) {
            $first_company_row = $first_company_result->fetch_assoc();
            $selected_company_id = $first_company_row['id'];
        } else {
            echo "No companies found!";
            exit(); // Exit if no companies are found
        }
    }

    // Fetch details of the selected company
    $selected_company_query = "SELECT * FROM company WHERE id = $selected_company_id";
    $selected_company_result = $conn->query($selected_company_query);

    // Display details of the selected company
    if ($selected_company_result && $selected_company_result->num_rows > 0) {
        $selected_company_row = $selected_company_result->fetch_assoc();
        $companyname = $selected_company_row['comp_name'];
        $productowner = $selected_company_row['comp_po'];
        $coach = $selected_company_row['comp_coach'];
        $teammembers = $selected_company_row['comp_members'];
        $link = $selected_company_row['comp_link'];
        $social1 = $selected_company_row['comp_social1'];
        $social2 = $selected_company_row['comp_social2'];
        $social3 = $selected_company_row['comp_social3'];
        $group = $selected_company_row['company_group'];

        // Display company overview and social links
       
        echo "<div class='row companyOverviewAndSocials'>";
        echo "<div class='col-md-6'>";
        echo "<h5>Company Overview</h5>";
        echo "<p>Product owner: $productowner</p>";
        echo "<p>Team members: $teammembers</p>";
        echo "<p>Group: $group</p>";
        echo "</div>";

        echo "<div class='col-md-6'>";
        // Display social links
        echo "<h5>Social Links</h5>";
        if (!empty($social1)) {
            $social1 = prependProtocolIfMissing($social1);
            echo "<p><a href='$social1' target='_blank'>$social1</a></p>";
        }
        if (!empty($social2)) {
            $social2 = prependProtocolIfMissing($social2);
            echo "<p><a href='$social2' target='_blank'>$social2</a></p>";
        }
        if (!empty($social3)) {
            $social3 = prependProtocolIfMissing($social3);
            echo "<p><a href='$social3' target='_blank'>$social3</a></p>";
        }
        echo "</div>";
        echo "</div>";

        // Fetch scoring
        $scoring_query = "SELECT c.cat_type, SUM(s.score_points) AS total_score FROM score s
                          INNER JOIN category c ON s.categoryId = c.id
                          WHERE s.companyId = $selected_company_id
                          GROUP BY s.categoryId";
        $scoring_result = $conn->query($scoring_query);

        // Fetch products
        $product_query = "SELECT * FROM product WHERE companyId = $selected_company_id";
        $product_result = $conn->query($product_query);

        // Fetch retrospectives
        $retrospective_query = "SELECT * FROM retrospective WHERE companyId = $selected_company_id";
        $retrospective_result = $conn->query($retrospective_query);

       // Fetch member qualities
       $member_qualities_query = "SELECT m.mem_name, r.refl_talents, r.refl_pitfalls, r.refl_talother, r.refl_sprint
       FROM members m
       INNER JOIN reflection r ON m.id = r.memberId
       WHERE m.companyId = $selected_company_id";
        $member_qualities_result = $conn->query($member_qualities_query);

        // Display scoring table
        echo "<h5>Scoring</h5>";
        echo "<div class='table-responsive'>";
        echo "<table class='table' style='background-color: #F5F5F5;'>";
        echo "<tr><th>Category</th><th>Total Score</th></tr>";
        if ($scoring_result && $scoring_result->num_rows > 0) {
            while ($scoring_row = $scoring_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $scoring_row['cat_type'] . "</td>";
                echo "<td>" . $scoring_row['total_score'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No scoring data available.</td></tr>";
        }
        echo "</table>";
        echo "</div>";

        // Display product table
        echo "<h5>Products</h5>";
        echo "<div class='table-responsive'>";
        echo "<table class='table' style='background-color: #F5F5F5;'>";
        echo "<tr><th>Product Name</th><th>Description</th><th>Customer Benefits</th><th>Sprint MVP</th></tr>";
        if ($product_result && $product_result->num_rows > 0) {
            while ($product_row = $product_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $product_row['prod_name'] . "</td>";
                echo "<td>" . $product_row['prod_description'] . "</td>";
                echo "<td>" . $product_row['prod_benefits'] . "</td>";
                echo "<td>" . $product_row['prod_sprintMvp'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No product data available.</td></tr>";
        }
        echo "</table>";
        echo "</div>";

        // Display retrospective table
        echo "<h5>Retrospectives</h5>";
        echo "<div class='table-responsive'>";
        echo "<table class='table' style='background-color: #F5F5F5;'>";
        echo "<tr><th>Sprint</th><th>Keep</th><th>Problem</th><th>Try</th></tr>";
        if ($retrospective_result && $retrospective_result->num_rows > 0) {
            while ($retrospective_row = $retrospective_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $retrospective_row['ret_sprint'] . "</td>";
                echo "<td>" . $retrospective_row['ret_keep'] . "</td>";
                echo "<td>" . $retrospective_row['ret_problem'] . "</td>";
                echo "<td>" . $retrospective_row['ret_try'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No retrospective data available.</td></tr>";
        }
        echo "</table>";
        echo "</div>";

        // Display member qualities table
        echo "<h5>Member Qualities</h5>";
        echo "<div class='table-responsive'>";
        echo "<table class='table' style='background-color: #F5F5F5;'>";
        echo "<tr><th>Member Name</th><th>Talents</th><th>Pitfalls</th><th>Reflected by Others</th><th>Sprint</th></tr>";
        if ($member_qualities_result && $member_qualities_result->num_rows > 0) {
            while ($member_row = $member_qualities_result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $member_row['mem_name'] . "</td>";
                echo "<td>" . $member_row['refl_talents'] . "</td>";
                echo "<td>" . $member_row['refl_pitfalls'] . "</td>";
                echo "<td>" . $member_row['refl_talother'] . "</td>";
                echo "<td>" . $member_row['refl_sprint'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No member qualities data available.</td></tr>";
        }
        echo "</table>";
        echo "</div>";

        echo "</div>";
        echo "</div>";
    } else {
        echo "Selected company not found!";
    }
} else {
    echo "There is no data found!";
}

// Close the result sets
$result->close();
?>