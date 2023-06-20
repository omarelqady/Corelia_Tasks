<?php
session_start();
require_once 'connection.php';

// Check if the user is logged in and retrieve their ID
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
$userId = $_SESSION['user_id'];

// Fetch the user's information from the database
$sql = "SELECT * FROM users WHERE idusers = :id";
$stmt = $conn->prepare($sql);
$stmt->execute([':id' => $userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$role=$_SESSION['role'];

// Fetch the allowed functionalities for the user's role from the database
$sql = "SELECT * FROM functionality WHERE role = :role";
$stmt = $conn->prepare($sql);
$stmt->execute([':role' => $role]);
$functionalities = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $editFields = isset($_POST['edit_fields']) ? $_POST['edit_fields'] : [];

    foreach ($editFields as $field) {
        if ($field === 'name' && isset($_POST['name'])) {
            // Update the name
            $name = $_POST['name'];
            $sql = "UPDATE users SET name = :name WHERE idusers = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':name' => $name, ':id' => $userId]);
            $user['name'] = $name;
        }

        if ($field === 'email' && isset($_POST['email'])) {
            // Update the email
            $email = $_POST['email'];
            $sql = "UPDATE users SET email = :email WHERE idusers = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':email' => $email, ':id' => $userId]);
            $user['email'] = $email;
        }

        if ($field === 'password' && isset($_POST['password'])) {
            // Update the password
            $password = $_POST['password'];
            // Hash the password before storing it in the database (ensure proper password hashing techniques)
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = :password WHERE idusers = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':password' => $hashedPassword, ':id' => $userId]);
        }
    }

    // Redirect to a success page or display a success message
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
</head>
<body>
    <h1>Edit Profile</h1>
    <form action="" method="post">
        <h2>Select the fields you want to edit:</h2>

        <?php if ($functionalities['edit_self'] === 'Yes'): ?>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>"><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password"><br><br>
        <?php endif; ?>

        <input type="submit" value="Update Profile">
    </form>
</body>
</html>
