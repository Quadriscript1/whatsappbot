<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    //
    public function handleChatbot(Request $request)
    {
        // Get the user's message from the request
        $userMessage = $request->input('text');

        // Query the database for matching replies
        $result = DB::table('chatbot')
            ->where('questions', 'like', '%' . $userMessage . '%')
            ->select('responses')
            ->first();

        if ($result) {
            // Retrieve the reply from the database
            $reply = $result->responses;
            return response()->json(['message' => $reply]);
        } else {
            return response()->json(['message' => "Sorry, I can't understand you!"]);
        }
    }
}
