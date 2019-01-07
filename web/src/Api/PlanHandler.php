<?php

declare(strict_types=1);

namespace App\Api;

use App\Model\Plan\PlanCollection;
use App\Model\Plan\PlanItem;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;

final class PlanHandler extends UiHandler
{
    public function getPlans(): ?PlanCollection
    {
        try {
            $clientProvider = $this->getUiClientProvider();

            $accessToken = $clientProvider->getAccessToken('client_credentials');

            $client = new Client();

            $response = $client->request('GET', $this->prepareUrl('subscription/plan/'), [
                RequestOptions::HEADERS => [
                    'Authorization' => \sprintf('Bearer %s', $accessToken->getToken()),
                ],
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \Exception('Invalid request');
            }

            $response = \json_decode((string) $response->getBody(), true);

            $collection = new PlanCollection();
            foreach ($response as $item) {
                $collection->addItem(PlanItem::deserialize($item));
            }

            return $collection;
        } catch (Exception | GuzzleException $e) {
            $this->logger->error('ERROR', [
                'message' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
