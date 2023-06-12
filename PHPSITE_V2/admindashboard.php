<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

require_once 'config.php';
$conn = new PDO($dsn, $username, $password, $options);

// Fetch tasks and user information
$sql = "SELECT tasks.id, tasks.user_id, tasks.task_name, tasks.day, tasks.time, users.username
        FROM tasks
        INNER JOIN users ON tasks.user_id = users.id";

$stmt = $conn->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #700961;
        }
        h1 {
            text-align: center;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }
        th {
            background-color: #f8f8f8;
            color: #555;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .nav-links {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .nav-links a {
            margin: 0 10px;
            color: #555;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h1>Welcome to the Admin Panel</h1>

    <div class="nav-links">
        <a href="admindashboard.php">Admin Panel</a>
        <a href="show.php">Show Tasks</a>
        <a href="task.php">Add Admin Task</a>
        <a href="show_users.php">Show Users</a>
        <a href="logout.php">Logout</a>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Task ID</th>
                <th>User ID</th>
                <th>Task Name</th>
                <th>Day</th>
                <th>Time</th>
                <th>Username</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?php echo $task['id']; ?></td>
                <td><?php echo $task['user_id']; ?></td>
                <td><?php echo $task['task_name']; ?></td>
                <td><?php echo $task['day']; ?></td>
                <td><?php echo $task['time']; ?></td>
                <td><?php echo $task['username']; ?></td>
                <td>
                    <a href="delete.php?taskid=<?php echo $task['id']; ?>">Delete Task</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
