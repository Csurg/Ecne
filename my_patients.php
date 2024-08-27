<?php
session_start();
require_once 'db_config.php';
require_once 'functions.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['vet_id'])) {
    redirection('signIn.php?l=0');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>My patients</title>
    <link href="css/table.css" rel="stylesheet">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/script.js"></script>
    <link href="css/style.css" rel="stylesheet">
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
                    <li class="nav-item"><a class="nav-link" href="create_appointment.php">Appointments</a></li>  
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" aria-current="page" href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
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

<div class="container px-4 px-lg-5 mt-2 mb-2">
    <h1 class="fw-light my-4 text-center">Patients</h1>


    <div class="col my-2 center">
        <?php
        $sql = "SELECT p.pet_id,p.name as Name,CONCAT(u.firstname,' ',u.lastname) AS owner,b.name AS breed,p.age,p.gender,p.other FROM pets p
                INNER JOIN users u ON p.user_id = u.user_id
                INNER JOIN breeds b ON p.breed_id = b.breed_id
                WHERE p.vet_id = {$_SESSION['vet_id']} 
                ORDER BY p.pet_id ASC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ?>
        <form id="resultsForm" action="treatment_results.php" method="post">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Breed</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Other</th>
                    <th>Results</th>
                </tr>
                <?php
                foreach ($results as $value) {
                    echo '<tr>
                            <td>' . $value['Name'] . '</td>
                            <td>' . $value['owner'] . '</td>
                            <td>' . $value['breed'] . '</td>
                            <td>' . $value['age'] . '</td>
                            <td>' . $value['gender'] . '</td>
                            <td>' . $value['other'] . '</td>
                            <td>
                                <button type="button" class="btn btn--radius-2 btn-success" onclick="submitForm(\'' . $value['Name'] . '\', \'' . $value['pet_id'] . '\')">Results</button>
                            </td>
                        </tr>';
                }
                ?>
            </table>
            <input type="hidden" name="name" id="name">
            <input type="hidden" name="pet_id" id="pet_id">
        </form>
    </div>
</div>

<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</body>
</html>