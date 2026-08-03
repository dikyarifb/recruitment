<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\OpenAIService;
use Illuminate\Routing\Controller;

class ChatController extends Controller
{
    protected $ai;

    public function __construct(OpenAIService $ai)
    {
        $this->ai = $ai;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'conversation_id' => 'required',
            'message' => 'required'
        ]);

        $answer = $this->ai->stream(
            $request->conversation_id,
            $request->message
        );

        return response()->json([
            'success' => true,
            'answer' => $answer
        ]);
    }
}