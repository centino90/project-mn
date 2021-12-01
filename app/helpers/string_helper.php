<?php
  // Simple page redirect
  function arrangeFullname(string $first, string $middle, string $last): string {
    return ucwords($last) . ', ' . ucwords($first) . ' ' . ucwords(substr($middle, 0, 1) . '.');
  }
