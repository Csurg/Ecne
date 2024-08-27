<?php
session_start();
require_once 'db_config.php';
require_once 'functions.php';

if(!isset($_SESSION['username']) || !isset($_SESSION['admin_id'])) {
    redirection('login.php?l=0');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="../images/favicon.png">
    <title>Register Veterinarians</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/script.js"></script>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/register.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="index.php">E-Pets Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="users.php">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="activity.php">Activity</a></li>
                <li class="nav-item"><a class="nav-link"  href="vets.php">Popularity</a></li>
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="vetRegister.php">Register Veterinarians</a></li>
                <?php
                if (isset($_SESSION['username'])) {
                    echo '
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">'.$_SESSION["username"]. '</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">                 
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
    <div class="my-5 text-center">
        <h1 class="font-weight-light">Register a new veterinarian</h1>
    </div>
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

    <form action="web.php" method="post" id="vetRegisterForm">
        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label for="email" class="label">Email</label>
                    <input class="input--style-4" type="text" id="email" name="email">
                    <small></small>
                </div>
            </div>
            
            <div class="col-2">
                <div class="input-group">
                    <label for="phone" class="label">Phone</label>
                    <input class="input--style-4" type="text" id="phone" name="phone" >
                    <small></small>
                </div>
            </div>
        </div>
        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label for="password" class="label">Password</label>
                    <input class="input--style-4" type="password" id="password" name="password">
                    <small></small>
                </div>
            </div>

            <div class="col-2">
                <div class="input-group">
                    <label for="passwordConfirm" class="label">Password Confirm</label>
                    <input class="input--style-4" type="password" id="passwordConfirm" name="passwordConfirm">
                    <small></small>
                </div>
            </div>
        </div>
        <div class="row row-space">
            <div class="col-2">
                <div class="input-group">
                    <label for="firstname" class="label">First name</label>
                    <input class="input--style-4" type="text" id="firstname" name="firstname">
                    <small></small>
                </div>
            </div>

            <div class="col-2">
                <div class="input-group">
                    <label for="lastname" class="label">Last name</label>
                    <input class="input--style-4" type="text" id="lastname" name="lastname">
                    <small></small>
                </div>
            </div>
        </div>
        <div class="row row-space">
            <div class="col-2">
                <div class="">
                    <label for="specialization" class="label">Specialization</label>
                    <select name="specialization" id="specialization" class="form-select">
                        <option value="" hidden>Choose</option>

                        <?php
                        $sql = 'SELECT * FROM specializations';
                        $query = $pdo->prepare($sql);
                        $query->execute();
                        $specializations = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($specializations as $specialization) {
                            $specializationId= $specialization['specialization_id'];
                            $specializationName = $specialization['name'];
                            ?>
                            <option value="<?php echo $specializationId; ?>"><?php echo $specializationName; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <small></small>
                </div>
            </div>

            <div class="col-2">
                <div class="">
                    <label for="office" class="label">Office</label>
                    <select name="office" id="office" class="form-select">
                        <option value="" hidden>Choose</option>

                        <?php
                        $sql = 'SELECT * FROM vet_offices';
                        $query = $pdo->prepare($sql);
                        $query->execute();
                        $offices = $query->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($offices as $office) {
                            $officeId= $office['vet_office_id'];
                            $officeName = $office['name'];
                            $officeCity = $office['city'];
                            ?>
                            <option value="<?php echo $officeId; ?>"><?php echo $officeName.' - '.$officeCity; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <small></small>
                </div>
            </div>
        </div><br>
        <div class="row row-space">
            <label for="biography" class="label">Biography</label>
            <textarea id="biography" rows="10" cols="40" name="biography"></textarea>
            <small></small>
        </div>
        <div class="p-t-15 text-center">
            <input type="hidden" name="action" value="register">
            <button class="btn btn--radius-2 btn-success" type="submit" id="register">Register</button>

            <button class="btn btn--radius-2 btn-danger" type="reset">Cancel</button>


</div>

</form>

</div>
</body>
<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</html>