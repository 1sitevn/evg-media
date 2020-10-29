<?php

require __DIR__ . '/../vendor/autoload.php';

define('KEY_PATH', '/Applications/Wowza Streaming Engine 4.8.5.05/WowzaStreamingEngine/keys');

// Check if function exists (php5.4+ includes this method)
if (!function_exists("hex2bin")) {
    function hex2bin($h)
    {
        if (!is_string($h))
            return null;
        $r = '';
        for ($a = 0; $a < strlen($h); $a += 2) {
            $r .= chr(hexdec($h{$a} . $h{($a + 1)}));
        }
        return $r;
    }
}

if (!function_exists("log_streaming_info")) {
    function log_streaming_info($path, $message)
    {
        $myfile = fopen($path, "a");
        fwrite($myfile, "\n" . $message);
        fclose($myfile);
    }
}

if (!function_exists('aes_encrypt')) {

    /**
     * @param $secretKey
     * @param $plainText
     * @return string
     */
    function aes_encrypt($secretKey, $plainText)
    {
        $cipher = new \phpseclib\Crypt\AES();
        $cipher->setKeyLength(256);
        $cipher->setKey($secretKey);

        return base64_encode($cipher->encrypt($plainText));
    }
}


if (!function_exists('aes_decrypt')) {

    /**
     * @param $secretKey
     * @param $cipherText
     * @return string
     */
    function aes_decrypt($secretKey, $cipherText)
    {
        $cipher = new \phpseclib\Crypt\AES();
        $cipher->setKeyLength(256);
        $cipher->setKey($secretKey);

        return $cipher->decrypt(base64_decode($cipherText));
    }
}

log_streaming_info(__DIR__ . "/logs.txt", json_encode($_GET));

$isValid = true;
if (!$isValid) {
    header('HTTP/1.0 403 Forbidden');
} else {
    header('Content-Type: binary/octet-stream');
    header('Pragma: no-cache');

    $secretKey = 'j91xEtOM9O33dbSGTYpIx3pCpo7N52fD';
    $key = '416BB6208A1452435B9EF76C32C18292';
    $key = aes_encrypt($secretKey, $key);

    echo $key;
    //echo hex2bin($key);

    exit(); // this is needed to ensure cr/lf is not added to output
}

?>
