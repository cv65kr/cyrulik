<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Api\SignInHandler;
use App\Model\UserModel;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Security;

final class UserAccessTokenListener
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var SignInHandler
     */
    private $signInHandler;

    /**
     * UserAccessTokenListener constructor.
     *
     * @param Security $security
     * @param SignInHandler $signInHandler
     */
    public function __construct(Security $security, SignInHandler $signInHandler)
    {
        $this->security = $security;
        $this->signInHandler = $signInHandler;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event): void
    {
        /** @var UserModel $user */
        $user = $this->security->getUser();
        if (null === $user) {
            return;
        }

        $accessToken = $this->signInHandler->refreshToken($user);
        if (null === $accessToken) {
            return;
        }

        $user->setAccessToken($accessToken);
    }
}