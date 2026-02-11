<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CountryService
{
    private $baseUrl = 'https://restcountries.com/v3.1';

    public function getAllCountries()
    {
        return Cache::remember('countries_all', 3600, function () {
            $response = Http::get($this->baseUrl . '/all', [
                'fields' => 'name,idd'
            ]);

            if ($response->successful()) {
                $countries = $response->json();
                return $this->formatCountries($countries);
            }

            return [];
        });
    }

    public function searchCountries($name)
    {
        if (empty($name)) {
            return $this->getAllCountries();
        }

        $response = Http::get($this->baseUrl . '/name/' . urlencode($name), [
            'fields' => 'name,idd'
        ]);

        if ($response->successful()) {
            $countries = $response->json();
            return $this->formatCountries($countries);
        }

        return [];
    }

    private function formatCountries($countries)
    {
        $formatted = [];

        foreach ($countries as $country) {
            $countryName = $country['name']['common'] ?? null;
            $callingCode = $this->getCallingCode($country);

            if ($countryName && $callingCode) {
                $formatted[] = [
                    'name' => $countryName,
                    'calling_code' => $callingCode,
                    'display_name' => $countryName . ' (' . $callingCode . ')'
                ];
            }
        }

        usort($formatted, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });

        return $formatted;
    }

    private function getCallingCode($country)
    {
        if (isset($country['idd']['root']) && isset($country['idd']['suffixes'][0])) {
            $root = $country['idd']['root'];
            $suffix = $country['idd']['suffixes'][0];
            return ltrim($root . $suffix, '+');
        }

        return null;
    }
}
