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
    <title>Manage appointments</title>
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
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="create_appointment.php">Appointments</a></li>  
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

<div class="container px-4 px-lg-5 mt-2 mb-2">
    <h1 class="fw-light my-4 text-center">Manage your appointments</h1>
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
        }
    }
    ?>
</div>
    <div>
        <form action="web.php" method="post" id="createAppForm" class="row g-3">
            <div class="col-md-4">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title">
                <small></small>
            </div>
            <div class="col-md-2">
                <label for="date" class="form-label">Choose a date</label>
                <select id="date" name="date" class="form-select"> </select>
            </div>

        <script>
            const select = document.getElementById('date');
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);

            for (let i = 0; i < 30; i++) {
                const option = document.createElement('option');
                const date = new Date(tomorrow);
                date.setDate(tomorrow.getDate() + i);
                const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
                option.value = formattedDate;
                option.textContent = formattedDate;
                select.appendChild(option);
            }
        </script>
            <div class="col-md-4 d-flex justify-content-center align-items-end ">
                <input type="hidden" name="action" value="createApp">
                <button type="submit" class="btn btn--radius-2 custom-blue" id="createApp" >Create appointments</button>
                    </div>
    </form>
    </div>

<div class="row mt-5">
    <div class="col my-2">
        <h2 class="font-weight-light">Created appointments:</h2>

        <?php
        $sql = "Select * FROM appointments WHERE vet_id = {$_SESSION['vet_id']}  AND date>NOW() ORDER BY date ASC";

        $apps=[];
        if($result =$pdo->query($sql)){
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $apps[] = $row;
            }
        }
        ?>
        <form action="web.php" method="post">
            <table>

                <tr>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Availability</th>
                </tr>


                <?php
                foreach ($apps as $key => $value) {
                    echo '<tr>
                            <td>' . $value['title'] . '</td>
                            <td>' . $value['date'] . '</td>                     
                               <td> ';

                    if ($value['is_available'] === 1) {
                        echo ' <input type="hidden" name="action" value="appointmentStatus">
                       <button class="btn btn-danger" type="submit" name="cancelApp" value="' . $value['appointment_id'] . '">Cancel</button>';
                    } else {
                        echo '  <input type="hidden" name="action" value="appointmentStatus">
                        <button class="btn btn-success" type="submit" name="reopenApp" value="' . $value['appointment_id'] . '">Reopen</button>';
                    }

                    echo '</td>
    </tr>';
                }
                ?>

            </table>
        </form>
    </div>


    <div class="col my-2">
        <h2 class="font-weight-light">Reserved appointments:</h2>

        <?php
        $sql = "Select ra.reserved_appointment_id,a.title,a.date,p.name AS petname,CONCAT(u.firstname,' ',u.lastname) AS username,ra.is_finished FROM reserved_appointments ra 
                INNER JOIN pets p ON ra.pet_id = p.pet_id
                INNER JOIN users u ON p.user_id = u.user_id
                INNER JOIN appointments a ON ra.appointment_id = a.appointment_id
                WHERE a.vet_id = {$_SESSION['vet_id']} AND ra.is_finished=0
                ORDER BY a.date ASC";

        $reservedapps=[];
        if($result =$pdo->query($sql)){
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $reservedapps[] = $row;
            }
        }
        ?>
        <form action="web.php" method="post">
            <table>

                <tr>
                    <th>Title</th>
                    <th>Pet name</th>
                    <th>Username</th>
                    <th>Date</th>
                    <th>Operation</th>
                </tr>


                <?php
                foreach ($reservedapps as $key => $value) {
                    echo '<tr>
                            <td>' . $value['title'] . '</td>
                            <td>' . $value['petname'] . '</td>
                            <td>' . $value['username'] . '</td>
                            <td>' . $value['date'] . '</td>                     
                               <td> ';

                        echo '  <input type="hidden" name="action" value="reservedappointmentStatus">
                        <button class="btn btn-success" type="submit" name="finish" value="' . $value['reserved_appointment_id'] . '">Finish</button>';


                    echo '</td>
    </tr>';
                }
                ?>

            </table>
        </form>
    </div>
</div>
</div>




<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</body>
</html>