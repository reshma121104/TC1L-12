<?php

    session_start();

    ob_start();
    
    $pageTitle = 'Users';
    
    include 'connect.php';
    include 'Includes/functions/functions.php'; 
    include 'Includes/templates/header.php'; 

    if (isset($_SESSION['username_aerobook_rental']) && isset($_SESSION['password_aerobok_rental'])) {
?>
        <div class="container-fluid">
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Users</h1>
                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-download fa-sm text-white-50"></i>
                    Generate Report
                </a>
            </div>

            <!-- Users -->
            <?php
                $stmt = $con->prepare("SELECT * FROM users");
                $stmt->execute();
                $rows_users = $stmt->fetchAll(); 
            ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Users</h6>
                </div>
                <div class="card-body">
                    
                    <!-- Users  -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">ID#</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">E-mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($rows_users as $user) {
                                        echo "<tr>";
                                            echo "<td>" . $user['user_id'] . "</td>";
                                            echo "<td>" . $user['username'] . "</td>";
                                            echo "<td>" . $user['full_name'] . "</td>";
                                            echo "<td>" . $user['user_email'] . "</td>";
                                        echo "</tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
  
<?php 
        include 'Includes/templates/footer.php';
    } else {
        header('Location: first.php');
        exit();
    }
    ob_end_flush();
?>
