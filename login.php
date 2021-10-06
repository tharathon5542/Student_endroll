<?php 
    // start session if there no session currently start now
    if(session_id() == '') {
        session_start();
    }

    // unset session from logout
    if(!empty($_GET['logout'])){
        unset($_SESSION['username']);
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>registration_000000000</title>
        <link href="./src/CSS/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

        <!-- toast message -->   
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    </head>

    <body class="" style="background: linear-gradient(#2b1055, #7597de);">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header" style="color: #fff; background-color: #28a745; border-color: #28a745;">
                                        <h4 class="text-center font-weight-light my-4">Sign In</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="./src/login_db.php">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputUsername">Username</label>
                                                <?php 
                                                    if(isset($_SESSION['rememberUserName'])){
                                                        echo '<input class="form-control py-4" id="inputUsername" type="text" name="inputUsername" placeholder="Enter username" value="' . $_SESSION['rememberUserName'] . '" required />';
                                                    }else{
                                                        echo '<input class="form-control py-4" id="inputUsername" type="text" name="inputUsername" placeholder="Enter username" required />';
                                                    }
                                                ?>          
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <?php 
                                                    if(isset($_SESSION['rememberPass'])){
                                                        echo '<input class="form-control py-4" id="inputPassword" name="inputPassword" type="password" placeholder="Enter password" value="' . $_SESSION['rememberPass'] . '" required /> ';
                                                    }else{
                                                        echo '<input class="form-control py-4" id="inputPassword" name="inputPassword" type="password" placeholder="Enter password" required /> ';
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <?php 
                                                        if(isset($_SESSION['rememberCheck'])){
                                                            echo '<input class="custom-control-input" id="rememberMeCheck" name="rememberMeCheck" type="checkbox" checked />';
                                                        }else{
                                                            echo '<input class="custom-control-input" id="rememberMeCheck" name="rememberMeCheck" type="checkbox" />';
                                                        }
                                                    ?> 
                                                    <label class="custom-control-label" for="rememberMeCheck">Remember username password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.php"></a>
                                                <button class="btn btn-success" name="login_user">Sign In</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- Toast message if there any error or success-->
        <?php
            if(isset($_SESSION['errors'])){
                echo "<script type='text/javascript'>toastr.error('" . $_SESSION['errors'] . "')</script>";
                unset($_SESSION['errors']); 
            }    
        ?>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="./src/assets/js/scripts.js"></script>

    </body>
</html>



