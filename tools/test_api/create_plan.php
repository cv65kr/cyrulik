<?php

require 'vendor/autoload.php';

$accessToken = '';

$client = new \GuzzleHttp\Client();

for ($i=1; $i <= 4; $i++) {
    $res = $client->request('POST', 'http://127.0.0.1:5002/subscription/plan/admin/', [
        'headers' => [
            'Authorization' => 'Bearer d2acdfed-36e5-480d-8a5a-3e4b3adc4e5f'
        ],
        'json' => [
            'name' => 'First plan '.$i,
            'pricePerMonth' => $i * 100,
        ]
    ]);

    $response = json_decode((string) $res->getBody(), true);

    dump($response);
}