<?php
session_start();
include 'includes/config.php';
include 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $user = loginUser($username, $password, $role);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        
        // Mengarahkan pengguna ke halaman yang sesuai berdasarkan peran
        if ($user['role'] === 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }
        exit();
    } else {
        $error = "Username, password, atau peran salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Login</button>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </form>
    </div>
</body>
</html>