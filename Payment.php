<!DOTYPE html>
<html>
<head>
    <title>Universal Payment Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f8f8f8;
            padding: 20px;
        }
        .container {
            background: #fff;
            padding: 25px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
            border-radius: 8px;
        }
        h2 {
            text-align: center;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 12px;
        }
        button {
            background-color: green;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 20px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment Details</h2>
        <form method="POST" action="Payment.php">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email ID" required>
            <input type="text" name="phone" placeholder="Contact No." required>
            <input type="text" name="address" placeholder="Delivery Address" required>
            <input type="text" name="amount" id="amount" placeholder="Amount to Pay" readonly>

            <label>Select Payment Method:</label>
            <select name="payment_method" required>
                <option value="">--Choose--</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
                <option value="Cash on Delivery">Cash on Delivery</option>
                <option value="UPI">UPI</option>
            </select>

            <button type="submit">Place Order</button>
        </form>
    </div>

<?php
//PHP Section for Form Submission and DB Insert
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "profiledb");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $amount = str_replace("Rs. ", "", $_POST["amount"]); // Remove "Rs. " prefix if present
    $payment_method = $_POST["payment_method"];

    $sql = "INSERT INTO payments (name, email, phone, address, amount, payment_method) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $email, $phone, $address, $amount, $payment_method);

    if ($stmt->execute()) {
        if ($payment_method === "UPI") {
            echo "<script>
                localStorage.removeItem('cart'); // Clear the cart
                localStorage.removeItem('payableAmount'); // Clear the payable amount
                window.location.href='upi.html';
            </script>";
        } elseif ($payment_method === "Credit Card") {
            echo "<script>
                localStorage.removeItem('cart'); // Clear the cart
                localStorage.removeItem('payableAmount'); // Clear the payable amount
                window.location.href='Credit Card.html';
            </script>";
        } elseif ($payment_method === "Debit Card") {
            echo "<script>
                localStorage.removeItem('cart'); // Clear the cart
                localStorage.removeItem('payableAmount'); // Clear the payable amount
                window.location.href='Debit Card.html';
            </script>";
        } else {
            echo "<script>
                alert('Order Placed successfully!');
                localStorage.removeItem('cart'); // Clear the cart
                localStorage.removeItem('payableAmount'); // Clear the payable amount
                window.location.href='index.html';
            </script>";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<script>
// Receive amount from localStorage or pass via query string
document.addEventListener('DOMContentLoaded', () => {
    const amount = localStorage.getItem("payableAmount"); // Set this in bill.html before redirect
    if (amount) {
        document.getElementById("amount").value = amount.replace("Rs. ", ""); // Remove "Rs. " prefix for consistency
    }
});
</script>
</body>
</html>