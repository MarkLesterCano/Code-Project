<?php
session_start();

// Database connection
$host = 'localhost';
$dbname = 'schoolregistration';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }

        .sidebar {
            background-color: #2d411a;
            color: white;
            width: 250px;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
            position: fixed;
        }

        .sidebar img {
            width: 80px;
            display: block;
            margin: 0 auto 10px;
        }

        .sidebar h2 {
            font-size: 16px;
            text-align: center;
        }

        .sidebar nav a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
            margin: 10px 0;
            border-radius: 4px;
        }

        .sidebar nav a.active, .sidebar nav a:hover {
            background-color: #3b5323;
            border-left: 4px solid #aacd6e;
            padding-left: 12px;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            background: #f9f9f9;
            flex: 1;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .now-serving {
            background: #d3d3d3;
            font-size: 40px;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            background: white;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        table thead {
            background: #f1f1f1;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <a href="admindashboard.php">
            <img src="./University_of_Pangasinan_logo (1).png" alt="Logo">
        </a>
        <h2>UNIVERSITY OF PANGASINAN</h2>
        <nav>
            <a href="admindashboard.php" class="active">Dashboard</a>
            <a href="#">Appointment</a>
            <a href="#">History</a>
            <a href="feedback.php" >Feedback</a>
            <a href="admin_profile.php" >Profile</a>
        </nav>
    </div>

    <div class="main-content">
        <h2>Dashboard Overview</h2>

        <div class="dashboard-grid">
            <div class="card">
                <p><strong>Average Wait Time</strong><br>15 mins</p>
            </div>
            <div class="card">
                <p><strong>Queues served</strong><br>250 <span style="color: green;">+20%</span></p>
            </div>
            <div class="card">
                <p><strong>Appointment attendance</strong><br>90% <span style="color: red;">-5%</span></p>
            </div>
        </div>

        <div style="display: flex; gap: 30px; align-items: center;">
            <div class="now-serving" style="flex: 2;">
                <p>Now Serving</p>
                <strong>#33456</strong>
                <div style="font-size: 14px; color: gray;">standby #333456</div>
            </div>
            <div class="card" style="flex: 1;">
                <canvas id="statusPie"></canvas>
                <div style="font-size: 12px; margin-top: 10px;">
                    <span style="color: #4CAF50;">■</span> Completed &nbsp;
                    <span style="color: #FFC107;">■</span> Pending &nbsp;
                    <span style="color: #F44336;">■</span> Canceled
                </div>
            </div>
        </div>

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>column 1</th>
                        <th>column 1</th>
                        <th>column 1</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Replace with PHP loop -->
                    <tr>
                        <td>1</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Data</td>
                        <td>Completed</td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>

    <script>
        const ctx = document.getElementById('statusPie').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Completed', 'Pending', 'Canceled'],
                datasets: [{
                    data: [60, 30, 10], // Example data
                    backgroundColor: ['#4CAF50', '#FFC107', '#F44336']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</body>
</html>
