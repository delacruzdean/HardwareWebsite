<?php
include "connection.php";


function log_inventory_update($conn, $item_id, $item_name, $update_type, $quantity) {
    $stmt = $conn->prepare("INSERT INTO inventory_updates (item_id, item_name, update_type, quantity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $item_id, $item_name, $update_type, $quantity);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $supplier = $_POST['supplier'];
    $date_added = date('Y-m-d');

    $sql = "INSERT INTO inventory (item_name, description, quantity, price, category, supplier, date_added) VALUES ('$item_name', '$description', $quantity, $price, '$category', '$supplier', '$date_added')";

    if (mysqli_query($conn, $sql)) {
        log_inventory_update($conn, $conn->insert_id, $item_name, 'add', $quantity);
        header("Location: inventory.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
</head>
<body>
    <h1>Add New Item</h1>
    <form action="" method="POST">
        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" required><br><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br><br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required><br><br>
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" required><br><br>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required><br><br>
        <label for="supplier">Supplier:</label>
        <input type="text" id="supplier" name="supplier" required><br><br>
        <button type="submit">Add Item</button>
    </form>
    <br>
    <a href="inventory.php"><button>Back to Inventory</button></a>
</body>
</html>
