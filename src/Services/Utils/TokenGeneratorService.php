<?php

namespace App\Services\Utils;


class TokenGeneratorService
{
    /**
     * @param $text
     * @return string
     * @throws \Exception
     */
    public function generateRandomToken($text) {
        return bin2hex(random_bytes(strlen($text)));
    }
}