<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign-Up</title>
</head>
<body>
<form method="POST">
  <label for="username">Username:</label>
  <input type="text" name="username" id="username" required>

  <label for="email">Email:</label>
  <input type="email" name="email" id="email" required>

  <label for="password">Password:</label>
  <input type="password" name="password" id="password" required>

  <input type="submit" value="Sign Up">
</form>

</body>
<?php
require_once 'connection.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = htmlspecialchars($_POST["username"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = htmlspecialchars($_POST["password"]);
    $new=md5($password);

    $sql = "SELECT COUNT(*) FROM users WHERE email = :e";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':e' => $email));
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
    $sql="INSERT INTO users (name, email, password) values (:u , :e ,:p)";
    $stmt=$conn->prepare($sql);
    $stmt->execute(array(
        ":u"=>$username,
        ":e"=>$email,
        ":p"=>$new
    ));
    echo "Registration successful!...";
    echo '<script>
    setTimeout(function() {
        window.location.href = "login.php";
    }, 2000);
  </script>'; 
}




    }

?>
</html>