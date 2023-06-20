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
            <th>Action</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo $product['proname']; ?></td>
                <td><?php echo $product['price']; ?></td>
                <td><?php echo $product['quantaty']; ?></td>
                <td>
                    <a href="pay.php?product_id=<?php echo $product['idprouduct']; ?>">Buy</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
