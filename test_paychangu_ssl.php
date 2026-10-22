<?php
$url = 'https://api.paychangu.com/v1/payment/initiate';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_exec($ch);
if (curl_errno($ch)) {
    echo 'CURL Error: ' . curl_error($ch);
} else {
    echo 'SSL handshake successful!';
}
curl_close($ch);