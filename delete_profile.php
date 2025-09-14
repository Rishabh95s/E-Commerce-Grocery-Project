<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $getPhoto = $conn->query("SELECT photo FROM profiles WHERE id = $id");
    if ($getPhoto && $getPhoto->num_rows > 0) {
        $photoRow = $getPhoto->fetch_assoc();
        if ($photoRow && file_exists($photoRow['photo'])) {
            unlink($photoRow['photo']);
        }
    }

    $conn->query("DELETE FROM profiles WHERE id = $id");
}

header("Location: view_profiles.php");
exit;
