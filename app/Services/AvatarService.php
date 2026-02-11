<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AvatarService
{
    private $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.avatar.api_url');
    }

    /**
     * Generate and store a random avatar image
     *
     * @return string|null Path to stored avatar or null on failure
     */
    public function generateAndStore()
    {
        try {
            // Get list of monsters
            $monstersResponse = Http::timeout(10)->get($this->apiUrl . '/api/2014/monsters');

            if (!$monstersResponse->successful()) {
                Log::error('Failed to fetch monsters list: ' . $monstersResponse->status());
                return null;
            }

            $monsters = $monstersResponse->json();

            if (empty($monsters['results'])) {
                Log::error('No monsters found in API response');
                return null;
            }

            // Pick a random monster
            $randomMonster = $monsters['results'][array_rand($monsters['results'])];

            // Get monster details
            $monsterResponse = Http::timeout(10)->get($this->apiUrl . $randomMonster['url']);

            if (!$monsterResponse->successful()) {
                Log::error('Failed to fetch monster details: ' . $monsterResponse->status());
                return null;
            }

            $monsterData = $monsterResponse->json();

            if (empty($monsterData['image'])) {
                Log::error('Monster has no image: ' . $randomMonster['name']);
                return null;
            }

            // Download the image
            $imageUrl = $this->apiUrl . $monsterData['image'];
            $imageResponse = Http::timeout(10)->get($imageUrl);

            if (!$imageResponse->successful()) {
                Log::error('Failed to download monster image: ' . $imageUrl . ' - Status: ' . $imageResponse->status());
                return null;
            }

            // Generate unique filename
            $filename = 'avatars/' . Str::uuid() . '.png';

            // Store image in storage/app/public
            Storage::disk('public')->put($filename, $imageResponse->body());

            Log::info('Avatar generated successfully: ' . $filename);

            // Return the path (relative to storage/app/public)
            return $filename;

        } catch (\Exception $e) {
            Log::error('Failed to generate avatar: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete an avatar file
     *
     * @param string $path Path to avatar file
     * @return bool
     */
    public function delete($path)
    {
        if (empty($path)) {
            return false;
        }

        try {
            return Storage::disk('public')->delete($path);
        } catch (\Exception $e) {
            Log::error('Failed to delete avatar: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get public URL for avatar
     *
     * @param string|null $path Path to avatar file
     * @return string URL to avatar or default avatar
     */
    public function getUrl($path)
    {
        if (empty($path) || !Storage::disk('public')->exists($path)) {
            // Return default avatar if none exists
            return asset('images/default-avatar.png');
        }

        return Storage::url($path);
    }
}
