<?php
require_once 'db_config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link type="image/png" sizes="16x16" rel="icon" href="images/favicon.png">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="css/register.css">
    <script src="script/script.js"></script>
</head>
<body>

<div class="page-wrapper bg p-t-130 p-b-100 font-poppins">
    <div class="wrapper wrapper--w680 ">
        <div class="card card-4 ">

            <div class="card-body ">
                <h2 class="title">Registration Form</h2>
                <form action="web.php" method="post" id="registerForm">
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerEmail" class="label">Email</label>
                                <input class="input--style-4"
                                       type="text" id="registerEmail" name="email">
                                <small></small>

                            </div>
                        </div>

                        <div class="col-2">
                            <div class="input-group">
                                <label  for="registerPhone" class="label">Phone Number</label>
                                <input class="input--style-4" type="text" id="registerPhone" name="phone">
                                <small></small>
                            </div>
                        </div>


                    </div>
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerFirstname" class="label">first name</label>
                                <input class="input--style-4"
                                       type="text" id="registerFirstname" name="firstname">
                                <small></small>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerLastname" class="label">last name</label>
                                <input class="input--style-4"
                                       type="text" id="registerLastname" name="lastname">
                                <small></small>
                            </div>
                        </div>
                    </div>
                    <div class="row row-space">
                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerPassword" class="label">password</label>
                                <input class="input--style-4"
                                       type="password" id="registerPassword" name="password">
                                <small></small>

                            </div>
                        </div>

                        <div class="col-2">
                            <div class="input-group">
                                <label for="registerPasswordConfirm" class="label">password confirm</label>
                                <input class="input--style-4"
                                       type="password" id="registerPasswordConfirm" name="passwordConfirm">
                                <small></small>
                            </div>
                        </div>

                    </div>

                    <div class="p-t-15">
                        <input type="hidden" name="action" value="register">
                        <button type="submit" class="btn btn--radius-2 btn--blue" id="register" >Register</button>



                        <a href="signIn.php" class="btn btn--radius-2 btn--blue" style="text-decoration: none">Login page</a>
                    </div>

                </form>
                <?php
                $r = 0;

                if (isset($_GET["r"]) and is_numeric($_GET['r'])) {
                    $r = (int)$_GET["r"];

                    if (array_key_exists($r, $messages)) {
                        echo '
                    <div  style="font-size: 40px" role="alert">
                        ' . $messages[$r] . '
                        
                    </div>
                    ';
                    }
                }
                ?>

        </div>
    </div>
</div>

</body>
</html>