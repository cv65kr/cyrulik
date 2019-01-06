<?php

declare(strict_types=1);

namespace App\Security;

use App\Security\Encoder\PasswordEncoder;
use App\Security\User\UserProvider;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

final class UserAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    /** @var PasswordEncoder */
    private $passwordEncoder;

    /** @var UserProvider */
    private $userProvider;

    /** @var RouterInterface */
    private $router;

    /**
     * UserAuthenticator constructor.
     */
    public function __construct(
        PasswordEncoder $passwordEncoder,
        UserProvider $userProvider,
        RouterInterface $router
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->userProvider = $userProvider;
        $this->router = $router;
    }

    public function supports(Request $request): bool
    {
        return 'sign_in' === $request->attributes->get('_route') && $request->isMethod('POST');
    }

    public function getCredentials(Request $request): array
    {
        $userData = $request->get('sign_in', []);

        $credentials = [
            'email' => $userData['login'] ?? '',
            'password' => $userData['password'] ?? '',
        ];

        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider): UserInterface
    {
        return $this->userProvider->loadUserByUsernameAndPassword($credentials['email'], $credentials['password']);
    }

    /**
     * Return the URL to the login page.
     *
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->router->generate('sign_in');
    }

    /**
     * Returns true if the credentials are valid.
     *
     * If any value other than true is returned, authentication will
     * fail. You may also throw an AuthenticationException if you wish
     * to cause authentication to fail.
     *
     * The *credentials* are the return value from getCredentials()
     *
     *
     * @return bool
     *
     * @throws AuthenticationException
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        // Because valid in API request
        return true;
    }

    /**
     * Called when authentication executed and was successful!
     *
     * This should return the Response sent back to the user, like a
     * RedirectResponse to the last page they visited.
     *
     * If you return null, the current request will continue, and the user
     * will be authenticated. This makes sense, for example, with an API.
     *
     * @param string $providerKey The provider (i.e. firewall) key
     *
     * @return Response|null
     *
     * @throws \Exception
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse(
            $this->router->generate('index')
        );
    }
}
