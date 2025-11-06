<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    public function send($recipient, $message)
    {
        $response = Http::withBasicAuth(
            config('services.marz.key'),
            config('services.marz.secret')
        )->post(config('services.marz.url'), [
            'recipient' => $recipient,
            'message' => $message,
        ]);

        return $response->json();
    }
}
