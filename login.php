<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$conn = connect();
    $data = json_decode(file_get_contents('php://input'), true);

    $token = $data['token'];

    $stmt = $conn->prepare("SELECT token FROM Tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        setcookie('Token', $token, time() + (30 * 24 * 60 * 60), '/'); // 30 tage

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid token']);
    }
}