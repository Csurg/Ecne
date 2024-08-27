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
    <title>Users</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/script.js"></script>


</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="index.php">E-Pets Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" aria-current="page"  href="users.php">Users</a></li>
                <li class="nav-item"><a class="nav-link" href="activity.php">Activity</a></li>
                <li class="nav-item"><a class="nav-link"  href="vets.php">Popularity</a></li>
                <li class="nav-item"><a class="nav-link" href="vetRegister.php">Register Veterinarians</a></li>
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
    <div class="my-2">

        <?php
        $ub = 0;

        if (isset($_GET["ub"]) and is_numeric($_GET['ub'])) {
            $ub = (int)$_GET["ub"];

            if (array_key_exists($ub, $messages)) {
                echo '
                    <div  style="font-size: 40px" role="alert">
                        ' . $messages[$ub] . '
                        
                    </div>
                    ';
            }
        }
        ?>
        <h1 class="font-weight-light">All users:</h1>
    </div>

    <?php
    $sql = "Select user_id,email,firstname,lastname,phone,is_banned FROM users";

    if($result =$pdo->query($sql)){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $row;
        }
    }
    ?>
    <form action="web.php" method="post">
        <table>

            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Phone</th>
                <th>Banned</th>
                <th>Operation</th>
            </tr>


            <?php
            foreach ($users as $key => $value) {
                echo '<tr>
        <td>' . $value['user_id'] . '</td>
        <td>' . $value['email'] . '</td>
        <td>' . $value['firstname'] . '</td>
        <td>' . $value['lastname'] . '</td>
        <td>' . $value['phone'] . '</td>
        <td>' . $value['is_banned'] . '</td>
           <td> ';

                if ($value['is_banned'] === 0) {
                    echo ' <input type="hidden" name="action" value="ban">
                       <button class="btn btn-danger" type="submit" name="userBan" value="' . $value['user_id'] . '">Ban</button>';
                } else {
                    echo '  <input type="hidden" name="action" value="ban">
                        <button class="btn btn-success" type="submit" name="userUnban" value="' . $value['user_id'] . '">Unban</button>';
                }

                echo '</td>
    </tr>';
            }
            ?>

        </table>
    </form>

    <div class="my-2">
        <h1 class="font-weight-light">All veterinarians:</h1>
    </div>
    <?php
    $sql = "Select * FROM veterinarians";

    if($result =$pdo->query($sql)){
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $vets[] = $row;
        }
    }
    ?>
    <form action="web.php" method="post">
        <table>

            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Phone</th>
                <th>Banned</th>
                <th>Operation</th>
            </tr>


            <?php
            foreach ($vets as $key => $value) {
                echo '<tr>
        <td>' . $value['vet_id'] . '</td>
        <td>' . $value['email'] . '</td>
        <td>' . $value['firstname'] . '</td>
        <td>' . $value['lastname'] . '</td>
        <td>' . $value['phone'] . '</td>
        <td>' . $value['is_banned'] . '</td>
           <td> ';

                if ($value['is_banned'] === 0) {
                    echo ' <input type="hidden" name="action" value="ban">
                       <button class="btn btn-danger" type="submit" name="vetBan" value="' . $value['vet_id'] . '">Ban</button>';
                } else {
                    echo '  <input type="hidden" name="action" value="ban">
                        <button class="btn btn-success" type="submit" name="vetUnban" value="' . $value['vet_id'] . '">Unban</button>';
                }

                echo '</td>
    </tr>';
            }
            ?>

        </table>
    </form>



</div>
</body>
<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</html>