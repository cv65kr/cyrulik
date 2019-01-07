<?php

declare(strict_types=1);

namespace App\Api;

use League\OAuth2\Client\Provider\GenericProvider;

class UiHandler extends AbstractApiHandler
{
    public function getUiClientProvider(): GenericProvider
    {
        return $this->getClient('web', \getenv('AUTH_WEB'));
    }
}
