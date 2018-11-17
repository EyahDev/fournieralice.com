<?php

namespace App\Services\Utils;


class TokenGenerator
{
    /**
     * Génère un token aléatoire d'une longueur à définir
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public function generateRandomToken(int $length) {
        return bin2hex(random_bytes($length));
    }
}