<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RouteController extends Controller
{
    public function index(): JsonResponse
    {
        $routes = Route::orderBy('sort_order')->get()->map(fn ($r) => $this->format($r));
        return response()->json($routes);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'             => 'required|string|max:255',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'difficulty'        => 'required|in:easy,medium,hard',
            'duration_days'     => 'required|integer|min:1',
            'price'             => 'nullable|numeric|min:0',
            'location'          => 'nullable|string|max:255',
            'max_participants'  => 'nullable|integer|min:1',
            'included'          => 'nullable|array',
            'excluded'          => 'nullable|array',
            'is_active'         => 'boolean',
            'sort_order'        => 'integer',
            'cover'             => 'nullable|image|max:10240',
        ]);

        $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);

        $route = Route::create($data);

        if ($request->hasFile('cover')) {
            $route->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return response()->json($this->format($route), 201);
    }

    public function show(Route $route): JsonResponse
    {
        return response()->json($this->format($route, true));
    }

    public function update(Request $request, Route $route): JsonResponse
    {
        $data = $request->validate([
            'title'             => 'sometimes|string|max:255',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'difficulty'        => 'sometimes|in:easy,medium,hard',
            'duration_days'     => 'sometimes|integer|min:1',
            'price'             => 'nullable|numeric|min:0',
            'location'          => 'nullable|string|max:255',
            'max_participants'  => 'nullable|integer|min:1',
            'included'          => 'nullable|array',
            'excluded'          => 'nullable|array',
            'is_active'         => 'boolean',
            'sort_order'        => 'integer',
            'cover'             => 'nullable|image|max:10240',
        ]);

        $route->update($data);

        if ($request->hasFile('cover')) {
            $route->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return response()->json($this->format($route));
    }

    public function destroy(Route $route): JsonResponse
    {
        $route->delete();
        return response()->json(null, 204);
    }

    public function addGalleryImage(Request $request, Route $route): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:10240']);
        $media = $route->addMediaFromRequest('image')->toMediaCollection('gallery');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], 201);
    }

    public function removeGalleryImage(Route $route, int $mediaId): JsonResponse
    {
        $route->deleteMedia($mediaId);
        return response()->json(null, 204);
    }

    private function format(Route $route, bool $full = false): array
    {
        $data = [
            'id'                => $route->id,
            'title'             => $route->title,
            'slug'              => $route->slug,
            'short_description' => $route->short_description,
            'difficulty'        => $route->difficulty,
            'duration_days'     => $route->duration_days,
            'price'             => $route->price,
            'location'          => $route->location,
            'max_participants'  => $route->max_participants,
            'is_active'         => $route->is_active,
            'sort_order'        => $route->sort_order,
            'cover'             => $route->getFirstMediaUrl('cover'),
        ];

        if ($full) {
            $data['description'] = $route->description;
            $data['included']    = $route->included ?? [];
            $data['excluded']    = $route->excluded ?? [];
            $data['gallery']     = $route->getMedia('gallery')
                ->map(fn ($m) => ['id' => $m->id, 'url' => $m->getUrl()])
                ->values()
                ->toArray();
        }

        return $data;
    }
}
