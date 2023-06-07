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

    <?php
    if(isset($_GET['taskid'])) {
        $task_id = $_GET['taskid'];
        require_once 'config.php';
        $conn = new PDO($dsn, $username, $password, $options);
        $sql = "DELETE FROM tasks WHERE id = :task_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':task_id' => $task_id));

        header('Location: show.php');
    }
    ?>

</body>
</html>
