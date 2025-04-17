    <?php
include "connection.php";

function log_inventory_update($conn, $item_id, $item_name, $update_type, $quantity) {
    $stmt = $conn->prepare("INSERT INTO inventory_updates (item_id, item_name, update_type, quantity) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $item_id, $item_name, $update_type, $quantity);
    $stmt->execute();
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM inventory WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $item = mysqli_fetch_assoc($result);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $item_name = $_POST['item_name'];
        $description = $_POST['description'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $supplier = $_POST['supplier'];

        $sql = "UPDATE inventory SET item_name='$item_name', description='$description', quantity=$quantity, price=$price, category='$category', supplier='$supplier' WHERE id=$id";
        
        if (mysqli_query($conn, $sql)) {
            log_inventory_update($conn, $id, $item_name, 'update', $quantity);
            header("Location: inventory.php");
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        mysqli_close($conn);
    }
} else {
    header("Location: inventory.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
</head>
<body>
    <h1>Edit Item</h1>
    <form action="" method="POST">
        <label for="item_name">Item Name:</label>
        <input type="text" id="item_name" name="item_name" value="<?php echo $item['item_name']; ?>" required><br><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $item['description']; ?></textarea><br><br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo $item['quantity']; ?>" required><br><br>
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo $item['price']; ?>" required><br><br>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" value="<?php echo $item['category']; ?>" required><br><br>
        <label for="supplier">Supplier:</label>
        <input type="text" id="supplier" name="supplier" value="<?php echo $item['supplier']; ?>" required><br><br>
        <button type="submit">Update Item</button>
    </form>
    <br>
    <a href="inventory.php"><button>Back to Inventory</button></a>
</body>
</html>
