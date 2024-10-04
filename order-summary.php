<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "car_rental";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    error_log("Connection failed: " . mysqli_connect_error());
    die("Connection failed: " . mysqli_connect_error());
}

$full_name = isset($_POST['full_name']) ? $_POST['full_name'] : '';
$driver_license_id = isset($_POST['license_id']) ? $_POST['license_id'] : '';
$pickup_date = isset($_POST['pickup_date']) ? $_POST['pickup_date'] : '';
$return_date = isset($_POST['return_date']) ? $_POST['return_date'] : '';
$car_id = isset($_POST['car_id']) ? $_POST['car_id'] : '';

$query = "SELECT * FROM cars WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $car_name = $row['car_name'];
    $car_model = $row['model'];
    $car_color = $row['color'];
    $car_price = $row['price']; 
} else {
    die("Car not found.");
}

$stmt->close();

$deposit_amount = $car_price * 0.20;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental - Order Summary</title>
    <link rel="stylesheet" href="order.css"> 
</head>
<body>
    <header>
        <h1>Order Summary</h1>
    </header>
    <main>
        <div class="summary-container"> 
            <h2>Car Details</h2>
            <p><strong>Car:</strong> <?php echo htmlspecialchars($car_name); ?></p>
            <p><strong>Model:</strong> <?php echo htmlspecialchars($car_model); ?></p>
            <p><strong>Color:</strong> <?php echo htmlspecialchars($car_color); ?></p>
            <p><strong>Price per Day:</strong> $<?php echo htmlspecialchars($car_price); ?></p>
            
            <h2>Rental Period</h2>
            <p><strong>Pickup Date:</strong> <?php echo htmlspecialchars($pickup_date); ?></p>
            <p><strong>Return Date:</strong> <?php echo htmlspecialchars($return_date); ?></p>
            
            <h2>Deposit Information</h2>
            <p>To confirm your reservation, a deposit of 20% of the total rental price is required.</p>
            <p><strong>Deposit Amount:</strong> $<?php echo number_format($deposit_amount, 2); ?></p>
            
            <form action="confirm-reservation.php" method="POST">
                <input type="hidden" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>">
                <input type="hidden" name="license_id" value="<?php echo htmlspecialchars($driver_license_id); ?>">
                <input type="hidden" name="pickup_date" value="<?php echo htmlspecialchars($pickup_date); ?>">
                <input type="hidden" name="return_date" value="<?php echo htmlspecialchars($return_date); ?>">
                <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car_id); ?>">
                
                <!-- Redirect to Deposit Checkout -->
                <a href="process_form.php?deposit=<?php echo $deposit_amount; ?>&car_id=<?php echo $car_id; ?>" class="button">Proceed to Deposit Payment</a>
            </form>
        </div>
    </main>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
