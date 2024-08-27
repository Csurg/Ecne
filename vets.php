<?php
session_start();
require_once 'db_config.php';
require_once 'functions.php';

if (isset($_POST['selected_vet_id'])) {
    updateVisit($pdo,$_POST['selected_vet_id']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>Veterinarians</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/script.js"></script>

</head>
<div>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" href="index.php">E-Pets</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active"  aria-current="page" href="vets.php">Veterinarians</a></li>
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
        <form method="GET" action="">
            <div class="input-group">
                <input id="search-input" name="specialization" type="search" class="form-control rounded" placeholder="Search by specialization" aria-label="Search" aria-describedby="search-addon" />
                <button id="search-button" type="submit" class="btn btn-outline-primary" data-mdb-ripple-init>Search</button>
            </div>
        </form>
    </div>
    <div id="vet-cards-container">

        <?php
        $specialization = isset($_GET['specialization']) ? '%' . htmlspecialchars($_GET['specialization']) . '%' : '%%';

        $sql = "SELECT vet_id,email, firstname, lastname, veterinarians.phone AS phone, biography, specializations.name AS spec, vet_offices.name AS office, vet_offices.city AS city
        FROM veterinarians
        INNER JOIN specializations ON veterinarians.specialization_id = specializations.specialization_id
        INNER JOIN vet_offices ON veterinarians.vet_office_id = vet_offices.vet_office_id
        WHERE specializations.name LIKE :specialization";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':specialization', $specialization, PDO::PARAM_STR);
        $stmt->execute();

        $vets = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vets[] = $row;
        }

        $counter = 0;
        foreach ($vets as $key => $value) {
            if ($counter % 3 == 0) { // Start a new row every 3 items
                if ($counter > 0) {
                    echo '</div>'; // Close the previous row
                }
                echo '<div class="row gx-4 gx-lg-5">';
            }

            echo '<div class="col-md-4 mb-5 vet-card" data-specialization="' . $value['spec'] . '">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="card-title text-center">' . $value['firstname'] . ' ' . $value['lastname'] . '</h2>
                    <p class="card-text text-center">Email: ' . $value['email'] . '</p>
                    <p class="card-text text-center">Phone: ' . $value['phone'] . '</p>
                    <p class="card-text text-center">Specialization: ' . $value['spec'] . '</p>
                    <p class="card-text text-center">Office: ' . $value['office'] . ' - ' . $value['city'] . '</p>
                    <button type="button" class="card-text text-center collapsible" onclick="updateVisit('. $value['vet_id'].')">Biography...</button>
                    <p class="content">' . $value['biography'] . '</p>
                </div>
            </div>
          </div>';

            $counter++;
        }
       /* if ($counter % 3 != 0) {
            echo '</div>';
        }*/
        ?>
    </div>
</div>
</div>
</div>

        <footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</body>
</html>