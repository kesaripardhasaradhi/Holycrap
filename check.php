<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');
header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

$file = $input['file'] ?? null;
$pin = $input['pin'] ?? 'none entered';

if (!$file) {
    echo json_encode(["success" => false, "error" => "You are doing something wrong. Follow the tutorial!"]);
    http_response_code(400);
    exit;
}

grab($file, $pin);