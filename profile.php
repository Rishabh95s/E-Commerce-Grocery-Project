<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        form { max-width: 500px; margin: auto; padding: 30px; background: #f4f4f4; border-radius: 8px; }
        input, textarea { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px 20px; background: #333; color: white; border: none; }
    </style>
</head>
<body>
<script>
    function calculateAge() {
        const dobInput = document.querySelector('input[name="dob"]');
        const ageInput = document.querySelector('input[name="age"]');
        dobInput.addEventListener('change', () => {
            const dob = new Date(dobInput.value);
            const today = new Date();
            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }
            ageInput.value = age > 0 ? age : '';
        });
    }
    document.addEventListener('DOMContentLoaded', calculateAge);
</script>

<h1 style="text-align:center;">User Profile Form</h1>

<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="first_name" placeholder="First Name" required>
    <input type="text" name="last_name" placeholder="Last Name" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="contact" placeholder="Contact Number" required>
    <textarea name="address" placeholder="Address" required></textarea>
    <label>Date of Birth:</label>
    <input type="date" name="dob" required>
    <input type="number" name="age" placeholder="Age" required>
    <label>Profile Photo:</label>
    <input type="file" name="photo" accept="image/*,.jpg,.jpeg,.png,.gif,.bmp,.webp" required>
    <button type="submit">Submit</button>
</form>

</body>
</html>