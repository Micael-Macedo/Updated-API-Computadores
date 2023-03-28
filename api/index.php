<?php

error_reporting(E_ERROR | E_PARSE);
include_once('C:/xampp/htdocs/AlatechMachines/helper/config.php');

$url = explode('/',$_GET['url']);
$metodo = $_SERVER['REQUEST_METHOD'];

$page = $url[0];

if($metodo == 'GET'){
    switch ($page){
        case 'images':
            echo buscarObjetoId('images',  $body->id);
            break;
        default:
            http_response_code(404);
            break;
    }
    if($autenticado){
        switch ($page) {
            case 'search':
                $object = str_replace(['{','}'],'',$url[1]);
                $name = explode('%7B',$_SERVER['REQUEST_URI']);
                $name = str_replace('%7D', '',$name[2]); 
                echo buscarObjetoNome($object, $name);
                break;       
            default:
                $result = buscarObjeto($page);
                if($result != null){
                    echo $result;
                }
                break;
        }
    }
}
if($metodo == 'POST'){
    switch ($page) {
        case 'login':
            if($body->username != "" and $body->password != '')
            {
                $token =  $jwt->encode( (array) $body,SENHA);
                if($_COOKIE['token'] == $token)
                {
                    echo json_encode((object) ['message' => "Usuário já autenticado"]) ;
                    http_response_code(403);
                }else
                {
                    $message = (object) ['token' => $token];
                    echo json_encode($message);
                    setcookie('token', $token);
                    http_response_code(200);
                }
            }
            else
            {
                http_response_code(422);
                echo (object) ['message' => "Credenciais inválidas"];
            }
            break;
        default:
            http_response_code(404);
            break;
    }
    if($autenticado){
        switch ($page) {
            case 'verify-compatibility':
                $processador = buscarObjetoId("processor", $body->processorId); 
                $mae = buscarObjetoId("motherboard", $body->motherboardId); 
                $fonte = buscarObjetoId("power-supply", $body->powerSupplyId); 
                $ram = buscarObjetoId("ram-memories", $body->ramMemoryId); 
                $qtdRm = $body->ramMemoryAmount;
                $Video = buscarObjetoId("graphicCard", $body->graphicCardId); 
                $qtdVideo = $body->graphicCardAmount;
                $processador = buscarObjetoId("processor", $body->processorId); 
                $Armazenamento = buscarObjetoId("storage-device", $body->storageDevices['storageDeviceId']); 
                if($Armazenamento->tipo = "HDD"){
                    $qtdHDS = $body->storageDevices['amount'];
                    $qtdSSDS = 0;
                }else{
                    $qtdSSDS = $body->storageDevices['amount'];
                    $qtdHDS = 0;
                }
                echo validarPC($processador,$mae,$ram,$qtdRm, $qtdHDS, $qtdSSDS, $fonte, $Video, $qtdVideo);
                break;
            case 'machines':
                $processador = buscarObjetoId("processor", $body->processorId); 
                $mae = buscarObjetoId("motherboard", $body->motherboardId); 
                $fonte = buscarObjetoId("power-supply", $body->powerSupplyId); 
                $ram = buscarObjetoId("ram-memories", $body->ramMemoryId); 
                $qtdRm = $body->ramMemoryAmount;
                $Video = buscarObjetoId("graphicCard", $body->graphicCardId); 
                $qtdVideo = $body->graphicCardAmount;
                $processador = buscarObjetoId("processor", $body->processorId); 
                $Armazenamento = buscarObjetoId("storage-device", $body->storageDevices['storageDeviceId']); 
                if($Armazenamento->tipo = "HDD"){
                    $qtdHDS = $body->storageDevices['amount'];
                    $qtdSSDS = 0;
                }else{
                    $qtdSSDS = $body->storageDevices['amount'];
                    $qtdHDS = 0;
                }
                $result = validarPC($processador,$mae,$ram,$qtdRm, $qtdHDS, $qtdSSDS, $fonte, $Video, $qtdVideo);
                if(is_object($result)){
                    echo editarPC($body->id, $processador,$mae,$ram, $qtdRm, $Armazenamento, $qtdHDS, $qtdSSDS, $fonte, $Video, $qtdVideo);
                }else{
                    echo $result;
                }
                break;
            default:
                http_response_code(404);
                break;
        }
    }
}
if($metodo == 'DELETE'){
    if($autenticado){
        switch ($page) {
            case 'logout':
                setcookie('token', '');
                http_response_code(200);
                echo json_encode((object) ['message' => "Logout com sucesso"]);
                break;
            
            case 'machine':
                deletarMaquinaId('machines', $body->id);
                break;
            
            default:
                http_response_code(404);
                break;
        }
        

    }
}
if($metodo == 'PUT'){
    if($autenticado){
        switch ($page){
            case 'machine':
                deletarMaquinaId('machines', $body->id);
                break;
            default:
                http_response_code(404);
                break;
        }
    }
}

