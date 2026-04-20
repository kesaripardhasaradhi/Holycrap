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
$dayNow = date('w');
$res = array_fill(0, 7, 0);

$q = "SELECT COUNT(id) as cnt, DATE_FORMAT(date, '%w') as d FROM Clicks WHERE `for` = ? AND date >= DATE_SUB(CURDATE(), INTERVAL ? DAY) GROUP BY d";
$stmt = $db->prepare($q);
$di = $dayNow;
$stmt->bind_param("si", $token, $di);
$stmt->execute();
$rSet = $stmt->get_result();

while ($row = $rSet->fetch_assoc()) {
    $dIdx = (int)$row['d'];
    $res[$dIdx] = (int)$row['cnt'];
}

$stmt->close();
$db->close();

$orderedRes = array_merge(array_slice($res, 1), [$res[0]]);

echo json_encode($orderedRes);