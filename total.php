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

$q = "SELECT COUNT(id) as cnt FROM Accounts WHERE `for` = ?";
$stmt = $db->prepare($q);
$stmt->bind_param("s", $token);
$stmt->execute();
$rSet = $stmt->get_result();
if ($row = $rSet->fetch_assoc()) {
    $res["Accounts"] = (int)$row['cnt'];
}
$stmt->close();

$q = "SELECT COUNT(id) as cnt FROM Clicks WHERE `for` = ?";
$stmt = $db->prepare($q);
$stmt->bind_param("s", $token);
$stmt->execute();
$rSet = $stmt->get_result();
if ($row = $rSet->fetch_assoc()) {
    $res["Clicks"] = (int)$row['cnt'];
}
$stmt->close();

$q = "SELECT COUNT(id) as cnt FROM Visits WHERE `for` = ?";
$stmt = $db->prepare($q);
$stmt->bind_param("s", $token);
$stmt->execute();
$rSet = $stmt->get_result();
if ($row = $rSet->fetch_assoc()) {
    $res["Visits"] = (int)$row['cnt'];
}
$stmt->close();

$res["Total"] = $res["Accounts"] + $res["Clicks"] + $res["Visits"];

$db->close();

echo json_encode($res);