<?php

namespace KiranoDev\LaravelSeo\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Routing\Controller;
use KiranoDev\LaravelSeo\Http\Requests\StoreSeoRequest;
use KiranoDev\LaravelSeo\Http\Requests\UpdateSeoRequest;
use KiranoDev\LaravelSeo\Http\Resources\SeoResource;
use KiranoDev\LaravelSeo\Models\Seo;

class SeoController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection|JsonResponse|SeoResource
    {
        if($request->filled('url')) {
            $seo = Seo::findByUrl($request->url);

            if (!$seo) return response()->json([
                'data' => Seo::getDefault()
            ]);

            return new SeoResource(
                cache()->rememberForever($seo->getCacheKey(), fn() => $seo)
            );
        }

        return SeoResource::collection(Seo::all());
    }

    public function store(StoreSeoRequest $request): SeoResource {
        return new SeoResource(Seo::create($request->validated()));
    }

    public function update(UpdateSeoRequest $request): SeoResource|JsonResponse {
        $seo = Seo::findByUrl($request->url);

        if (!$seo) return response()->json([
            'data' => Seo::getDefault()
        ]);

        $seo->update($request->validated());

        return new SeoResource($seo);
    }
}