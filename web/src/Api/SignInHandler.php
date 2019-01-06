<?php

declare(strict_types=1);

namespace App\Api;

use App\Model\UserModel;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use League\OAuth2\Client\Token\AccessTokenInterface;

final class SignInHandler extends AbstractApiHandler
{
    /**
     * @return UserModel
     */
    public function findUser(string $email, string $password): ?UserModel
    {
        try {
            $accessToken = $this->getToken($email, $password);

            $client = new Client();

            $response = $client->request('GET', $this->prepareUrl('account/current/'), [
                RequestOptions::HEADERS => [
                    'Authorization' => \sprintf('Bearer %s', $accessToken->getToken()),
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Invalid request');
            }

            $response = \json_decode((string) $response->getBody(), true);
            $response = $response['userAuthentication']['principal'];
            $response['roles'] = \array_map(function ($role) {
                return (string) $role['authority'];
            }, $response['authorities']);

            $userModel = UserModel::deserialize($response);
            $userModel->setAccessToken($accessToken);
            $userModel->setPlainPassword($password);

            return $userModel;
        } catch (Exception | GuzzleException $e) {
            $this->logger->error('ERROR', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }

    public function refreshToken(UserModel $model): ?AccessTokenInterface
    {
        $accessToken = $model->getAccessToken();
        if (null === $accessToken) {
            return null;
        }

        if (false === $accessToken->hasExpired()) {
            return null;
        }

        try {
            $clientProvider = $this->getClient('web', \getenv('AUTH_WEB'));

            return $clientProvider->getAccessToken('refresh_token', [
                'refresh_token' => $accessToken->getRefreshToken(),
            ]);
        } catch (Exception $e) {
            $this->logger->error('ERROR', [
                'message' => $e->getMessage(),
            ]);
        }

        return null;
    }

    /**
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    public function getToken(string $email, string $password): AccessTokenInterface
    {
        $clientProvider = $this->getClient('web', \getenv('AUTH_WEB'));

        return $clientProvider->getAccessToken('password', [
            'username' => $email,
            'password' => $password,
        ]);
    }
}
