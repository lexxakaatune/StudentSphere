<?php 

function set_flash(string $key, string|bool|int|array $msg): void {
  $_SESSION['flash'][$key] = $msg;
}

function get_flash(string $key): string|bool|int|array|null {
  if (!empty($_SESSION['flash'][$key])) {
    $msg = $_SESSION['flash'][$key];
    unset($_SESSION['flash'][$key]);
    return $msg;
  }
  return null;
}