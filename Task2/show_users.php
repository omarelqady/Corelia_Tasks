<?php
session_start();
require_once 'connection.php';
include 'nav.html';

// Check if the user is an admin or supporter before allowing access
$userRole=$_SESSION['role'];
// Fetch the allowed functionalities for the user's role from the database
$sql = "SELECT * FROM functionality WHERE role = :role";
$stmt = $conn->prepare($sql);
$stmt->execute(array(':role' => $userRole));
$userFunctionality = $stmt->fetch(PDO::FETCH_ASSOC);
if ($userFunctionality['seedata'] !== 'Yes') {
    // If add prouduct functionality is not allowed, redirect to login page
    echo "no no you're limited access";
    echo '<script>
    setTimeout(function() {
        window.location.href = "index.php";
    }, 2000);
  </script>';
    exit();
}

// Fetch all users from the database
$sql = "SELECT * FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Users</title>
</head>
<body>
    <h1>Users</h1>
    <table>
        <tr>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Action</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['idusers']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['functionality_role']; ?></td>
                <td><a href="delete.php?user_id=<?php echo $user['idusers']; ?>">Delete Account</a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
