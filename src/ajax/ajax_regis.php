<?php

// start session if there no session currently start now
if (session_id() == '') {
    session_start();
}

// include database server
include('../server.php');

// on del registered from table
if (isset($_POST['del_regis_id'])) {

    $SQL_delUserRegistered = "DELETE FROM subject_registration WHERE regis_id = " . $_POST['del_regis_id'];
    mysqli_query($conn, $SQL_delUserRegistered);

    // select user subject offered information from database 
    $SQL_getUserSubjectOfferedInformation =
        "SELECT subject_registration.regis_id,subject_registration.subj_Code,subject.subj_Name,subject_registration.section,lecturer.lecturer_name,subject_offered.preriod FROM subject_registration 
        LEFT JOIN subject ON subject_registration.subj_Code = subject.subj_Code 
        LEFT JOIN subject_offered ON (subject.subj_Code = subject_offered.subj_Code AND subject_registration.section = subject_offered.section) 
        LEFT JOIN lecturer ON subject_offered.lecturer_id = lecturer.lecturer_id 
        WHERE subject_registration.code = '" . $_SESSION['username'] . "'";
    $QUERY_getUserSubjectOfferedInformation = mysqli_query($conn, $SQL_getUserSubjectOfferedInformation);

    $out_put1 = "";
    while ($rows = mysqli_fetch_array($QUERY_getUserSubjectOfferedInformation)) {
        $out_put1 .=
            "<tr>
                <td>" . $rows['subj_Code'] . "</td>
               <td style='text-align: left'>" . $rows['subj_Name'] . "</td>
                <td>" . $rows['section'] . "</td>
                <td>" . $rows['lecturer_name'] . "</td>
                <td>" . $rows['preriod'] . "</td>
               <td>" .  "<button type='button' class='del-btn' onClick='ajaxDelRegis(" . $rows['regis_id'] . ")'><ion-icon name='trash-outline'></ion-icon></button>" . "</td>
            </tr>";
    }

    // select subject information from database 
    $SQL_getSubjectInformation =
        "SELECT subject_offered.subj_Code,subject.subj_Name,subject_offered.section,lecturer.lecturer_name,subject_offered.preriod,COUNT(subject_registration.regis_id) AS counter FROM subject_offered 
         LEFT JOIN subject ON subject_offered.subj_Code = subject.subj_Code 
         LEFT JOIN lecturer ON subject_offered.lecturer_id = lecturer.lecturer_id 
         LEFT JOIN subject_registration ON subject_offered.subj_Code = subject_registration.subj_Code AND subject_offered.section = subject_registration.section 
         GROUP BY subject_offered.subj_Code,subject_offered.section";
    $QUERY_getSubjectInformation = mysqli_query($conn, $SQL_getSubjectInformation);

    $out_put2 = "";
    while ($rows = mysqli_fetch_array($QUERY_getSubjectInformation)) {
        $out_put2 .= '<tr>
                 <td>' . $rows['subj_Code'] . '</td>
                 <td style="text-align: left">' . $rows['subj_Name'] . '</td>
                 <td>' . $rows['section'] . '</td>
                 <td>' . $rows['lecturer_name'] . '</td>
                 <td>' . $rows['preriod'] . '</td>
                 <td>' . $rows['counter'] . '</td>
                 <td><button type="button" class="view-btn" onClick="ajaxView(\'' . $rows['subj_Code'] . "','" . $rows['section'] . '\')"><ion-icon name="newspaper-outline" class="view"></ion-icon></button></td>
                 <td><button type="button" class="regis-btn"><ion-icon name="download-outline" class="register" onClick="ajaxAddRegis(\'' . $rows['subj_Code'] . "','" . $rows['section'] . "','" . $_SESSION['username']  . '\')"></ion-icon></button></td>
                 </tr>';
    }


    $return = '';
    $return .= $out_put1 . "XXZ";
    $return .= $out_put2 . "XXZ";

    echo $return;
}

