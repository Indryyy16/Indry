<?php
function registerUser($username, $password, $role) {
    global $pdo;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':role', $role);
    return $stmt->execute();
}

function loginUser($username, $password, $role) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND role = :role");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return false;
}
function createComplaint($user_id, $complaint_text) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO complaints (user_id, complaint_text) VALUES (:user_id, :complaint_text)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':complaint_text', $complaint_text);
    return $stmt->execute();
}

function getComplaints($user_id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM complaints WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllComplaints() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM complaints");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateComplaintStatus($id, $status) {
    global $pdo;
    $stmt = $pdo->prepare("UPDATE complaints SET status = :status WHERE id = :id");
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}

function deleteComplaint($id) {
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM complaints WHERE id = :id");
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
}
?>