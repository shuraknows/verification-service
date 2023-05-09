<?php

declare(strict_types=1);

namespace App\Infrastructure\Template\Http\Client;

use Symfony\Contracts\HttpClient\HttpClientInterface;

final class TemplateServiceClient
{
    public function __construct(private HttpClientInterface $client, private string $templateServiceUrl)
    {
    }

    public function requestVerificationBody(string $code, string $slug): string
    {
        return $this->client->request(
            'POST',
            $this->templateServiceUrl,
            [
                'headers' => ['Accept' => 'application/json'],
                'body' => json_encode([
                    'slug'    => $slug,
                    'variables' => ['code' => $code],
                ])
            ]
        )->getContent();
    }
}
