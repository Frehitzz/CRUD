<?php 
require_once("config_session.php"); //Add this for to keep the signup data
require_once("MVC_view_signup.php"); // Add this line
require_once("database.php");

// COUNTS TOTAL ITEMS ON SYSTEM
$stmt = $pdo->query("SELECT COUNT(*) FROM INVENTORY");
$totalitems = $stmt->fetchColumn();

//COUNTS TOTAL CATEGORIES USED
$stmt = $pdo->query("SELECT COUNT(DISTINCT category) FROM inventory");
$categories = $stmt->fetchColumn();

//COUNTS TOTAL OF LOW STOCK ITEMS
$stmt = $pdo->query("SELECT COUNT(*) FROM inventory WHERE sta_tus = 'Low Stock' ");
$lowStockItems = $stmt->fetchColumn();

//COUNTS TOTAL OF OUT OF STOCK ITEMS
$stmt = $pdo->query("SELECT COUNT(*) FROM inventory WHERE sta_tus = 'Out of Stock' ");
$OutStockItems = $stmt->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"/>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
     <div class="navigation">
        <div class="greetings">
            <h1 class="title"> Welcome <?php echo htmlspecialchars($_SESSION['user_username']);?></h1>
        </div>
        <div class="right-nav">
            <i id="bell" class="fa-solid fa-bell"></i>
            <i id="gear" class="fa-solid fa-gear"></i>
            <i id="logout" class="fa-solid fa-right-from-bracket"></i>
        </div>
    </div>
<!--
    <div class="side-nav">
        <h1 class="inside-sidenav">Storage Manager</h1>
        <h3 class="inside-sidenav">Storage Overview</h3>
        <h3 class="inside-sidenav">Inventory Management</h3>
    </div>

    <div class="container">
        <h1>Storage Manager</h1>
    </div> -->

    
<div class="parent">
    <div class="div3">
        <h1 class="inside-title">Storage Overview</h1>

        <div class="box-container">
            <div class="box1">
                <p>Total Items</p>
                <p><?= $totalitems?></p>
            </div>
            <div class="box2">
                <p>Categories</p>
                <p><?= $categories?></p>
            </div>
            <div class="box3">
                <p>Low Stock Items</p>
                <p><?= $lowStockItems?></p>
            </div>
            <div class="box4">
                <p>Out of Stock</p>
                <p><?= $OutStockItems?></p>
            </div>
        </div>

        <div class="inventory">
            <div class="title-and-button">
                <h1>Inventory Management</h1>
                <a href="php_inventory/add_item.php"><button class="button1">+ Add New Item</button></a>
            </div>
            <form>
                <input type="text" name="search" placeholder="Search Items">
                <select value="Select categories">
                    <option>All categories</option>
                    <option>Electronics</option>
                    <option>Foods</option>
                    <option>Cosmetics</option>
                    <option>Baby</option>
                </select>
                <input type="submit" value="Apply Filter">
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Display_order</th>
                        <th>Items</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <?php
                    require_once("database.php");
                    //get all the records from the 'inventory' table
                    $stmt = $pdo->query("SELECT * FROM inventory");
                    // this get all rows(items) from the result and store the, as arrays
                    $items = $stmt->fetchAll();
                ?>

                <tbody>
                    <!-- This is where the items display -->
                    
                     <!-- Loop Through All Items and Display Them in a Table -->
                     <?php 
                     $counter = 1;
                     foreach($items as $item): 
                     ?>
                     <tr>
                        <!-- Inside of the [] is the name of column on our database -->
                        <td><?= $counter++?></td>
                        <td><?= htmlspecialchars($item['item_name'])?></td>
                        <td><?= htmlspecialchars($item['category'])?></td>
                        <td><?= htmlspecialchars($item['quantity'])?></td>
                        <td><?= htmlspecialchars($item['sta_tus'])?></td>

                        <!-- edit and delete button -->
                        <td>
                            <a href="php_inventory/edit_item.php?id=<?= $item['id'] ?>">Edit</a>
                            <a href="php_inventory/delete_item.php?id=<?= $item['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                     </tr>
                     <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


</body>
</html>