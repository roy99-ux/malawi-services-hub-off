<?php
$url = 'https://api.paychangu.com/v1';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'CURL error: ' . curl_error($ch);
} else {
    echo 'Connected successfully. Response: ' . $response;
}
curl_close($ch);