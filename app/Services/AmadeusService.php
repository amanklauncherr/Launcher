<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class AmadeusService
{
    protected $baseUrl;
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->baseUrl = 'https://test.api.amadeus.com';
        $this->clientId = 'fbHM2EoHTyvzDBNsGyqFv6sa5uGpt9En';
        $this->clientSecret = 'MgnbcTliA1P2cZzH';
    }

    public function getAccessToken()
    {
        return Cache::remember('amadeus_token', 1800, function () {
            $response = Http::asForm()->post("{$this->baseUrl}/v1/security/oauth2/token", [
                'grant_type'    => 'client_credentials',
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

            $data = $response->json();
            return $data['access_token'] ?? null;
        });
    }

    public function getHotelsByCity($cityCode)
    {
        $token = $this->getAccessToken();
        if (!$token) {
            return ['error' => 'Failed to get access token'];
        }

        $response = Http::withToken($token)->get("{$this->baseUrl}/v1/reference-data/locations/hotels/by-city", [
            'cityCode' => $cityCode,
        ]);

        return $response->json();
    }
}
