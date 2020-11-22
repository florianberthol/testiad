<?php
namespace Core;


class Controller
{
    private const LAYOUT_PATH = __DIR__ . '/../View/layout/layout.html.php';

    public function render(string $template, array $param)
    {
        $template = __DIR__ . '/../View/' . $template . '.html.php';
        include self::LAYOUT_PATH;
    }

    public function redirect (string $target)
    {
        header('Location: ' . $target);
    }
}