<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/backend/include.php');

class Cryption 
{
    private static $m = 'aes-256-cbc';
    private static $k = 'cbc-652-sea';
    private static $l = 16;

    public static function e($p) 
	{
        $iv = openssl_random_pseudo_bytes(self::$l);
        $enc = openssl_encrypt($p, self::$m, self::$k, 0, $iv);
        return base64_encode($enc . '::' . $iv);
    }

    public static function d($p) 
	{
        list($enc, $iv) = explode('::', base64_decode($p), 2);
        return openssl_decrypt($enc, self::$m, self::$k, 0, $iv);
    }

    public static function sK($k) 
	{
        self::$k = $k;
    }

    public static function sM($m) 
	{
        self::$m = $m;
    }
}