// on register
if (isset($_POST['add_regis'])) {

    $subj_code = $_POST['subj_code'];
    $section = $_POST['section'];
    $std_code = $_POST['std_code'];

    $SQL_insertUserRegistration = "INSERT INTO subject_registration (subj_Code,section,code) 
        SELECT '$subj_code','$section','$std_code' FROM dual 
        WHERE NOT EXISTS (SELECT * FROM subject_registration WHERE subj_Code = '$subj_code' AND section = '$section' AND code = '$std_code')";
    mysqli_query($conn, $SQL_insertUserRegistration);


    // select user subject offered information from database 
    $SQL_getUserSubjectOfferedInformation =
        "SELECT subject_registration.regis_id,subject_registration.subj_Code,subject.subj_Name,subject_registration.section,lecturer.lecturer_name,subject_offered.preriod FROM subject_registration 
        LEFT JOIN subject ON subject_registration.subj_Code = subject.subj_Code 
        LEFT JOIN subject_offered ON (subject.subj_Code = subject_offered.subj_Code AND subject_registration.section = subject_offered.section) 
        LEFT JOIN lecturer ON subject_offered.lecturer_id = lecturer.lecturer_id 
        WHERE subject_registration.code = '" . $_SESSION['username'] . "'";
    $QUERY_getUserSubjectOfferedInformation = mysqli_query($conn, $SQL_getUserSubjectOfferedInformation);

    $out_put1 = "";
    while ($rows = mysqli_fetch_array($QUERY_getUserSubjectOfferedInformation)) {
        $out_put1 .=
            "<tr>
                <td>" . $rows['subj_Code'] . "</td>
               <td style='text-align: left'>" . $rows['subj_Name'] . "</td>
                <td>" . $rows['section'] . "</td>
                <td>" . $rows['lecturer_name'] . "</td>
                <td>" . $rows['preriod'] . "</td>
               <td>" .  "<button type='button' class='del-btn' onClick='ajaxDelRegis(" . $rows['regis_id'] . ")'><ion-icon name='trash-outline'></ion-icon></button>" . "</td>
            </tr>";
    }

    // select subject information from database 
    $SQL_getSubjectInformation =
        "SELECT subject_offered.subj_Code,subject.subj_Name,subject_offered.section,lecturer.lecturer_name,subject_offered.preriod,COUNT(subject_registration.regis_id) AS counter FROM subject_offered 
        LEFT JOIN subject ON subject_offered.subj_Code = subject.subj_Code 
        LEFT JOIN lecturer ON subject_offered.lecturer_id = lecturer.lecturer_id 
        LEFT JOIN subject_registration ON subject_offered.subj_Code = subject_registration.subj_Code AND subject_offered.section = subject_registration.section 
        GROUP BY subject_offered.subj_Code,subject_offered.section";
    $QUERY_getSubjectInformation = mysqli_query($conn, $SQL_getSubjectInformation);

    $out_put2 = "";
    while ($rows = mysqli_fetch_array($QUERY_getSubjectInformation)) {
        $out_put2 .= '<tr>
                <td>' . $rows['subj_Code'] . '</td>
                <td style="text-align: left">' . $rows['subj_Name'] . '</td>
                <td>' . $rows['section'] . '</td>
                <td>' . $rows['lecturer_name'] . '</td>
                <td>' . $rows['preriod'] . '</td>
                <td>' . $rows['counter'] . '</td>
                <td><button type="button" class="view-btn" onClick="ajaxView(\'' . $rows['subj_Code'] . "','" . $rows['section'] . '\')"><ion-icon name="newspaper-outline" class="view"></ion-icon></button></td>
                <td><button type="button" onClick="ajaxAddRegis(\'' . $rows['subj_Code'] . "','" . $rows['section'] . "','" . $_SESSION['username']  . '\')" class="regis-btn"><ion-icon name="download-outline" class="register" ></ion-icon></button></td>
                </tr>';
    }

    $return = '';
    $return .= $out_put1 . "XXZ";
    $return .= $out_put2 . "XXZ";

    echo $return;
}


// on View
if (isset($_POST['subj_code'])) {
    $subj_code = $_POST['subj_code'];
    $section = $_POST['section'];

    $SQL_getUserRegisteredInformation = "SELECT subject_registration.code,student.nameandsurname FROM subject_registration 
        LEFT JOIN student ON subject_registration.code = student.code WHERE subj_Code = '$subj_code' AND section = '$section'";
    $QUERY_getUserRegisteredInformation = mysqli_query($conn, $SQL_getUserRegisteredInformation);

    $result = array();
    $std_code_array = array();
    $std_name_array = array();
    while ($rows = mysqli_fetch_array($QUERY_getUserRegisteredInformation)) {
        array_push($result, (object)[
            'std_code' => $rows['code'],
            'std_name' => $rows['nameandsurname']
    ]);
    }

    echo json_encode($result);
}
