<?php
session_start();
require_once 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id']) && ($_SESSION['role']!=='admin' || $_SESSION['role']!=='supporter')  ) {
    header("Location: login.php");
    exit();
}

include 'nav.html';

// Fetch the allowed functionalities for the user's role from the database
$userRole = $_SESSION['role'];
$sql = "SELECT * FROM functionality WHERE role = :role";
$stmt = $conn->prepare($sql);
$stmt->execute(array(':role' => $userRole));
$userFunctionality = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the edit product functionality is allowed for the user's role
if ($userFunctionality['editproduct'] !== 'Yes') {
    // If edit product functionality is not allowed, redirect to shop.php
    echo "You have limited access.";
    echo '<script>
    setTimeout(function() {
        window.location.href = "shop.php";
    }, 2000);
  </script>';
    exit();
}


// Check if the product ID is provided
if (!isset($_GET['product_id'])) {
    echo "Product ID is missing.";
    exit();
}

$productID = $_GET['product_id'];

// Fetch the product from the database
$sql = "SELECT * FROM prouduct WHERE idprouduct = :product_id";
$stmt = $conn->prepare($sql);
$stmt->execute(array(':product_id' => $productID));
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the product exists
if (!$product) {
    echo "Product not found.";
    exit();
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $price = htmlspecialchars($_POST['price']);
    $quantity = htmlspecialchars($_POST['quantity']);

    // Update the product in the database
    $sql = "UPDATE prouduct SET proname = :name, price = :price, quantaty = :quantity WHERE idprouduct = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':name' => $name, ':price' => $price, ':quantity' => $quantity, ':product_id' => $productID));

    // Redirect to the shop.php page to display all products
    header("Location: shop.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>
    <form method="POST">
        <label for="name">Product Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $product['proname']; ?>" required>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" value="<?php echo $product['price']; ?>" required>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo $product['quantaty']; ?>" required>

        <input type="submit" value="Update Product">
    </form>
</body>
</html>
