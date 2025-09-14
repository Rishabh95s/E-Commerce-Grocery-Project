
<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $address = $conn->real_escape_string($_POST['address']);
    $email = $conn->real_escape_string($_POST['email']);
    $locality = $conn->real_escape_string($_POST['locality']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $date = $conn->real_escape_string($_POST['date']);
    $time = $conn->real_escape_string($_POST['time']);

    $query = "INSERT INTO deliveries (user_id, name, address, email, locality,  phone, delivery_date, delivery_time) 
              VALUES ('$user_id', '$name', '$address', '$email', '$locality', '$phone', '$date', '$time')";

    if ($conn->query($query) === TRUE) {
        header("Location: payment.php");
        exit();
    } else {
        die("Error saving delivery details: " . $conn->error);
    }
} else {
    header("Location: Details For Checkout HTML.php");
    exit();
}
?>