<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Faq;
use App\Models\HeroSection;
use App\Models\Page;
use App\Models\Price;
use App\Models\Route;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function hero(): JsonResponse
    {
        $hero = HeroSection::where('is_active', true)->first();

        if (! $hero) {
            return response()->json(null);
        }

        return response()->json([
            'id'           => $hero->id,
            'title'        => $hero->title,
            'subtitle'     => $hero->subtitle,
            'button_text'  => $hero->button_text,
            'button_url'   => $hero->button_url,
            'background'   => $hero->getFirstMediaUrl('background'),
        ]);
    }

    public function routes(Request $request): JsonResponse
    {
        $routes = Route::active()
            ->when($request->difficulty, fn ($q) => $q->where('difficulty', $request->difficulty))
            ->get()
            ->map(fn ($r) => $this->formatRoute($r));

        return response()->json($routes);
    }

    public function route(string $slug): JsonResponse
    {
        $route = Route::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return response()->json($this->formatRoute($route, true));
    }

    public function equipment(): JsonResponse
    {
        $items = Equipment::active()
            ->get()
            ->map(fn ($e) => [
                'id'            => $e->id,
                'name'          => $e->name,
                'description'   => $e->description,
                'category'      => $e->category,
                'price_per_day' => $e->price_per_day,
                'is_available'  => $e->is_available,
                'photo'         => $e->getFirstMediaUrl('photo'),
            ]);

        return response()->json($items);
    }

    public function prices(): JsonResponse
    {
        $prices = Price::active()
            ->get()
            ->map(fn ($p) => [
                'id'          => $p->id,
                'title'       => $p->title,
                'description' => $p->description,
                'price'       => $p->price,
                'currency'    => $p->currency,
                'period'      => $p->period,
                'features'    => $p->features ?? [],
                'is_popular'  => $p->is_popular,
            ]);

        return response()->json($prices);
    }

    public function faqs(): JsonResponse
    {
        $faqs = Faq::active()
            ->get()
            ->map(fn ($f) => [
                'id'       => $f->id,
                'question' => $f->question,
                'answer'   => $f->answer,
            ]);

        return response()->json($faqs);
    }

    public function page(string $slug): JsonResponse
    {
        $page = Page::where('slug', $slug)->where('is_active', true)->firstOrFail();

        return response()->json([
            'id'               => $page->id,
            'title'            => $page->title,
            'content'          => $page->content,
            'meta_title'       => $page->meta_title,
            'meta_description' => $page->meta_description,
            'cover'            => $page->getFirstMediaUrl('cover'),
        ]);
    }

    private function formatRoute(Route $route, bool $full = false): array
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
            'cover'             => $route->getFirstMediaUrl('cover'),
        ];

        if ($full) {
            $data['description'] = $route->description;
            $data['included']    = $route->included ?? [];
            $data['excluded']    = $route->excluded ?? [];
            $data['gallery']     = $route->getMedia('gallery')->map->getUrl()->values()->toArray();
        }

        return $data;
    }
}
