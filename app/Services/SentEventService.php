<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
class SentEventService{
    private static $baseUrl = "http://websocket:3000";

    public static function send($message)
    {   
        $response = Http::post(self::$baseUrl . "/message", [
            'message' => $message
        ]);

        if(!$response->successful()){
            Log::error("Error to interact with WS server: " . $response->status());
        }
    }
}