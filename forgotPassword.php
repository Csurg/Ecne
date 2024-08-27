<?php
require_once 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>Forgot Password</title>

    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="script/script.js"></script>
</head>
<body>

<section  class="vh-100 login-bg">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-success text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold mb-2 ">Forgot your password?</h2>

                            <div>
                                <p class="mb-0">You can reset your password here.</a>
                                </p>
                            </div>
                            <div class="text-white-50 mb-5"></div>
                            <form action="web.php" method="post" name="forget" id="forgetForm">
                                <div class="form-outline form-white mb-4">
                                    <input type="text" id="forgetEmail" class="form-control form-control-lg"
                                           name="email" />
                                    <label class="form-label" for="forgetEmail">Email Address</label>
                                    <small></small>
                                </div>
                                <input type="hidden" name="action" value="forget">
                                <button class="btn btn-outline-light btn-lg px-5" type="submit">Reset password</button>
                            </form>

                                    <?php

                                    $f = 0;

                                    if (isset($_GET["f"]) and is_numeric($_GET['f'])) {
                                        $f = (int)$_GET["f"];

                                        if (array_key_exists($f, $messages)) {
                                            echo '
                            <div style="font-size: 30px" role="alert">
                                ' . $messages[$f] . '
                            </div>
                            ';
                                        }
                                    }
                                    ?>

                    </div>

                    <div>
                        <p class="mb-0">Back to <a href="signIn.php" class="text-white-50 underline-on-hover">Login page</a>.
                        </p>
                        <div>
                            <p class="mb-0">Don't have an account yet? <a href="register.php" class="text-white-50 underline-on-hover">Register!</a>
                            </p>
                        </div>
                        <div>
                            <p class="mb-0">Continue as <a href="index.php" class="text-white-50 underline-on-hover">Guest.</a>
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

</body>
</html>