<?php

declare(strict_types=1);

namespace App\Model;

use DateTime;
use DateTimeInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class UserModel implements UserInterface
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string|null
     */
    private $plainPassword;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var DateTimeInterface|null
     */
    private $createdAt;

    /**
     * @var DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var AccessTokenInterface|null
     */
    private $accessToken;

    /**
     * UserModel constructor.
     *
     * @param string $id
     * @param string $username
     * @param string $password
     * @param string $firstname
     * @param string $lastname
     * @param DateTimeInterface|null $createdAt
     * @param DateTimeInterface|null $updatedAt
     * @param array $roles
     * @param AccessTokenInterface|null $accessToken
     * @param string|null $plainPassword
     */
    private function __construct(
        string $id,
        string $username,
        string $password,
        string $firstname,
        string $lastname,
        ?DateTimeInterface $createdAt,
        ?DateTimeInterface $updatedAt,
        array $roles,
        ?AccessTokenInterface $accessToken = null,
        ?string $plainPassword = null
    ) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->roles = $roles;
        $this->accessToken = $accessToken;
        $this->plainPassword = $plainPassword;
    }

    /**
     * @param array $data
     *
     * @return UserModel
     *
     * @throws \Exception
     */
    public static function deserialize(array $data): self
    {
        $createdAt = null;
        if (false === empty($data['createdAt'])) {
            $createdAt = new DateTime($data['createdAt']);
        }

        $updatedAt = null;
        if (false === empty($data['updatedAt'])) {
            $updatedAt = new DateTime($data['updatedAt']);
        }

        return new self(
            (string) $data['id'],
            (string) $data['username'],
            (string) $data['password'],
            (string) $data['firstName'],
            (string) $data['lastName'],
            $createdAt,
            $updatedAt,
            $data['roles']
        );
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     */
    public function setPlainPassword(?string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param DateTimeInterface|null $createdAt
     */
    public function setCreatedAt(?DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return AccessTokenInterface|null
     */
    public function getAccessToken(): ?AccessTokenInterface
    {
        return $this->accessToken;
    }

    /**
     * @param AccessTokenInterface|null $accessToken
     */
    public function setAccessToken(?AccessTokenInterface $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return '';
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}