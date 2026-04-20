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
$res = ["Accounts" => 0, "Clicks" => 0, "Visits" => 0, "Total" => 0];
$date = date('Y-m-d');

$tables = ["Accounts", "Clicks", "Visits"];
foreach ($tables as $table) {
    $q = "SELECT COUNT(id) as cnt FROM $table WHERE `for` = ? AND DATE(`date`) = ?";
    $stmt = $db->prepare($q);
    $stmt->bind_param("ss", $token, $date);
    $stmt->execute();
    $rSet = $stmt->get_result();
    if ($row = $rSet->fetch_assoc()) {
        $res[$table] = (int)$row['cnt'];
    }
    $stmt->close();
}

$res["Total"] = $res["Accounts"] + $res["Clicks"] + $res["Visits"];

$db->close();

echo json_encode($res);
