<?php

declare(strict_types=1);

namespace App\Library\View;

use League\Plates\Engine;
use League\Plates\Template\Template;

class LeaguePlatesRenderer implements ViewInterface
{

    private Engine $engine;

    public function __construct()
    {
        $this->engine = new Engine(dirname(__DIR__, 3) . '/templates');
    }

    public function render(string $view, array $data = [], string $layout = '_layout'): string
    {
        $renderer = new Template($this->engine, $view);
        $renderer->layout($layout, $data);
        $renderer->data($data);
        return $renderer->render($data);
    }
}
