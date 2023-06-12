<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';
$conn = new PDO($dsn, $username, $password, $options);
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["role"] === "user") {
    $oldPassword = htmlspecialchars($_POST['old_password']);

    // Verify the old password before allowing the update
    $selectSql = "SELECT password FROM users WHERE id = :user_id";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->bindParam(':user_id', $user_id);
    $selectStmt->execute();
    $userData = $selectStmt->fetch(PDO::FETCH_ASSOC);

    if ($userData && md5($oldPassword) === $userData['password']) {
        // Old password matches, proceed with the update
        if (isset($_POST['update_name'])) {
            $newName = htmlspecialchars($_POST['new_name']);

            // Update the name
            $updateSql = "UPDATE users SET username = :new_name WHERE id = :user_id";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bindParam(':new_name', $newName);
            $updateStmt->bindParam(':user_id', $user_id);
            $updateStmt->execute();

            echo "Name updated successfully!";
        } elseif (isset($_POST['update_password'])) {
            $newPassword = htmlspecialchars($_POST['new_password']);
            $hashedPassword = md5($newPassword);

            // Update the password
            $updateSql = "UPDATE users SET password = :new_password WHERE id = :user_id";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bindParam(':new_password', $hashedPassword);
            $updateStmt->bindParam(':user_id', $user_id);
            $updateStmt->execute();

            echo "Password updated successfully!";
        }
    } else {
        // Old password is incorrect
        echo "Incorrect old password. Please try again.";
    }
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION["role"] === "admin") {
    if (isset($_GET['idu'])) {

        $userid = $_GET['idu'];

        if (isset($_POST['new_name'])) {
            $newName = htmlspecialchars($_POST['new_name']);

            // Update the name
            $updateSql = "UPDATE users SET username = :new_name WHERE id = :user_id";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bindParam(':new_name', $newName);
            $updateStmt->bindParam(':user_id', $userid);
            $updateStmt->execute();
          
             header('Location: show_users.php');
            exit();
        } elseif (isset($_POST['new_password'])) {
            $newPassword = htmlspecialchars($_POST['new_password']);
            $hashedPassword = md5($newPassword);

            // Update the password
            $updateSql = "UPDATE users SET password = :new_password WHERE id = :user_id";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bindParam(':new_password', $hashedPassword);
            $updateStmt->bindParam(':user_id', $userid);
            $updateStmt->execute();
         header('Location: show_users.php');
            exit();
    
        }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
        <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 20px;
        background-color: cyan;
    }

    .container {
        max-width: 400px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    label {
        margin-bottom: 10px;
        font-weight: bold;
        color: #333;
    }

    input[type="text"],
    input[type="password"] {
        width: 30%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .button-group {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .button-group button {
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
    }

    .error-message {
        color: red;
        margin-bottom: 10px;
    }
</style>
</head>

<body>
    <h1>Profile</h1>
    <center>
        <h2>Update Name</h2>
    </center>
    <form method="POST">
        <label for="new_name">New Name:</label>
        <input type="text" id="new_name" name="new_name" required><br>
        <?php if ($_SESSION["role"] === "user") : ?>
            <label for="old_password">Old Password:</label>
            <input type="password" id="old_password" name="old_password" required><br>
        <?php endif; ?>
        <input type="submit" name="update_name" value="Update Name">
    </form>
    <center>
        <h2>Update Password</h2>
    </center>
    <form method="POST">
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        <?php if ($_SESSION["role"] === "user") : ?>
            <label for="old_password">Old Password:</label>
            <input type="password" id="old_password" name="old_password" required><br>
        <?php endif; ?>
        <input type="submit" name="update_password" value="Update Password">
    </form>
</body>

</html>
