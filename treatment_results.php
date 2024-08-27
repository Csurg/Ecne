<?php
session_start();
require_once 'functions.php';
if(!isset($_SESSION['username'])) {
    redirection('signIn.php?l=0');
}

if (isset($_POST['pet_id']) && isset($_POST['name'])) {
    $pet_id = $_POST['pet_id'];
    $name = $_POST['name'];
} else {
    echo 'No data received.';
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>Results</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <script src="script/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <link href="css/datatablesStyle.css" rel="stylesheet">
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "lengthMenu": [5,10,15,20],
                "pageLength": 10
            });
        });
    </script>

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
                }else if(isset($_SESSION['user_id'])){
                    echo '
                    <li class="nav-item"><a class="nav-link" href="appointment.php">Appointments</a></li>                 
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" aria-current="page"  href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
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
                    <a class="nav-link dropdown-toggle active" aria-current="page"  href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
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
<?php
if(isset($_SESSION['user_id'])) {
    echo '<div>
            <a class="btn btn--radius-2 btn-dark" href="my_pets.php">Back</a>
            </div>
    ';
}
else{
    echo '<div>
            <a class="btn btn--radius-2 btn-dark" href="my_patients.php">Back</a>
            </div>
    ';
}
    ?>

<div class="container px-4 px-lg-5">
    <h1 class="fw-light my-4 text-center">Results for <?php echo $name;?></h1>

    <div class="my-2">
        <table id="myTable" class="display">
            <thead class="mytable">
            <tr class="mytable">
                <th class="mytable">Title</th>
                <th class="mytable">Description</th>
                <th class="mytable">Medicine</th>
                <th class="mytable">Date</th>
                <th class="mytable">Vet</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $sql = "SELECT t.title,t.description,t.medicine,t.date, CONCAT(v.firstname,' ',v.lastname) AS vetname 
                    FROM treatments t
                    INNER JOIN reserved_appointments ra ON t.reserved_appointment_id = ra.reserved_appointment_id
                    INNER JOIN appointments a ON ra.appointment_id = a.appointment_id
                    INNER JOIN veterinarians v ON a.vet_id = v.vet_id
                    WHERE ra.pet_id = :pet_id
                    ORDER BY t.treatment_id";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':pet_id', $pet_id, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $value) {
                echo '<tr>
                        <td>' . $value['title'] . '</td>
                        <td>' . $value['description'] . '</td>
                        <td>' . $value['medicine'] . '</td>
                        <td>' . $value['date'] . '</td>
                        <td>' . $value['vetname'] . '</td>                                        
                           </tr> ';

            }
            ?>
            </tbody>

        </table>
    </div>
</div>



<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</body>
</html>