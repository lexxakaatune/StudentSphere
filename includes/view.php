<?php

function render(string $view, array $data = []): void {
  extract($data, EXTR_SKIP);
  $path = __DIR__ . "/../view/{$view}.php";
  if (!file_exists($path)) {
    http_response_code(500);
    echo "view not found: {$view}";
    exit;
  }
  require $path;
}