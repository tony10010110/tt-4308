<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index(): JsonResponse
    {
        $items = Equipment::orderBy('sort_order')->get()->map(fn ($e) => $this->format($e));
        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string',
            'category'      => 'nullable|string|max:100',
            'price_per_day' => 'nullable|numeric|min:0',
            'is_available'  => 'boolean',
            'is_active'     => 'boolean',
            'sort_order'    => 'integer',
            'photo'         => 'nullable|image|max:10240',
        ]);

        $item = Equipment::create($data);

        if ($request->hasFile('photo')) {
            $item->addMediaFromRequest('photo')->toMediaCollection('photo');
        }

        return response()->json($this->format($item), 201);
    }

    public function show(Equipment $equipment): JsonResponse
    {
        return response()->json($this->format($equipment));
    }

    public function update(Request $request, Equipment $equipment): JsonResponse
    {
        $data = $request->validate([
            'name'          => 'sometimes|string|max:255',
            'description'   => 'nullable|string',
            'category'      => 'nullable|string|max:100',
            'price_per_day' => 'nullable|numeric|min:0',
            'is_available'  => 'boolean',
            'is_active'     => 'boolean',
            'sort_order'    => 'integer',
            'photo'         => 'nullable|image|max:10240',
        ]);

        $equipment->update($data);

        if ($request->hasFile('photo')) {
            $equipment->addMediaFromRequest('photo')->toMediaCollection('photo');
        }

        return response()->json($this->format($equipment));
    }

    public function destroy(Equipment $equipment): JsonResponse
    {
        $equipment->delete();
        return response()->json(null, 204);
    }

    private function format(Equipment $equipment): array
    {
        return [
            'id'            => $equipment->id,
            'name'          => $equipment->name,
            'description'   => $equipment->description,
            'category'      => $equipment->category,
            'price_per_day' => $equipment->price_per_day,
            'is_available'  => $equipment->is_available,
            'is_active'     => $equipment->is_active,
            'sort_order'    => $equipment->sort_order,
            'photo'         => $equipment->getFirstMediaUrl('photo'),
        ];
    }
}
