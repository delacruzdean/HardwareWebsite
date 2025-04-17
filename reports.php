<?php


include "connection.php";

$transactions = $conn->query("SELECT * FROM transactions ORDER BY transaction_date DESC")->fetch_all(MYSQLI_ASSOC);
$inventory_updates = $conn->query("SELECT * FROM inventory_updates ORDER BY update_date DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports</title>
    <link rel="stylesheet" href="css/inventory_style.css">
</head>
<body>
    <div class="container">
        <h1>Reports</h1>
        <a href="admin_home.html" class="button">Back to Admin Home</a>

        <h2>Transaction Reports</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Transaction Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?php echo $transaction['transaction_id']; ?></td>
                    <td><?php echo $transaction['customer_name']; ?></td>
                    <td><?php echo $transaction['item_name']; ?></td>
                    <td><?php echo $transaction['quantity']; ?></td>
                    <td><?php echo $transaction['total_price']; ?></td>
                    <td><?php echo $transaction['transaction_date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Inventory Update Reports</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Action</th>
                    <th>Quantity</th>
                    <th>Update Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventory_updates as $update): ?>
                <tr>
                    <td><?php echo $update['update_id']; ?></td>
                    <td><?php echo $update['item_id']; ?></td>
                    <td><?php echo $update['item_name']; ?></td>
                    <td><?php echo $update['update_type']; ?></td>
                    <td><?php echo $update['quantity']; ?></td>
                    <td><?php echo $update['update_date']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
