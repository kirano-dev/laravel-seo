<?php

namespace KiranoDev\LaravelSeo\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSeoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'url' => ['sometimes', Rule::unique('seo')->ignore($this->route('seo'), 'url')],
            'title' => ['sometimes'],
            'description' => ['sometimes'],
            'keywords' => ['sometimes'],
        ];
    }
}