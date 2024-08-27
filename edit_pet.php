<?php
session_start();
require_once 'functions.php';
if(!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    redirection('signIn.php?l=0');
}
$data[] = [];
if (isset($_POST['data'])) {
    $data = explode(',', $_POST['data']);

    $pet_id = $data[0];
    $name = $data[1];
    $breed_id = $data[2];
    $vet_id = $data[3];
    $age = $data[4];
    $gender = $data[5];
    $other = $data[6];

} else {
    echo 'No data received.';
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>Pet edit</title>
    <link href="css/style.css" rel="stylesheet">

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/script.js"></script>
    <link href="css/register.css" rel="stylesheet">
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            var gender = "<?php echo $gender; ?>";

            if (gender === "Male") {
                document.getElementById("GenderMale").checked = true;
            } else if (gender === "Female") {
                document.getElementById("GenderFemale").checked = true;
            }
        });
    </script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <div class="container">
        <a class="navbar-brand" >E-Pets</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link disabled" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link disabled" href="vets.php">Veterinarians</a></li>
                <li class="nav-item"><a class="nav-link disabled" href="aboutus.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link disabled" href="contactus.php">Contact Us</a></li>
                <?php
                    if(isset($_SESSION['user_id'])){
                    echo '                 
                    <li class="nav-item"><a class="nav-link disabled" href="appointment.php">Appointments</a></li>  
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" aria-current="page" href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["firstname"]. '</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item disabled" href="editprofile.php">Edit profile</a>
                        <a class="dropdown-item disabled" href="my_pets.php">My pets</a>
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
<div>
    <a class="btn btn--radius-2 btn-dark" href="my_pets.php">Back</a>
</div>
<div class="container px-4 px-lg-5">
    <h1 class="fw-light my-4 text-center">Edit</h1>

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

    <form action="web.php" method="post" id="petForm">
        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label for="name" class="label">Name</label>
                    <input class="input--style-4" type="text" id="name" name="name" value="<?php echo $name; ?>" >
                    <small></small>
                </div>
            </div>

            <div class="col-2">
                <div class="input-group">
                    <label for="age" class="label">Age</label>
                    <input class="input--style-4" type="text" id="age" name="age" value="<?php echo $age; ?>">
                    <small></small>
                </div>
            </div>
        </div>
        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label class="label">Gender</label>
                    <div class="p-t-30" id="Gender">
                        <label for="GenderMale" class="radio-container m-r-45">Male
                            <input type="radio" name="gender" id="GenderMale" value="Male" >
                            <small></small>
                            <span class="checkmark"></span>
                        </label>
                        <label for="GenderFemale" class="radio-container">Female
                            <input type="radio" name="gender" id="GenderFemale" value="Female">
                            <small></small>
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <small></small>
                </div>
            </div>
        </div>

        <div class="row row-space">
            <div class="col-2">
                <div class="">
                    <label for="breed" class="label">Breed</label>
                    <select name="breed" id="breed" class="form-select">
                        <option value="" hidden>Choose</option>

                        <?php
                        $sql = 'SELECT * FROM breeds';
                        $query = $pdo->prepare($sql);
                        $query->execute();
                        $breeds = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($breeds as $breed) {
                            $breedId= $breed['breed_id'];
                            $breedName = $breed['name'];
                            ?>
                            <option value="<?php echo $breedId; ?>" <?php echo ($breedId == $breed_id) ? 'selected' : ''; ?>>
                                <?php echo $breedName; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <small></small>
                </div>
            </div>

            <div class="col-2">
                <div class="">
                    <label for="vet" class="label">Veterinarians</label>
                    <select name="vet" id="vet" class="form-select">
                        <option value="" hidden>Choose</option>

                        <?php
                        $sql = 'SELECT vet_id,CONCAT(firstname,\' \',lastname) AS name, s.name AS specialization FROM veterinarians
                                INNER JOIN specializations s ON veterinarians.specialization_id = s.specialization_id';
                        $query = $pdo->prepare($sql);
                        $query->execute();
                        $vets = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($vets as $vet) {
                            $vetId = $vet['vet_id'];
                            $vetName = $vet['name'];
                            $vetSpecialization = $vet['specialization'];
                            ?>
                            <option value="<?php echo $vetId; ?>" <?php echo ($vetId == $vet_id) ? 'selected' : ''; ?>>
                                <?php echo $vetName . ' - ' . $vetSpecialization; ?>
                            </option>
                            <?php
                        }
                        ?>
                    </select>
                    <small></small>
                </div>
            </div>
        </div><br>
        <div class="row row-space">
            <label for="other" class="label">Others</label>
            <textarea id="other" rows="10" cols="40" name="other" placeholder="Here you can share more data with us about your pet..."><?php echo $other; ?></textarea>
            <small></small>
        </div>
        <div class="p-t-15 text-center">

            <input type="hidden" name="pet_id" value="<?php echo $pet_id; ?>">
            <input type="hidden" name="action" value="petEdit">
            <button class="btn btn--radius-2 btn-success" type="submit" id="petEdit">Edit</button>

            <button class="btn btn--radius-2 btn-danger" type="reset">Cancel</button>

        </div>

    </form>

</div>

<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</body>
</html>