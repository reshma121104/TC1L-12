<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "car_rental";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['email']) && isset($_POST['psw']) && isset($_POST['psw-repeat'])) {
        $email = $_POST['email'];
        $password = $_POST['psw'];
        $repeat_password = $_POST['psw-repeat'];

    
        if ($password !== $repeat_password) {
            $error = "Passwords do not match.";
        } else {

            $stmt = $conn->prepare("SELECT id FROM login WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {

                $error = "Email is already registered.";
            } else {

                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                //database
                $stmt->close(); 
                $stmt = $conn->prepare("INSERT INTO login (email, password) VALUES (?, ?)");
                if (!$stmt) {
                    die("Prepare failed: " . $conn->error);
                }

                $stmt->bind_param("ss", $email, $hashed_password);

                if (!$stmt->execute()) {
                    $error = "Execution failed: " . $stmt->error;
                } else {
                    header("Location: firstpg.php");
                    exit();
                }
            }

            $stmt->close();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an account</title>
    <link rel="stylesheet" href="logincss.css">
</head>
<body>

<form action="login.php" method="POST" style="border:1px solid #ccc">
  <div class="container">
    <h1>Aerobook Sign up</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

    <label>
      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    </label>

    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>

    <div class="clearfix">
      <button type="button" class="cancelbtn">Cancel</button>
      <button type="submit" class="signupbtn">Sign Up</button>
    </div>

    <?php if (!empty($error)): ?>
        <p class="error" style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

  </div>
</form>

</body>
</html>
