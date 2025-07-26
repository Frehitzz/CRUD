<?php
require_once("../database.php");

/*
$id = $_GET['id'] 
= check if this code exist on the url
example: http://localhost/codes/CRUD/php_inventory/edit_item.php?id=1

 $_POST['id'] = if not exist on the url check if the id exist

 ?? null = if both dont exist set the $id=null
*/
$id = $_GET['id'] ?? $_POST['id'] ?? null;


if($_SERVER["REQUEST_METHOD"] === "POST"){
    $itemname = $_POST['item_name'];
    $category = $_POST['category'];
    $quantity = (int)$_POST['quantity'];
    $status = $_POST['sta_tus'];

    //SQL query
    $stmt = $pdo->prepare("UPDATE inventory SET item_name=?, category=?, quantity=?,sta_tus=?
                        WHERE id=?");
    $stmt->execute([$itemname,$category,$quantity,$status,$id]);

    header("Location: ../home.php");
    exit;
}

    $stmt = $pdo->prepare("SELECT * FROM inventory WHERE id=?");
    $stmt->execute([$id]);
    //fetch() = to retrieve a single row
    $item = $stmt->fetch();
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/edit_item.css">
</head>
<body>
    <form action="edit_item.php" method="POST">
        <!-- 
        the value that have $item[' '] 
        -->

        <!-- an invisible input box that still sends data when the form is submitted. -->
        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">

        <input type="text" name="item_name" placeholder="Item Name" value="<?= $item['item_name']?>">
        <input type="text" name="category" placeholder="Category" value="<?= $item['category']?>">
        <input type="number" name="quantity" placeholder="Quantity" value="<?= $item['quantity']?>">
        <select name="sta_tus">
            <option <?= $item['sta_tus'] === 'In Stock' ? 'selected' : '' ?>>In stock</option>
            <option <?= $item['sta_tus'] === 'Low Stock' ? 'selected' : '' ?>>Low Stock</option>
            <option <?= $item['sta_tus'] === 'Out of Stock' ? 'selected' : '' ?>>Out of Stock</option>
        </select>
        <button type="submit">Update</button>
    </form>
</body>
</html>