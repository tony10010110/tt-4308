<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Price;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PriceController extends Controller
{
    public function index(): JsonResponse
    {
        $prices = Price::orderBy('sort_order')->get();
        return response()->json($prices);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'currency'    => 'string|max:10',
            'period'      => 'nullable|string|max:50',
            'features'    => 'nullable|array',
            'features.*'  => 'string',
            'is_popular'  => 'boolean',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);

        $price = Price::create($data);

        return response()->json($price, 201);
    }

    public function show(Price $price): JsonResponse
    {
        return response()->json($price);
    }

    public function update(Request $request, Price $price): JsonResponse
    {
        $data = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|numeric|min:0',
            'currency'    => 'string|max:10',
            'period'      => 'nullable|string|max:50',
            'features'    => 'nullable|array',
            'features.*'  => 'string',
            'is_popular'  => 'boolean',
            'is_active'   => 'boolean',
            'sort_order'  => 'integer',
        ]);

        $price->update($data);

        return response()->json($price);
    }

    public function destroy(Price $price): JsonResponse
    {
        $price->delete();
        return response()->json(null, 204);
    }
}
