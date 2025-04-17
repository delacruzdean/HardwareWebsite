<?php


include "connection.php";

$query = "";
if (isset($_POST['query'])) {
    $query = mysqli_real_escape_string($conn, $_POST['query']);
}

$sql = "SELECT * FROM inventory WHERE item_name LIKE '%$query%' OR description LIKE '%$query%' OR category LIKE '%$query%' OR supplier LIKE '%$query%'";
$result = mysqli_query($conn, $sql);

$output = '<table border="1">
            <thead>
                <tr>
                    <th>ID</th>
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
            <tbody>';

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['item_name']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['supplier']}</td>
                        <td>{$row['date_added']}</td>
                        <td>{$row['last_updated']}</td>
                        <td>
                            <a href='edit_item.php?id={$row['id']}'>Edit</a> |
                            <a href='delete_item.php?id={$row['id']}'>Delete</a>
                        </td>
                    </tr>";
    }
} else {
    $output .= "<tr><td colspan='10'>No records found</td></tr>";
}

$output .= '</tbody></table>';
echo $output;

mysqli_close($conn);
?>
