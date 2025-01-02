<?php

namespace KiranoDev\LaravelSeo\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use KiranoDev\LaravelSeo\Http\Requests\StoreSeoRequest;
use KiranoDev\LaravelSeo\Http\Requests\UpdateSeoRequest;
use KiranoDev\LaravelSeo\Http\Resources\SeoResource;
use KiranoDev\LaravelSeo\Models\Seo;
use KiranoDev\LaravelSeo\Models\Seo as SeoModel;

class SeoController extends Controller
{
    public function index(Request $request): JsonResponse|SeoResource
    {
        $seo = Seo::findByUrl($request->get('url'));

        if (!$seo) return response()->json([
            'data' => SeoModel::getDefault()
        ]);

        return new SeoResource(
            cache()->rememberForever($seo->getCacheKey(), fn() => $seo)
        );
    }

    public function store(StoreSeoRequest $request): SeoResource {
        return new SeoResource(Seo::create($request->validated()));
    }

    public function update(UpdateSeoRequest $request, Seo $seo): SeoResource {
        $seo->update($request->validated());

        return new SeoResource($seo);
    }
}