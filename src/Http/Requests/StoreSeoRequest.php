<?php

namespace KiranoDev\LaravelSeo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSeoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => ['required', 'unique:seo,url'],
            'title' => ['sometimes'],
            'description' => ['sometimes'],
            'keywords' => ['sometimes'],
        ];
    }
}