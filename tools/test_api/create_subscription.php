<?php

require 'vendor/autoload.php';

$accessToken = '5f0cb638-4185-4d36-9e3a-b79aa03e76ed';

$client = new \GuzzleHttp\Client();

$res = $client->request('POST', 'http://127.0.0.1:5002/subscription/', [
    'headers' => [
        'Authorization' => 'Bearer '.$accessToken
    ],
    'json' => [
        'plan' => '7885f9f3-1381-435a-89d7-a9de4e496a3e',
        'paymentStatus' => 0,
    ]
]);

$response = json_decode((string) $res->getBody(), true);
dump($response);



$res = $client->request('POST', 'http://127.0.0.1:5002/subscription/', [
    'headers' => [
        'Authorization' => 'Bearer '.$accessToken
    ],
    'json' => [
        'plan' => '7885f9f3-1381-435a-89d7-a9de4e496a3e',
        'startedAt' => '2018-12-28 12:00:00',
        'endAt' => '2019-01-10 12:00:00',
        'paymentStatus' => 2,
    ]
]);

$response = json_decode((string) $res->getBody(), true);
dump($response);


////////////////// LIST

$res = $client->request('GET', 'http://127.0.0.1:5002/subscription/admin/', [
    'headers' => [
        'Authorization' => 'Bearer '.$accessToken
    ],
]);

$response = json_decode((string) $res->getBody(), true);
dump($response);