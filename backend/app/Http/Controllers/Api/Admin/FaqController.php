<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Faq::orderBy('sort_order')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'question'   => 'required|string|max:500',
            'answer'     => 'required|string',
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ]);

        return response()->json(Faq::create($data), 201);
    }

    public function show(Faq $faq): JsonResponse
    {
        return response()->json($faq);
    }

    public function update(Request $request, Faq $faq): JsonResponse
    {
        $data = $request->validate([
            'question'   => 'sometimes|string|max:500',
            'answer'     => 'sometimes|string',
            'is_active'  => 'boolean',
            'sort_order' => 'integer',
        ]);

        $faq->update($data);

        return response()->json($faq);
    }

    public function destroy(Faq $faq): JsonResponse
    {
        $faq->delete();
        return response()->json(null, 204);
    }

    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items'       => 'required|array',
            'items.*.id'  => 'required|integer|exists:faqs,id',
            'items.*.sort_order' => 'required|integer',
        ]);

        foreach ($request->items as $item) {
            Faq::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json(['message' => 'Порядок оновлено.']);
    }
}
