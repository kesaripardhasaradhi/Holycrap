<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');
header('Content-Type: application/json');

$token = $_COOKIE['Token'] ?? null;
if (!$token) {
    echo json_encode(["success" => false, "error" => "Unauthorized"]);
    http_response_code(401);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $webhook = filter_var($data['webhook'], FILTER_SANITIZE_URL);
    if (!$webhook || !filter_var($webhook, FILTER_VALIDATE_URL) ||
        !preg_match('/^https:\/\/(carnary\.)?discord(?:app)?\.com\/api\/webhooks\/\d+\/[\w-]+$/', $webhook)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Invalid webhook.']));
    }

    $proxies = proxy();
    if (empty($proxies) || !is_array($proxies)) {
        http_response_code(500);
        die(json_encode(['success' => false, 'error' => 'No proxies available.']));
    }

    $proxy = $proxies[array_rand($proxies)];
    $ch = curl_init($webhook);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_PROXY => $proxy['ip'] . ':' . $proxy['port'],
        CURLOPT_PROXYUSERPWD => $proxy['user'] . ':' . $proxy['pass'],
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_TIMEOUT => 10
    ]);

    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code !== 200) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Webhook failed.']));
    }

    $avatar_url = '/controlPage/files/img/user.png';

    if (isset($data['avatar_url'])) {
        $icon = filter_var($data['avatar_url'], FILTER_SANITIZE_URL);
        if (!filter_var($icon, FILTER_VALIDATE_URL)) {
            http_response_code(400);
            die(json_encode(['success' => false, 'error' => 'Invalid icon link.']));
        }

        $proxy = $proxies[array_rand($proxies)];
        $ch = curl_init($icon);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_NOBODY => true,
            CURLOPT_PROXY => $proxy['ip'] . ':' . $proxy['port'],
            CURLOPT_PROXYUSERPWD => $proxy['user'] . ':' . $proxy['pass'],
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $content = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        curl_close($ch);

        if ($code !== 200 || !preg_match('/^image\//', $content)) {
            http_response_code(400);
            die(json_encode(['success' => false, 'error' => 'Icon is not a proper image.']));
        }

        $avatar_url = $icon;
    }

    $name = isset($data['name']) ? filter_var($data['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    if ($name && !preg_match('/^[A-Za-z0-9]+( [A-Za-z0-9]+)*$/', $name)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Invalid name.']));
    }

    $username = isset($data['username']) ? filter_var($data['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    if ($username && !preg_match('/^[A-Za-z0-9]+( [A-Za-z0-9]+)*$/', $username)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Invalid username.']));
    }

    if (empty($name) && empty($username)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Name and username cannot both be empty.']));
    }

    $directory = filter_var($data['directory'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!$directory || !preg_match('/^[A-Za-z0-9]{3,20}$/', $directory)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Directory invalid.']));
    }

    $conn = connect();

    $stmt = $conn->prepare("SELECT id, name, username, user_icon, directory, webhook FROM Tokens WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($userId, $currentName, $currentUsername, $currentUserIcon, $currentDirectory, $currentWebhook);
    $stmt->fetch();
    $stmt->close();

    if (!$userId) {
        http_response_code(401);
        die(json_encode(['success' => false, 'error' => 'Unauthorized or invalid token.']));
    }

    $conditions = [];
    $params = [];
    $types = '';

    if ($webhook !== $currentWebhook) {
        $stmt = $conn->prepare("SELECT webhook FROM Tokens WHERE webhook = ?");
        $stmt->bind_param("s", $webhook);
        $stmt->execute();
        $stmt->bind_result($existingWebhook);
        $stmt->fetch();
        $stmt->close();

        if ($existingWebhook) {
            http_response_code(400);
            die(json_encode(['success' => false, 'error' => 'Webhook already in use.']));
        }

        $conditions[] = "webhook = ?";
        $params[] = $webhook;
        $types .= 's';
    }

    if ($directory !== $currentDirectory) {
        $stmt = $conn->prepare("SELECT directory FROM Tokens WHERE directory = ?");
        $stmt->bind_param("s", $directory);
        $stmt->execute();
        $stmt->bind_result($existingDirectory);
        $stmt->fetch();
        $stmt->close();

        if ($existingDirectory) {
            http_response_code(400);
            die(json_encode(['success' => false, 'error' => 'Directory already taken.']));
        }

        $conditions[] = "directory = ?";
        $params[] = $directory;
        $types .= 's';
    }

    $stmt = $conn->prepare("UPDATE Tokens SET name = ?, username = ?, user_icon = ? " . (empty($conditions) ? "" : ", " . implode(", ", $conditions)) . " WHERE token = ?");
    $stmt->bind_param("ssss" . $types, $name, $username, $avatar_url, $token, ...$params);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['success' => true]);
}