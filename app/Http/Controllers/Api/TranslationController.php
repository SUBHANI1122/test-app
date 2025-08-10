<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TranslationService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TranslationController extends Controller
{
    private TranslationService $service;

    public function __construct(TranslationService $service)
    {
        $this->service = $service;
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:191',
            'locale' => 'required|string|max:8',
            'content' => 'required|string',
            'tags' => 'array',
            'context' => 'nullable|string',
        ]);

        $translation = $this->service->createTranslation($validated);

        return response()->json($translation, 201);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'content' => 'sometimes|string',
            'tags' => 'sometimes|array',
            'context' => 'nullable|string',
        ]);

        $ok = $this->service->updateTranslation($id, $validated);

        return response()->json(['updated' => $ok]);
    }

    public function show(int $id)
    {
        $translation = $this->service->getTranslation($id);

        if (!$translation) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($translation);
    }

    public function search(Request $request)
    {
        $filters = $request->only(['locale', 'key', 'content', 'tags', 'context']);

        $pageSize = (int) $request->get('per_page', 50);

        $result = $this->service->search($filters, $pageSize);

        return response()->json($result);
    }

    public function exportJson(Request $request, string $locale)
    {
        $generator = $this->service->exportLocale($locale);

        $response = new StreamedResponse(function () use ($generator) {
            // Start JSON object
            echo '{';
            $first = true;

            foreach ($generator as $pair) {
                foreach ($pair as $key => $value) {
                    if (!$first) {
                        echo ',';
                    }
                    $first = false;

                    echo json_encode((string) $key) . ':' . json_encode((string) $value);
                }
            }

            echo '}';
        });

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}