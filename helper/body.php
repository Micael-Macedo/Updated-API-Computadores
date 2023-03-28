<?php

$body = json_decode(file_get_contents('php://input'));
if($body->pageSize == ''){
    $body->pageSize = 20;
}
if($body->page == ''){
    $body->page = 1;
}
$pageSize = $body->pageSize;
$page = $body->page;
$comeco = ($pageSize * $page) - $pageSize;