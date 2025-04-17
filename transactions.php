<?php
session_start();
include "connection.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['action'])) {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? null;
    $price = $_POST['price'] ?? null;
    $quantity = $_POST['quantity'] ?? null;
    $customer_name = $_POST['customer_name'] ?? null;

    if ($_POST['action'] == 'add') {
        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $name,
                'price' => $price,
                'quantity' => 1
            ];
        }
    }

    if ($_POST['action'] == 'remove') {
        unset($_SESSION['cart'][$id]);
    }

    if ($_POST['action'] == 'update') {
        $_SESSION['cart'][$id]['quantity'] = $quantity;
    }

    if ($_POST['action'] == 'checkout') {
        $total_price = 0;
        foreach ($_SESSION['cart'] as $id => $item) {
            $quantity = $item['quantity'];
            $price = $item['price'] * $quantity;
            $total_price += $price;

            $stmt = $conn->prepare("INSERT INTO transactions (item_id, item_name, quantity, total_price, customer_name) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isids", $id, $item['name'], $quantity, $price, $customer_name);
            $stmt->execute();

            // Update inventory
            $stmt = $conn->prepare("UPDATE inventory SET quantity = quantity - ? WHERE id = ?");
            $stmt->bind_param("ii", $quantity, $id);
            $stmt->execute();
        }
        $_SESSION['cart'] = [];
        echo json_encode(['success' => true, 'total_price' => $total_price, 'cart' => $_SESSION['cart']]);
        exit;
    }
}

function getCustomerNames($conn)
{
    $stmt = $conn->prepare("SELECT name FROM users");
    $stmt->execute();
    $result = $stmt->get_result();
    $names = [];
    while ($row = $result->fetch_assoc()) {
        $names[] = $row['name'];
    }
    return $names;
}

$customer_names = getCustomerNames($conn);

function calculateTotalPrice()
{
    $total_price = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }
    return $total_price;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>
    <link rel="stylesheet" href="css/inventory_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Styles for the confirmation modal */
        #confirmation-modal {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            z-index: 1000;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            /* Adjust as needed */
        }

        #confirmation-modal h2 {
            margin-top: 0;
        }

        #confirmation-modal button {
            margin: 5px;
        }

        /* Overlay for the modal */
        #modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Transactions</h1>
        <input type="text" id="search" placeholder="Search Inventory">
        <br><br>
        <a href="admin_home.html" class="button">Back to Admin Home</a>
        <br><br>
        <div id="inventory-table">
            <!-- Inventory table will be loaded here via AJAX -->
        </div>

        <h2>Shopping Cart</h2>
        <div id="cart">
            <table border="1">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($_SESSION['cart'])) {
                        foreach ($_SESSION['cart'] as $id => $item) {
                            echo "<tr>
                                <td>{$item['name']}</td>
                                <td>
                                    <input type='number' value='{$item['quantity']}' data-id='$id' class='cart-quantity'>
                                </td>
                                <td>{$item['price']}</td>
                                <td>" . $item['price'] * $item['quantity'] . "</td>
                                <td>
                                    <button class='remove-from-cart' data-id='$id'>Remove</button>
                                </td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            <p>Total Price: $<span id="total-price"><?php echo calculateTotalPrice(); ?></span></p>

            <div style="display: inline-block;">
                <label for="customer-name" style="display: inline-block; vertical-align: middle;">Select
                    Customer:</label>
                <select id="customer-name" style="display: inline-block; vertical-align: middle; margin-left: 5px;">
                    <?php
                    foreach ($customer_names as $name) {
                        echo "<option value=\"$name\">$name</option>";
                    }
                    ?>
                </select>
                <button id="checkout"
                    style="display: inline-block; vertical-align: middle; margin-right: 1000px;">Checkout</button>
            </div>
        </div>
    </div>

    <div id="modal-overlay"></div>

    <div id="confirmation-modal">
        <h2>Order Confirmation</h2>
        <div id="confirmation-details"></div>
        <p>Total Price: $<span id="confirmation-total-price"></span></p>
        <button id="confirm-checkout">Confirm</button>
        <button id="cancel-checkout">Cancel</button>
    </div>

    <script>
        function loadInventory(query = '') {
            $.ajax({
                url: "fetch_inventory_transactions.php",
                method: "POST",
                data: { query: query },
                success: function (data) {
                    $('#inventory-table').html(data);
                }
            });
        }

        function updateTotalPrice() {
            var total = 0;
            $('#cart tbody tr').each(function () {
                var price = parseFloat($(this).find('td:nth-child(4)').text());
                total += price;
            });
            $('#total-price').text(total.toFixed(2));
        }

        $(document).ready(function () {
            loadInventory();

            $('#search').keyup(function () {
                var search = $(this).val();
                loadInventory(search);
            });

            $(document).on('click', '.add-to-cart', function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var price = $(this).data('price');
                var quantity = $(this).data('quantity');

                $.ajax({
                    url: "transactions.php",
                    method: "POST",
                    data: {
                        action: 'add',
                        id: id,
                        name: name,
                        price: price,
                        quantity: quantity
                    },
                    success: function () {
                        location.reload();
                    }
                });
            });

            $(document).on('click', '.remove-from-cart', function () {
                var id = $(this).data('id');

                $.ajax({
                    url: "transactions.php",
                    method: "POST",
                    data: {
                        action: 'remove',
                        id: id
                    },
                    success: function () {
                        location.reload();
                    }
                });
            });

            $(document).on('change', '.cart-quantity', function () {
                var id = $(this).data('id');
                var quantity = $(this).val();

                $.ajax({
                    url: "transactions.php",
                    method: "POST",
                    data: {
                        action: 'update',
                        id: id,
                        quantity: quantity
                    },
                    success: function () {
                        location.reload();
                    }
                });
            });

            $('#checkout').click(function () {
                var cartDetails = '';
                $('#cart tbody tr').each(function () {
                    var name = $(this).find('td:nth-child(1)').text();
                    var quantity = $(this).find('.cart-quantity').val();
                    var price = $(this).find('td:nth-child(3)').text();
                    var total = $(this).find('td:nth-child(4)').text();

                    cartDetails += `<p>${name} - ${quantity} x $${price} = $${total}</p>`;
                });

                $('#confirmation-details').html(cartDetails);
                $('#confirmation-total-price').text($('#total-price').text());
                $('#modal-overlay').show();
                $('#confirmation-modal').show();
            });

            $('#confirm-checkout').click(function () {
                var customerName = $('#customer-name').val();
                $.ajax({
                    url: "transactions.php",
                    method: "POST",
                    data: {
                        action: 'checkout',
                        customer_name: customerName
                    },
                    success: function (response) {
                        var res = JSON.parse(response);
                        if (res.success) {
                            alert('Checkout successful! Total price: $' + res.total_price);
                            location.reload();
                        }
                    }
                });
            });

            $('#cancel-checkout').click(function () {
                $('#confirmation-modal').hide();
                $('#modal-overlay').hide();
            });

            updateTotalPrice();
        });
    </script>
</body>

</html>