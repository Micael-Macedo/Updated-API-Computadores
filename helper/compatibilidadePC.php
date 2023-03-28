<?php

function validarPC($processador, $mae, $ram, $qtdRam, $qtdArmazenamentoHD, $qtdArmazenamentoSSD, $fonte, $placaVideo, $qtdVideo){
    $Messages = [];
    if($processador->soquete != $mae->soquete){
        array_push( $Messages, (object) ['message' => 'processador incompativel com placa mae']);
    }
    if($processador->TDP > $mae->TDP){
        array_push( $Messages, (object) ['message' => 'processador incompativel com placa mae']);
    }
    if($mae->TipoRam != $ram->TipoRam){
        array_push( $Messages, (object) ['message' => 'placa mae incompativel com memoria ram']);
    }
    if($mae->qtdRam < $qtdRam or $qtdRam == 0){
        array_push( $Messages, (object) ['message' => 'quantidade de memoria ram incompativel com memoria ram']);
    }
    if($mae->slotsPCI < $qtdVideo){
        array_push( $Messages, (object) ['message' => 'quantidade de placas de video incompativel com quantidade da placa mãe']);
    }
    if($mae->qtdSata < $qtdArmazenamentoHD){
        array_push( $Messages, (object) ['message' => 'quantidade de HDS incompativel com slots da placa mãe']);
    }
    if($mae->qtdM2 < $qtdArmazenamentoSSD){
        array_push( $Messages, (object) ['message' => 'quantidade de SSDS incompativel com slots da placa mãe']);
    }
    if($qtdArmazenamentoHD + $qtdArmazenamentoSSD == 0){
        array_push( $Messages, (object) ['message' => 'quantidade de armazenamento insulficientes para placa mãe']);
    }
    if($mae->SLI == 1 and $qtdVideo > 1){
        array_push( $Messages, (object) ['message' => 'placa mãe não suporta SLI/Crossfire']);
    }
    if($fonte->potencia < $placaVideo->pMIn){
        array_push( $Messages, (object) ['message' => 'fonte incompativel com placa de video']);
    }
    if(count($Messages) == 0){
        http_response_code(200);
        return json_encode((object) ['message' => 'Máquina válida']);
    }else{
        http_response_code(422);
        return json_encode($Messages);
    }
}