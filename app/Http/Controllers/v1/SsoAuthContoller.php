<?php

namespace App\Http\Controllers\v1;

use Illuminate\Support\Facades\Log;
use App\Repository\SsoAuthRepository;
use Illuminate\Support\Facades\Request;
use App\Http\Requests\SsoProviderRequest;

class SsoAuthContoller
{
    public function __construct(public SsoAuthRepository $SsoAuthRepository)
    {
        $this->SsoAuthRepository = $SsoAuthRepository;
    }

    public function redirectToProvider(SsoProviderRequest $SsoProviderRequest)
    {
        try {
            $provider       = $SsoProviderRequest->input('provider');
            Log::info('User enter successfully:', $SsoProviderRequest->toArray());
            $data_result    = $this->SsoAuthRepository->getSsoAuthenticate($provider);
            return $data_result;

        } catch (\Exception $e) {
            abort(500, $e->getMessage());
            Log::error('Error during authentication:', ['message' => $e->getMessage()]);
        }
    }


    public function handleProviderCallback(SsoProviderRequest $SsoProviderRequest)
    {
        try {
            $provider = $SsoProviderRequest->input('provider');
            Log::info('User callback successfully:', $SsoProviderRequest->toArray() );
            return $this->SsoAuthRepository->setSsoAuthenticate($provider);
            Log::info('User auth successfully:', $this->SsoAuthRepository);
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
            Log::error('Error during authentication:', ['message' => $e->getMessage()]);
        }
    }
    
}
