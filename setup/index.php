<?php

$host = "localhost";
$database = "hotel_lagos";
$user = "hotel_lagos";
$password = "hotel_lagos";

//create users & databases
//try {
//    $conn = new PDO("mysql:host=$host", "root", "");
//    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $sql = "CREATE DATABASE IF NOT EXISTS $database";
//
//    $stmt = $conn->prepare($sql);
//
//    if ($stmt->execute())
//    {echo "Database created successfully...<br>";}
//    else
//    {echo "Database failed<br>";exit;}
//} catch (PDOException $e) {
//    echo "Database failed" . "<br>" . $e->getMessage();
//    exit;
//}
//
//
//try {
//    $user_name = $user . '@' . $host;
//    $conn = new PDO("mysql:host=$host", "root", "");
//    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    $sql="CREATE USER '".$user."'@'localhost' IDENTIFIED WITH mysql_native_password AS '".$password."';"
//            . "GRANT ALL PRIVILEGES ON *.* TO '".$user_name."' REQUIRE NONE WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;"
//            ."GRANT ALL PRIVILEGES ON '".$database."* TO '".$user_name."'"
//            ."GRANT SELECT, INSERT, UPDATE, DELETE ON '".$database." * TO '".$user_name."';"
//            ."FLUSH PRIVILEGES";
//
//    $stmt = $conn->prepare($sql);
//
//    if ($stmt->execute())
//    {echo "User created successfully...<br>";}
//    else{echo "User failed<br>";exit;}
//        
//} catch (PDOException $e) {
//    echo "User failed" . "<br>" . $e->getMessage();
//    exit;
//}


try {
    $conn = new PDO("mysql:host=$host;dbname=$database", "root", "");
    $query = file_get_contents("hotel_starter.sql");

    $stmt = $conn->prepare($query);

    if ($stmt->execute()) {
        echo "Starter Tables Created Successfully...<br>";
        //update installation
//        $now = date('Y-m-d');
//        $q = "Update maintenance set last_rooms_charge=$now,last_close_account=$now,charged_rooms_count=0"
//                . "install_date=$now,expire_date=$now"
//                . "where ID='1'";
//        $stmt = $conn->prepare($q);
//
//        if ($stmt->execute()) {
//            echo "Pride Hotel App Installed...<br>";
//        }else{
//            echo "Pride Hotel App Installation failed...<br>";
//        }
    } else {
        echo "Starter Tables Failed<br>";
        exit;
    }
} catch (PDOException $e) {
    echo "Starter Tables failed" . "<br>" . $e->getMessage();
    exit;
}

echo "Setup Completed<br>";
sleep(5);


