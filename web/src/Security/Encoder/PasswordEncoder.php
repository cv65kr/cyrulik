<?php

declare(strict_types=1);

namespace App\Security\Encoder;

use Symfony\Component\Security\Core\Encoder\BasePasswordEncoder;

final class PasswordEncoder extends BasePasswordEncoder
{
    /**
     * Encodes the raw password.
     *
     * @param string $raw The password to encode
     * @param string $salt The salt
     *
     * @return string The encoded password
     */
    public function encodePassword($raw, $salt): string
    {
        return \password_hash($raw, PASSWORD_BCRYPT);
    }

    /**
     * Checks a raw password against an encoded password.
     *
     * @param string $encoded An encoded password
     * @param string $raw A raw password
     * @param string $salt The salt
     *
     * @return bool true if the password is valid, false otherwise
     */
    public function isPasswordValid($encoded, $raw, $salt): bool
    {
        return $encoded === $raw;
    }
}
