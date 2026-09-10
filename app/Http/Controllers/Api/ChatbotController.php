<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChatbotRequest;
use App\Models\Movie;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function send(ChatbotRequest $request)
    {
        $apiKey = env('GEMINI_API_KEY');
        $message = $request->validated('message');

        // هات كل الأفلام الموجودة في الموقع
        $movies = Movie::all(['title', 'description', 'release_year', 'rating']);

        $moviesList = $movies->map(function ($movie) {
            return "- {$movie->title} ({$movie->release_year}) | تقييم: {$movie->rating} | {$movie->description}";
        })->implode("\n");

        // اعمل system prompt يوضح للـ AI هو مساعد سينما بيعرف الأفلام دي بس
        $systemPrompt = "أنت مساعد ذكي اسمه Cinema Assistant، بتشتغل جوه موقع سينما. "
    . "دي قائمة الأفلام الموجودة فعليًا في قاعدة بيانات الموقع:\n\n{$moviesList}\n\n"
    . "لو المستخدم سأل عن فيلم من القائمة دي، جاوبه من الداتا الحقيقية من غير ما تخترع تفاصيل غلط. "
    . "لو سأل عن فيلم مش موجود في القائمة، قوله بوضوح إنه مش موجود في مكتبة الموقع حاليًا. "
    . "لو سأل مين صاحب الموقع  أو مين اللي عمل الموقع, قوله ان صاحب الموقع اسمه محمد هيثم شلبي"
    . "لكن لو سأل أي سؤال عام تاني (مش عن الأفلام)، جاوبه بشكل طبيعي زي أي مساعد ذكي عادي.";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->retry(3, 1000)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.6-flash:generateContent?key={$apiKey}",
            [
                'system_instruction' => [
                    'parts' => [['text' => $systemPrompt]],
                ],
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $message]
                        ]
                    ]
                ]
            ]
        );

        if ($response->failed()) {
            return response()->json([
                'error' => $response->json(),
                'status' => $response->status(),
            ], 500);
        }

        $data = $response->json();
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'مفيش رد';

        return response()->json([
            'reply' => $reply,
        ]);
    }
}
