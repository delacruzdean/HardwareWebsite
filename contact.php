<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
    <div class="container">
        <div class="form-box box">
            <?php
            include "connection.php";

            $message = ""; // Initialize the message variable

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = clean_input($_POST["name"]);
                $email = clean_input($_POST["email"]);
                $subject = clean_input($_POST["subject"]);
                $message_text = clean_input($_POST["message"]);

                $query = "INSERT INTO contact (name, email, subject, message) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ssss", $name, $email, $subject, $message_text);
                if ($stmt->execute()) {
                    $message = "<div class='message success'>
                    <p>Message sent successfully ✨</p>
                    </div><br>";
                } else {
                    $message = "<div class='message failure'>
                    <p>Message sending failed 😔</p>
                    </div><br>";
                }
                $stmt->close();
                $conn->close();
            }

            function clean_input($data)
            {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            ?>

            <!-- Display the message -->
            <?php echo $message; ?>

            <!-- Go back button -->
            <a href="home.php"><button class="btn">Go Back</button></a>
        </div>
    </div>
</body>
</html>
