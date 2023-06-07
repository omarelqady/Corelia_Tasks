<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TASK TO-DO</title>
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f2f2f2;
}

form {
    margin-bottom: 20px;
}

label {
    font-weight: bold;
    color: #333;
    display: block;
    margin-bottom: 10px;
}

input[type="text"],
input[type="date"],
input[type="number"] {
    width: 40%;
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
input[type="button"],.logout {
    padding: 10px 20px;
    background-color: #0080ff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: bold;
    text-decoration: none;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    padding: 8px;
    border-bottom: 1px solid #ccc;
}

th {
    background-color: #f2f2f2;
    font-weight: bold;
}

tr:hover {
    background-color: #f9f9f9;
}

    </style>
</head>

<body>
    <center>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="task_name">Task Name:</label>
            <input type="text" name="task_name" id="task_name" required><br><br>
            
            <label for="day">Day:</label>
            <input type="date" name="day" id="day" required><br><br>
            
            <label for="time">Time:</label>
            <input type="number" name="time" id="time" required><br><br>
            
            <input type="submit" value="Add Task">
            <br>
           
            <br>
            <input type="button" value="show Tasks" onclick=" window.location.href='show.php' ">
            <a href="logout.php" class="logout">log-out</a>
        </form>
        </center>

</form>
<?php
 if ($_SERVER['REQUEST_METHOD'] === 'POST')
 {
$taskName =htmlspecialchars( $_POST['task_name']);
$day = htmlspecialchars($_POST['day']);
$time = htmlspecialchars($_POST['time']);
$userId = $_SESSION['user_id'];
require_once 'config.php';
$conn = new PDO($dsn, $username, $password, $options);
$sql = "INSERT INTO tasks (user_id, task_name, day, time) VALUES (:userId, :taskName, :day, :time)";
$sql=$conn->prepare($sql);
$sql->execute(array(
    ':userId' => $userId,
     ':taskName' => $taskName,
      ':day' => $day,
       ':time' => $time
    ));
 }


 

?>

</body>
</html>