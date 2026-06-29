<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(): JsonResponse
    {
        $pages = Page::all()->map(fn ($p) => $this->format($p));
        return response()->json($pages);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'slug'             => 'required|string|max:100|unique:pages,slug',
            'title'            => 'required|string|max:255',
            'content'          => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active'        => 'boolean',
            'cover'            => 'nullable|image|max:10240',
        ]);

        $page = Page::create($data);

        if ($request->hasFile('cover')) {
            $page->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return response()->json($this->format($page), 201);
    }

    public function show(Page $page): JsonResponse
    {
        return response()->json($this->format($page));
    }

    public function update(Request $request, Page $page): JsonResponse
    {
        $data = $request->validate([
            'title'            => 'sometimes|string|max:255',
            'content'          => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_active'        => 'boolean',
            'cover'            => 'nullable|image|max:10240',
        ]);

        $page->update($data);

        if ($request->hasFile('cover')) {
            $page->addMediaFromRequest('cover')->toMediaCollection('cover');
        }

        return response()->json($this->format($page));
    }

    public function destroy(Page $page): JsonResponse
    {
        $page->delete();
        return response()->json(null, 204);
    }

    private function format(Page $page): array
    {
        return [
            'id'               => $page->id,
            'slug'             => $page->slug,
            'title'            => $page->title,
            'content'          => $page->content,
            'meta_title'       => $page->meta_title,
            'meta_description' => $page->meta_description,
            'is_active'        => $page->is_active,
            'cover'            => $page->getFirstMediaUrl('cover'),
        ];
    }
}
