<?php 
require_once("config_session.php"); //Add this for to keep the signup data
require_once("MVC_view_signup.php"); // Add this line
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
                <p>4</p>
            </div>
            <div class="box2">
                <p>Storage Used</p>
                <p>50%</p>
            </div>
            <div class="box3">
                <p>Low Stock Items</p>
                <p>16</p>
            </div>
            <div class="box4">
                <p>Out of Stock</p>
                <p>10</p>
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
                        <th>ID</th>
                        <th>Name</th>
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
                     <?php foreach($items as $item): ?>
                     <tr>
                        <!-- Inside of the [] is the name of column on our database -->
                        <td><?= htmlspecialchars($item['id'])?></td>
                        <td><?= htmlspecialchars($item['item_name'])?></td>
                        <td><?= htmlspecialchars($item['category'])?></td>
                        <td><?= htmlspecialchars($item['quantity'])?></td>
                        <td><?= htmlspecialchars($item['sta_tus'])?></td>

                        <!-- edit and delete button -->
                        <td>
                            <a href="edit_item.php">Edit</a>
                            <a href="delete_item.php" onclick="return confirm('Are you sure?')">Delete</a>
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