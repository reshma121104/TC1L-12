<?php
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "car_rental";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    error_log("Connection failed: " . mysqli_connect_error());
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental - Choose Your Car</title>
    <link rel="stylesheet" href="reserve.css"> <!-- Link to your CSS file -->
</head>
<body>
    <header>
        <h1>Choose Your Car</h1>
    </header>
    <main>
        <div class="car-container">
            <?php
            // Include the database connection file
            include 'connect.php';
            $query = "SELECT * FROM cars ORDER BY car_name ASC";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="car-item">';
                echo '<img src="' . $row['image'] . '" alt="' . $row['car_name'] . '">';
                echo '<h2>' . $row['car_name'] . '</h2>';
                echo '<p>Model: ' . $row['model'] . '</p>';
                echo '<p>Color: ' . $row['color'] . '</p>';
                echo '<form action="order-summary.php" method="POST">'; // Set action to order-summary.php
                echo '<input type="hidden" name="car_id" value="' . $row['id'] . '">'; // Send car_id
                echo '<input type="submit" value="Reserve Now">'; // Reserve Now button
                echo '</form>';
                echo '</div>';
            }
            ?>
        </div>
    </main>
</body>
</html>

<?php
// Close connection
mysqli_close($conn);
?>
