<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'config.php';
$conn = new PDO($dsn, $username, $password, $options);
$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM tasks WHERE user_id = :userId";
$stmt = $conn->prepare($sql);
$stmt->execute(array(':userId' => $userId));

$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tasks</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
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
        .c
        {
            text-decoration: none;
            padding: 5px 10px;
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
    <h1>Tasks</h1>

    <table>
        <tr>
            <th>Task Name</th>
            <th>Day</th>
            <th>Time</th>
            <th>FINISHED OR STILL</th>
        </tr>
        <?php foreach ($tasks as $task): ?>
        <tr>
            <td><?php echo $task['task_name']?></td>
            <td><?php echo $task['day']; ?></td>
            <td><?php echo $task['time'].' minutes'; ?></td>
            <td>
    <a href="delete.php?taskid=<?php echo $task['id']; ?>" class="t">Delete Task</a>
</td>

        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <br>
    <center>
        
        <a href="task.php" class="t">Back to add task</a> <br> <br> <br>
        <a href="delete_account.php" class="t"> delete account?</a>

    </center>
    
</body>
</html>
