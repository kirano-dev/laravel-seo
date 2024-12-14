<?php

namespace KiranoDev\LaravelSeo\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
{
    public function toArray($request): array {
        return [
            'title' => $this->title,
            'keywords' => $this->keywords,
            'description' => $this->description,
        ];
    }
}