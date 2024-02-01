<?php
// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>



<div class="container">

    <h1 class="dashboardTitle">Programme Overview</h1>

    <div class="row scoringGraph">
        <div class="col-md-12">
            <p class="scoringText">Scoring: Best Overall</p>
            <canvas id="bestOverallChart" width="1800" height="600"></canvas>
        </div>
    </div>

    <div class="row scoringGraph">
        <div class="col-md-6">
            <p class="scoringText">Scoring: Best Development</p>
            <canvas id="bestDevelopmentChart" height="200"></canvas>
        </div>
        <div class="col-md-6">
            <p class="scoringText">Scoring: Best Marketing</p>
            <canvas id="bestMarketingChart" height="200"></canvas>
        </div>
    </div>

    <div class="row scoringGraph">
        <div class="col-md-6">
            <p class="scoringText">Scoring: Judges Total</p>
            <canvas id="judgesTotalChart" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Your JavaScript code for initializing and updating charts -->
<script>
// Example data for the charts
var overallData = {
    labels: ["Overall Category 1", "Overall Category 2", "Overall Category 3", "Overall Category 4",
        "Overall Category 5", "Overall Category 6"
    ],
    datasets: [{
        label: 'Overall Score',
        backgroundColor: '#4263EB',
        data: [92, 60, 35, 20, 10, 5]
    }]
};

var developmentData = {
    labels: ["Feature A", "Feature B", "Feature C"],
    datasets: [{
        label: 'Development Score',
        backgroundColor: '#4263EB',
        data: [10, 60, 90]
    }]
};

var marketingData = {
    labels: ["Campaign X", "Campaign Y", "Campaign Z"],
    datasets: [{
        label: 'Marketing Score',
        backgroundColor: '#4263EB',
        data: [15, 25, 60]
    }]
};

var judgesTotalData = {
    labels: ["Round 1"],
    datasets: [{
        label: 'Total Score',
        backgroundColor: '#4263EB',
        data: [50]
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
                    display: true // Show vertical gridlines
                }
            },
            y: {
                grid: {
                    display: false // Hide horizontal gridlines
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
                    display: true // Show vertical gridlines
                }
            },
            y: {
                grid: {
                    display: false // Hide horizontal gridlines
                }
            }
        }
    }
});

var judgesTotalChart = new Chart(judgesTotalChart, {
    type: 'bar',
    data: judgesTotalData,
    options: {
        indexAxis: 'y',
        scales: {
            x: {
                grid: {
                    display: true // Show vertical gridlines
                }
            },
            y: {
                grid: {
                    display: false // Hide horizontal gridlines
                }
            }
        }
    }
});
</script>