<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BiteshipService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('BITESHIP_API_KEY');
        $this->baseUrl = env('BITESHIP_API_URL', 'https://api.biteship.com/v1');
    }

    /**
     * Search for areas based on query (e.g. city or district name)
     */
    public function searchArea($query)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get("{$this->baseUrl}/maps/areas", [
            'countries' => 'ID',
            'input' => $query,
            'type' => 'single',
        ]);

        return $response->json();
    }

    /**
     * Check shipping rates
     */
    public function checkRates($originAreaId, $destinationAreaId, $items)
    {
        \Illuminate\Support\Facades\Log::info('Biteship Check Rates Request', [
            'origin' => $originAreaId,
            'destination' => $destinationAreaId,
            'items' => $items,
        ]);

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/rates/couriers", [
            'origin_area_id' => $originAreaId,
            'destination_area_id' => $destinationAreaId,
            // 'couriers' => 'jne,jnt,sicepat,anteraja', // Removed to let Biteship return all available options
            'items' => $items,
        ]);

        \Illuminate\Support\Facades\Log::info('Biteship Check Rates Response', $response->json());

        return $response->json();
    }
}
