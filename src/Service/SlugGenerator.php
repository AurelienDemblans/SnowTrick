<?php

declare (strict_types=1);

namespace App\Service;

class SlugGenerator
{
    public function __invoke(string $stringToSlugify): string
    {
        $slug = strtolower(str_replace(' ', '-', $stringToSlugify));
        return $slug;
    }

}
