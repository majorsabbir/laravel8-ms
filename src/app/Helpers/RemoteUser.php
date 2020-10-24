<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class RemoteUser
{
    public static function get(int $user)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . request()->bearerToken(),
                'Accept'        => 'application/json',
            ])->get(env('USERS_MODULE_URI').'/'.$user);
            
            $responseData = $response->json();
    
            return isset($responseData['data']) ? $responseData['data'] : null;
        } catch (\Exception $exception) {
            return \Log::error($exception->getMessage());
        }
    }

    public static function recordableAttributes(int $user)
    {
        $attributes = [];

        $remoteUserAttributes = self::get($user);

        foreach (['id', 'username', 'full_name', 'avatar'] as $attr) {
            if (isset($remoteUserAttributes[$attr])) {
                $attributes[$attr] = $remoteUserAttributes[$attr];
            }
        }

        return $attributes;
    }
}
