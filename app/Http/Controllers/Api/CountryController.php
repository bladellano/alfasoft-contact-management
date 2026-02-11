<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CountryService;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function search(Request $request)
    {
        $search = $request->input('q', '');

        if (empty($search)) {
            // Return top 10 countries when no search term
            $countries = $this->countryService->getAllCountries();
            return response()->json(array_slice($countries, 0, 10));
        }

        // Search countries by name
        $countries = $this->countryService->searchCountries($search);

        return response()->json($countries);
    }

    public function getByCode(Request $request)
    {
        $code = $request->input('code');

        if (empty($code)) {
            return response()->json(null);
        }

        $countries = $this->countryService->getAllCountries();

        $country = collect($countries)->first(function ($country) use ($code) {
            return $country['calling_code'] === $code;
        });

        return response()->json($country);
    }
}
