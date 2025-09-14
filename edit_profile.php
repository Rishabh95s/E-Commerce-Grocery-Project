<?php
include 'db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("Invalid profile ID.");
}

$result = $conn->query("SELECT * FROM profiles WHERE id = $id");

if (!$result || $result->num_rows === 0) {
    die("Profile not found.");
}

$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = htmlspecialchars($_POST['first_name']);
    $last = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $contact = htmlspecialchars($_POST['contact']);
    $address = htmlspecialchars($_POST['address']);
    $dob = htmlspecialchars($_POST['dob']);
    $age = intval($_POST['age']);

    if ($_FILES['photo']['name']) {
        $photoName = basename($_FILES['photo']['name']);
        $photoTmp = $_FILES['photo']['tmp_name'];
        $photoPath = "uploads/" . $photoName;

        if (move_uploaded_file($photoTmp, $photoPath)) {
            if (file_exists($data['photo'])) {
                unlink($data['photo']);
            }

            $stmt = $conn->prepare("UPDATE profiles SET photo=? WHERE id=?");
            $stmt->bind_param("si", $photoPath, $id);
            $stmt->execute();
        } else {
            die("Failed to upload photo.");
        }
    }

    $stmt = $conn->prepare("UPDATE profiles SET 
        first_name=?, last_name=?, email=?, contact=?, address=?, dob=?, age=? 
        WHERE id=?");
    $stmt->bind_param("ssssssii", $first, $last, $email, $contact, $address, $dob, $age, $id);
    $stmt->execute();

    header("Location: view_profiles.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        form { max-width: 500px; margin: auto; padding: 20px; background: #f4f4f4; border-radius: 8px; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px 20px; background: #333; color: white; border: none; }
    </style>
</head>
<body>

<h2>Edit Profile</h2>

<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="first_name" value="<?php echo $data['first_name']; ?>" required>
    <input type="text" name="last_name" value="<?php echo $data['last_name']; ?>" required>
    <input type="email" name="email" value="<?php echo $data['email']; ?>" required>
    <input type="text" name="contact" value="<?php echo $data['contact']; ?>" required>
    <textarea name="address" required><?php echo $data['address']; ?></textarea>
    <label>Date of Birth:</label>
    <input type="date" name="dob" value="<?php echo $data['dob']; ?>" required>
    <input type="number" name="age" value="<?php echo $data['age']; ?>" required>
    <label>Change Profile Photo (optional):</label>
    <input type="file" name="photo" accept="image/*">
    <button type="submit">Update</button>
</form>

<br>
<a href="view_profiles.php">Back to Profiles</a>

</body>
</html>
