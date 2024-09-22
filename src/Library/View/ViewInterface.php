<?php

declare(strict_types=1);

namespace App\Library\View;

interface ViewInterface
{
    public function render(string $view, array $data = [], string $layout = '_layout'): string;
}

