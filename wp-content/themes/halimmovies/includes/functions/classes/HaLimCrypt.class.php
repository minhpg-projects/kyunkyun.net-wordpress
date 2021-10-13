<?php


class HaLimCrypt {
	// Set your unique has keys
	private static $secretKey = 'HaLim';
	private static $secretIv = 'halimthemes.com';
	// Encryption method
	private static $encryptMethod = "AES-256-CBC";
	// pass string/number which you want to encrypt
	public static function encrypt($data)
	{
	  	$key = hash('sha256', self::$secretKey);
	  	$iv = substr(hash('sha256', self::$secretIv), 0, 16);
	  	$result = openssl_encrypt($data, self::$encryptMethod, $key, 0, $iv);
	  	return $result= base64_encode($result);
	}

	// pass encrypted data to decrypt
	public static function decrypt($data)
	{
	  	$key = hash('sha256', self::$secretKey);
	  	$iv = substr(hash('sha256', self::$secretIv), 0, 16);
	  	$result = openssl_decrypt(base64_decode($data), self::$encryptMethod, $key, 0, $iv);
	  	return $result;
	}
}
