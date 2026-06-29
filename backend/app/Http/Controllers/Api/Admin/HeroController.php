<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index(): JsonResponse
    {
        $heroes = HeroSection::all()->map(fn ($h) => $this->format($h));
        return response()->json($heroes);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|string|max:255',
            'is_active'   => 'boolean',
            'background'  => 'nullable|image|max:10240',
        ]);

        $hero = HeroSection::create($data);

        if ($request->hasFile('background')) {
            $hero->addMediaFromRequest('background')->toMediaCollection('background');
        }

        return response()->json($this->format($hero), 201);
    }

    public function show(HeroSection $hero): JsonResponse
    {
        return response()->json($this->format($hero));
    }

    public function update(Request $request, HeroSection $hero): JsonResponse
    {
        $data = $request->validate([
            'title'       => 'sometimes|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:100',
            'button_url'  => 'nullable|string|max:255',
            'is_active'   => 'boolean',
            'background'  => 'nullable|image|max:10240',
        ]);

        $hero->update($data);

        if ($request->hasFile('background')) {
            $hero->addMediaFromRequest('background')->toMediaCollection('background');
        }

        return response()->json($this->format($hero));
    }

    public function destroy(HeroSection $hero): JsonResponse
    {
        $hero->delete();
        return response()->json(null, 204);
    }

    private function format(HeroSection $hero): array
    {
        return [
            'id'          => $hero->id,
            'title'       => $hero->title,
            'subtitle'    => $hero->subtitle,
            'button_text' => $hero->button_text,
            'button_url'  => $hero->button_url,
            'is_active'   => $hero->is_active,
            'background'  => $hero->getFirstMediaUrl('background'),
        ];
    }
}
