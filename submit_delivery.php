<?php
session_start();
include 'db.php'; // Ensure this connects to the correct database 'user_auth'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Clean inputs
    $name     = $conn->real_escape_string(trim($_POST['name']));
    $address  = $conn->real_escape_string(trim($_POST['address']));
    $email    = $conn->real_escape_string(trim($_POST['email']));
    $locality = $conn->real_escape_string(trim($_POST['locality']));
    $phone    = $conn->real_escape_string(trim($_POST['phone']));

    // Check if email exists in the users table
    $emailCheckSql = "SELECT email FROM users WHERE email = ?";
    $emailCheckStmt = $conn->prepare($emailCheckSql);

    if (!$emailCheckStmt) {
        die("SQL Prepare failed: " . $conn->error);
    }

    $emailCheckStmt->bind_param("s", $email);
    $emailCheckStmt->execute();
    $emailCheckStmt->store_result();

    if ($emailCheckStmt->num_rows === 0) {
        echo "<script>
            alert('Invalid details.');
            window.location.href = 'Details For Checkout HTML.php';
              </script>";
        $emailCheckStmt->close();
        $conn->close();
        exit();
    }

    $emailCheckStmt->close();

    // Prepare SQL
    $sql = "INSERT INTO delivery_details (name, address, email, locality, phone)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // If preparation fails, show the error
    if (!$stmt) {
        die("SQL Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssss", $name, $address, $email, $locality, $phone);

    if ($stmt->execute()) {
        echo "<script>window.location.href = 'Payment.php';</script>";
    } else {
        echo "Execute failed: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: Details For Checkout HTML.html");
    exit();
}
