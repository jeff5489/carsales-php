<?php

    function restrictAllButAdmins(){
        if($_SESSION['user_level'] == "admin"){
            echo "Logged in as: admin";
        } else {
            die("Only Admins authorized to use this page.");
        }
    }

    function restrictAllButEmployees(){
        if($_SESSION['user_level'] == "admin"){
            echo "Logged in as: admin";
        } elseif($_SESSION['user_level'] == "sales associate"){
            echo "Logged in as: sales associate";
        }else {
            die("Only Employees authorized to use this page.");
        }
    }
?>