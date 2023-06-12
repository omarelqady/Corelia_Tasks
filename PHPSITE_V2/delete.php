<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['taskid']) &&$_SESSION["role"]=="user" ) {
    $task_id = $_GET['taskid'];
    $user_id = $_SESSION['user_id'];
    require_once 'config.php';
    $conn = new PDO($dsn, $username, $password, $options);
    
    // Verify if the task with the specified ID belongs to the authenticated user
    $selectSql = "SELECT * FROM tasks WHERE id = :task_id AND user_id = :user_id";
    $selectStmt = $conn->prepare($selectSql);
    $selectStmt->execute(array(':task_id' => $task_id, ':user_id' => $user_id));
    $task = $selectStmt->fetch(PDO::FETCH_ASSOC);

    // If the task exists and belongs to the authenticated user, perform the deletion
    if ($task) {
        $deleteSql = "DELETE FROM tasks WHERE id = :task_id AND user_id = :user_id";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->execute(array(':task_id' => $task_id, ':user_id' => $user_id));
        header('Location: show.php');
        exit();
    } else {
        echo "NooooB Hacker HAHAHAHAHAH";
    }
}
 else if (isset($_GET['taskid']) && $_SESSION["role"] == "admin") {
    $task_id = $_GET['taskid'];
    require_once 'config.php';
    $conn = new PDO($dsn, $username, $password, $options);

    $deleteSql = "DELETE FROM tasks WHERE id = :task_id";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->execute(array(':task_id' => $task_id));
    header('Location: admindashboard.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Task</title>
</head>
<body>
    <h1>Delete Finished Task</h1>
</body>
</html>
