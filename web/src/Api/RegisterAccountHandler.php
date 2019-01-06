<?php

declare(strict_types=1);

namespace App\Api;

use App\Model\SignUpModel;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

final class RegisterAccountHandler extends AbstractApiHandler
{
    /**
     * @param SignUpModel $model
     *
     * @return bool
     */
    public function create(SignUpModel $model): bool
    {
        try {
            $clientProvider = $this->getClient('register-service', \getenv('AUTH_REGISTER_SERVICE_PASSWORD'));

            $accessToken = $clientProvider->getAccessToken('client_credentials');

            $uiToken = $accessToken->getToken();

            return $this->createAccountRequest($model, $uiToken);
        } catch (Exception | GuzzleException $e) {

            $this->logger->error('ERROR', [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }

    /**
     * @param SignUpModel $model
     * @param string $token
     *
     * @return bool
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function createAccountRequest(SignUpModel $model, string $token): bool
    {
        $client = new Client();

        $response = $client->request('POST', $this->prepareUrl('account/'), [
            RequestOptions::HEADERS => [
                'Authorization' => \sprintf('Bearer %s', $token),
            ],
            RequestOptions::JSON => [
                'email' => $model->getLogin(),
                'password' => $model->getPassword(),
                'firstName' => $model->getFirstname(),
                'lastName' => $model->getLastname(),
            ]
        ]);

        return $response->getStatusCode() === 200;
    }
}