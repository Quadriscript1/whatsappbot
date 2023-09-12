<?php

namespace App\Http\Controllers;

use App\Models\chatbot;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TwilioController extends Controller
{

 
    public function handleWebhook(Request $request){
        $webhook = new chatbot([
            'webhook' => $request->message->message,

        ]);

        $identifier = 'phone:' . $request->contact->phone;
        $apiUrl = "https://api.respond.io/v2/contact/{$identifier}/message";

        $result = DB::table('chatbot')
        ->where('questions', 'like', '%' . $request->message->message->text . '%')
        ->select('responses')
        ->first();
        if ($result) {
            $message = $result;
        } else{
            $message = 'Sorry, I cant understand you!';
        }

        $payload = [
        "channelId" => $request->message->channelId,
            "message" => [
                "type" => "text",
                "text" => $message,
                "messageTag" => ""
            ]
        ];

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6Mzc5NSwic3BhY2VJZCI6MTc3MTU1LCJvcmdJZCI6MTc3NjUyLCJ0eXBlIjoiYXBpIiwiaWF0IjoxNjk0MDg5MjY3fQ.3FYAMhBmN0UONwq7DlsFd9vNZqu2_WaAriy7myaJgzQ', // Replace with your API key
        ];

        try {
            $response = Http::withHeaders($headers)->post($apiUrl, $payload);
            Log::info('Response data: ' . $response->body());
        } catch (\Exception $e) {
            // Handle any errors here
            Log::error('Error: ' . $e->getMessage());
        }

        $webhook->save();

        return response()->json(['message' => 'ok']);
    }
}



