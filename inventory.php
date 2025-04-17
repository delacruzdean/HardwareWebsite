<?php


require 'connection.php';

// Function to log inventory updates
function log_inventory_update($conn, $item_id, $item_name, $update_type, $quantity) {
    $stmt = $conn->prepare("INSERT INTO inventory_updates (item_id, item_name, update_type, quantity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $item_id, $item_name, $update_type, $quantity);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_item'])) {
        $item_name = $_POST['item_name'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $supplier = $_POST['supplier'];
        $date_added = $_POST['date_added'];
        
        $stmt = $conn->prepare("INSERT INTO inventory (item_name, description, quantity, price, category, supplier, date_added, last_updated) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssissss", $item_name, $description, $quantity, $price, $category, $supplier, $date_added);
        $stmt->execute();
        
        log_inventory_update($conn, $conn->insert_id, $item_name, 'add', $quantity);
        
    } elseif (isset($_POST['edit_item'])) {
        $id = $_POST['id'];
        $item_name = $_POST['item_name'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $supplier = $_POST['supplier'];
        $date_added = $_POST['date_added'];
        
        $stmt = $conn->prepare("UPDATE inventory SET item_name = ?, description = ?, quantity = ?, price = ?, category = ?, supplier = ?, date_added = ?, last_updated = NOW() WHERE id = ?");
        $stmt->bind_param("ssissssi", $item_name, $description, $quantity, $price, $category, $supplier, $date_added, $id);
        $stmt->execute();
        
        log_inventory_update($conn, $id, $item_name, 'update', $quantity);
        
    } elseif (isset($_POST['remove_item'])) {
        $id = $_POST['id'];
        $item_name = $_POST['item_name'];
        
        $stmt = $conn->prepare("DELETE FROM inventory WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        log_inventory_update($conn, $id, $item_name, 'remove', 0);
    }
}

// Fetch and display inventory items
$items = $conn->query("SELECT * FROM inventory ORDER BY item_name ASC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="css/inventory_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Inventory List</h1>
        <input type="text" id="search" placeholder="Search Inventory">
        <br><br>
        <a href="admin_home.html" class="button">Back to Admin Home</a>
        <br><br>
        <a href="add_item.php" class="button">Add New Item</a>
        <br><br>
        <div id="inventory-table">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Date Added</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['item_name']) ?></td>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                        <td><?= htmlspecialchars($item['price']) ?></td>
                        <td><?= htmlspecialchars($item['category']) ?></td>
                        <td><?= htmlspecialchars($item['supplier']) ?></td>
                        <td><?= htmlspecialchars($item['date_added']) ?></td>
                        <td><?= htmlspecialchars($item['last_updated']) ?></td>
                        <td>
                            <a href="edit_item.php?id=<?= $item['id'] ?>" class="btn btn-warning">Edit</a>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                <input type="hidden" name="item_name" value="<?= $item['item_name'] ?>">
                                <button type="submit" name="remove_item" class="btn btn-danger" onclick="return confirm('Are you sure you want to remove this item?')">Remove</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function loadInventory(query = '') {
            $.ajax({
                url: "fetch_inventory.php",
                method: "POST",
                data: { query: query },
                success: function (data) {
                    $('#inventory-table').html(data);
                }
            });
        }

        $(document).ready(function () {
            $('#search').keyup(function () {
                var search = $(this).val();
                loadInventory(search);
            });
        });
    </script>
</body>

</html>
