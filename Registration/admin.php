
    <?php
    session_start();
    if (!isset($_SESSION['admin_logged_in'])) {
        header("Location: index.php");
        exit();
    }

    ?>

    <a href="logout.php">Logout</a>

