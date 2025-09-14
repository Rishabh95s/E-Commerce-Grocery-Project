<?php
// Include the database connection file
require_once 'db.php';

// Ensure the database connection is established
if (!isset($conn) || !$conn) {
    die("Database connection error.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = $_POST['first_name'];
    $last = $_POST['last_name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $dob = $_POST['dob'];
    $age = $_POST['age'];

    $photoName = $_FILES['photo']['name'];
    $photoTmp = $_FILES['photo']['tmp_name'];
    $photoPath = "uploads/" . basename($photoName);
    move_uploaded_file($photoTmp, $photoPath);

    $stmt = $conn->prepare("INSERT INTO profiles 
        (first_name, last_name, email, contact, address, dob, age, photo) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssssssis", $first, $last, $email, $contact, $address, $dob, $age, $photoPath);

    if ($stmt->execute()) {
        echo "Profile saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<br><br>
<a href="profile.php">Go Back</a> |
<a href="view_profiles.php">View Profiles</a>
