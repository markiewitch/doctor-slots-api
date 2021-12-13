<?php

declare(strict_types=1);

namespace App\Adapters\Database;

class Cursor
{
    public static function decrypt(string $value): ?array
    {
        try {
            $decoded = json_decode(base64_decode($value), flags: JSON_THROW_ON_ERROR);
            // todo improve this code to make cursors more powerful and safe, right now they're [[field, operator, value]]
            return $decoded;
        } catch (\JsonException $e) {
        }
        return null;
    }

    public static function encode(array $data): string
    {
        return base64_encode(json_encode($data));
    }
}
