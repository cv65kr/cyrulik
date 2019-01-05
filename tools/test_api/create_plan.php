<?php

require 'vendor/autoload.php';

$accessToken = '5f0cb638-4185-4d36-9e3a-b79aa03e76ed';

$client = new \GuzzleHttp\Client();

for ($i=1; $i <= 4; $i++) {
    $res = $client->request('POST', 'http://127.0.0.1:5002/subscription/plan/admin/', [
        'headers' => [
            'Authorization' => 'Bearer '.$accessToken
        ],
        'json' => [
            'name' => 'First plan '.$i,
            'pricePerMonth' => $i * 100,
        ]
    ]);

    $response = json_decode((string) $res->getBody(), true);

    dump($response);
}