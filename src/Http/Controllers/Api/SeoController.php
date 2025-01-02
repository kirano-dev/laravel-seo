<?php

namespace KiranoDev\LaravelSeo\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use KiranoDev\LaravelSeo\Http\Requests\StoreSeoRequest;
use KiranoDev\LaravelSeo\Http\Requests\UpdateSeoRequest;
use KiranoDev\LaravelSeo\Http\Resources\SeoResource;
use KiranoDev\LaravelSeo\Models\Seo;

class SeoController extends Controller
{
    public function index()
    {
        return SeoResource::collection(Seo::all());
    }

    public function store(StoreSeoRequest $request): SeoResource {
        return new SeoResource(Seo::create($request->validated()));
    }

    public function update(UpdateSeoRequest $request, Seo $seo): SeoResource {
        $seo->update($request->validated());

        return new SeoResource($seo);
    }

    public function show(string $url): JsonResponse|SeoResource {
        $seo = Seo::findByUrl($url);

        if (!$seo) return response()->json([
            'data' => Seo::getDefault()
        ]);

        return new SeoResource(
            cache()->rememberForever($seo->getCacheKey(), fn() => $seo)
        );
    }
}