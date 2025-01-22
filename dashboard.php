<?php
session_start();
include 'includes/config.php';
include 'includes/functions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $complaint_text = $_POST['complaint_text'];
    createComplaint($user_id, $complaint_text);
}

$complaints = getComplaints($user_id);
?> 

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/script.js"></script>
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <form method="POST" action="">
            <textarea name="complaint_text" placeholder="Masukkan pengaduan" required></textarea>
            <button type="submit">Ajukan Pengaduan</button>
        </form>

        <h3>Pengaduan Anda</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pengaduan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $complaint): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($complaint['id']); ?></td>
                        <td><?php echo htmlspecialchars($complaint['complaint_text']); ?></td>
                        <td><?php echo htmlspecialchars($complaint['status']); ?></td>
                        <td><?php echo htmlspecialchars($complaint['created_at']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.html">Logout</a>
    </div>
</body>
</html>