<?php
session_start();
require_once 'db_config.php';
require_once 'functions.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['vet_id'])) {
    redirection('signIn.php?l=0');
}
if(isset($_SESSION['finish'])){
    $reserved_appointment_id = $_SESSION['finish'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>Treatment form</title>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/script.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">

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
                <li class="nav-item"><a class="nav-link" href="aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="contactus.php">Contact Us</a></li>
                <?php
                if (!isset($_SESSION['username'])) {
                    echo'
                <li class="nav-item"><a class="nav-link" href="signIn.php">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Registration</a></li>
                    ';
                }else if(isset($_SESSION['vet_id'])){
                    echo '                 
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="create_appointment.php">Appointments</a></li>  
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
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
    <h1 class="fw-light my-4 text-center">Treatment</h1>

    <div>
        <?php
        $c = 0;

        if (isset($_GET["r"]) and is_numeric($_GET['r'])) {
            $c = (int)$_GET["r"];

            if (array_key_exists($c, $messages)) {
                echo '
                    <div  style="font-size: 30px" role="alert">
                        ' . $messages[$c] . '
                        
                    </div>
                    ';
                if($messages[$c] == "Success!")
                {
                    header( "refresh:3;url=create_appointment.php" );
                }
            }
        }
        ?>
    </div>

    <form action="web.php" method="post" id="treatmentForm">
        <div class="row row-space">

                <div class="input-group">
                    <label for="title" class="label">Title</label>
                    <input class="input--style-4" type="text" id="title" name="title">
                    <small></small>
                </div>
        </div>
        <div class="row row-space">

            <div class="input-group">
                <label for="medicine" class="label">Medicine</label>
                <input class="input--style-4" type="text" id="medicine" name="medicine" >
                <small></small>
            </div>
        </div>
        <div class="row row-space">
            <label for="description" class="label">Description</label>
            <textarea id="description" rows="10" cols="40" name="description"></textarea>

        </div>
        <div class="p-t-15 text-center">
            <input type="hidden" name="reserved_appointment_id" value="<?php echo $reserved_appointment_id;?>">
            <input type="hidden" name="action" value="treatmentSave">
            <button class="btn btn--radius-2 btn-success" type="submit" id="treatmentSave">Save</button>

            <button class="btn btn--radius-2 btn-danger" type="reset">Cancel</button>

        </div>

    </form>

</div>



<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</body>
</html>