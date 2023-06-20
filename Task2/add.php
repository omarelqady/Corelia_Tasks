<?php
session_start();
require_once 'connection.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userRole=$_SESSION['role'];
// Fetch the allowed functionalities for the user's role from the database
$sql = "SELECT * FROM functionality WHERE role = :role";
$stmt = $conn->prepare($sql);
$stmt->execute(array(':role' => $userRole));
$userFunctionality = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the add prouduct functionality is allowed for the user's role
if ($userFunctionality['addproduct'] !== 'Yes') {
    // If add prouduct functionality is not allowed, redirect to login page
    echo "no no you're limited access";
    echo '<script>
    setTimeout(function() {
        window.location.href = "show.php";
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
    <title>Add prouduct</title>
</head>
<body>
    <h1>Add prouduct</h1>
    <form method="POST" >
        <label for="name">prouduct Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" required>

        <input type="submit" value="Add prouduct">
    </form>
</body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $price = htmlspecialchars($_POST["price"]);
    $quantity = htmlspecialchars($_POST["quantity"]);

    // Insert the prouduct into the database
    $sql = "INSERT INTO prouduct (proname, price, quantaty ) VALUES (:name, :price, :quantity)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':name' => $name, ':price' => $price, ':quantity' => $quantity));

    // Redirect to the show.php page to display all prouducts
    header("Location: shop.php");
    exit();
}
?>

