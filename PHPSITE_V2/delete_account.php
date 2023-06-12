<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';
$conn = new PDO($dsn, $username, $password, $options);

if ($_SESSION["role"] === "admin" && isset($_GET['id'])) {
    // Code to delete user account for admins
    $user_id = $_GET['id'];
    
    // Perform the deletion of the user account
    $deleteSql = "DELETE FROM users WHERE id = :user_id";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bindParam(':user_id', $user_id);
    $deleteStmt->execute();
    
    header('Location: show_users.php');
    exit();
} elseif ($_SESSION["role"] !== "admin") {
    $user_id = $_SESSION['user_id'];
    
    $deleteSql = "DELETE FROM users WHERE id = :user_id";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bindParam(':user_id', $user_id);
    $deleteStmt->execute();
    
    session_destroy();
    header('Location: signup.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
</head>
<body>
    <h1>Delete Account</h1>
</body>
</html>
