<?php

namespace App\Http\Controllers;
use App\Services\SmsService;

use Illuminate\Support\Facades\Http;

class SmsController extends Controller
{
    public function send(SmsService $smsService)
    {
        // $response = Http::withBasicAuth(
        //     config('services.marz.key'),
        //     config('services.marz.secret')
        // )->post(config('services.marz.url'), [
        //     'recipient' => '+256702262806',
        //     'message' => 'Hello, this is a test message!',
        // ]);

        // if ($response->successful()) {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'SMS sent successfully!',
        //         'response' => $response->json(),
        //     ]);
        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'error' => $response->body(),
        //     ], $response->status());
        // }

        $response = $smsService->send('+256702262806', 'Hello, this is a test message!');
        return response()->json($response);
    }
}
