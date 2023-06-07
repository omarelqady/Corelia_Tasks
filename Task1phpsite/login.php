<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>
<body>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        input[type="submit"]  {
            padding: 10px 20px;
            background-color: #0080ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .t
        {
            text-decoration: none;
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
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br><br>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br><br>
            
            <input type="submit" value="Login"> <br> <br>
            
        </form>
        <br> <br>
        <center>

            <a href="signup.php" class="t">Sign-Up</a>
        </center>
    </div>
</body>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        require_once 'config.php';
        $conn=new PDO($dsn,$username,$password,$options);
        $name=htmlspecialchars($_POST["username"]);
        $pass=htmlspecialchars($_POST["password"]);
        $hashed=md5($pass);
        $sql="SELECT * FROM users WHERE username=:n AND password =:p";
        $sql=$conn->prepare($sql);
        $sql->execute(array(
            ':n'=>$name ,
            ':p'=> $hashed
        ));
        $checkeduser=$sql->fetch(PDO::FETCH_ASSOC);

        if($checkeduser)
        {
            
                    
        $_SESSION['user_id'] = $checkeduser['id'];
        $_SESSION['username'] = $checkeduser['username'];
            echo "Login Successfull! You will be redirect to your Tasks sooon!";
            echo '<script>
        setTimeout(function() {
            window.location.href = "task.php";
        }, 2000);
      </script>'; 
        }
        else
        {
            echo"Login Faild!";
        }
        
    }
    
    ?>
</html>

