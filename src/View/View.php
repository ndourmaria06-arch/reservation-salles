<?php

declare(strict_types=1);

namespace App\View;

final class View
{
    public function __construct(
        private readonly string $templatesPath,
    ) {
    }

    public function render(string $template, array $data = []): string
    {
        extract($data, EXTR_SKIP);

        ob_start();
        require $this->templatesPath . '/' . $template . '.php';

        return (string) ob_get_clean();
    }
}