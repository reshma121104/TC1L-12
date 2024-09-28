<?php
// Start the session and enable output buffering
session_start();
ob_start();

// Page Title
$pageTitle = 'Car Brands';

// Includes
include 'connect.php';
include 'Includes/functions/functions.php'; 
include 'Includes/templates/header.php';



// Check if user is already logged in
if (isset($_SESSION['username_aerobook_rental']) && isset($_SESSION['password_aerobook_rental'])) {
?>
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Car Brands</h1>
            <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i>
                Generate Report
            </a>
        </div>

        <!-- ADD NEW BRAND SUBMITTED -->
        <?php
        if (isset($_POST['add_brand_sbmt']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $brand_name = test_input($_POST['brand_name']);
            $brand_image = rand(0,100000).'_'.$_FILES['brand_image']['name'];
            move_uploaded_file($_FILES['brand_image']['tmp_name'], "Uploads/images//".$brand_image);

            try {
                $stmt = $con->prepare("INSERT INTO car_brands(brand_name,brand_image) VALUES(?,?)");
                $stmt->execute(array($brand_name, $brand_image));
                echo "<div class='alert alert-success'>New Car Brand has been inserted successfully</div>";
            } catch (Exception $e) {
                echo "<div class='alert alert-danger'>Error occurred: " .$e->getMessage() . "</div>";
            }
        }

        if (isset($_POST['delete_brand_sbmt']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $brand_id = $_POST['brand_id'];
            try {
                $stmt = $con->prepare("DELETE FROM car_brands WHERE brand_id = ?");
                $stmt->execute(array($brand_id));
                echo "<div class='alert alert-success'>Car Brand has been deleted successfully</div>";
            } catch (Exception $e) {
                echo "<div class='alert alert-danger'>Error occurred: " .$e->getMessage() . "</div>";
            }
        }
        
        ?>

        <!-- Car Brands Table -->
        <?php
        $stmt = $con->prepare("SELECT * FROM car_brands");
        $stmt->execute();
        $rows_brands = $stmt->fetchAll();
        ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Car Brands</h6>
            </div>
            <div class="card-body">

                <!-- ADD NEW BRAND BUTTON -->
                <button class="btn btn-success btn-sm" style="margin-bottom: 10px;" type="button" data-toggle="modal" data-target="#add_new_brand">
                    <i class="fa fa-plus"></i> Add New Brand
                </button>

                <!-- Add New Brand Modal -->
                <div class="modal fade" id="add_new_brand" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Brand</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="car-brands.php" method="POST" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="brand_name">Brand name</label>
                                        <input type="text" class="form-control" placeholder="Brand Name" name="brand_name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="brand_image">Brand image</label>
                                        <input type="file" class="form-control" name="brand_image" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-info" name="add_brand_sbmt">Add Brand</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Brands Table -->
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Brand ID</th>
                                <th>Brand Name</th>
                                <th>Brand Image</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($rows_brands as $brand) { ?>
                                <tr>
                                    <td><?php echo $brand['brand_id']; ?></td>
                                    <td><?php echo $brand['brand_name']; ?></td>
                                    <td style="width:30%">
                                        <img src="Uploads/images/<?php echo $brand['brand_image']; ?>" alt="<?php echo $brand['brand_name']; ?>" class="img-fluid img-thumbnail">
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" type="button" data-toggle="modal" data-target="#delete_<?php echo $brand['brand_id']; ?>">
                                            <i class="fa fa-trash"></i>
                                        </button>

                                        <!-- Delete Modal -->
                                         
                                        <div class="modal fade" id="delete_<?php echo $brand['brand_id']; ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <form action="car-brands.php" method="POST">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Delete Brand</h5>
                                                            <input type="hidden" name="brand_id" value="<?php echo $brand['brand_id']; ?>">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete the brand "<?php echo $brand['brand_name']; ?>"?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="submit" name="delete_brand_sbmt" class="btn btn-danger">Delete</button>
                                                            
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
  
<?php
    // Include Footer
    include 'Includes/templates/footer.php';
} else {
    header('Location: firstpg.php');
    exit();
}
?>
