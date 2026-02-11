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
            // Generate unique seed for Robohash
            $seed = Str::uuid();

            // Build Robohash URL with parameters
            // size: 200x200, set2: robots
            $imageUrl = $this->apiUrl . '/' . $seed . '?size=200x200&set=set2';

            // Download the image
            $imageResponse = Http::timeout(10)->get($imageUrl);

            if (!$imageResponse->successful()) {
                Log::error('Failed to download avatar: ' . $imageUrl . ' - Status: ' . $imageResponse->status());
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
