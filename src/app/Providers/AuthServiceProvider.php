<?php

namespace App\Providers;

use App\Helpers\JWT;
use App\Helpers\GenericUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('api', function ($request) {
            $token = $this->getBearerToken($request);
            
            if ($token && ($payload = JWT::getPayload($token))) {
                return new GenericUser(json_decode(json_encode($payload->user), true));
                // return new GenericUser(['id' => 1, 'email' => 'admin@admin.com']);
            }
        });
    }

    private function getBearerToken($request)
    {
        $headers = $request->header('authorization');
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}
