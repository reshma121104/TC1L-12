<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collecting form data
    $full_name = $_POST['full_name'];
    $driver_license = $_POST['driver_license'];
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];

    // Insert data into the database
    $sql = "INSERT INTO reservations (full_name, driver_license, pickup_date, return_date)
            VALUES ('$full_name', '$driver_license', '$pickup_date', '$return_date')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to reserve.php after successful reservation
        header("Location: reserve.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroBook Car Rental</title>
    <link rel="stylesheet" href="f1.css"> <!-- Linking to external CSS -->
</head>
<body>
    <!-- Header Bar -->
    <header>
        <h1>AeroBook Car Rental</h1>
    <section>
     
        <form action="firstpg.php" method="POST">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required>

            <label for="driver_license">Driver License</label>
            <input type="text" id="driver_license" name="driver_license" required>

            <label for="pickup_date">Pickup Date</label>
            <input type="date" id="pickup_date" name="pickup_date" required>

            <label for="return_date">Return Date</label>
            <input type="date" id="return_date" name="return_date" required>

            <input type="submit" value="Submit">
        </form>
    </section>

    <!-- CONTACT SECTION -->
    <section class="contact-section" id="contact-us">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 sm-padding">
                    <div class="contact-info">
                        <h2>Feedback<br>Send us a message today!</h2>
                    </div>
                </div>
                <div class="col-lg-6 sm-padding">
                    <form id="contact_ajax_form" action="submit_feedback.php" method="POST" class="contactForm">
                        <div class="form-group column-row row">
                            <div class="col-sm-6">
                                <input type="text" id="contact_name" name="name" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="col-sm-6">
                                <input type="email" id="contact_email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" id="contact_subject" name="subject" class="form-control" placeholder="Subject" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea id="contact_message" name="message" cols="30" rows="5" class="form-control message" placeholder="Message" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="contact_send_btn">Send Message</button>
                            </div>
                        </div>
                    </form>
                    <div id="form_status"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript for form submission -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#contact_ajax_form').on('submit', function(e) {
            e.preventDefault(); // Prevent the form from redirecting

            // Send AJAX request
            $.ajax({
                type: "POST",
                url: "submit_feedback.php",
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    $('#form_status').html('<p class="success-message">Feedback submitted successfully!</p>');
                },
                error: function() {
                    $('#form_status').html('<p class="error-message">Error occurred. Please try again.</p>');
                }
            });
        });
    });
    </script>
</body>
</html>
