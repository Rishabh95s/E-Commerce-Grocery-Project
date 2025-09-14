<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo "<script>
                    window.location.href = 'index.html';
                  </script>";
        } else {
            echo "<script>
                    alert('Invalid password!');
                    window.location.href = './Login and Registration HTML.html';
                  </script>";
        }
    } else {
        echo "<script>
                alert('No user found with that email!');
                window.location.href = './Login and Registration HTML.html';
              </script>";
    }

    $stmt->close();
}
$conn->close();
?>
