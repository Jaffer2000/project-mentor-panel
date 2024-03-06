<?php
// Include your database connection file
require_once 'db_connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Fetch scores with category and company information
$score_query = "SELECT s.score_points, s.score_date, s.companyId, s.score_activity, s.score_comments, s.categoryId, c.cat_type, co.comp_name
                FROM score s
                LEFT JOIN category c ON s.categoryId = c.id
                LEFT JOIN company co ON s.companyId = co.id";
$score_result = $conn->query($score_query);
?>

<div class='container-fluid retrospectives'>
    <div class='row headerAndSearchBar'>
        <div class='col-md-6'>
            <h2>Score List</h2>
        </div>
        <div class='col-md-6'>
            <div class='search-container'>
                <input type='text' id='searchInput' onkeyup='searchTable()' placeholder='Search'>
                <i class='fas fa-search search-icon'></i> <!-- Font Awesome search icon -->
                <button onclick='addScore()' style='padding: 8px 12px; border-radius: 5px; background-color: #2F4D63; color: #fff; border: none; cursor: pointer;'>
                    <i class='fas fa-plus'></i> Add Score
                </button>
            </div>
        </div>
    </div>

    <div class='table-responsive'>
        <table class='table' style='background-color: #F5F5F5;' id='retroTable'>
            <tr>
                <th>Points</th>
                <th>Date</th>
                <th>Company</th>
                <th>For</th>
                <th>Comments</th>
                <th>Category</th>
            </tr>
            <?php
            if ($score_result && $score_result->num_rows > 0) {
                while ($score_row = $score_result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $score_row['score_points'] . "</td>";

                    // Format 'score_date' to dd/mm/yyyy
                    $scoreDate = DateTime::createFromFormat('Y-m-d', $score_row['score_date']);
                    echo "<td>" . $scoreDate->format('d/m/Y') . "</td>";

                    echo "<td>" . $score_row['comp_name'] . "</td>";
                    echo "<td>" . $score_row['score_activity'] . "</td>";
                    echo "<td>" . $score_row['score_comments'] . "</td>";
                    echo "<td>" . $score_row['cat_type'] . "</td>";

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No score data available.</td></tr>";
            }
            ?>
        </table>
    </div>

    <?php
    // Count the total number of scores
    $total_scores_query = "SELECT COUNT(*) AS total_scores FROM score";
    $total_scores_result = $conn->query($total_scores_query);
    $total_scores = ($total_scores_result) ? $total_scores_result->fetch_assoc()['total_scores'] : 0;

    // Calculate the range of displayed items
    $start_range = ($total_scores > 0) ? 1 : 0;
    $end_range = ($score_result && $score_result->num_rows > 0) ? $start_range + $score_result->num_rows - 1 : 0;
    ?>

    <div class='counter'>
        <?php echo "$start_range to $end_range of $total_scores items"; ?>
    </div>
</div>

<script>
function searchTable() {
    // Declare variables
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("retroTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td");
        for (var j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                    break;
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    function addScore() {
        // Redirect to addretro.php
        window.location.href = 'index.php?pagina=addscore';

}
}
</script>