<?php

require 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();

$res = $client->request('POST', 'http://127.0.0.1:5002/account/oauth/token', [
    'headers' => [
        'Authorization' => 'Basic c3Vic2NyaXB0aW9uLXNlcnZpY2U6dGVzdA==',
        'Accept' => 'application/json',
    ],
    'query' => [
        'grant_type' => 'password',
        'client_id' => 'subscription-service',
        'username' => 'admin@admin.dev',
        'password' => 'test',
    ]
]);

$response = json_decode((string) $res->getBody(), true);


dump($response);