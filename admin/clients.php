<?php
    // Start session
    session_start();
    
    // Start output buffering to prevent headers already sent issues
    ob_start();
    
    // Page Title
    $pageTitle = 'Clients';

    // Includes
    include 'connect.php';
    include 'Includes/functions/functions.php'; 
    include 'Includes/templates/header.php'; // Ensure no whitespace before this file's PHP block

    // Check If user is already logged in
    if (isset($_SESSION['username_aerobookrental']) && isset($_SESSION['password_aerobook_rental'])) {
?>

        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Clients</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                    Generate Report
                </a>
            </div>

            <!-- Clients Table -->
            <?php
                // Prepare SQL statement to fetch clients
                $stmt = $con->prepare("SELECT * FROM clients");
                $stmt->execute();
                $rows_clients = $stmt->fetchAll(); 
            ?>

            <!-- Card for displaying clients -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Clients</h6>
                </div>
                <div class="card-body">
                    
                    <!-- Clients Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">ID#</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">E-mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    // Loop through clients and display in table
                                    foreach ($rows_clients as $client) {
                                        echo "<tr>";
                                            echo "<td>" . $client['client_id'] . "</td>";
                                            echo "<td>" . $client['full_name'] . "</td>";
                                            echo "<td>" . $client['client_phone'] . "</td>";
                                            echo "<td>" . $client['client_email'] . "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Content -->

<?php 
        // Include Footer
        include 'Includes/templates/footer.php';
    } else {
        // If user not logged in, redirect to login page
        header('Location: firstpg.php');
        exit();
    }

    // End output buffering and flush the output
    ob_end_flush();
?>
