<?php
    date_default_timezone_set('America/Bogota');
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: POST");
    header("Allow: POST");
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "OPTIONS" || $method == "GET" || $method == "PUT" || $method == "DELETE") {
        die();
    }
    $json = file_get_contents('php://input');
    $data=json_decode($json);
    header('Content-Type: application/json');

    try{
        $ServerName="178.128.146.252";
        $UserName="admin_sigmauser"; 
        $Password = "pfaDKIJyPF";
        $DataBaseName = "admin_sigmatest";
        $Connection = new PDO("mysql:host=$ServerName;dbname=$DataBaseName", $UserName, $Password);
        $Connection->exec("set names utf8");


    }catch(PDOException $error){
        http_response_code(400);
        $error->getMessage();
        $response=[
            "message"=>"Error DataBase: ".$error,
        ];
    }catch(Exception $error){
        http_response_code(400);
        $error->getMessage();
        $response=[
            "message"=>"Error General: ".$error,
        ];
    }

?>