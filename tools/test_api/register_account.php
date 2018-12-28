<?php

require 'vendor/autoload.php';

$client = new \GuzzleHttp\Client();

$res = $client->request('POST', 'http://127.0.0.1:5002/account/oauth/token', [
    'headers' => [
        'Authorization' => 'Basic cmVnaXN0ZXItc2VydmljZTp0ZXN0'
    ],
    'query' => [
        'grant_type' => 'client_credentials',
        'client_id' => 'register-service',
    ]
]);

$response = json_decode((string) $res->getBody(), true);

$accessToken = $response['access_token'];


$res = $client->request('POST', 'http://127.0.0.1:5002/account/', [
    'headers' => [
        'Authorization' => 'Bearer '.$accessToken,
    ],
    'json' => [
        'email' => 'admin@admin.dev',
        'password' => 'test',
        'firstName' => 'Jan',
        'lastName' => 'Kowalski',
    ]
]);


dump($response);