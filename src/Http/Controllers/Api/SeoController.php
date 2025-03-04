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

            $data = new SeoResource(cache()
                ->rememberForever($seo->getCacheKey(), fn() => $seo));

            $eTag = md5(json_encode($data));
            $headers = [
                'ETag' => $eTag,
                'Cache-Control' => 'public, max-age=60',
            ];

            if (request()->header('If-None-Match') === $eTag) {
                return response(status: 304, headers: [
                    'Cache-Control' => 'public, max-age=60',
                ]);
            }

            return response()
                ->json([
                    'data' => $data,
                    'message' => 'ok'
                ])
                ->withHeaders($headers);
        }

        return SeoResource::collection(Seo::all());
    }

    public function store(StoreSeoRequest $request): SeoResource {
        $seo = Seo::create($request->validated());

        cache()->rememberForever($seo->getCacheKey(), fn() => $seo);

        return new SeoResource($seo);
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