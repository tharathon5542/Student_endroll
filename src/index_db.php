<?php 

    // start session if there no session currently start now
    if(session_id() == '') {
        session_start();
    }

    // include database server
    include('server.php');

    // select user information from database
    $SQL_getUserInformation = "SELECT * FROM student WHERE code = '" . $_SESSION['username'] . "'";
    $QUERY_UserInformation = mysqli_query($conn,$SQL_getUserInformation);
    $RESULT_UserInformation = mysqli_fetch_assoc($QUERY_UserInformation);


    // select user subject offered information from database 
    $SQL_getUserSubjectOfferedInformation =
    "SELECT subject_registration.regis_id,subject_registration.subj_Code,subject.subj_Name,subject_registration.section,lecturer.lecturer_name,subject_offered.preriod FROM subject_registration 
    LEFT JOIN subject ON subject_registration.subj_Code = subject.subj_Code 
    LEFT JOIN subject_offered ON (subject.subj_Code = subject_offered.subj_Code AND subject_registration.section = subject_offered.section) 
    LEFT JOIN lecturer ON subject_offered.lecturer_id = lecturer.lecturer_id 
    WHERE subject_registration.code = '" . $_SESSION['username'] . "'";
    $QUERY_getUserSubjectOfferedInformation = mysqli_query($conn,$SQL_getUserSubjectOfferedInformation);

    // select subject information from database 
    $SQL_getSubjectInformation =
    "SELECT subject_offered.subj_Code,subject.subj_Name,subject_offered.section,lecturer.lecturer_name,subject_offered.preriod,COUNT(subject_registration.regis_id) AS counter FROM subject_offered 
    LEFT JOIN subject ON subject_offered.subj_Code = subject.subj_Code 
    LEFT JOIN lecturer ON subject_offered.lecturer_id = lecturer.lecturer_id 
    LEFT JOIN subject_registration ON subject_offered.subj_Code = subject_registration.subj_Code AND subject_offered.section = subject_registration.section 
    GROUP BY subject_offered.subj_Code,subject_offered.section";
    $QUERY_getSubjectInformation = mysqli_query($conn,$SQL_getSubjectInformation);
    
?>