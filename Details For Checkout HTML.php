<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "your_username", "your_password", "your_database");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $fullName = $_POST["fullName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $pincode = $_POST["pincode"];
    $paymentMethod = $_POST["paymentMethod"];

    // Check if email exists in the users table
    $emailCheckSql = "SELECT email FROM users WHERE email = ?";
    $emailCheckStmt = $conn->prepare($emailCheckSql);
    $emailCheckStmt->bind_param("s", $email);
    $emailCheckStmt->execute();
    $emailCheckResult = $emailCheckStmt->get_result();

    if ($emailCheckResult->num_rows > 0) {
        // Proceed with inserting into delivery_details
        $sql = "INSERT INTO delivery_details (full_name, email, phone, address, city, state, pincode, payment_method)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssss", $fullName, $email, $phone, $address, $city, $state, $pincode, $paymentMethod);

        if ($stmt->execute()) {
            echo "<script>alert('Delivery details submitted successfully!');</script>";
            // Redirect to success page
            header("Location: thank-you.html"); // Change this to your desired success page
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "<script>alert('Email does not exist in the users table. Please register first.');</script>";
    }

    $emailCheckStmt->close();
    $conn->close();
}
?>
<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "profiledb"; // Database for user authentication

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $locality = $_POST['locality'];
    $phone = $_POST['phone'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    $sql = "INSERT INTO delivery_details (name, address, email, locality, phone, date, time)
            VALUES ('$name', '$address', '$email', '$locality', '$phone', '$date', '$time')";

}
?>
<!DOCTYPE html>

<html>

    <head>

        <meta http-equiv="contact-type" content="text/html; charset-utf-8"/>

        <meta name="viewport" content="width-device-width,initial-scale=1,mininmum-scale=1,maximum-scale=1,user-scalable=no">

        <title>
            
            Details for Delivery
        
        </title>

        <link href="Details For Checkout CSS.css" rel="stylesheet" type="text/css" />
        
        <link rel="shortcut icon" type="image/jpg" href="C:\Users\hp\Desktop\College\First Semester\Introduction To Web Technologies\Notepad ++ Files\Project\favicon.ico"/>

        <script src="Details For Checkout JS.js"></script>

    
    </head>

    <body>

        <div class="contact-in">

            <div class="contact-map">

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224345.83923192866!2d77.06889754725779!3d28.52758200617606!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x52c2b7494e204dce!2sNew%20Delhi%2C%20Delhi!5e0!3m2!1sen!2sin!4v1642929688022!5m2!1sen!2sin" width="100%" height="auto" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

            </div>

            <div class="contact-form">

                <h1 align = 'center'>
                    
                    Details For Delivery
                
                </h1>

                <div id="error_message"></div>

               <!-- Inside your form -->
<form action="submit_delivery.php" method="POST">
    <input type="text" name="name" placeholder="Name" class="contact-form-txt" required>
    <input type="text" name="address" placeholder="Address" class="contact-form-txt" required>
    <input type="text" name="email" placeholder="Email-ID" class="contact-form-txt" required>
    <input type="text" name="locality" placeholder="Locality/Apartment" class="contact-form-txt" required>
    <input type="text" name="phone" placeholder="Contact No." class="contact-form-txt" required>
    <button type="submit" class="contact-form-btn">Proceed to payment</button>
</form>


            </div>

        </div>

    </body>

</html>
<?php $conn->close(); ?>

