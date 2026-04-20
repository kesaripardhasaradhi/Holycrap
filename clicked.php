<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');
header('Content-Type: application/json');

$d = json_decode(file_get_contents('php://input'), true);
if (!$d['h']) {
    echo json_encode(["success" => false, "error" => "Invalid Entrance"]);
    http_response_code(401);
    exit;
}

clicks($d['h']);