<?php
require_once 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>Reset password</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <script src="script/script.js"></script>
</head>
<body id="login-body">

<section  class="vh-100 login-bg">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-success text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <div class="mb-md-5 mt-md-4 pb-5">

                            <h2 class="fw-bold mb-2 ">Reset your password</h2>
                            <div class="text-white-50 mb-5"></div>
                            <form action="forget.php" method="post" id="resetForm">
                                <div class="form-outline form-white mb-4">
                                    <label for="resetEmail" class="form-label">Email Address</label>
                                    <input type="text" id="resetEmail" class="form-control form-control-lg"
                                           name="resetEmail">
                                    <small></small>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <label for="resetPassword" class="form-label">Password</label>
                                    <input type="password" id="resetPassword" class="form-control form-control-lg"
                                           name="resetPassword" placeholder="Password (min 8 characters)">
                                    <small></small>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <label for="resetPasswordConfirm" class="form-label">Password Confirm</label>
                                    <input type="password" id="resetPasswordConfirm" class="form-control form-control-lg"
                                           name="resetPasswordConfirm">
                                    <small></small>
                                </div>

                                <div class="form-outline form-white mb-4">
                                    <input type="hidden" name="action" value="resetPassword">
                                    <input type="hidden" name="token" value="<?php echo $token ?>">
                                   <!-- <button type="submit" class="btn btn-primary">Send</button>
                                    <button type="reset" class="btn btn-primary resetButton" >Cancel</button>-->
                                    <button type="submit" class="btn btn-outline-light btn-lg px-5">Send</button>
                                    <button type="reset" class="btn btn-outline-light btn-lg px-5 " >Cancel</button>
                                </div>

                            </form>

                            <?php
                            $rf = 0;

                            if (isset($_GET["rf"]) and is_numeric($_GET['rf'])) {
                                $rf = (int)$_GET["rf"];

                                if (array_key_exists($rf, $messages)) {
                                    echo '
                                    <div style="font-size: 40px" role="alert">
                                        ' . $messages[$rf] . '
                                        
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