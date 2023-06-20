<?php
session_start();
require_once 'connection.php';

// Check if the user is an admin or supporter before allowing access
$userRole = $_SESSION['role'];

$userid = $_SESSION['user_id'];

// Fetch the allowed functionalities for the user's role from the database
$sql = "SELECT * FROM functionality WHERE role = :role";
$stmt = $conn->prepare($sql);
$stmt->execute(array(':role' => $userRole));
$userFunctionality = $stmt->fetch(PDO::FETCH_ASSOC);
if (isset($_GET['user_id'])) {
    $idu = $_GET['user_id'];

if ($userFunctionality['deleteuser'] !== 'Yes' && isset($_SESSION['role'])  ) {
    echo "You have limited access.";
    echo '<script>
    setTimeout(function() {
        window.location.href = "index.php";
    }, 2000);
  </script>';
    exit();
}
}

if (isset($_POST['confirm'])) {
    $sql = "DELETE FROM users WHERE idusers = :id";
    $stmt = $conn->prepare($sql);
    if (!isset($_GET['user_id'])) {
        // Delete user's own account if delete_self functionality is enabled
        if ($userFunctionality['delete_self'] === 'Yes') {
            $userid == $_SESSION['user_id'];
            $stmt->execute(array(
                'id' => $userid
            ));
            // Destroy the session and redirect to a confirmation page or login page
            session_destroy();
            header("Location: login.php");
            exit();
        }
        elseif (isset($_GET['user_id']))
        {
            $t=htmlspecialchars($_GET['user_id']);
            $stmt->execute(array(
                'id' => $t
            ));
              session_destroy();
            header("Location: show_users.php");
            exit();

        }
         else {
            echo "You do not have permission to delete this account.";
            exit();
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
</head>
<body>
    <h1>Delete Account</h1>
    <p>Are you sure you want to delete your account? This action is irreversible.</p>
    <form action="" method="post">
        <input type="submit" name="confirm" value="Confirm">
    </form>
</body>
</html>
