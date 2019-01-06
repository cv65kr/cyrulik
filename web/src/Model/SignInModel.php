<?php

declare(strict_types=1);

namespace App\Model;

final class SignInModel
{
    /** @var string|null */
    private $login;

    /** @var string|null */
    private $password;

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(?string $login): void
    {
        $this->login = $login;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }
}
