<?php

// start session if there no session currently start now
if (session_id() == '') {
    session_start();
}

// check session timeout
$now = time();
if ($now > $_SESSION['expire']) {
    unset($_SESSION['username']);
    header('location: login.php');
}

// check if username session is set
if (!isset($_SESSION['username'])) {
    header('location: login.php');
}

// check if admin
if ($_SESSION['username'] === "admin") {
    header('location: manage.php');
}

include('./src/index_db.php');

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

    <link href="./src/CSS/index.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>

    <!-- toast message -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
    <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</head>

<body class="components-container">

    <header>
        <a href="#home" class="logo">ระบบลงทะเบียนเรียน</a>
        <ul>
            <li><a href="" class="active">ลงทะเบียนเรียน</a></li>
            <li><a href="./login.php?logout=1">Sign Out</a></li>
        </ul>
    </header>

    <section>

        <div class="left-section">
            <div class="section-head">
                <h2>ยินดีต้อนรับ <?php echo $RESULT_UserInformation['code'] . " " . $RESULT_UserInformation['nameandsurname'] ?> </h2>
                <p>รายวิชาที่ลงทะเบียนเรียน **เลือกรายวิชาที่ลงทะเบียนเรียนจากรายวิชาที่เปิดสอน</p>
            </div>
            <table class="subjectOffered">
                <tr>
                    <th>รหัสวิชา</th>
                    <th>ชื่อวิชา</th>
                    <th>Section</th>
                    <th>ผู้สอน</th>
                    <th>คาบเรียน</th>
                    <th>ลบ</th>
                </tr>
                <tbody id="regis-table">
                    <?php
                    while ($rows = mysqli_fetch_array($QUERY_getUserSubjectOfferedInformation)) {
                        echo "<tr>";
                        echo    "<td>" . $rows['subj_Code'] . "</td>";
                        echo    "<td style='text-align: left'>" . $rows['subj_Name'] . "</td>";
                        echo    "<td>" . $rows['section'] . "</td>";
                        echo    "<td>" . $rows['lecturer_name'] . "</td>";
                        echo    "<td>" . $rows['preriod'] . "</td>";
                        echo    "<td>" .  "<button type='button' class='del-btn' onClick='ajaxDelRegis(" . $rows['regis_id'] . ")'><ion-icon name='trash-outline'></ion-icon></button>" . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="right-section">
            <div class="section-head">
                <h2>รายวิชาที่เปิดสอน</h2>
            </div>
            <table class="subjectOffered">
                <tr>
                    <th>รหัสวิชา</th>
                    <th>ชื่อวิชา</th>
                    <th>Section</th>
                    <th>ผู้สอน</th>
                    <th>คาบเรียน</th>
                    <th>จำนวนผู้เรืยน</th>
                    <th>View</th>
                    <th>เลือก</th>
                </tr>
                <tbody id="subject-table">
                    <?php
                    while ($rows = mysqli_fetch_array($QUERY_getSubjectInformation)) {
                        echo "<tr>";
                        echo    "<td>" . $rows['subj_Code'] . "</td>";
                        echo    "<td style='text-align: left'>" . $rows['subj_Name'] . "</td>";
                        echo    "<td>" . $rows['section'] . "</td>";
                        echo    "<td>" . $rows['lecturer_name'] . "</td>";
                        echo    "<td>" . $rows['preriod'] . "</td>";
                        echo    "<td>" . $rows['counter'] . "</td>";
                        echo    '<td><button type="button" class="view-btn" onClick="ajaxView(\'' . $rows['subj_Code'] . "','" . $rows['section'] . '\')" ><ion-icon name="newspaper-outline" class="view"></ion-icon></button></td>';
                        echo    '<td><button type="button" class="regis-btn" onClick="ajaxAddRegis(\'' . $rows['subj_Code'] . "','" . $rows['section'] . "','" . $_SESSION['username']  . '\')"><ion-icon name="download-outline" class="register" ></ion-icon></button></td>';
                        echo "</tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>

    </section>

    <!-- Toast message if there any error or success-->
    <?php
    if (isset($_SESSION['errors'])) {
        echo "<script type='text/javascript'>toastr.error('" . $_SESSION['errors'] . "')</script>";
        unset($_SESSION['errors']);
    }
    ?>

    <script>
        // del user registered
        function ajaxDelRegis(regis_id) {
            $.ajax({
                url: "./src/ajax/ajax_regis.php",
                method: "POST",
                data: {
                    del_regis_id: regis_id
                },
                dataType: "text",
                success: function(data) {
                    $('#regis-table').html(data.split("XXZ")[0]);
                    $('#subject-table').html(data.split("XXZ")[1]);
                }
            })
        }

        // add user registered
        function ajaxAddRegis(subj_Code, section, std_code) {
            $.ajax({
                url: "./src/ajax/ajax_regis.php",
                method: "POST",
                data: {
                    add_regis: 1,
                    subj_code: subj_Code,
                    section: section,
                    std_code: std_code
                },
                dataType: "text",
                success: function(data) {
                    $('#regis-table').html(data.split("XXZ")[0]);
                    $('#subject-table').html(data.split("XXZ")[1]);
                }
            })
        }

        // view user registered
        function ajaxView(subj_Code, section) {
            $alert_message = "";
            $.ajax({
                url: "./src/ajax/ajax_regis.php",
                method: "POST",
                data: {
                    subj_code: subj_Code,
                    section: section,
                },
                dataType: "json",
                success: function(data) {
                    for (let i = 0; i < data.length; i++) {
                        $alert_message += data[i]['std_code'] + "  " + data[i]['std_name'] + "  "
                    }
                    if ($alert_message.length > 0) {
                        alert($alert_message);
                    }

                }
            })
        }
    </script>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="./src/assets/js/scripts.js"></script>

</body>

</html>