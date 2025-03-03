<?php

namespace KiranoDev\LaravelSeo\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use KiranoDev\LaravelSeo\Http\Requests\StoreSeoRequest;
use KiranoDev\LaravelSeo\Http\Requests\UpdateSeoRequest;
use KiranoDev\LaravelSeo\Http\Resources\SeoResource;
use KiranoDev\LaravelSeo\Models\Seo;

class SeoController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection|JsonResponse|SeoResource|Response
    {
        if($request->filled('url')) {
            $seo = Seo::findByUrl($request->url);

            if (!$seo) return response()->json([
                'data' => Seo::getDefault()
            ]);

            $cache = cache()->rememberForever($seo->getCacheKey(), fn() => $seo);

            $eTag = md5(json_encode($cache));
            $headers = [
                'ETag' => $eTag,
                'Cache-Control' => 'public, max-age=0',
            ];

            if (request()->header('If-None-Match') === $eTag) {
                return response(status: 304);
            }

            return response()
                ->json(new SeoResource($cache))
                ->withHeaders($headers);
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
        cache()->forget($seo->getCacheKey());

        return new SeoResource($seo);
    }

    public function destroy(Request $request): JsonResponse
    {
        $seo = Seo::findByUrl($request->url);

        if ($seo) {
            cache()->forget($seo->getCacheKey());
            $seo->delete();
        }

        return response()->json('ok', 204);
    }
}