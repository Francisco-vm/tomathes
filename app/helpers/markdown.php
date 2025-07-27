<?php

namespace App\Helpers;

use Parsedown;

function parseMarkdown(string $text): string {
    $parsedown = new Parsedown();
    return $parsedown->text($text);
}