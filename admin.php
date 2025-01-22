<?php
session_start();
include 'includes/config.php';
include 'includes/functions.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update'])) {
        $id = $_POST['complaint_id'];
        $status = $_POST['status'];
        updateComplaintStatus($id, $status);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['complaint_id'];
        deleteComplaint($id);
    }
}

$complaints = getAllComplaints();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard Admin</h2>
        <h3>Semua Pengaduan</h3>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pengaduan</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $complaint): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($complaint['id']); ?></td>
                        <td><?php echo htmlspecialchars($complaint['complaint_text']); ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="complaint_id" value="<?php echo htmlspecialchars($complaint['id']); ?>">
                                <select name="status">
                                    <option value="pending" <?php echo $complaint['status'] === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="selesai" <?php echo $complaint['status'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                    <option value="ditolak" <?php echo $complaint['status'] === 'ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                                </select>
                                <button type="submit" name="update">Update</button>
                            </form>
                        </td>
                        <td><?php echo htmlspecialchars($complaint['created_at']); ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="complaint_id" value="<?php echo htmlspecialchars($complaint['id']); ?>">
                                <button type="submit" name="delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.html">Logout</a>
    </div>
</body>
</html>