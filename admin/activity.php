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
    <title>Activity</title>
    <link href="css/datatablesStyle.css" rel="stylesheet">
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="script/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "lengthMenu": [5,10,15,20],
                "pageLength": 5
            });
        });
    </script>

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
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="activity.php">Activity</a></li>
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
        <h1 class="font-weight-light">Activities</h1>
        <table id="myTable" class="display">
            <thead class="mytable">
            <tr class="mytable">
                <th class="mytable">ID</th>
                <th class="mytable">User ID</th>
                <th class="mytable">User agent</th>
                <th class="mytable">Ip address</th>
                <th class="mytable">Device type</th>
                <th class="mytable">Country</th>
                <th class="mytable">City</th>
                <th class="mytable">Proxy</th>
                <th class="mytable">Date</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $rows[] = getAll($pdo,"users_detected_data");

            foreach ($rows as $values) {
                foreach ($values as $row) {
                    echo "<tr class='mytable'>";
                    echo "<td class='mytable'>{$row['user_detected_data_id']}</td>";
                    echo "<td class='mytable'>{$row['user_id']}</td>";
                    echo "<td class='mytable'>{$row['user_agent']}</td>";
                    echo "<td class='mytable'>{$row['ip_address']}</td>";
                    echo "<td class='mytable'>{$row['device_type']}</td>";
                    echo "<td class='mytable'>{$row['country']}</td>";
                    echo "<td class='mytable'>{$row['city']}</td>";
                    echo "<td class='mytable'>{$row['proxy']}</td>";
                    echo "<td class='mytable'>{$row['date']}</td>";
                    echo "</tr>";
                }
            }
            ?>
            </tbody>

        </table>

    </div>

</div>

</body>
<footer class="py-5 bg-success">
    <div class="container px-4 px-lg-5"><p class="m-0 text-center text-white">&copy; E-Pets <?php echo date('Y'); ?></p></div>
</footer>
</html>