<?php
include("../database.php");

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $itemname = $_POST['item_name'];
    $category = $_POST['category'];
    $quantity = (int)$_POST['quantity'];
    $status = $_POST['sta_tus'];

    //SQL QUERY
    $stmt = $pdo->prepare("INSERT INTO inventory (item_name, category, quantity, sta_tus)
                        VALUES (?,?,?,?)");
    $stmt->execute([$itemname, $category, $quantity, $status]);

    header("Location: ../home.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/add_item.css">
</head>
<body>
    <form action="add_item.php" method="POST">
        <input type="text" name="item_name" placeholder="Item Name">
        <input type="text" name="category" placeholder="Category">
        <input type="number" name="quantity" placeholder="Quantity">
        <select name="sta_tus">
            <option>In stock</option>
            <option>Low Stock</option>
            <option>Out of Stock</option>
        </select>
        <button type="submit">Add Item</button>
    </form>
</body>
</html>