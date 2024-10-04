<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="success.css">
</head>
<body>

<div class="success-container">
    <div class="success-wrapper">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Payment Successful</h1>
        <p>Thank you for your reservation! You can collect your rental car at our location and complete the full payment when you arrive. We look forward to serving you.</p>
        
        <a href="firstpg.php" class="btn">Return to Home</a>
    </div>
</div>
<script>
    setTimeout(function() {
        window.location.href = 'firstpg.php';
    }, 10000);
</script>

</body>
</html>
