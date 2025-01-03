<?php

namespace KiranoDev\LaravelSeo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use KiranoDev\LaravelSeo\Models\Seo;

class UpdateSeoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => ['required', Rule::unique('seo')->ignore(Seo::findByUrl($this->url), 'url')],
            'title' => ['sometimes'],
            'description' => ['sometimes'],
            'keywords' => ['sometimes'],
        ];
    }
}