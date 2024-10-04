<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $card_holder = isset($_POST['card_holder']) ? $_POST['card_holder'] : '';
    $card_number = isset($_POST['card_number']) ? $_POST['card_number'] : '';
    $expiry_date = isset($_POST['expiry_date']) ? $_POST['expiry_date'] : '';
    $cvc = isset($_POST['cvc']) ? $_POST['cvc'] : '';
    $deposit_amount = isset($_POST['deposit_amount']) ? $_POST['deposit_amount'] : '';

    $query = "INSERT INTO payments (card_holder, card_number, expiry_date, cvc, deposit_amount, payment_status)
              VALUES (?, ?, ?, ?, ?, 'pending')";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssd', $card_holder, $card_number, $expiry_date, $cvc, $deposit_amount);
    
    if ($stmt->execute()) {

        $payment_id = $stmt->insert_id;

        $update_query = "UPDATE payments SET payment_status = 'completed' WHERE id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param('i', $payment_id);
        $update_stmt->execute();

        header('Location: successful.php?payment_id=' . $payment_id);
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $update_stmt->close();
    
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Checkout Form</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css">
        <link rel="stylesheet" href="styles.css">
    </head>
    <body>

    <div class="wrapper">
        <div class="payment">
            <div class="payment-logo">
                <p>p</p>
            </div>

            <h2>Payment Gateway</h2>

            <form method="POST" action="">
                <div class="form">
                    <div class="card space icon-relative">
                        <label class="label">Card holder:</label>
                        <input type="text" class="input" name="card_holder" placeholder="Card Holder Name" required>
                        <i class="fas fa-user"></i>
                    </div>

                    <div class="card space icon-relative">
                        <label class="label">Card number:</label>
                        <input type="text" class="input" name="card_number" placeholder="Card Number" required>
                        <i class="far fa-credit-card"></i>
                    </div>

                    <div class="card-grp space">
                        <div class="card-item icon-relative">
                            <label class="label">Expiry date:</label>
                            <input type="text" name="expiry_date" class="input" placeholder="MM / YY" required>
                            <i class="far fa-calendar-alt"></i>
                        </div>

                        <div class="card-item icon-relative">
                            <label class="label">CVC:</label>
                            <input type="text" name="cvc" class="input" placeholder="CVC" required>
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>

                    <!-- Hidden fields to pass car and reservation info -->
                    <input type="hidden" name="deposit_amount" value="<?php echo isset($_GET['deposit']) ? htmlspecialchars($_GET['deposit']) : 0; ?>">
                    <button type="submit" class="btn">
                        Pay $<?php echo isset($_GET['deposit']) ? number_format($_GET['deposit'], 2) : '0.00'; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>

    </body>
    </html>
    <?php
}

// Close the database connection
$conn->close();
?>
