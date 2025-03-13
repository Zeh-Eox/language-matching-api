<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTranslationRequest;
use App\Models\Translation;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(Translation::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTranslationRequest $request): JsonResponse
    {
        try {
            $translation = new Translation();

            $translation->source_language = $request->source_language;
            $translation->target_language = $request->target_language;
            $translation->source_text = $request->source_text;
            $translation->target_text = $request->target_text;
            $translation->user_id = auth()->user()->id;

            $translation->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Translation successfully added',
                'datas' => $translation
            ]);
        } catch (Exception $e)
        {
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getByLanguage(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'source_language' => 'required|string|size:2',
            'target_language' => 'required|string|size:2',
        ]);

        $translations = Translation::where('source_language', $validated['source_language'])
                                   ->where('target_language', $validated['target_language'])
                                   ->get();

        return response()->json($translations);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
