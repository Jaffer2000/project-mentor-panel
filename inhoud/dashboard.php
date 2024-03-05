<?php
// Include your database connection file
require_once 'db_connection.php';

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Initialize arrays to store aggregated scores for each company
$companyScores = [];

// Fetch data from the database for all scores
$sqlScores = "SELECT s.score_points, c.comp_name, ct.cat_type 
              FROM score s
              INNER JOIN company c ON s.companyId = c.id
              INNER JOIN category ct ON s.categoryId = ct.id";

$resultScores = $conn->query($sqlScores);

// Fetch and aggregate scores for each company
if ($resultScores->num_rows > 0) {
    while ($row = $resultScores->fetch_assoc()) {
        $compName = $row['comp_name'];
        $score = $row['score_points'];
        // Check if the company already exists in the aggregated scores array
        if (!isset($companyScores[$compName])) {
            $companyScores[$compName] = 0; // Initialize score for the company
        }
        // Add the score to the existing total score for the company
        $companyScores[$compName] += $score;
    }
}

// Sort the overall scores and labels in descending order based on scores
arsort($companyScores);

// Convert aggregated scores to labels and scores arrays for the Best Overall chart
$overallLabels = array_keys($companyScores);
$overallScores = array_values($companyScores);

// Fetch data from the database for the Best Development chart
$sqlDevelopment = "SELECT s.score_points, c.comp_name
                   FROM score s
                   INNER JOIN company c ON s.companyId = c.id
                   INNER JOIN category ct ON s.categoryId = ct.id
                   WHERE ct.cat_type = 'development'
                   ORDER BY s.score_points DESC
                   LIMIT 4";

$resultDevelopment = $conn->query($sqlDevelopment);

// Initialize arrays to store data for the Best Development chart
$developmentLabels = [];
$developmentScores = [];

// Fetch and format data for the Best Development chart
if ($resultDevelopment->num_rows > 0) {
    while ($row = $resultDevelopment->fetch_assoc()) {
        $developmentLabels[] = $row['comp_name'];
        $developmentScores[] = $row['score_points'];
    }
}

// Sort the Best Development scores and labels in descending order
array_multisort($developmentScores, SORT_DESC, $developmentLabels);

// Fetch data from the database for the Best Marketing chart
$sqlMarketing = "SELECT s.score_points, c.comp_name
                  FROM score s
                  INNER JOIN company c ON s.companyId = c.id
                  INNER JOIN category ct ON s.categoryId = ct.id
                  WHERE ct.cat_type = 'marketing'
                  ORDER BY s.score_points DESC
                  LIMIT 4";

$resultMarketing = $conn->query($sqlMarketing);

// Initialize arrays to store data for the Best Marketing chart
$marketingLabels = [];
$marketingScores = [];

// Fetch and format data for the Best Marketing chart
if ($resultMarketing->num_rows > 0) {
    while ($row = $resultMarketing->fetch_assoc()) {
        $marketingLabels[] = $row['comp_name'];
        $marketingScores[] = $row['score_points'];
    }
}

// Sort the Best Marketing scores and labels in descending order
array_multisort($marketingScores, SORT_DESC, $marketingLabels);

// Fetch data from the database for the Judges Total chart
$sqlJudges = "SELECT comp_name, SUM(judge_q1 + judge_q2 + judge_q3 + judge_q4 + judge_q5 + judge_q6) AS total_score
              FROM judges j
              INNER JOIN company c ON j.companyId = c.id
              GROUP BY comp_name
              ORDER BY total_score DESC
              LIMIT 4";

$resultJudges = $conn->query($sqlJudges);

// Initialize arrays to store data for the Judges Total chart
$judgesLabels = [];
$judgesScores = [];

// Fetch and format data for the Judges Total chart
if ($resultJudges->num_rows > 0) {
    while ($row = $resultJudges->fetch_assoc()) {
        $judgesLabels[] = $row['comp_name'];
        $judgesScores[] = $row['total_score'];
    }
}

// Sort the Judges Total scores and labels in descending order
array_multisort($judgesScores, SORT_DESC, $judgesLabels);

// Close the database connection
$conn->close();
?>

