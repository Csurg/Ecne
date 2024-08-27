<?php
require_once 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="../images/favicon.png">
    <title>Login</title>
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <script src="script/script.js"></script>
</head>
<body id="login-body">

<section  class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-black text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold mb-2 text-uppercase">ADMIN</h2>
                            <div class="text-white-50 mb-5"></div>
                            <form action="web.php" method="post" id="loginForm">
                                <div class="form-outline form-white mb-4">
                                    <input type="text" id="adminUsername" class="form-control form-control-lg" name="username">
                                    <label class="form-label" for="adminUsername">Username</label>
                                    <small></small>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="password" id="adminPassword" class="form-control form-control-lg" name="password">
                                    <label class="form-label" for="adminPassword">Password</label>
                                    <small></small>
                                </div>

                                <input type="hidden" name="action" value="login">
                                <button type="submit" class="btn btn-outline-light btn-lg px-5">Log in</button>
                            </form>
                            <?php

                            $l = 0;

                            if (isset($_GET["l"]) and is_numeric($_GET['l'])) {
                                $l = (int)$_GET["l"];

                                if (array_key_exists($l, $messages)) {
                                    echo '
                    <div style="font-size: 40px" role="alert">
                        ' . $messages[$l] . '
                        
                    </div>
                    ';
                                }
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>