<?php 

    // start session if there no session currently start now
    if(session_id() == '') {
        session_start();
    }

    // include database server
    include('./server.php');

    // on login
    if(isset($_POST['login_user'])){

        // get value from html tag
        $userName = mysqli_real_escape_string($conn,$_POST['inputUsername']);
        $password = mysqli_real_escape_string($conn,$_POST['inputPassword']);

        // check email & password to login
        $sql_check_login = "SELECT * FROM student WHERE code = '$userName' AND password = '$password'";
        $query_check_login = mysqli_query($conn,$sql_check_login);
        $result_check_login = mysqli_fetch_assoc($query_check_login);

        // if check login is success
        if($result_check_login){
            $_SESSION['username'] = $result_check_login['code'];

            // check if remember me is check or not
            if(isset($_POST['rememberMeCheck'])){
                $_SESSION['rememberUserName'] = $userName;
                $_SESSION['rememberPass'] = $password;
                $_SESSION['rememberCheck'] = '1';
            }else{
                unset($_SESSION['rememberUserName']);
                unset($_SESSION['rememberPass']);
                unset($_SESSION['rememberCheck']);
            }

            $_SESSION['start'] = time();
            // Ending a session in 30 minutes from the starting time.
            $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
            header('location: ../index.php');

        }else{
        // if check login is fail
            $_SESSION['errors'] = "Wrong Username or Password";
            header('location: ../login.php');
        }

    }

    // on login
    if(isset($_POST['login_admin'])){

    

    }

?>