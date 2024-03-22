<?php
// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

// Query to get count of students in each training category
$sql = "SELECT tr_cat, COUNT(*) as count FROM members
        INNER JOIN training ON members.trainingId = training.id
        GROUP BY tr_cat";

$result = $conn->query($sql);

// Prepare data for Chart.js
$labels = [];
$data = [];

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $labels[] = $row["tr_cat"];
    $data[] = $row["count"];
  }
}
?>

<div class="container-fluid graphs">
    <p class="scoringText">Registered Members</p>
    <canvas id="myChart" width="400" height="400"></canvas>
</div>

<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Number of Students',
            data: <?php echo json_encode($data); ?>,
            backgroundColor: [
                '#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd',
                '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22', '#17becf',
                '#aec7e8', '#ffbb78', '#98df8a', '#ff9896', '#c5b0d5',
                '#c49c94', '#f7b6d2', '#c7c7c7', '#dbdb8d', '#9edae5',
                '#7f7f7f'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: false,
        legend: {
            display: true,
            position: 'bottom',
            align: 'start', // Align legends to start
            labels: {
                boxWidth: 10, // Adjust box width for each legend item
                padding: 20, // Padding between legend items
                usePointStyle: true // Use point style instead of box for legend markers
            }
        },
        title: {
            display: true,
            text: 'Student Training Category'
        },
        layout: {
            padding: {
                bottom: 30 // Add padding at the bottom for legends
            }
        }
    }
});
</script>