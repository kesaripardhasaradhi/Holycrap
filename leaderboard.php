<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');
header('Content-Type: application/json');

$token = $_COOKIE['Token'] ?? null;
if (!$token) {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    http_response_code(401);
    exit;
}

leaderboard();