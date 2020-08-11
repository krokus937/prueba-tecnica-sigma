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
    //Lectura de la peticion
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

        if(isset($data->Departament) && isset($data->City) && isset($data->Name) && isset($data->Email)){
            $Departament=$data->Departament;
            $City=$data->City;
            $Name=$data->Name;
            $Email=$data->Email;

            $InsertData=$Connection->prepare("INSERT INTO contacts (name,email,state,city) VALUES (?,?,?,?)");
            $InsertData->bindParam(1, $Name);
            $InsertData->bindParam(2, $Email);
            $InsertData->bindParam(3, $Departament);
            $InsertData->bindParam(4, $City);
            $InsertData->execute();
            http_response_code(201);
            $response=array(
                "message"=>"Tu información ha sido recibida satisfactoriamente"
            );
        }else{
            http_response_code(400);
            $response=[
                "message"=>"Error: los parametros enviados estan errados ",
            ];
        }
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
    echo json_encode($response, JSON_FORCE_OBJECT);

?>