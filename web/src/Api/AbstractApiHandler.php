<?php

declare(strict_types=1);

namespace App\Api;

use League\OAuth2\Client\OptionProvider\HttpBasicAuthOptionProvider;
use League\OAuth2\Client\Provider\GenericProvider;
use Psr\Log\LoggerInterface;

abstract class AbstractApiHandler
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * AbstractApiHandler constructor.
     *
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->url = \sprintf(
            'http://%s:%d/',
            \getenv('CONFIG_SERVICE_HOST_GATEWAY'),
            \getenv('CONFIG_SERVICE_PORT_GATEWAY')
        );
        $this->logger = $logger;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    protected function prepareUrl(string $path): string
    {
        return \sprintf('%s%s', $this->url, $path);
    }

    /**
     * @param string $clientId
     * @param string $clientSecret
     *
     * @return GenericProvider
     */
    protected function getClient(string $clientId, string $clientSecret): GenericProvider
    {
        return new GenericProvider(
            [
                'clientId' => $clientId,
                'clientSecret' => $clientSecret,
                'urlAccessToken' => \sprintf('%saccount/oauth/token', $this->url),
                'urlAuthorize' => '',
                'urlResourceOwnerDetails' => '',
            ],
            [
                'optionProvider' => new HttpBasicAuthOptionProvider(),
            ]
        );
    }
}