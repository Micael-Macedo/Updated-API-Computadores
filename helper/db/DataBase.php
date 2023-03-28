<?php 
include_once('C:/xampp/htdocs/AlatechMachines/helper/body.php');
$db = new mysqli('localhost','root','', 'AlatechMachines',3307);


function queryDb($sql){
    global $db;
    try {
        $result = $db->query($sql);
        $array = [];
        while ($objeto = $result->fetch_object()) {
            array_push($array, $objeto);
        }
        return $array;

    } catch (\Throwable $th) {
        http_response_code(404);
    }
}
function buscarObjeto($objeto)
{
    global $pageSize, $comeco;
    $sql = "select * from `$objeto` limit $pageSize offset $comeco";
    return json_encode(queryDb($sql));
    
}
function buscarObjetoNome($objeto, $nome)
{
    global $pageSize, $comeco;
    $sql = "select * from `$objeto` where nome = '$nome' limit $pageSize offset $comeco";
    return json_encode(queryDb($sql));
}
function buscarObjetoId($objeto, $id)
{
    $sql = "select * from `$objeto` where id = $id";
    return (object) queryDb($sql);
}
function deletarMaquinaId($objeto, $id)
{
    $objeto = buscarObjetoId($objeto, $id);
    if($objeto){
        $sql = "delete from `$objeto` where id = $id";
        http_response_code(204);
        return json_encode(queryDb($sql));
    }else{
        http_response_code(404);
        echo json_encode((object) ['message' => "Modelo de máquina não encontrado"]);
    }
}
function adicionarPC($processador, $mae, $ram, $qtdRam, $armazenamento, $qtdArmazenamentoHD, $qtdArmazenamentoSSD, $fonte, $placaVideo, $qtdVideo)
{
    global $db;
    $sql = "insert into machines(processadorId, placaMaeId, memoriaRamId,qtdRam, armazenamentoId, qtdhd, qtdSSD, fonte) values $processador, $mae, $ram, $qtdRam, $armazenamento ,$qtdArmazenamentoHD, $qtdArmazenamentoSSD, $fonte, $placaVideo, $qtdVideo";
    http_response_code(201);
    queryDb($sql);
    return json_encode((object) ['id' => $db->insert_id]);
}

function editarPC($id, $processador, $mae, $ram, $qtdRam, $armazenamento, $qtdArmazenamentoHD, $qtdArmazenamentoSSD, $fonte, $placaVideo, $qtdVideo){
    $sql = "update machines set processadorId = $processador, placaMaeId =  $mae, memoriaRamId = $ram, qtdRam =  $qtdRam, qtdhd = $qtdArmazenamentoHD, 
        qtdSSD = $qtdArmazenamentoSSD, armazenamentoId = $armazenamento, fonteId = $fonte, placaVideoId =  $placaVideo, qtdVideos =  $qtdVideo where id = $id";
    http_response_code(201);
    queryDb($sql);
    return json_encode(buscarObjetoId('machines', $id));
}
?>