<div class="container-fluid graphs">

    <h1 class="dashboardTitle">Programme Overview</h1>

    <div class="row scoringGraph">
        <div class="col-md-12">
            <p class="scoringText">Scoring: Best Overall</p>
            <canvas id="bestOverallChart" height="100"></canvas>
        </div>
    </div>

    <div class="row scoringGraph">
        <div class="col-md-6">
            <p class="scoringText">Scoring: Best Development</p>
            <canvas id="bestDevelopmentChart" width="400"></canvas>
        </div>
        <div class="col-md-6">
            <p class="scoringText">Scoring: Best Marketing</p>
            <canvas id="bestMarketingChart" width="400"></canvas>
        </div>
    </div>
    <div class="row scoringGraph">
        <div class="col-md-6">
            <p class="scoringText">Scoring: Judges Total</p>
            <canvas id="judgesTotalChart" width="400"></canvas>
        </div>
        <div class="col-md-6">
            <!-- SPACE -->
        </div>
    </div>

</div>

<!-- JavaScript code for initializing and updating charts -->
<script>
// Pass PHP variables to JavaScript
var overallLabels = <?php echo json_encode($overallLabels); ?>;
var overallScores = <?php echo json_encode($overallScores); ?>;
var developmentLabels = <?php echo json_encode($developmentLabels); ?>;
var developmentScores = <?php echo json_encode($developmentScores); ?>;
var marketingLabels = <?php echo json_encode($marketingLabels); ?>;
var marketingScores = <?php echo json_encode($marketingScores); ?>;

// Example data for the charts
var overallData = {
    labels: overallLabels,
    datasets: [{
        label: 'Overall Score',
        backgroundColor: '#4263EB',
        data: overallScores
    }]
};

var developmentData = {
    labels: developmentLabels,
    datasets: [{
        label: 'Development Score',
        backgroundColor: '#4263EB',
        data: developmentScores
    }]
};

var marketingData = {
    labels: marketingLabels,
    datasets: [{
        label: 'Marketing Score',
        backgroundColor: '#4263EB',
        data: marketingScores
    }]
};

var judgesData = {
    labels: <?php echo json_encode($judgesLabels); ?>,
    datasets: [{
        label: 'Judges Total Score',
        backgroundColor: '#4263EB',
        data: <?php echo json_encode($judgesScores); ?>
    }]
};

// Get chart elements
var bestOverallChart = document.getElementById('bestOverallChart').getContext('2d');
var bestDevelopmentChart = document.getElementById('bestDevelopmentChart').getContext('2d');
var bestMarketingChart = document.getElementById('bestMarketingChart').getContext('2d');
var judgesTotalChart = document.getElementById('judgesTotalChart').getContext('2d');

// Create and update charts
var overallChart = new Chart(bestOverallChart, {
    type: 'bar',
    data: overallData,
    options: {
        scales: {
            x: {
                grid: {
                    display: false // Hide vertical gridlines
                }
            },
            y: {
                grid: {
                    display: true, // Show horizontal gridlines
                }
            }
        }
    }
});

var developmentChart = new Chart(bestDevelopmentChart, {
    type: 'bar',
    data: developmentData,
    options: {
        indexAxis: 'y',
        scales: {
            x: {
                grid: {
                    display: true // Hide vertical gridlines
                }
            },
            y: {
                grid: {
                    display: false, // Show horizontal gridlines
                }
            }
        }
    }
});

var marketingChart = new Chart(bestMarketingChart, {
    type: 'bar',
    data: marketingData,
    options: {
        indexAxis: 'y',
        scales: {
            x: {
                grid: {
                    display: true // Hide vertical gridlines
                }
            },
            y: {
                grid: {
                    display: false, // Show horizontal gridlines
                }
            }
        }
    }
});

var judgesChart = new Chart(judgesTotalChart, {
    type: 'bar',
    data: judgesData,
    options: {
        indexAxis: 'y',
        scales: {
            x: {
                grid: {
                    display: true // Hide vertical gridlines
                }
            },
            y: {
                grid: {
                    display: false, // Show horizontal gridlines
                }
            }
        }
    }
});
</script>