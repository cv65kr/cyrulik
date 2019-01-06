<?php

declare(strict_types=1);

namespace App\Security\User;

use App\Api\SignInHandler as UserFinder;
use App\Model\UserModel as User;
use Symfony\Component\Intl\Exception\NotImplementedException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class UserProvider implements UserProviderInterface
{
    /** @var UserFinder */
    private $userFinder;

    /**
     * UserProvider constructor.
     */
    public function __construct(UserFinder $userFinder)
    {
        $this->userFinder = $userFinder;
    }

    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        throw new NotImplementedException('');
    }

    public function loadUserByUsernameAndPassword(string $username, string $password): UserInterface
    {
        return $this->fetchUser($username, $password);
    }

    /**
     * Refreshes the user.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     */
    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->fetchUser(
            $user->getUsername(),
            $user->getPlainPassword()
        );
    }

    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     */
    public function supportsClass($class): bool
    {
        return User::class === $class;
    }

    private function fetchUser(string $username, string $password): UserInterface
    {
        $user = $this->userFinder->findUser($username, $password);
        if (null === $user) {
            throw new UsernameNotFoundException();
        }

        return $user;
    }
}
