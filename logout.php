<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');

if (isset($_COOKIE['Token'])) {
    $token = $_COOKIE['Token'];
} else {
    header('Location: /sign-in');
    exit();
}

$conn = connect();

$query = "SELECT * FROM Tokens WHERE token = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $token);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $r = $res->fetch_assoc();
    $is_hooked = $r['is_hooked'];

    if ($is_hooked == 0) {
        setcookie('Token', '', time() - 3600, '/');
        header('Location: /controlPage/create');
        exit();
    }

    if ($is_hooked == 1) {
        $hook_id = $r['hook_id'];

        $hook_query = "SELECT directory FROM Hooks WHERE id = ?";
        $hook_stmt = $conn->prepare($hook_query);
        $hook_stmt->bind_param("i", $hook_id);
        $hook_stmt->execute();
        $hook_res = $hook_stmt->get_result();

        if ($hook_res->num_rows > 0) {
            $hook_r = $hook_res->fetch_assoc();
            $dir = $hook_r['directory'];

            setcookie('Token', '', time() - 3600, '/');
            header("Location: /generator/$dir/create");
            exit();
        } else {
            header('Location: /controlPage/create');
            exit();
        }
    }
} else {
    header('Location: /controlPage/create');
    exit();
}

$conn->close();