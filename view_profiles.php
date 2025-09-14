<?php
// Ensure the correct path to db.php
include __DIR__ . '/db.php';

$search = "";
if (isset($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM profiles WHERE 
        first_name LIKE '%$search%' OR 
        last_name LIKE '%$search%' OR 
        email LIKE '%$search%' OR 
        contact LIKE '%$search%'"; // Removed 'ORDER BY' clause
} else {
    $sql = "SELECT * FROM profiles"; // Removed 'ORDER BY' clause
}

$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Profiles</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        .profile {
            background: #f9f9f9;
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
            display: flex;
            gap: 15px;
        }
        .profile img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
        .profile-details {
            flex: 1;
        }
    </style>
</head>
<body>

<h2>Registered User Profiles</h2>

<form method="GET" style="margin-bottom: 20px;">
    <input type="text" name="search" placeholder="Search by name, email, contact" value="<?php echo htmlspecialchars($search); ?>" style="width: 300px; padding: 8px;">
    <button type="submit" style="padding: 8px 15px;">Search</button>
</form>

<?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="profile">
            <img src="<?php echo ($row['photo']); ?>" alt="Profile Photo"> <!-- Escaped photo URL -->
            <div class="profile-details">
                <strong>Name:</strong> <?php echo ($row['first_name'] . ' ' . $row['last_name']); ?><br>
                <strong>Email:</strong> <?php echo ($row['email']); ?><br>
                <strong>Contact:</strong> <?php echo ($row['contact']); ?><br>
                <strong>Address:</strong> <?php echo ($row['address']); ?><br>
                <strong>Date of Birth:</strong> <?php echo ($row['dob']); ?><br>
                <strong>Age:</strong> <?php echo ($row['age']); ?><br>
                <a href="edit_profile.php?id=<?php echo urlencode($row['id']); ?>">Edit</a> <!-- Changed 'email' to 'id' to match the database primary key -->
                <a href="delete_profile.php?id=<?php echo urlencode($row['id']); ?>&redirect=index.html" onclick="return confirm('Are you sure?')">Delete</a> <!-- Changed 'email' to 'id' to match the database primary key -->
            </div>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No profiles found.</p>
<?php endif; ?>

<br>
<a href="profile.php">Back to Profile Form</a>

</body>
</html>