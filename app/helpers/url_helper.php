<?php
  // Simple page redirect
  function redirect(string $page): void {
    header('location: ' . URLROOT . '/' . $page);
  }

  function redirectBack(): void {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }