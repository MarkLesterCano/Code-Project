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

// Get admin data
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle update
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];

    $update = $conn->prepare("UPDATE admins SET name = ?, email = ? WHERE id = ?");
    $update->execute([$name, $email, $admin_id]);
    header("Location: admin_profile.php?updated=true");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Profile</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; display: flex; }
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
            max-width: 500px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        input[type="text"], input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            background-color: #2d411a;
            color: white;
            border: none;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
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
            <a href="adminappointment.php">Appointment</a>
            <a href="adminhistory.php">History</a>
            <a href="adminfeedback.php">Feedback</a>
            <a href="adminprofile.php" class="active">Profile</a>
        </nav>
    </div>

    <div class="main-content">
        <h2>Admin Profile</h2>
        <div class="card">
            <?php if (isset($_GET['updated'])): ?>
                <div class="success">Profile updated successfully!</div>
            <?php endif; ?>
            <form method="POST">
                <label>Name</label>
                <input type="text" name="name" value="<?= htmlspecialchars($admin['name']) ?>" required>
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>
                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>
</body>
</html>
