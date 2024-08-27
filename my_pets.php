<?php
session_start();
require_once 'db_config.php';
require_once 'functions.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    redirection('signIn.php?l=0');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>My pets</title>

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
                }else if(isset($_SESSION['user_id'])){
                    echo '                 
                    <li class="nav-item"><a class="nav-link" href="appointment.php">Appointments</a></li>  
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" aria-current="page" href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="editprofile.php">Edit profile</a>
                        <a class="dropdown-item" href="my_pets.php">My pets</a>
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
<div class="text-center mt-4">
    <a class="btn btn--radius-2 btn-success" href="pet_register.php">Add a new pet</a>
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
</div>

<div class="container px-4 px-lg-5 mt-5">
<?php
    $id = $_SESSION['user_id'];
    $sql="Select pet_id,name,breed_id,vet_id,age,gender,other,lost FROM pets WHERE user_id = $id AND deleted_at IS NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($row as $key => $value) {
    echo '
    <div class="row gx-4 gx-lg-5 mb-4">
        <div class="card h-100">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h2 class="card-title">'.$value['name'].'</h2>
                <div class="ml-auto d-flex">
                    <form method="POST" action="edit_pet.php">
                        <input type="hidden" name="data" value="'.$value['pet_id'].','.$value['name'].','.$value['breed_id'].','.$value['vet_id'].','.$value['age'].','.$value['gender'].','.$value['other'].'">
                        <button class="btn btn--radius-2 custom-blue me-2" href="edit_pet.php">Edit</button>
                        </form>
                    <form method="POST" action="delete_pet.php" onsubmit="return confirm(\'Are you sure you want to delete this pet?\');">
                            <input type="hidden" name="pet_id" value="'.$value['pet_id'].'">
                            <button type="submit" class="btn btn--radius-2 btn-danger me-2">Remove</button>
                        </form>
                    <form method="POST" action="create_qr_code.php" target="_blank">
                            <input type="hidden" name="name" value="'.$value['name'].'">
                            <input type="hidden" name="pet_id" value="'.$value['pet_id'].'">
                            <button type="submit" class="btn btn--radius-2 btn-dark" >QR Code</button>
                        </form>
                        <form method="POST" action="treatment_results.php">
                            <input type="hidden" name="name" value="'.$value['name'].'">                       
                            <input type="hidden" name="pet_id" value="'.$value['pet_id'].'">
                            <button type="submit" class="btn btn--radius-2 btn-success" >Results</button>
                        </form>
                        ';
                     if ($value['lost'] === 0) {
                            echo'<form method="POST" action="lost_pet.php">
                                <input type="hidden" name="pet_id" value="'.$value['pet_id'].'">
                                <button type="submit" class="btn btn--radius-2 custom-red" href="my_pets.php">LOST</button>
                             </form>';}
                     else{
                         echo'<form method="POST" action="found_pet.php">
                                    <input type="hidden" name="pet_id" value="'.$value['pet_id'].'">
                                    <button type="submit" class="btn btn--radius-2 btn-success" href="my_pets.php">FOUND</button>
                                 </form>';
                         }
                echo'</div>
            </div>
        </div>
    </div>';
}
?>
</div>


<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</body>
</html>