<?php
session_start();
require_once 'db_config.php';
require_once 'functions.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>About Us</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/script.js"></script>

</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="index.php">E-Pets</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="vets.php">Veterinarians</a></li>
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="contactus.php">Contact Us</a></li>
                <?php
                if (!isset($_SESSION['username'])) {
                    echo'
                <li class="nav-item"><a class="nav-link" href="signIn.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Registration</a></li>
                    ';
                }else if(isset($_SESSION['user_id'])){
                    echo '                 
                    <li class="nav-item"><a class="nav-link" href="appointment.php">Appointments</a></li>  
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="editprofile.php">Edit profile</a>
                        <a class="dropdown-item" href="my_pets.php">My pets</a>
                   <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Log out</a>
                            </div>
                        </li>
                    ';
                }
                else
                {
                    echo '                 
                   <li class="nav-item"><a class="nav-link" href="create_appointment.php">Appointments</a></li>  
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="editprofile.php">Edit profile</a>
                        <a class="dropdown-item" href="my_patients.php">My patients</a>
                   <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">Log out</a>
                            </div>
                        </li>
                    ';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container px-4 px-lg-5">
    <div class="my-2">

    </div>

    <div class="col-lg">
        <h1 class="font-weight-light my-2 text-center">Welcome to E-Pets!</h1>
        <p class="text-center">Your pets health and well-being are our top priorities, and we are honored to be a trusted partner in their care.</p>
    </div>
    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <div class="col-lg-7 text-center"><img class="img-fluid rounded mb-4 mb-lg-0" src="images/about1.jpg" alt="about1.jpg" /></div>
        <div class="col-lg-5">
            <p >We are passionate about providing exceptional veterinary care for your beloved pets. With years of experience and a deep commitment to animal health, our team of dedicated veterinarians and support staff offer a full range of services to keep your pets healthy and happy. From routine check-ups and vaccinations to advanced diagnostics and surgeries, we strive to treat every pet like a member of our own family.</p>
            <p>We believe in compassionate, personalized care and building lasting relationships with our clients. Whether your pet is here for preventive care or needs specialized treatment, we are here to support you every step of the way.</p>
        </div>
    </div>

    <div class="row gx-4 gx-lg-5 align-items-center my-5">

        <div class="col-lg-5">
            <p>Founded on a love for animals and a desire to make a difference, E-Pets began as a small, local veterinary practice. Over the years, we’ve grown, but our mission remains the same: to provide compassionate, high-quality care for pets and peace of mind for their owners. Every day, we’re driven by our passion for animal health and our commitment to the community we serve.</p>
        </div>
        <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="images/about2.jpg" alt="about2.jpg" /></div>
    </div>
</div>


</div>

<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</body>
</html>