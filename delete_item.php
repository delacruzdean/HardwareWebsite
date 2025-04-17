<?php
include "connection.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM inventory WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: inventory.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    header("Location: inventory.php");
    exit();
}
?>
