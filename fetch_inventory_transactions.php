<?php
session_start();
include "connection.php";

// Check if a search query is provided
$query = "";
if (isset($_POST['query'])) {
    $query = $_POST['query'];
}

// Fetch inventory items from the database
if ($query != "") {
    $stmt = $conn->prepare("SELECT * FROM inventory WHERE item_name LIKE ?");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("s", $searchTerm);
} else {
    $stmt = $conn->prepare("SELECT * FROM inventory");
}

$stmt->execute();
$result = $stmt->get_result();

$output = "
<table border='1'>
    <thead>
        <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Quantity Available</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
";

while ($row = $result->fetch_assoc()) {
    $output .= "
    <tr>
        <td>{$row['id']}</td>
        <td>{$row['item_name']}</td>
        <td>{$row['price']}</td>
        <td>{$row['quantity']}</td>
        <td>
            <button class='add-to-cart' 
                data-id='{$row['id']}' 
                data-name='{$row['item_name']}' 
                data-price='{$row['price']}' 
                data-quantity='1'>
                Add to Cart
            </button>
        </td>
    </tr>
    ";
}

$output .= "
    </tbody>
</table>
";

echo $output;
?>
