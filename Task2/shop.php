<?php
session_start();
require_once 'connection.php';
include 'nav.html';

// Fetch all products from the database
$sql = "SELECT * FROM prouduct";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Products</title>
</head>
<body>
<h1>Products</h1>
<table>
    <tr>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'supporter'): ?>
            <th>Action</th>
        <?php endif; ?>
    </tr>
    <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['proname']; ?></td>
            <td><?php echo $product['price']; ?></td>
            <td><?php echo $product['quantaty']; ?></td>
            <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'supporter'): ?>
                <td>
                    <a href="edit_product.php?product_id=<?php echo $product['idprouduct']; ?>">Edit</a>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>

