<?php
namespace App\Services\InternetServiceProvider;

use InvalidArgumentException;

class InternetServiceProviderFactory
{
    public static function create(string $provider): InternetServiceProviderInterface
    {
        return match ($provider) {
            'mpt' => new Mpt(),
            'ooredoo' => new Ooredoo(),
            default => throw new InvalidArgumentException("Unsupported provider: $provider"),
        };
    }
}