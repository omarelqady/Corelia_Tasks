<?php
session_start();
require_once 'connection.php';

// Check if the user is logged in and has admin role
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

$role = $_SESSION['role'];
// Check if the user has admin role
if ($role !== 'admin') {
    echo "You do not have permission to access this page.";
    exit;
}

// Fetch the available roles from the database
$sql = "SELECT role FROM functionality ";
$stmt = $conn->prepare($sql);
$stmt->execute();
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = md5($_POST['password']);
    $selectedRole = $_POST['role'];

    // Insert the new user into the database
    $insertSql = "INSERT INTO users (name, email, password, functionality_role) VALUES (:username, :email, :password, :roleId)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->execute([
        ':username' => $username,
        ':email' => $email,
        ':password' => $password,
        ':roleId' => $selectedRole
    ]);

    // Redirect to a success page or display a success message
    header("Location: show_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
</head>
<body>
    <h1>Add User</h1>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo $role['role']; ?>"><?php echo $role['role']; ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <input type="submit" value="Add User">
    </form>
</body>
</html>
