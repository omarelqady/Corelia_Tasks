<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
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

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #0080ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <center>

        <h1>Sign Up</h1>
    </center>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <input type="submit" value="Sign Up">
    </form>
</body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST["username"]);
    $pass = htmlspecialchars($_POST["password"]);
    $hashed = md5($pass);

    require_once 'config.php';
    $conn = new PDO($dsn, $username, $password, $options);

    // Check if the username already exists
    $checkexist = "SELECT COUNT(*) FROM users WHERE username = :username";
    $stmt = $conn->prepare($checkexist);
    $stmt->execute(array(':username' => $name));
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        $sql = "INSERT INTO users (username, password) VALUES (:uname, :pass)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':uname' => $name, ':pass' => $hashed));

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
