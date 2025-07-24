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

//Searching

/*
- This SQL query retrieves **unique categories** from your `inventory` table.
- `DISTINCT` ensures that if the same category appears multiple times, it's only returned once.
- `ORDER BY category ASC` sorts them alphabetically (A → Z).
*/
$catstmt = $pdo->query("SELECT DISTINCT category FROM inventory ORDER BY category ASC");

/*
Fethces all the rows returned from the query
PDO::FETCH_COLUMN - it only return one column from each row
*/
$search_categ = $catstmt->fetchAll(PDO::FETCH_COLUMN);

/*
Check if the search param exist in the url
if it exist assign the value to $search
if not assign an empty string ''
*/ 
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';


/*
- Starts building the SQL query.
- `WHERE 1=1` is a common trick to make it easy to append more `AND` conditions later without worrying about syntax.
*/
$sql = "SELECT * FROM inventory WHERE 1=1";
$params = [];

// checks if the user typed something 
// if yes then:
if ($search !== ''){
    /*
    '.=' = dinagdag lang sa query mo sa $sql
      = Only get the items where the name looks like what the user typed
    */
    $sql .= " AND item_name LIKE :search";

    //:search = what the user type must be put here
    //% means "any characters before or after" — so it finds items that contain the word.
    $params[':search'] = "%$search%";
}

// this block only runs if the user selected a specific category 
if($category !== '' && $category !== 'All'){
    $sql .= " AND category = :category";
    $params[':category'] = $category;
}

$sql .= " ORDER BY id ASC";

$stmt = $pdo->prepare($sql); //Gets the SQL query ready (with placeholders)
$stmt->execute($params);     //Runs the SQL and inserts the actual search values.
$itemsearch = $stmt->fetchAll(); // Gets all the matching items from the database.


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
            <h1 class="title"><a href="home.php"> Welcome <?php echo htmlspecialchars($_SESSION['user_username']);?></a></h1>
        </div>
        <div class="right-nav">
            <i id="bell" class="fa-solid fa-bell"></i>
            <i id="gear" class="fa-solid fa-gear"></i>
            <a href="index.php" onclick="return confirm('Are you sure?')"><i id="logout" class="fa-solid fa-right-from-bracket"></i></a>
        </div>
    </div>

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

            <form action="home.php" method="GET">
                <input type="text" name="search" placeholder="Search Items" value="<?= htmlspecialchars($search)?>">

                <select value="Select categories" name="category">
                    <option value="All">All categories</option>
                <?php foreach($search_categ as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat)?>
                        </option>
                <?php endforeach; ?>
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
                     if (isset($itemsearch)){
                        foreach($itemsearch as $isearch):
                     ?>
                        <tr>
                            <td><?= $counter++?></td>
                            <td><?= htmlspecialchars($isearch['item_name'])?></td>
                            <td><?= htmlspecialchars($isearch['category'])?></td>
                            <td><?= htmlspecialchars($isearch['quantity'])?></td>
                            <td><?= htmlspecialchars($isearch['sta_tus'])?></td>

                            <td>
                                <a href="php_inventory/edit_item.php?id=<?= $isearch['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="php_inventory/delete_item.php?id=<?= $isearch['id'] ?>" onclick="return confirm('Are you sure?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php 
                    endforeach;
                    }else{
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
                     <?php endforeach;
                    }
                     ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


</body>
</html>