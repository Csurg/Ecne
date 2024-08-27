<?php
session_start();
require_once 'db_config.php';
require_once 'functions.php';

if(isset($_SESSION['user_id'])) {
    if(!hasPet($pdo, $_SESSION['user_id']))
        redirection('pet_register.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>Home page</title>
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
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="vets.php">Veterinarians</a></li>
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
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

    <div class="row gx-4 gx-lg-5 align-items-center my-5">
        <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" src="images/home.jpg" alt="home.jpg" /></div>
        <div class="col-lg-5">
            <h1 class="fw-light">About Us</h1>
            <p>This is one of the best sites where you can find health care for your pets.</p>
            <a class="btn btn-primary" href="aboutus.php">Learn more</a>
        </div>
    </div>

    <h1 class="fw-light my-4 text-center">Here you can find the best and most professional vets!</h1>



    <div class="row gx-4 gx-lg-5">
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body">
                    <img class="img-fluid rounded mb-4 mb-lg-0" src="images/dr1.jpg" alt="dr1.jpg" />
                    <h2 class="card-title">Josh Clark</h2>
                    <p class="card-text">Meet Josh Clark, a compassionate and dedicated veterinarian with a passion for animal care. With years of experience and a gentle touch, Josh is known for his unwavering commitment to the well-being of his furry patients. Whether it's a routine check-up or a complex medical issue,
                        Josh approaches each case with expertise and a genuine love for animals, making him a trusted figure in the community.</p>
                </div>
                <div class="card-footer"><a class="btn btn-primary btn-sm" href="vets.php">More Info</a></div>
            </div>
        </div>
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body">
                    <img class="img-fluid rounded mb-4 mb-lg-0" src="images/dr2.jpg" alt="dr2.jpg" />
                    <h2 class="card-title">Darcy Zuri</h2>
                    <p class="card-text">Meet Darcy Zuri, a caring vet devoted to the health and happiness of animals. With a warm heart and skilled hands, Darcy is a trusted figure in the world of veterinary care.</p>
                </div>
                <div class="card-footer"><a class="btn btn-primary btn-sm" href="vets.php">More Info</a></div>
            </div>
        </div>
        <div class="col-md-4 mb-5">
            <div class="card h-100">
                <div class="card-body">
                    <img class="img-fluid rounded mb-4 mb-lg-0" src="images/dr3.jpg" alt="dr3.jpg" />
                    <h2 class="card-title">Benjamin Smith</h2>
                    <p class="card-text">Introducing Benjamin Smith, a dedicated vet with a passion for healing animals. Known for his expertise and kindness, Benjamin is committed to providing top-notch care, ensuring the well-being of his four-legged patients</p>
                </div>
                <div class="card-footer"><a class="btn btn-primary btn-sm" href="vets.php">More Info</a></div>
            </div>
        </div>
    </div>

</div>

<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</body>
</html>