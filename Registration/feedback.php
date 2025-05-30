<?php
session_start();
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

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch feedback entries
$feedbacks = $conn->query("SELECT * FROM feedback ORDER BY submitted_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Feedback</title>
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
        }
        .sidebar nav a.active, .sidebar nav a:hover {
            background-color: #3b5323;
            border-left: 4px solid #aacd6e;
            padding-left: 6px;
        }
        .main-content {
            flex: 1;
            padding: 30px;
            background: #f9f9f9;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        table th {
            background-color: #f0f0f0;
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
            <a href="admindashboard.php">Dashboard</a>
            <a href="#">Appointment</a>
            <a href="#">History</a>
            <a href="feedback.php" class="active">Feedback</a>
            <a href="admin_profile.php">Profile</a>
        </nav>
    </div>

    <div class="main-content">
        <h2>Feedback Submissions</h2>
        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($feedbacks as $feedback): ?>
                        <tr>
                            <td><?= htmlspecialchars($feedback['id']) ?></td>
                            <td><?= htmlspecialchars($feedback['name']) ?></td>
                            <td><?= htmlspecialchars($feedback['email']) ?></td>
                            <td><?= htmlspecialchars($feedback['message']) ?></td>
                            <td><?= htmlspecialchars($feedback['submitted_at']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
