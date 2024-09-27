<?php 
    include "connect.php"; // Database connection
    include "Includes/templates/header.php"; // Header template
    include "Includes/templates/navbar.php"; // Navbar template
?>

<!-- Home -->
<section class="home_section">
    <div class="section-header">
        <div class="section-title" style="font-size:50px; color:white">
            Discover Top Flight & Car Rental Deals
        </div>
        <hr class="separator">
        <div class="section-tagline">
            Runaway to Open Road
        </div>					
    </div>
</section>

<!-- Services -->
<section class="our-services" id="services">
    <div class="container">
        <div class="section-header">
            <div class="section-title">
                Services Offered by Aerobook
            </div>
            <hr class="separator">
            <div class="section-tagline">
                For those who value efficiency and convenience.
            </div>
        </div>
        <div class="row">
            <!-- Add your service items here -->
        </div>
    </div>
</section>

<!-- Area -->
<section class="about-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 left-area" style="padding:0px">
                <img src="Design/images/about-img.jpg" alt="Car Rental Image">
            </div>
            <div class="col-md-6 right-area" style="padding:50px">
                <h1>
                    Globally Connected <br>
                    by Large Network
                </h1>
                <p>
                    <span>
                    We're here to provide you with seamless travel experiences
                    </span>
                </p>
                <p>
                    Experience top-tier flight and car rental services tailored to your needs. Fly with ease, drive in comfort
                    <a class="my-btn bttn" href="#">get details</a>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Brands -->
<section class="our-brands" id="brands">
    <div class="container">
        <div class="section-header">
            <div class="section-title">
                Premium Flight & Car Rental Solutions
            </div>
            <hr class="separator">
            <div class="section-tagline">
                We offer professional car rental
            </div>
        </div>
        <div class="car-brands">
            <div class="row">
                <?php
                    $stmt = $con->prepare("SELECT * FROM car_brands");
                    $stmt->execute();
                    $car_brands = $stmt->fetchAll();

                    foreach ($car_brands as $car_brand) {
                        $car_brand_img = "admin/Uploads/images/" . $car_brand['brand_image'];
                        ?>
                        <div class="col-md-4">
                            <div class="car-brand" style="background-image: url(<?php echo $car_brand_img ?>);">
                                <div class="brand_name">
                                    <h3>
                                        <?php echo $car_brand['brand_name']; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- CAR RESERVATION -->
<section class="reservation_section" style="padding:50px 0px" id="reserve">
    <div class="container">
        <div class="row">
            <div class="col-md-5"></div>
            <div class="col-md-7">
                <form method="POST" action="reserve.php" class="car-reservation-form" id="reservation_form">
                    <div class="text_header">
                        <span>Book Your Flight or Car</span>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="pickup_location">Pickup Location</label>
                            <input type="text" class="form-control" name="pickup_location" placeholder="Mmu, Cyberjaya" required>
                        </div>
                        <div class="form-group">
                            <label for="return_location">Return Location</label>
                            <input type="text" class="form-control" name="return_location" placeholder="Mmu, Cyberjaya" required>
                        </div>
                        <div class="form-group">
                            <label for="pickup_date">Pickup Date</label>
                            <input type="date" min="<?php echo date('Y-m-d', strtotime("+1 day")) ?>" name="pickup_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="return_date">Return Date</label>
                            <input type="date" min="<?php echo date('Y-m-d', strtotime("+2 day")) ?>" name="return_date" class="form-control" required>
                        </div>
                        <button type="submit" class="btn sbmt-bttn" name="reserve_car">Book Instantly</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- CONTACT -->
<section class="contact-section" id="contact-us">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 sm-padding">
                <div class="contact-info">
                    <h2>
                        Get in touch with us & 
                        <br>send us message today!
                    </h2>
                    <p>
                        Getting dressed up and traveling with good friends makes for a shared, unforgettable experience.
                    </p>
                    <h3>
                        Mmu, Cyberjaya
                        <br>
                        Persiaran Multimedia, 63100
                    </h3>
                    <ul>
                        <li>
                            <span style="font-weight: bold">Email:</span> 
                            aerobook@gmail.com
                        </li>
                        <li>
                            <span style="font-weight: bold">Phone:</span> 
                            +60 1162174081
                        </li>
                        <li>
                            <span style="font-weight: bold">Fax:</span> 
                            +60 1162174081
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6 sm-padding">
                <form id="contact_ajax_form" action="submit_feedback.php" method="POST" class="contactForm">
                    <div class="form-group colum-row row">
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

<script src="https://code.jquery.com/jquery.min.js"></script> 
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
