<?php
session_start();
include 'nav.html';
require_once 'connection.php';
$productID = htmlspecialchars( $_GET['product_id']);
$sql="SELECT quantaty FROM prouduct where idprouduct=:p";
$stmt=$conn->prepare($sql);
$stmt->execute(array(
    ':p'=>$productID
));
$quan = $stmt->fetchColumn();

if (!isset($_GET['product_id']) || !isset($_SESSION['user_id']   ) ) {
    header("Location: login.php");
    exit;
}
$id=$_SESSION['user_id'];


    if ($quan === '0') {
        echo "No more product";
        
        // Wait for 2 seconds (2000 milliseconds)
        usleep(2000000);
    
        // Redirect to a different page
        header("Location: index.php");
        exit();
    }


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qua=htmlspecialchars($_POST['quantity']);
    $date = date('Y-m-d H:i:s'); 

    $sql = "INSERT INTO `orders` (quantity, order_date, users_idusers, idprouduct) VALUES (:q, :d, :uid, :idp)";
    $stmt=$conn->prepare($sql);
   $stmt->execute(array(
    ':q'=> $qua,
    ':d'=>$date,
    ':uid'=>$id,
    ':idp'=>$productID
   ));
   $updateSql = "UPDATE prouduct SET quantaty = quantaty - :q WHERE idprouduct = :idp";
   $updateStmt = $conn->prepare($updateSql);
   
   $updateStmt->execute(array(
       ':q' => $qua,
       ':idp' => $productID
   ));
   

    
    echo "Purchase successful! Thank you for buying the product.";
    echo '<script>
    setTimeout(function() {
        window.location.href = "index.php";
    }, 2000);
  </script>'; 
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Form</title>
</head>
<body>
    <h1>Purchase Form</h1>
    <form action="" method="post">
        <input type="number" name="quantity" placeholder="Quantity" required>
        <input type="hidden" name="product_id" value="<?php echo $productID; ?>">
        <input type="submit" value="Buy">
    </form>
</body>
</html>
