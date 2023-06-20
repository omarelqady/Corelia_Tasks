<?php
session_start();
require_once 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST["password"]);
    $hashedPassword = md5($password);

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE email = :email AND password = :password";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':email' => $email, ':password' => $hashedPassword));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Perform ABAC evaluation based on user attributes
        $role = $user['functionality_role'];

        // Check access based on user's role
        if ($role === 'admin') {
            // Access granted for admin role
            $_SESSION['user_id'] = $user['idusers'];
            $_SESSION['role'] = $role;
            $_SESSION['name']=$user['name'];
            echo "Welcome, Admin! You have full access.";
        } elseif ($role === 'supporter') {
            // Access granted for supporter role
            $_SESSION['user_id'] = $user['idusers'];
            $_SESSION['role'] = $role;
            $_SESSION['name']=$user['name'];
            echo "Welcome, Supporter! You have limited access.";
        } elseif ($role === 'customer') {
            // Access granted for customer role
            $_SESSION['user_id'] = $user['idusers'];
            $_SESSION['role'] = $role;
            $_SESSION['name']=$user['name'];
            echo "Welcome, Customer! You have restricted access.";
        } else {
            // Unknown role
            echo "Invalid role. Please contact the administrator.";
        }
    } else {
        echo "Invalid email or password. Please try again.";
    }
    echo '<script>
    setTimeout(function() {
        window.location.href = "index.php";
    }, 2000);
  </script>'; 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" value="Log In">
        
    </form>
    <a href="signup.php">dont have acc?! regester now</a>
</body>
</html>

