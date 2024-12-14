<?php

namespace KiranoDev\LaravelSeo\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use KiranoDev\LaravelSeo\Models\Seo;

class Meta extends Component
{
    public ?Seo $seo;

    public string $title;
    public string $keywords;
    public string $description;

    public function __construct()
    {
        $this->seo = cache('seo.' . url()->current());

        $this->fill();
    }

    private function fill(): void {
        $default = Seo::getDefault();

        $this->title = $this->seo?->title ?? $default['title'];
        $this->keywords = $this->seo?->keywords ?? $default['keywords'];
        $this->description = $this->seo?->description ?? $default['description'];
    }

    public function render(): View|Closure|string
    {
        return view('seo::components.meta');
    }
}